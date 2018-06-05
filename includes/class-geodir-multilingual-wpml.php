<?php
/**
 * GeoDirectory Multilingual WPML
 *
 * @class    GeoDir_Multilingual_WPML
 * @author   AyeCode
 * @package  GeoDir_Multilingual/Classes
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * GeoDir_Multilingual_WPML class.
 */
class GeoDir_Multilingual_WPML {

	public static function init() {
		global $sitepress;

		add_action( 'plugins_loaded', array( __CLASS__, 'ajax_set_guest_lang' ), -1 );
		add_action( 'icl_make_duplicate', array( __CLASS__, 'make_duplicate' ), 11, 4 );
		add_filter( 'icl_make_duplicate', array( __CLASS__, 'filter_ls_languages' ), 11, 1 );
		add_filter( 'geodir_post_permalink_structure_cpt_slug', array( __CLASS__, 'post_permalink_structure_cpt_slug' ), 10, 3 );
		add_filter( 'post_type_archive_link', array( __CLASS__, 'post_type_archive_link' ), 1000, 2 );
		add_filter( 'geodir_term_link', array( __CLASS__, 'term_link' ), 10, 3 );
		add_action( 'geodir_language_file_add_string', array( __CLASS__, 'register_string' ), 10, 1 );

		if ( $sitepress->get_setting( 'sync_comments_on_duplicates' ) ) {
            add_action( 'comment_post', array( __CLASS__, 'sync_comment' ), 100, 1 );
        }
        
		//add_action('geodir_after_save_listing', array( __CLASS__, 'duplicate_listing' ), 100, 2);// TODO
        add_action( 'geodir_edit_post_link_html', array( __CLASS__, 'display_listing_duplicates' ), 0, 1 );// TODO
        //if ( is_admin() ) {
            //add_filter( 'geodir_design_settings', 'geodir_wpml_duplicate_settings', 10, 1 ); // TODO
        //}
	}

	/**
	 * Set the WPML language for AJAX requests for non logged user.
	 *
	 * Custom AJAX requests always return the default language content.
	 *
	 * @since 1.0.0
	 *
	 * @global object $sitepress Sitepress WPML object.
	 *
	 */
	 public static function ajax_set_guest_lang() {    
		if ( geodir_is_wpml() && wpml_is_ajax() && !is_user_logged_in() ) {
			if ( empty( $_GET['lang'] ) && !( !empty( $_SERVER['REQUEST_URI'] ) && preg_match( '@\.(css|js|png|jpg|gif|jpeg|bmp)@i', basename( preg_replace( '@\?.*$@', '', $_SERVER['REQUEST_URI'] ) ) ) ) ) {
				global $sitepress;
				
				$referer = wp_get_referer();
				
				$current_lang = $sitepress->get_current_language();
				$referrer_lang = $sitepress->get_language_from_url( $referer );
				
				if ( $referrer_lang && $current_lang != $referrer_lang ) {
					$_GET['lang'] = $referrer_lang;
				}
			}
		}
	}

	/**
	 * Filters the WPML language switcher urls for GeoDirectory pages.
	 *
	 * @since 1.0.0
	 *
	 * @param array    $languages WPML active languages.
	 * @return array Filtered languages.
	 */
	public static function filter_ls_languages($languages) {    
		if (geodir_is_geodir_page()) {        
			$keep_vars = array();
			
			if (geodir_is_page('add-listing')) {
				$keep_vars = array('listing_type', 'package_id');
			} else if (geodir_is_page('search')) {
				$keep_vars = array('geodir_search', 'stype', 'snear', 'set_location_type', 'set_location_val', 'sgeo_lat', 'sgeo_lon');
			} else if (geodir_is_page('author')) {
				$keep_vars = array('geodir_dashbord', 'stype', 'list');
			} else if (geodir_is_page('login')) {
				$keep_vars = array('forgot', 'signup');
			}

			$keep_vars = apply_filters( 'geodir_multilingual_wpml_ls_languages_keep_vars', $keep_vars, $languages );

			if (!empty($keep_vars)) {
				foreach ( $languages as $code => $url) {
					$filter_url = $url['url'];
					
					foreach ($keep_vars as $var) {
						if (isset($_GET[$var]) && !is_array($_GET[$var])) {
							$filter_url = remove_query_arg(array($var), $filter_url);
							$filter_url = add_query_arg(array($var => $_GET[$var]), $filter_url);
						}
					}
					
					if ($filter_url != $url['url']) {
						$languages[$code]['url'] = $filter_url;
					}
				}
			}
		}

		return $languages;
	}

	public static function post_permalink_structure_cpt_slug( $cpt_slug, $gd_post, $post_link ) {
		// Alter the CPT slug if WPML is set to do so
		if ( !empty( $gd_post ) && geodir_wpml_is_post_type_translated( $gd_post->post_type ) ) {
			if ( self::is_slug_translation_on( $gd_post->post_type ) && ( $language_code = self::get_lang_from_url( $post_link ) ) ) {
				$org_slug = $cpt_slug;

				$cpt_slug = apply_filters( 'wpml_translate_single_string', $cpt_slug, 'WordPress', 'URL slug: ' . $cpt_slug, $language_code );

				if ( ! $cpt_slug ) {
					$cpt_slug = $org_slug;
				}
			}
		}

		return $cpt_slug;
	}

	/**
	 * Wpml post type archive link.
	 *
	 * @since 1.0.0
	 *
	 * @param string $link link.
	 * @param string $post_type Post type.
	 * @return string $link.
	 */
	public static function post_type_archive_link( $link, $post_type ) {
		$post_types   = geodir_get_posttypes();
		
		if ( isset( $post_types[ $post_type ] ) ) {
			$slug = $post_types[ $post_type ]['rewrite']['slug'];

			// Alter the CPT slug if WPML is set to do so
			if ( geodir_wpml_is_post_type_translated( $post_type ) ) {
				if ( self::is_slug_translation_on( $post_type ) && ( $language_code = self::get_lang_from_url( $link ) ) ) {
					$org_slug = $slug;

					$slug = apply_filters( 'wpml_translate_single_string', $slug, 'WordPress', 'URL slug: ' . $slug, $language_code );

					if ( ! $slug ) {
						$slug = $org_slug;
					} else {
						$link = str_replace( $org_slug, $slug, $link );
					}
				}
			}
		}

		return $link;
	}

	public static function term_link( $term_link, $term, $taxonomy ) {
		$post_types = geodir_get_posttypes('array');
		$post_type = str_replace("category","",$taxonomy);
		$post_type = str_replace("_tags","",$post_type);
		$slug = $post_types[$post_type]['rewrite']['slug'];
		if ( geodir_wpml_is_post_type_translated( $post_type ) && self::is_slug_translation_on( $post_type ) ) {
			global $sitepress;
			$default_lang = $sitepress->get_default_language();
			$language_code = self::get_lang_from_url( $term_link );
			if ( ! $language_code ) {
				$language_code  = $default_lang;
			}

			$org_slug = $slug;
			$slug = apply_filters( 'wpml_translate_single_string', $slug, 'WordPress', 'URL slug: ' . $slug, $language_code );

			if ( ! $slug ) {
				$slug = $org_slug;
			}

			$term_link = trailingslashit( preg_replace( "/" . preg_quote( $org_slug, "/" ) . "/", $slug, $term_link, 1 ) );
		}

		return $term_link;
	}

	/**
	 * Duplicate post listing manually after listing saved.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id The Post ID.
	 * @param string $lang Language code for translating post.
	 * @param array $request_info The post details in an array.
	 */
	public static function duplicate_listing($post_id, $request_info) {
		global $sitepress;
		
		$icl_ajx_action = !empty($_REQUEST['icl_ajx_action']) && $_REQUEST['icl_ajx_action'] == 'make_duplicates' ? true : false;
		if (!empty($_REQUEST['action']) && $_REQUEST['action'] == 'wpml_duplicate_dashboard' && !empty($_REQUEST['duplicate_post_ids'])) {
			$icl_ajx_action = true;
		}
		
		if (!$icl_ajx_action && in_array(get_post_type($post_id), geodir_get_posttypes()) && $post_duplicates = $sitepress->get_duplicates($post_id)) {
			foreach ($post_duplicates as $lang => $dup_post_id) {
				self::make_duplicate($post_id, $lang, $request_info, $dup_post_id, true);
			}
		}
	}

	/**
	 * Duplicate post details for WPML translation post.
	 *
	 * @since 1.0.0
	 *
	 * @param int $master_post_id Original Post ID.
	 * @param string $lang Language code for translating post.
	 * @param array $postarr Array of post data.
	 * @param int $tr_post_id Translation Post ID.
	 * @param bool $after_save If true it will force duplicate. 
	 *                         Added to fix duplicate translation for front end.
	 */
	public static function make_duplicate( $master_post_id, $lang, $postarr, $tr_post_id, $after_save = false ) {
		global $sitepress;
		
		$post_type = get_post_type($master_post_id);
		$icl_ajx_action = !empty($_REQUEST['icl_ajx_action']) && $_REQUEST['icl_ajx_action'] == 'make_duplicates' ? true : false;
		if (!empty($_REQUEST['action']) && $_REQUEST['action'] == 'wpml_duplicate_dashboard' && !empty($_REQUEST['duplicate_post_ids'])) {
			$icl_ajx_action = true;
		}
		
		if (in_array($post_type, geodir_get_posttypes())) {
			if ($icl_ajx_action || $after_save) {
				// Duplicate post details
				self::duplicate_post_details($master_post_id, $tr_post_id, $lang);
				
				// Duplicate taxonomies
				self::duplicate_taxonomies($master_post_id, $tr_post_id, $lang);
				
				// Duplicate post images
				self::duplicate_post_images($master_post_id, $tr_post_id, $lang);
			}
			
			// Sync post reviews
			if ($sitepress->get_setting('sync_comments_on_duplicates')) {
				self::duplicate_post_reviews($master_post_id, $tr_post_id, $lang);
			}
		}
	}

	/**
	 * Duplicate post general details for WPML translation post.
	 *
	 * @since 1.0.0
	 *
	 * @global object $wpdb WordPress Database object.
	 * @global string $plugin_prefix Geodirectory plugin table prefix.
	 *
	 * @param int $master_post_id Original Post ID.
	 * @param int $tr_post_id Translation Post ID.
	 * @param string $lang Language code for translating post.
	 * @return bool True for success, False for fail.
	 */
	public static function duplicate_post_details($master_post_id, $tr_post_id, $lang) {
		global $wpdb, $plugin_prefix;

		$post_type = get_post_type($master_post_id);
		$post_table = $plugin_prefix . $post_type . '_detail';

		$query = $wpdb->prepare("SELECT * FROM " . $post_table . " WHERE post_id = %d", array($master_post_id));
		$data = (array)$wpdb->get_row($query);

		if ( !empty( $data ) ) {
			$data['post_id'] = $tr_post_id;

			unset($data['default_category'], $data['post_category']);

			$data = apply_filters( 'geodir_multilingual_duplicate_post_details', $data, $master_post_id, $tr_post_id, $lang );

			$wpdb->update($post_table, $data, array('post_id' => $tr_post_id));

			return true;
		}

		return false;
	}

	/**
	 * Duplicate post taxonomies for WPML translation post.
	 *
	 * @since 1.0.0
	 *
	 * @global object $sitepress Sitepress WPML object.
	 * @global object $wpdb WordPress Database object.
	 *
	 * @param int $master_post_id Original Post ID.
	 * @param int $tr_post_id Translation Post ID.
	 * @param string $lang Language code for translating post.
	 * @return bool True for success, False for fail.
	 */
	public static function duplicate_taxonomies($master_post_id, $tr_post_id, $lang) {
		global $sitepress, $wpdb;
		$post_type = get_post_type($master_post_id);

		remove_filter('get_term', array($sitepress,'get_term_adjust_id')); // AVOID filtering to current language

		$taxonomies = get_object_taxonomies($post_type);
		foreach ($taxonomies as $taxonomy) {
			$terms = get_the_terms($master_post_id, $taxonomy);
			$terms_array = array();
			
			if ($terms) {
				foreach ($terms as $term) {
					$tr_id = apply_filters( 'translate_object_id',$term->term_id, $taxonomy, false, $lang);
					
					if (!is_null($tr_id)){
						// not using get_term - unfiltered get_term
						$translated_term = $wpdb->get_row($wpdb->prepare("
							SELECT * FROM {$wpdb->terms} t JOIN {$wpdb->term_taxonomy} x ON x.term_id = t.term_id WHERE t.term_id = %d AND x.taxonomy = %s", $tr_id, $taxonomy));

						$terms_array[] = $translated_term->term_id;
					}
				}

				if (!is_taxonomy_hierarchical($taxonomy)){
					$terms_array = array_unique( array_map( 'intval', $terms_array ) );
				}

				wp_set_post_terms($tr_post_id, $terms_array, $taxonomy);

				if ( $taxonomy == $post_type . 'category' ) {
					geodir_save_post_meta( $tr_post_id, 'post_category',  ','. implode( ',', $terms_array ) . ',' );
					geodir_save_post_meta( $tr_post_id, 'default_category', $terms_array[0] );
				}
			}
		}
	}

	/**
	 * Duplicate post images for WPML translation post.
	 *
	 * @since 1.0.0
	 *
	 * @global object $wpdb WordPress Database object.
	 *
	 * @param int $master_post_id Original Post ID.
	 * @param int $tr_post_id Translation Post ID.
	 * @param string $lang Language code for translating post.
	 * @return bool True for success, False for fail.
	 */
	public static function duplicate_post_images($master_post_id, $tr_post_id, $lang) {
		global $wpdb;

		$query = $wpdb->prepare("DELETE FROM " . GEODIR_ATTACHMENT_TABLE . " WHERE type = %s AND post_id = %d", array('post_images', $tr_post_id));
		$wpdb->query($query);

		$query = $wpdb->prepare("SELECT * FROM " . GEODIR_ATTACHMENT_TABLE . " WHERE type = %s AND post_id = %d ORDER BY menu_order ASC", array('post_images', $master_post_id));
		$post_images = $wpdb->get_results($query);

		if ( !empty( $post_images ) ) {
			foreach ( $post_images as $post_image) {
				$image_data = (array)$post_image;
				unset($image_data['ID']);
				$image_data['post_id'] = $tr_post_id;
				
				$wpdb->insert(GEODIR_ATTACHMENT_TABLE, $image_data);
			}
			
			return true;
		}

		return false;
	}

	/**
	 * Duplicate post reviews for WPML translation post.
	 *
	 * @since 1.0.0
	 *
	 * @global object $wpdb WordPress Database object.
	 *
	 * @param int $master_post_id Original Post ID.
	 * @param int $tr_post_id Translation Post ID.
	 * @param string $lang Language code for translating post.
	 * @return bool True for success, False for fail.
	 */
	public static function duplicate_post_reviews($master_post_id, $tr_post_id, $lang) {
		global $wpdb;

		$reviews = $wpdb->get_results($wpdb->prepare("SELECT comment_id FROM " . GEODIR_REVIEW_TABLE . " WHERE post_id=%d ORDER BY comment_id ASC", $master_post_id), ARRAY_A);

		if (!empty($reviews)) {
			foreach ($reviews as $review) {
				self::duplicate_post_review($review['comment_id'], $master_post_id, $tr_post_id, $lang);
			}
		}

		return false;
	}

	/**
	 * Duplicate post review for WPML translation post.
	 *
	 * @since 1.0.0
	 *
	 * @global object $wpdb WordPress Database object.
	 * @global string $plugin_prefix Geodirectory plugin table prefix.
	 *
	 * @param int $master_comment_id Original Comment ID.
	 * @param int $master_post_id Original Post ID.
	 * @param int $tr_post_id Translation Post ID.
	 * @param string $lang Language code for translating post.
	 * @return bool True for success, False for fail.
	 */
	public static function duplicate_post_review($master_comment_id, $master_post_id, $tr_post_id, $lang) {
		global $wpdb, $plugin_prefix, $sitepress;

		$review = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . GEODIR_REVIEW_TABLE . " WHERE comment_id=%d ORDER BY comment_id ASC", $master_comment_id), ARRAY_A);

		if (empty($review)) {
			return false;
		}
		if ($review['post_id'] != $master_post_id) {
			$wpdb->query($wpdb->prepare("UPDATE " . GEODIR_REVIEW_TABLE . " SET post_id=%d WHERE comment_id=%d", $master_post_id, $master_comment_id));
			GeoDir_Comments::update_post_rating($master_post_id, $post_type);
		}

		$tr_comment_id = self::get_duplicate_comment($tr_post_id, $master_comment_id);

		if (empty($tr_comment_id)) {
			return false;
		}

		$post_type = get_post_type($master_post_id);
		$post_table = $plugin_prefix . $post_type . '_detail';

		$translated_post = $wpdb->get_row($wpdb->prepare("SELECT latitude, longitude, city, region, country FROM " . $post_table . " WHERE post_id = %d", $tr_post_id), ARRAY_A);
		if (empty($translated_post)) {
			return false;
		}

		$review['comment_id'] = $tr_comment_id;
		$review['post_id'] = $tr_post_id;
		$review['city'] = $translated_post['city'];
		$review['region'] = $translated_post['region'];
		$review['country'] = $translated_post['country'];
		$review['latitude'] = $translated_post['latitude'];
		$review['longitude'] = $translated_post['longitude'];

		$tr_review_id = $wpdb->get_var($wpdb->prepare("SELECT comment_id FROM " . GEODIR_REVIEW_TABLE . " WHERE comment_id=%d AND post_id=%d ORDER BY comment_id ASC", $tr_comment_id, $tr_post_id));

		if ($tr_review_id) { // update review
			$wpdb->update(GEODIR_REVIEW_TABLE, $review, array('comment_id' => $tr_review_id));
		} else { // insert review
			$wpdb->insert(GEODIR_REVIEW_TABLE, $review);
			$tr_review_id = $wpdb->insert_id;
		}

		if ($tr_post_id) {
			GeoDir_Comments::update_post_rating($tr_post_id, $post_type);
			
			if (defined('GEODIRREVIEWRATING_VERSION') && geodir_get_option('geodir_reviewrating_enable_review') && $sitepress->get_setting('sync_comments_on_duplicates')) {
				$wpdb->query($wpdb->prepare("DELETE FROM " . GEODIR_COMMENTS_REVIEWS_TABLE . " WHERE comment_id = %d", array($tr_comment_id)));
				$likes = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . GEODIR_COMMENTS_REVIEWS_TABLE . " WHERE comment_id=%d ORDER BY like_date ASC", $master_comment_id, $tr_post_id), ARRAY_A);

				if (!empty($likes)) {
					foreach ($likes as $like) {
						unset($like['like_id']);
						$like['comment_id'] = $tr_comment_id;
						
						$wpdb->insert(GEODIR_COMMENTS_REVIEWS_TABLE, $like);
					}
				}
			}
		}

		return $tr_review_id;
	}

	/**
	 * Synchronize review for WPML translation post.
	 *
	 * @since 1.0.0
	 *
	 * @global object $wpdb WordPress Database object.
	 * @global object $sitepress Sitepress WPML object.
	 * @global array $gd_wpml_posttypes Geodirectory post types array.
	 *
	 * @param int $comment_id The Comment ID.
	 */
	public static function sync_comment( $comment_id ) {
		global $wpdb, $sitepress, $gd_wpml_posttypes;

		if (empty($gd_post_types)) {
			$gd_wpml_posttypes = geodir_get_posttypes();
		}

		$comment = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->comments} WHERE comment_ID=%d", $comment_id), ARRAY_A);
		if (empty($comment)) {
			return;
		}

		$post_id = $comment['comment_post_ID'];
		$post_type = $post_id ? get_post_type($post_id) : NULL;

		if (!($post_type && in_array($post_type, $gd_wpml_posttypes))) {
			return;
		}

		$post_duplicates = $sitepress->get_duplicates($post_id);
		if (empty($post_duplicates)) {
			return;
		}

		foreach ($post_duplicates as $lang => $dup_post_id) {
			if (empty($comment['comment_parent'])) {
				self::duplicate_post_review($comment_id, $post_id, $dup_post_id, $lang);
			}
		}
		
		return true;
	}

	/**
	 * Get the WPML duplicate comment ID of the comment.
	 *
	 * @since 1.0.0
	 *
	 * @global object $dup_post_id WordPress Database object.
	 *
	 * @param int $dup_post_id The duplicate post ID.
	 * @param int $original_cid The original Comment ID.
	 * @return int The duplicate comment ID.
	 */
	public static function get_duplicate_comment($dup_post_id, $original_cid) {
		global $wpdb;

		$duplicate = $wpdb->get_var(
			$wpdb->prepare(
				"   SELECT comm.comment_ID
					FROM {$wpdb->comments} comm
					JOIN {$wpdb->commentmeta} cm
						ON comm.comment_ID = cm.comment_id
					WHERE comm.comment_post_ID = %d
						AND cm.meta_key = '_icl_duplicate_of'
						AND cm.meta_value = %d
					LIMIT 1",
				$dup_post_id,
				$original_cid
			)
		);

		return $duplicate;
	}

	/**
	 * Display WPML languages option in sidebar to allow authors to duplicate their listing.
	 *
	 * @since 1.0.0
	 *
	 * @global WP_Post|null $post The current post.
	 * @global bool $preview True if the current page is add listing preview page. False if not.
	 * @global object $sitepress Sitepress WPML object.
	 *
	 * @param string $content_html The output html of the geodir_edit_post_link() function.
	 * @return string Filtered html of the geodir_edit_post_link() function.
	 */
	public static function display_listing_duplicates( $content_html ) {
		global $post, $preview, $sitepress;
		
		if ( !empty( $post->ID ) && !$preview && geodir_is_page( 'detail' ) && self::is_duplicate_allowed( $post->ID ) ) {
			$post_id = $post->ID;
			$element_type = 'post_' . get_post_type( $post_id );
			$original_post_id = $sitepress->get_original_element_id( $post_id, $element_type );
			
			if ( $original_post_id == $post_id ) {
				$wpml_languages = $sitepress->get_active_languages();
				$post_language = $sitepress->get_language_for_element( $post_id, $element_type );
				
				if ( !empty( $wpml_languages ) && isset( $wpml_languages[ $post_language ] ) ) {
					unset( $wpml_languages[ $post_language ] );
				}
				
				if ( !empty( $wpml_languages ) ) {
					$trid  = $sitepress->get_element_trid( $post_id, $element_type );
					$element_translations = $sitepress->get_element_translations( $trid, $element_type );
					$duplicates = $sitepress->get_duplicates( $post_id );
					
					$wpml_content = '<div class="geodir-company_info gd-detail-duplicate"><h3 class="widget-title">' . __( 'Translate Listing', 'geodirectory' ) . '</h3>';
					$wpml_content .= '<table class="gd-duplicate-table" style="width:100%;margin:0"><tbody>';
					$wpml_content .= '<tr style="border-bottom:solid 1px #efefef"><th style="padding:0 2px 2px 2px">' . __( 'Language', 'geodirectory' ) . '</th><th style="width:25px;"></th><th style="width:5em;text-align:center">' . __( 'Translate', 'geodirectory' ) . '</th></tr>';
					
					$needs_translation = false;
					
					foreach ( $wpml_languages as $lang_code => $lang ) {
						$duplicates_text = '';
						$translated = false;
						
						if ( !empty( $element_translations ) && isset( $element_translations[$lang_code] ) ) {
							$translated = true;
							
							if ( !empty( $duplicates ) && isset( $duplicates[$lang_code] ) ) {
								$duplicates_text = ' ' . __( '(duplicate)', 'geodirectory' );
							}
						} else {
							$needs_translation = true;
						}
						
						$wpml_content .= '<tr><td style="padding:4px">' . $lang['english_name'] . $duplicates_text . '</td><td>&nbsp;</td><td style="text-align:center;">';
						
						if ( $translated ) {
							$wpml_content .= '<i class="fa fa-check" style="color:orange"></i>';
						} else {
							$wpml_content .= '<input name="gd_icl_dup[]" value="' . $lang_code . '" title="' . esc_attr__( 'Create duplicate', 'geodirectory' ) . '" type="checkbox">';
						}
						
						$wpml_content .= '</td></tr>';
					}
					
					if ( $needs_translation ) {
						$nonce = wp_create_nonce( 'geodir_duplicate_nonce' );
						$wpml_content .= '<tr><td>&nbsp;</td><td style="vertical-align:middle;padding-top:13px"><i style="display:none" class="fa fa-spin fa-refresh"></i></td><td style="padding:15px 3px 3px 3px;text-align:right"><button data-nonce="' . esc_attr( $nonce ) . '" data-post-id="' . $post_id . '" id="gd_make_duplicates" class="button-secondary">' . __( 'Duplicate', 'geodirectory' ) . '</button></td></tr>';
					}
					
					$wpml_content .= '</tbody></table>';
					$wpml_content .= '</div>';
					
					$content_html .= $wpml_content;
				}
			}
		}
		
		return $content_html;
	}

	public static function frontend_duplicate() {
		check_ajax_referer( 'duplicate-post', 'security' );

		$json = array();
		$json['success'] = false;
		
		$post_id = !empty( $_REQUEST['post_id'] ) ? absint( $_REQUEST['post_id'] ) : 0;
		$langs = !empty( $_REQUEST['dups'] ) ? explode( ',', sanitize_text_field( $_REQUEST['dups'] ) ) : array();
		
		if ( !empty( $post_id ) && !empty( $langs ) ) {
			if ( self::is_duplicate_allowed( $post_id ) ) {
				global $sitepress;
				
				$element_type = 'post_' . get_post_type( $post_id );
				$master_post_id = $sitepress->get_original_element_id( $post_id, $element_type );
				
				if ( $master_post_id == $post_id ) {
					$_REQUEST['icl_ajx_action'] = 'make_duplicates';
					
					foreach ( $langs as $lang ) {
						$return = $sitepress->make_duplicate( $master_post_id, $lang );
					}
					$json['success'] = true;
				} else {
					$json['error'] = __( 'Translation can be done from original listing only.', 'geodirectory' );
				}
			} else {
				$json['error'] = __( 'You are not allowed to translate this listing.', 'geodirectory' );
			}
		}
		
		wp_send_json( $json );
	}

	/**
	 * Checks the user allowed to duplicate listing or not for WPML.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id The post ID.
	 * @return bool True if allowed.
	 */
	public static function is_duplicate_allowed( $post_id ) {
		$allowed = false;
		
		if ( !geodir_is_wpml() || empty( $post_id ) ) {
			return $allowed;
		}
		
		$user_id = (int)get_current_user_id();
		
		if ( empty( $user_id ) ) {
			return $allowed;
		}
		
		$post_type = get_post_type( $post_id );
		if ( !geodir_wpml_is_post_type_translated( $post_type ) || get_post_meta( $post_id, '_icl_lang_duplicate_of', true ) ) {
			return $allowed;
		}
		
		if ( geodir_listing_belong_to_current_user( $post_id ) ) {
			$allowed = true;
		}
		
		$disable_cpts = geodir_get_option( 'geodir_wpml_disable_duplicate' );
		if ( $allowed && !empty( $disable_cpts ) && in_array( $post_type, $disable_cpts ) ) {
			$allowed = false;
		}
		
		/**
		 * Filter the user allowed to duplicate listing or not for WPML.
		 *
		 * @param bool $allowed True if allowed.
		 * @param int $post_id The post ID.
		 */
		return apply_filters( 'geodir_multilingual_wpml_is_duplicate_allowed', $allowed, $post_id );
	}

	/**
	 * Get the WPML language from the url.
	 *
	 * @since 1.0.0
	 *
	 * @param string $url.
	 * @return string|bool
	 */
	public static function get_lang_from_url($url) {
		global $sitepress, $gd_wpml_get_languages;
		
		if (geodir_is_wpml()) {
			return $sitepress->get_language_from_url($url);
		}
		
		if (isset($_REQUEST['lang']) && $_REQUEST['lang']) {
			return $_REQUEST['lang'];
		}

		$url = str_replace(array("http://","https://"),"",$url);

		// site_url() seems to work better than get_bloginfo('url') here, WPML can change get_bloginfo('url') to add the lang.
		$site_url = str_replace(array("http://","https://"),"",site_url());

		$url = str_replace($site_url,"",$url);

		$segments = explode('/', trim($url, '/'));

		if ($gd_wpml_get_languages) {
			$langs = $gd_wpml_get_languages;
		} else {
			$gd_wpml_get_languages = $sitepress->get_active_languages();
		}

		if (isset($segments[0]) && $segments[0] && array_key_exists($segments[0], $gd_wpml_get_languages)) {
			return $segments[0];
		}

		return false;
	}

	/**
	 * Function for WPML post slug translation turned on.
	 *
	 * @since 2.0.0
	 *
	 * @param $post_type Get listing posttype.
	 * @return string $settings.
	 */
	public static function is_slug_translation_on($post_type) {
		global $sitepress;
		$settings = $sitepress->get_settings();
		return isset($settings['posts_slug_translation']['types'][$post_type])
		&& $settings['posts_slug_translation']['types'][$post_type]
		&& isset($settings['posts_slug_translation']['on'])
		&& $settings['posts_slug_translation']['on'];
	}

	/**
	 * Filters WordPress locale ID.
	 *
	 * Load current WPML language when editing the GD CPT.
	 *
	 * @since 1.0.0
	 *
	 * @param string $locale The locale ID.
	 * @return string Filtered locale ID.
	 */
	public static function filter_locale($locale) {
		global $sitepress;
		
		$post_type = !empty($_REQUEST['post_type']) ? $_REQUEST['post_type'] : (!empty($_REQUEST['post']) ? get_post_type($_REQUEST['post']) : '');
		
		if (!empty($sitepress) && $sitepress->is_post_edit_screen() && $post_type && in_array($post_type, geodir_get_posttypes()) && $current_lang = $sitepress->get_current_language()) {
			$locale = $sitepress->get_locale($current_lang);
		}
		
		return $locale;
	}

	/**
	 * Registers a individual text string for WPML translation.
	 *
	 * @since 1.0.0
	 *
	 * @param string $string The string that needs to be translated.
	 * @param string $domain The plugin domain. Default geodirectory.
	 * @param string $name The name of the string which helps to know what's being translated.
	 */
	public static function register_string( $string, $domain = 'geodirectory', $name = '' ) {
		do_action( 'wpml_register_single_string', $domain, $name, $string );
	}

	/**
	 * Retrieves an individual WPML text string translation.
	 *
	 * @since 1.0.0
	 *
	 * @param string $string The string that needs to be translated.
	 * @param string $domain The plugin domain. Default geodirectory.
	 * @param string $name The name of the string which helps to know what's being translated.
	 * @param string $language_code Return the translation in this language. Default is NULL which returns the current language.
	 * @return string The translated string.
	 */
	public static function translate_string( $string, $domain = 'geodirectory', $name = '', $language_code = NULL ) {
		return apply_filters( 'wpml_translate_single_string', $string, $domain, $name, $language_code );
	}
}