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

		add_filter( 'icl_ls_languages', array( __CLASS__, 'icl_ls_languages' ), 11, 1 );
		add_filter( 'geodir_get_page_id', array( __CLASS__, 'get_page_id' ), 10, 4 );
		add_filter( 'geodir_post_permalink_structure_cpt_slug', array( __CLASS__, 'post_permalink_structure_cpt_slug' ), 10, 3 );
		add_filter( 'post_type_archive_link', array( __CLASS__, 'post_type_archive_link' ), 1000, 2 );
		add_filter( 'geodir_term_link', array( __CLASS__, 'term_link' ), 10, 3 );
		add_filter( 'geodir_posts_join', array( __CLASS__, 'posts_join' ), 10, 2 );
		add_filter( 'geodir_posts_where', array( __CLASS__, 'posts_where' ), 10, 2 );
		add_filter( 'geodir_filter_widget_listings_join', array( __CLASS__, 'widget_posts_join' ), 10, 2 );
		add_filter( 'geodir_filter_widget_listings_where', array( __CLASS__, 'widget_posts_where' ), 10, 2 );
		add_filter( 'geodir_rest_markers_query_join', array( __CLASS__, 'rest_markers_query_join' ), 10, 2 );
		add_filter( 'geodir_rest_markers_query_where', array( __CLASS__, 'rest_markers_query_where' ), 10, 2 );
		add_filter( 'geodir_filter_query_var_category', array( __CLASS__, 'filter_query_var_categories' ), 10, 2 );
		add_filter( 'geodir_map_categories_term_id', array( __CLASS__, 'map_categories_term_id' ), 10, 2 );
		add_filter( 'option_geodir_add_listing_page', array( __CLASS__, 'option_add_listing_page' ), 10, 1 );
		add_filter( 'geodir_recent_reviews_query_join', array( __CLASS__, 'recent_reviews_query_join' ), 10, 3 );
		add_filter( 'geodir_recent_reviews_query_where', array( __CLASS__, 'recent_reviews_query_where' ), 10, 3 );
		add_filter( 'geodir_info_page_home_url', array( __CLASS__, 'home_url' ), 0, 1 );
		add_filter( 'geodir_unique_post_slug_posts_join', array( __CLASS__, 'unique_post_slug_posts_join' ), 10, 3 );
		add_filter( 'geodir_unique_post_slug_posts_where', array( __CLASS__, 'unique_post_slug_posts_where' ), 10, 3 );
		add_filter( 'geodir_unique_post_slug_terms_join', array( __CLASS__, 'unique_post_slug_terms_join' ), 10, 3 );
		add_filter( 'geodir_unique_post_slug_terms_where', array( __CLASS__, 'unique_post_slug_terms_where' ), 10, 3 );
		add_filter( 'geodir_unique_term_slug_posts_join', array( __CLASS__, 'unique_term_slug_posts_join' ), 10, 4 );
		add_filter( 'geodir_unique_term_slug_posts_where', array( __CLASS__, 'unique_term_slug_posts_where' ), 10, 4 );
		add_filter( 'geodir_import_category_validate_item', array( __CLASS__, 'import_category_validate_item' ), 10, 2 );
		add_filter( 'geodir_import_category_set_globals', array( __CLASS__, 'import_category_set_globals' ), 0, 1 );
		add_filter( 'geodir_import_category_reset_globals', array( __CLASS__, 'import_category_reset_globals' ), 0, 1 );
		add_filter( 'geodir_export_posts_set_globals', array( __CLASS__, 'export_posts_set_globals' ), 10, 1 );
		add_filter( 'geodir_export_posts_restore_globals', array( __CLASS__, 'export_posts_reset_globals' ), 10, 1 );
		add_filter( 'geodir_export_categories_csv_columns', array( __CLASS__, 'export_categories_csv_columns' ), 10, 2 );
		add_filter( 'geodir_export_categories_csv_row', array( __CLASS__, 'export_categories_csv_row' ), 10, 3 );
		add_filter( 'geodir_export_posts_csv_columns', array( __CLASS__, 'export_posts_csv_columns' ), 10, 2 );
		add_filter( 'geodir_export_posts_csv_row', array( __CLASS__, 'export_posts_csv_row' ), 10, 3 );
		add_filter( 'geodir_export_categories_set_globals', array( __CLASS__, 'export_categories_set_globals' ), 10, 1 );
		add_filter( 'geodir_export_categories_restore_globals', array( __CLASS__, 'export_categories_reset_globals' ), 10, 1 );
		add_filter( 'geodir_switch_locale', array( __CLASS__, 'switch_locale' ), 10, 1 );
		add_filter( 'geodir_restore_locale', array( __CLASS__, 'restore_locale' ), 10, 1 );
		add_filter( 'wpml_copy_from_original_custom_fields', array( __CLASS__, 'copy_from_original_custom_fields' ), 10, 1 );
		add_filter( 'geodir_cpt_post_type_archive_link_slug', array( __CLASS__, 'post_type_archive_link_slug' ), 10, 3 );

		add_action( 'plugins_loaded', array( __CLASS__, 'ajax_set_guest_lang' ), -1 );
		add_action( 'icl_make_duplicate', array( __CLASS__, 'make_duplicate' ), 11, 4 );
		add_action( 'geodir_language_file_add_string', array( __CLASS__, 'register_string' ), 10, 1 );
		add_action( 'geodir_category_imported', array( __CLASS__, 'category_imported' ), 10, 2 );
		add_action( 'geodir_before_count_terms', array( __CLASS__, 'before_count_terms' ), -100, 3 );
		add_action( 'geodir_after_count_terms', array( __CLASS__, 'after_count_terms' ), -100, 3 );
		add_action( 'save_post', array( __CLASS__, 'setup_save_post' ), 0, 3 );
		add_action( 'save_post', array( __CLASS__, 'wpml_media_duplicate' ), 101, 2 );
		add_action( 'icl_post_languages_options_after', array( __CLASS__, 'setup_copy_from_original' ), 10, 1 );

		add_action( 'geodir_bp_listings_count_where', array( __CLASS__, 'geodir_bp_listings_count_where' ), 10, 2 );
		add_action( 'geodir_bp_listings_count_join', array( __CLASS__, 'geodir_bp_listings_count_join' ), 10, 2 );
		add_action( 'geodir_bp_listings_join', array( __CLASS__, 'geodir_bp_listings_join' ), 10, 2 );
		add_action( 'geodir_bp_listings_where', array( __CLASS__, 'geodir_bp_listings_where' ), 10, 2 );
		add_action( 'geodir_bp_favorite_count_join', array( __CLASS__, 'geodir_bp_favorite_count_join' ), 10, 2 );
		add_action( 'geodir_bp_favorite_count_where', array( __CLASS__, 'geodir_bp_favorite_count_where' ), 10, 2 );
		add_action( 'geodir_bp_reviews_count_join', array( __CLASS__, 'geodir_bp_reviews_count_join' ), 10, 2 );
		add_action( 'geodir_bp_reviews_count_where', array( __CLASS__, 'geodir_bp_reviews_count_where' ), 10, 2 );

		if ( $sitepress->get_setting( 'sync_comments_on_duplicates' ) ) {
            add_action( 'comment_post', array( __CLASS__, 'sync_comment' ), 100, 1 );
        }

		// Pricing manager
		add_filter( 'geodir_wpi_allow_invoice_for_listing', array( __CLASS__, 'allow_invoice_for_listing' ), 10, 2 );
	}

	public static function get_default_language() {
		global $sitepress;

		return $sitepress->get_default_language();
	}

	public static function get_current_language() {
		global $sitepress;

		return $sitepress->get_current_language();
	}

	public static function is_translated_post_type( $post_type ) {
		global $sitepress;

		return $sitepress->is_translated_post_type( $post_type );
	}

	/**
	 * Get WPML language code for current term.
	 *
	 * @since 1.0.0
	 *
	 * @global object $sitepress Sitepress WPML object.
	 *
	 * @param int $element_id Post ID or Term id.
	 * @param string $element_type Element type. Ex: post_gd_place or tax_gd_placecategory.
	 * @return Language code.
	 */
	public static function get_language_for_element( $element_id, $element_type ) {
		global $sitepress;

		return $sitepress->get_language_for_element( $element_id, $element_type );
	}

	/**
	 * Get WPML original translation element id.
	 *
	 * @global object $sitepress Sitepress WPML object.
	 *
	 * @param int $element_id Post ID or Term id.
	 * @param string $element_type Element type. Ex: post_gd_place or tax_gd_placecategory.
	 * @return Original element id.
	 */
	public static function get_original_element_id( $element_id, $element_type ) {
		global $sitepress;

		$original_element_id = $sitepress->get_original_element_id( $element_id, $element_type );
		if ( $element_id == $original_element_id ) {
			$original_element_id = '';
		}

		return $original_element_id;
	}

	public static function get_object_id( $element_id, $element_type = 'post', $return_original_if_missing = false, $ulanguage_code = null ) {
		return wpml_object_id_filter( $element_id, $element_type, $return_original_if_missing, $ulanguage_code );
	}

	public static function get_object_ids( $element_ids, $element_type = 'post', $return_original_if_missing = false, $ulanguage_code = null ) {
		if ( empty( $element_ids ) || ! is_array( $element_ids ) ) {
			return array();
		}

		$ids = array();
		foreach ( $element_ids as $element_id ) {
			if ( $element_id && ( $id = self::get_object_id( $element_id, $element_type, $return_original_if_missing, $ulanguage_code ) ) ) {
				$ids[] = $id;
			}
		}

		return $ids;
	}

	/**
	 * Returns WPML element ID.
	 *
	 * @since   1.0.0
	 *
	 * @param int $page_id      The page ID.
	 * @param string $post_type The post type.
	 *
	 * @return int Element ID when exists. Else the page id.
	 */
	public static function get_element_id( $page_id, $post_type ) {
		global $sitepress;
		if ( ! empty( $sitepress ) && isset( $sitepress->queries ) ) {
			$trid = $sitepress->get_element_trid( $page_id, $post_type );

			if ( $trid > 0 ) {
				$translations = $sitepress->get_element_translations( $trid, $post_type );

				$lang = self::get_current_language();
				if ( ! $lang ) {
					$lang = self::get_default_language();
				}

				if ( ! empty( $translations ) && ! empty( $lang ) && isset( $translations[ $lang ] ) && isset( $translations[ $lang ]->element_id ) && ! empty( $translations[ $lang ]->element_id ) ) {
					$page_id = $translations[ $lang ]->element_id;
				}
			}
		}

		return $page_id;
	}

	public static function get_page_id( $page_id, $page, $post_type = '', $translated = true ) {
		if ( $translated ) {
			$page_id = self::get_object_id( $page_id, 'page', true );
		}
		return $page_id;
	}

	public static function switch_lang( $code = null, $cookie_lang = true ) {
		global $sitepress;

		$current_lang = self::get_current_language();

		$sitepress->switch_lang( $code, $cookie_lang );

		return $current_lang;
	}

	public static function store_lang( $switch_lang = 'all' ) {
		global $geodir_wpml_switch_lang;

		$geodir_wpml_switch_lang = self::get_current_language();

		$current_lang = self::switch_lang( $switch_lang );

		return $current_lang;
	}

	public static function restore_lang() {
		global $geodir_wpml_switch_lang;

		if ( $geodir_wpml_switch_lang !== null ) {
			self::switch_lang( $geodir_wpml_switch_lang );
		}

		$geodir_wpml_switch_lang = '';
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
		if ( wpml_is_ajax() && !is_user_logged_in() ) {
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
	public static function icl_ls_languages($languages) {    
		if (geodir_is_geodir_page()) {
			$keep_vars = array();
			
			$is_location = false;
			if (geodir_is_page('add-listing')) {
				$keep_vars = array('listing_type', 'package_id');
			} else if (geodir_is_page('search')) {
				$keep_vars = array('geodir_search', 'stype', 'snear', 'set_location_type', 'set_location_val', 'sgeo_lat', 'sgeo_lon');
			} else if (geodir_is_page('author')) {
				$keep_vars = array('geodir_dashbord', 'stype', 'list');
			} else if (geodir_is_page('login')) {
				$keep_vars = array('forgot', 'signup');
			} else if ( geodir_is_page( 'location' ) ) {
				$is_location = true;
				$location_terms = geodir_get_current_location_terms();
				$location_terms = geodir_remove_location_terms( $location_terms );

				if ( empty( $location_terms ) ) {
					return $languages;
				}
			}

			$keep_vars = apply_filters( 'geodir_multilingual_wpml_ls_languages_keep_vars', $keep_vars, $languages );

			if (!empty($keep_vars)) {
				$permalink_structure = get_option( 'permalink_structure' );
				$current_lang = self::get_current_language();

				foreach ( $languages as $code => $url) {
					$filter_url = $url['url'];
					if ( $is_location ) {
						self::switch_lang( $code );
						$filter_url = trailingslashit( geodir_get_location_link( 'base' ) );
						if ($permalink_structure) {
							$filter_url .= implode( '/', array_values( $location_terms ) ) . '/';
						} else {
							$filter_url = add_query_arg( $location_terms, $filter_url );
						}
					} else {
						foreach ($keep_vars as $var) {
							if (isset($_GET[$var]) && !is_array($_GET[$var])) {
								$filter_url = remove_query_arg(array($var), $filter_url);
								$filter_url = add_query_arg(array($var => $_GET[$var]), $filter_url);
							}
						}
					}
					
					if ($filter_url != $url['url']) {
						$languages[$code]['url'] = $filter_url;
					}
				}
				if ( $is_location ) {
					self::switch_lang( $current_lang );
				}
			}
		}

		return $languages;
	}

	public static function post_permalink_structure_cpt_slug( $cpt_slug, $gd_post, $post_link ) {
		// Alter the CPT slug if WPML is set to do so
		if ( !empty( $gd_post ) && !empty( $gd_post->post_type ) && is_post_type_translated( $gd_post->post_type ) ) {
			if ( self::is_slug_translation_on( $gd_post->post_type ) && ( $language_code = self::get_lang_from_url( $post_link ) ) ) {
				$cpt_slug = self::translate_slug( $cpt_slug, $gd_post->post_type, $language_code );
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
			if ( is_post_type_translated( $post_type ) ) {
				if ( self::is_slug_translation_on( $post_type ) && ( $language_code = self::get_lang_from_url( $link ) ) ) {
					$org_slug = $slug;

					$slug = self::translate_string( $slug, 'WordPress', 'URL slug: ' . $post_type, $language_code );

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
		if ( is_post_type_translated( $post_type ) && self::is_slug_translation_on( $post_type ) ) {
			global $sitepress;
			$default_lang = $sitepress->get_default_language();
			$language_code = self::get_lang_from_url( $term_link );
			if ( ! $language_code ) {
				$language_code  = $default_lang;
			}

			$org_slug = $slug;
			$slug = self::translate_slug( $slug, $post_type, $language_code );

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
		global $sitepress, $geodir_wpml_after_save;
		
		$post_type = get_post_type($master_post_id);
		$icl_ajx_action = !empty($_REQUEST['icl_ajx_action']) && ( $_REQUEST['icl_ajx_action'] == 'make_duplicates' || $_REQUEST['icl_ajx_action'] == 'set_duplication' ) ? true : false;
		if (!empty($_REQUEST['action']) && $_REQUEST['action'] == 'wpml_duplicate_dashboard' && !empty($_REQUEST['duplicate_post_ids'])) {
			$icl_ajx_action = true;
		}
		
		if ( geodir_is_gd_post_type( $post_type ) ) {
			if ($icl_ajx_action || $after_save || $geodir_wpml_after_save) {
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
			$term_names = array();
			
			if ($terms) {
				foreach ($terms as $term) {
					$tr_id = apply_filters( 'translate_object_id',$term->term_id, $taxonomy, false, $lang);
					
					if (!is_null($tr_id)){
						// not using get_term - unfiltered get_term
						$translated_term = $wpdb->get_row($wpdb->prepare("
							SELECT * FROM {$wpdb->terms} t JOIN {$wpdb->term_taxonomy} x ON x.term_id = t.term_id WHERE t.term_id = %d AND x.taxonomy = %s", $tr_id, $taxonomy));

						$terms_array[] = $translated_term->term_id;
						$term_names[] = $translated_term->name;
					}
				}

				if (!is_taxonomy_hierarchical($taxonomy)){
					$terms_array = array_unique( array_map( 'intval', $terms_array ) );
				}

				wp_set_post_terms($tr_post_id, $terms_array, $taxonomy);

				if ( $taxonomy == $post_type . 'category' ) {
					geodir_save_post_meta( $tr_post_id, 'post_category',  ','. implode( ',', $terms_array ) . ',' );
					geodir_save_post_meta( $tr_post_id, 'default_category', $terms_array[0] );
				} else if ( $taxonomy == $post_type . '_tags' ) {
					geodir_save_post_meta( $tr_post_id, 'post_tags', implode( ',', $term_names ) );
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
	 * @return string Filtered html of the geodir_edit_post_link() function.
	 */
	public static function post_detail_duplicates() {
		global $post, $preview, $sitepress;

		$content = '';

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
					
					$wpml_content = '<div class="geodir-company_info gd-detail-duplicate"><h3 class="widget-title">' . __( 'Translate Listing', 'geodir-multilingual' ) . '</h3>';
					$wpml_content .= '<table class="gd-duplicate-table" style="width:100%;margin:0"><tbody>';
					$wpml_content .= '<tr style="border-bottom:solid 1px #efefef"><th style="padding:0 2px 2px 2px">' . __( 'Language', 'geodir-multilingual' ) . '</th><th style="width:25px;"></th><th style="width:5em;text-align:center">' . __( 'Translate', 'geodir-multilingual' ) . '</th></tr>';
					
					$needs_translation = false;
					
					foreach ( $wpml_languages as $lang_code => $lang ) {
						$duplicates_text = '';
						$translated = false;
						
						if ( !empty( $element_translations ) && isset( $element_translations[$lang_code] ) ) {
							$translated = true;
							
							if ( !empty( $duplicates ) && isset( $duplicates[$lang_code] ) ) {
								$duplicates_text = ' ' . __( '(duplicate)', 'geodir-multilingual' );
							}
						} else {
							$needs_translation = true;
						}
						
						$wpml_content .= '<tr><td style="padding:4px">' . $lang['english_name'] . $duplicates_text . '</td><td>&nbsp;</td><td style="text-align:center;">';
						
						if ( $translated ) {
							$wpml_content .= '<i class="fa fa-check" style="color:orange"></i>';
						} else {
							$wpml_content .= '<input name="gd_icl_dup[]" value="' . $lang_code . '" title="' . esc_attr__( 'Create duplicate', 'geodir-multilingual' ) . '" type="checkbox">';
						}
						
						$wpml_content .= '</td></tr>';
					}
					
					if ( $needs_translation ) {
						$wpml_content .= '<tr><td colspan="3" style="text-align:right"><i style="display:none" class="fa fa-spin fa-refresh"></i> <button data-nonce="' . esc_attr( wp_create_nonce( 'geodir-duplicate-post' ) ) . '" data-post-id="' . $post_id . '" id="gd_make_duplicates" class="button-secondary">' . __( 'Duplicate', 'geodir-multilingual' ) . '</button></td></tr>';
					}
					
					$wpml_content .= '</tbody></table>';
					$wpml_content .= '</div>';
					
					$content .= $wpml_content;
				}
			}
		}
		
		return $content;
	}

	public static function frontend_duplicate() {
		check_ajax_referer( 'geodir-duplicate-post', 'security' );

		$post_id = !empty( $_REQUEST['post_id'] ) ? absint( $_REQUEST['post_id'] ) : 0;
		$langs = !empty( $_REQUEST['dups'] ) ? explode( ',', sanitize_text_field( $_REQUEST['dups'] ) ) : array();

		try {
			$data = array();
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
						$data['done'] = true;
					} else {
						throw new Exception( __( 'Translation can be done from original listing only.', 'geodir-multilingual' ) );
					}
				} else {
					throw new Exception( __( 'You are not allowed to translate this listing.', 'geodir-multilingual' ) );
				}
			}
			wp_send_json_success( $data );
		} catch ( Exception $e ) {
			wp_send_json_error( array( 'message' => $e->getMessage() ) );
		}
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
		
		if ( empty( $post_id ) ) {
			return $allowed;
		}
		
		$user_id = (int)get_current_user_id();
		
		if ( empty( $user_id ) ) {
			return $allowed;
		}
		
		$post_type = get_post_type( $post_id );
		if ( ! is_post_type_translated( $post_type ) || get_post_meta( $post_id, '_icl_lang_duplicate_of', true ) ) {
			return $allowed;
		}
		
		if ( geodir_listing_belong_to_current_user( $post_id ) ) {
			$allowed = true;
		}

		if ( $allowed && ! self::allow_frontend_duplicate( $post_type ) ) {
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
	public static function get_lang_from_url( $url ) {
		global $sitepress;

		return $sitepress->get_language_from_url( $url );
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

	public static function filter_single_type_join( $join, $post_type ) {
		global $wpml_query_filter;

		if ( ! empty( $wpml_query_filter ) && self::is_translated_post_type( $post_type ) ) {
			$join = $wpml_query_filter->filter_single_type_join( $join, $post_type );
		}

		return $join;
	}

	public static function filter_single_type_where( $where, $post_type ) {
		global $wpml_query_filter;

		if ( ! empty( $wpml_query_filter ) && self::is_translated_post_type( $post_type ) ) {
			$where = $wpml_query_filter->filter_single_type_where( $where, $post_type );
		}

		return $where;
	}

	public static function posts_join( $join, $query ) {
		global $wpdb, $geodir_post_type, $wpml_query_filter;

		if ( ! empty( $_REQUEST['stype'] ) && geodir_is_page( 'search' ) ) {
			$post_type = sanitize_text_field( $_REQUEST['stype'] );
		} else {
			$post_type = $geodir_post_type;
		}

		if ( $post_type ) {
			$join = self::filter_single_type_join( $join, $post_type );
		}

		return $join;
	}

	public static function posts_where( $where, $query ) {
		global $geodir_post_type;

		if ( ! empty( $_REQUEST['stype'] ) && geodir_is_page( 'search' ) ) {
			$post_type = sanitize_text_field( $_REQUEST['stype'] );
		} else {
			$post_type = $geodir_post_type;
		}

		if ( $post_type ) {
			$where = self::filter_single_type_where( $where, $post_type );
		}

		return $where;
	}

	public static function widget_posts_join( $join, $post_type ) {
		if ( $post_type ) {
			$join = self::filter_single_type_join( $join, $post_type );
		}

		return $join;
	}

	public static function widget_posts_where( $where, $post_type ) {
		if ( $post_type ) {
			$where = self::filter_single_type_where( $where, $post_type );
		}

		return $where;
	}

	public static function rest_markers_query_join( $join, $request ) {
		global $wpdb;

		if ( ! empty( $request['post_type'] ) ) {
			$wpml_join = self::filter_single_type_join( '', $request['post_type'] );
			$wpml_join = str_replace( " {$wpdb->posts}.", " p.", $wpml_join );

			$join .= $wpml_join;
		}

		return $join;
	}

	public static function rest_markers_query_where( $where, $request ) {
		global $wpdb;

		if ( ! empty( $request['post_type'] ) ) {
			$wpml_where = self::filter_single_type_where( '', $request['post_type'] );
			$wpml_where = str_replace( array( " {$wpdb->posts} p", " p." ), array( " {$wpdb->posts} wpml_p", " wpml_p." ), $wpml_where );
			$wpml_where = str_replace( " {$wpdb->posts}.", " p.", $wpml_where );

			$where .= $wpml_where;
		}

		return $where;
	}

	public static function get_post_language( $post_ID ) {
		global $sitepress;

		$post_lang = $post_ID ? $sitepress->post_translations()->get_element_lang_code( $post_ID ) : self::get_current_language();
		if ( ! $post_lang ) {
			$post_lang = $sitepress->post_translations()->get_save_post_lang( $post_ID, $sitepress );
		}

		return $post_lang;
	}

	public static function get_save_post_trid( $post ) {
		global $sitepress;

		$post_id     = isset( $post->ID ) ? $post->ID : 0;
		$post_status = isset( $post->post_status ) ? $post->post_status : '';

		return $sitepress->post_translations()->get_save_post_trid( $post_id, $post_status );
	}

	public static function get_post_source_lang_code( $post_ID ) {
		global $sitepress;

		$post_lang = $post_ID ? $sitepress->post_translations()->get_source_lang_code( $post_ID ) : self::get_current_language();
		if ( ! $post_lang ) {
			$post_lang = $sitepress->post_translations()->get_save_post_lang( $post_ID, $sitepress );
		}

		return $post_lang;
	}

	public static function unique_post_slug_posts_join( $join, $post_ID, $post_type ) {
		global $wpdb;

		if ( empty( $post_ID ) || empty( $post_type ) ) {
			return $join;
		}

		if ( is_post_type_translated( $post_type ) && ( $post_lang = self::get_post_language( $post_ID ) ) ) {
			$join .= " JOIN {$wpdb->prefix}icl_translations AS icl_t ON p.ID = icl_t.element_id AND icl_t.element_type = CONCAT( 'post_', p.post_type )";
		}

		return $join;
	}

	public static function unique_post_slug_posts_where( $where, $post_ID, $post_type ) {
		global $wpdb;

		if ( empty( $post_ID ) || empty( $post_type ) ) {
			return $where;
		}

		if ( is_post_type_translated( $post_type ) && ( $post_lang = self::get_post_language( $post_ID ) ) ) {
			$where .= " AND icl_t.language_code = '" . $post_lang . "'";
		}

		return $where;
	}

	public static function unique_post_slug_terms_join( $join, $post_ID, $post_type ) {
		global $wpdb;

		if ( empty( $post_ID ) || empty( $post_type ) ) {
			return $join;
		}

		if ( is_post_type_translated( $post_type ) && ( $post_lang = self::get_post_language( $post_ID ) ) ) {
			$join .= " JOIN {$wpdb->prefix}icl_translations AS icl_t ON icl_t.element_id = tt.term_taxonomy_id AND icl_t.element_type = CONCAT( 'tax_', tt.taxonomy )";
		}

		return $join;
	}

	public static function unique_post_slug_terms_where( $where, $post_ID, $post_type ) {
		global $wpdb;

		if ( empty( $post_ID ) || empty( $post_type ) ) {
			return $where;
		}

		if ( is_post_type_translated( $post_type ) && ( $post_lang = self::get_post_language( $post_ID ) ) ) {
			$where .= " AND icl_t.language_code = '" . $post_lang ."'";
		}

		return $where;
	}

	public static function unique_term_slug_posts_join( $join, $term_id, $taxonomy, $post_type ) {
		global $wpdb, $sitepress;

		if ( empty( $term_id ) || empty( $post_type ) ) {
			return $join;
		}

		$term_lang = self::get_language_for_element( $term_id, 'tax_' . $taxonomy );
        if ( ! $term_lang ) {
            $term_lang = self::get_current_language();
        }

		if ( is_taxonomy_translated( $taxonomy ) && is_post_type_translated( $post_type ) && $term_lang ) {
			$join .= " JOIN {$wpdb->prefix}icl_translations AS icl_t ON p.ID = icl_t.element_id AND icl_t.element_type = CONCAT( 'post_', p.post_type )";
		}

		return $join;
	}

	public static function unique_term_slug_posts_where( $where, $term_id, $taxonomy, $post_type ) {
		global $wpdb;

		if ( empty( $term_id ) || empty( $post_type ) ) {
			return $where;
		}

		$term_lang = self::get_language_for_element( $term_id, 'tax_' . $taxonomy );
        if ( ! $term_lang ) {
            $term_lang = self::get_current_language();
        }

		if ( is_taxonomy_translated( $taxonomy ) && is_post_type_translated( $post_type ) && $term_lang ) {
			$where .= " AND icl_t.language_code = '" . $term_lang . "'";
		}

		return $where;
	}

	public static function export_categories_csv_columns( $row, $post_type ) {
		if ( is_taxonomy_translated( $post_type . 'category' ) ) {
			$row[] = 'cat_language';
			$row[] = 'cat_id_original';
		}
		return $row;
	}

	public static function export_categories_csv_row( $row, $term_id, $post_type ) {
		if ( is_taxonomy_translated( $post_type . 'category' ) ) {
			$row[] = self::get_language_for_element( $term_id, 'tax_' . $post_type . 'category' );
			$row[] = self::get_original_element_id( $term_id, 'tax_' . $post_type . 'category' );
		}
		return $row;
	}

	public static function export_posts_csv_columns( $row, $post_type ) {
		if ( is_post_type_translated( $post_type ) ) {
			$row[] = 'language';
			$row[] = 'original_post_id';
		}
		return $row;
	}

	public static function export_posts_csv_row( $row, $term_id, $post_type ) {
		if ( is_post_type_translated( $post_type ) ) {
			$row[] = self::get_language_for_element( $term_id, 'post_' . $post_type );
			$row[] = self::get_original_element_id( $term_id, 'post_' . $post_type );
		}
		return $row;
	}

	public static function filter_query_var_categories( $categories, $post_type ) {
		if ( ! empty( $categories ) && is_array( $categories ) && ! in_array( '0', $categories ) && is_taxonomy_translated( $post_type . 'category' ) ) {
			$categories = self::get_object_ids( $categories, $post_type . 'category' );
        }

		return $categories;
	}

	public static function import_category_validate_item( $item, $data ) {
		$item['cat_language']    = ! empty( $data['cat_language'] ) ? trim( $data['cat_language'] ) : '';
		$item['cat_id_original'] = ! empty( $data['cat_id_original'] ) ? absint( $data['cat_id_original'] ) : '';

		return $item;
	}

	public static function category_imported( $term_id, $term_data ) {
		if ( ! empty( $term_id ) && ! empty( $term_data['cat_language'] ) && ! empty( $term_data['cat_id_original'] ) && is_taxonomy_translated( $term_data['taxonomy'] ) ) {
			$element_type = 'tax_' . $term_data['taxonomy'];
			$trid = $sitepress->get_element_trid( (int) $term_data['cat_id_original'], $element_type );
			$source_lang = self::get_language_for_element( $term_id, $element_type );
			if ( ! $source_lang ) {
				$source_lang = self::get_default_language();
			}

			$sitepress->set_element_language_details( $term_id, $element_type, $trid, $term_data['cat_language'], $source_lang );
		}
	}

	public static function map_categories_term_id( $term_id, $post_type ) {
		if ( is_taxonomy_translated( $post_type . 'category' ) ) {
			$default_lang = self::get_default_language();
			$term_id = self::get_object_id( $term_id, $post_type . 'category', true, $default_lang );
		}
		return $term_id;
	}

	public static function option_add_listing_page( $page_id ) {
		return self::get_element_id( $page_id, 'post_page' );
	}

	public static function recent_reviews_query_join( $join, $post_type = '', $add_location_filter = false ) {
		global $wpdb;

		if ( $current_lang = self::get_current_language() ) {
			$join .= " JOIN {$wpdb->prefix}icl_translations AS icltr2 ON icltr2.element_id = c.comment_post_ID AND p.ID = icltr2.element_id AND CONCAT( 'post_', p.post_type ) = icltr2.element_type LEFT JOIN {$wpdb->prefix}icl_translations AS icltr_comment ON icltr_comment.element_id = c.comment_ID AND icltr_comment.element_type = 'comment'";
		}

		return $join;
	}

	public static function recent_reviews_query_where( $where, $post_type = '', $add_location_filter = false ) {
		global $wpdb;

		if ( $current_lang = self::get_current_language() ) {
			$where .= " AND icltr2.language_code = '{$current_lang}' AND ( icltr_comment.language_code IS NULL OR icltr_comment.language_code = icltr2.language_code )";
		}

		return $where;
	}

	public static function home_url( $home_url = '' ) {
		return apply_filters( 'wpml_home_url', $home_url );
	}

	public static function before_count_terms( $post_type, $taxonomy, $args ) {
		self::store_lang();
	}

	public static function after_count_terms( $post_type, $taxonomy, $args ) {
		self::restore_lang();
	}

	public static function export_posts_set_globals( $post_type ) {
		self::store_lang();
	}

	public static function export_posts_reset_globals( $post_type ) {
		self::restore_lang();
	}

	public static function export_categories_set_globals( $post_type ) {
		self::store_lang();
	}

	public static function export_categories_reset_globals( $post_type ) {
		self::restore_lang();
	}

	public static function import_category_set_globals( $cat_info ) {
		if ( ! empty( $cat_info['cat_language'] ) ) {
			self::store_lang( $cat_info['cat_language'] );
		}
	}

	public static function import_category_reset_globals( $cat_info ) {
		if ( ! empty( $cat_info['cat_language'] ) ) {
			self::restore_lang();
		}
	}

	public static function switch_locale( $lang ) {
		return self::switch_lang( $lang );
	}

	public static function restore_locale( $lang ) {
		return self::switch_lang( $lang );
	}

	public static function allow_frontend_duplicate( $post_type ) {
		$post_types = $post_types = geodir_get_posttypes( 'array' );

		if ( ! empty( $post_types ) && ! empty( $post_types[$post_type]['wpml_duplicate'] ) ) {
			$allow = true;
		} else {
			$allow = false;
		}
		return apply_filters( 'geodir_multilingual_post_type_allow_frontend_duplicate', $allow, $post_type );
	}

	/**
	 * Fires once a post has been saved.
	 *
	 * @param int     $post_ID Post ID.
	 * @param WP_Post $post    Post object.
	 * @param bool    $update  Whether this is an existing post being updated or not.
	 */
	public static function setup_save_post( $post_ID, $post, $update = false ) {
		global $geodir_wpml_after_save;

		$geodir_wpml_after_save = $update && geodir_is_gd_post_type( get_post_type( $post_ID ) ) ? true : false;
	}

	public static function copy_from_original_custom_fields( $builtin_custom_fields ) {
		global $wpdb;

		$trid = filter_input( INPUT_POST, 'trid' );
		$content_type = filter_input( INPUT_POST, 'content_type' );
        $excerpt_type = filter_input( INPUT_POST, 'excerpt_type' );
        $lang = filter_input( INPUT_POST, 'lang' );
		$post_lang = isset( $_POST[ 'trlang' ] ) ? filter_input( INPUT_POST, 'trlang' ) : self::get_post_language( $trid );

		$post_id = $wpdb->get_var( $wpdb->prepare( "SELECT element_id FROM {$wpdb->prefix}icl_translations WHERE trid=%d AND language_code=%s", $trid, $lang ) );
		if ( empty( $post_id ) ) {
			return $builtin_custom_fields;
		}

		$post_type = get_post_type( $post_id );
		if ( ! geodir_is_gd_post_type( $post_type ) ) {
			return $builtin_custom_fields;
		}

		$gd_post = geodir_get_post_info( $post_id );
		if ( empty( $gd_post ) ) {
			return $builtin_custom_fields;
		}

		$custom_fields  = geodir_post_custom_fields( '', 'all', $post_type );
		if ( empty( $custom_fields ) ) {
			return $builtin_custom_fields;
		}

		$field_names = array_keys( (array) $gd_post );

		$fields = array();
		foreach ( $custom_fields as $id => $field ) {
			$field_type = $field['field_type'];
			$name = $field['htmlvar_name'];

			if ( in_array( $name, array( 'post_images', 'fieldset' ) ) ) {
				continue;
			}
			$extra_fields = !empty($field['extra_fields']) ? maybe_unserialize($field['extra_fields']) : NULL;

			switch ( $field_type ) {
				case 'categories':
					$taxonomy = $post_type . 'category';
					$cat_display_type = ! empty( $extra_fields['cat_display_type'] ) ? $extra_fields['cat_display_type'] : 'multiselect';
					$value = ! empty( $gd_post->{$name} ) ? $gd_post->{$name} : '';

					if ( $cat_display_type == 'multiselect' || $cat_display_type == 'checkbox' ) {
						$editor_type = $cat_display_type == 'checkbox' ? 'multicheckbox' : 'multiselect';
						$values = ! empty( $value ) ? explode( ',', $value ) : array();
						$value = array();
						if ( ! empty( $values ) ) {
							foreach ( $values as $value_id ) {
								if ( ! empty( $value_id ) && ( $term_id = apply_filters( 'translate_object_id', (int) $value_id, $taxonomy, false, $post_lang ) ) ) {
									$value[] = $term_id;
								}
							}
						}
					} else {
						$editor_type = $cat_display_type;
						$value = ! empty( $value ) ? apply_filters( 'translate_object_id', (int) $value, $taxonomy, false, $post_lang ) : '';
					}

					$fields[ $name ] = array(
						'editor_name' => $taxonomy,
						'editor_type' => $editor_type,
						'value'       => $value
					);
					$fields[ 'default_category' ] = array(
						'editor_name' => 'default_category',
						'editor_type' => 'text',
						'value'       => ! empty( $gd_post->default_category ) ? apply_filters( 'translate_object_id', (int) $gd_post->default_category, $taxonomy, false, $post_lang ) : ''
					);
					break;
				case 'multiselect':
					$multi_display_type = isset($extra_fields['multi_display_type']) ? $extra_fields['multi_display_type'] : 'select';
					$value = ! empty( $gd_post->{$name} ) ? explode( ',', $gd_post->{$name} ) : array();
					if ( $multi_display_type == 'radio' ) {
						$editor_type = 'radio';
						$value = ! empty( $value ) ? $value[0] : '';
					} else if ( $multi_display_type == 'checkbox' ) {
						$editor_type = 'multicheckbox';
					} else {
						$editor_type = 'multiselect';
						$value = $value;
					}

					$fields[ $name ] = array(
						'editor_name' => $name,
						'editor_type' => $editor_type,
						'value'       => $value
					);

					break;
				case 'address':
					$address_fields = array( 'street', 'country', 'region', 'city', 'neighbourhood', 'zip', 'latitude', 'longitude', 'mapview', 'mapzoom' );

					foreach ( $address_fields as $key ) {
						$fields[ $key ] = array(
							'editor_name' => 'address_' . $key,
							'editor_type' => 'text',
							'value'       => isset ( $gd_post->{$key} ) ? $gd_post->{$key} : ''
						);
					}

					break;
				case 'checkbox':
					$fields[ $name ] = array(
						'editor_name' => $name,
						'editor_type' => 'checkbox',
						'value'       => isset ( $gd_post->{$name} ) ? (int) $gd_post->{$name} : 0
					);
					break;
				case 'html':
					$fields[ $name ] = array(
						'editor_name' => $name,
						'editor_type' => 'editor',
						'value'       => isset ( $gd_post->{$name} ) ? $gd_post->{$name} : ''
					);
					break;
				default:
					if ( in_array( $field_type, array( 'file', 'radio', 'select', 'business_hours' ) ) ) {
						$editor_type = $field_type;
					} else {
						$editor_type = 'text';
					}
					$fields[ $name ] = array(
						'editor_name' => $name,
						'editor_type' => $editor_type,
						'value'       => isset ( $gd_post->{$name} ) ? $gd_post->{$name} : ''
					);
					break;
			}
		}

		$fields = apply_filters( 'geopdir_multilingual_wpml_copy_from_original_custom_fields', $fields, $gd_post, $trid, $lang, $content_type, $excerpt_type );

		if ( ! empty( $fields ) && is_array( $fields ) ) {
			$builtin_custom_fields = array_merge( $builtin_custom_fields, $fields );
		}

		return $builtin_custom_fields;
	}

	public static function translate_slug( $slug, $post_type, $language_code ) {
		$slug_translated = self::translate_string( $slug, 'WordPress', 'URL slug: ' . $post_type, $language_code );

		if ( ! $slug_translated ) {
			$slug_translated = $slug;
		}

		return $slug_translated;
	}

	public static function post_type_archive_link_slug( $slug, $post_type, $link ) {
		if ( is_post_type_translated( $post_type ) && self::is_slug_translation_on( $post_type ) && ( $language_code = self::get_lang_from_url( $link ) ) ) {
			$slug = self::translate_slug( $slug, $post_type, $language_code );
		}
		return $slug;
	}

	/**
	 * @param int     $pidd
	 * @param WP_Post $post
	 *
	 * @return void
	 */
	public static function wpml_media_duplicate( $pidd, $post ) {
		global $wpdb, $sitepress;

		$request_post_icl_ajx_action = filter_input(INPUT_POST, 'icl_ajx_action', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_NULL_ON_FAILURE);

		if ( empty( $pidd ) || empty( $post ) || $request_post_icl_ajx_action == 'make_duplicates' || get_post_meta( $pidd, '_icl_lang_duplicate_of', true ) ) {
			return;
		}

		if ( $post->post_status == "auto-draft" || ! geodir_is_gd_post_type( $post->post_type ) ) {
			return;
		}

		$posts_prepared = $wpdb->prepare("SELECT post_type, post_status FROM {$wpdb->posts} WHERE ID = %d", array($pidd));
		list( $post_type, $post_status ) = $wpdb->get_row( $posts_prepared, ARRAY_N );

		// checking - if translation and not saved before
		if ( isset( $_GET[ 'trid' ] ) && !empty( $_GET[ 'trid' ] ) && $post_status == 'auto-draft' ) {
			// get source language
			if ( isset( $_GET[ 'source_lang' ] ) && !empty( $_GET[ 'source_lang' ] ) ) {
				$src_lang = $_GET[ 'source_lang' ];
			} else {
				$src_lang = self::get_default_language();
			}

			// get source id
			$src_id_prepared =  $wpdb->prepare("SELECT element_id FROM {$wpdb->prefix}icl_translations WHERE trid=%d AND language_code=%s", array($_GET['trid'], $src_lang));
			$src_id = $wpdb->get_var( $src_id_prepared );

			// checking - if set duplicate media
			if ( get_post_meta( $src_id, '_wpml_media_duplicate', true ) ) {
				// duplicate media before first save
				self::duplicate_post_attachments( $pidd, $_GET[ 'trid' ], $src_lang, self::get_language_for_element( $pidd, 'post_' . $post_type ) );
			}
		}

		// exceptions
		if (
			!self::is_translated_post_type( $post_type )
			|| isset( $_POST[ 'autosave' ] )
			|| ( isset( $_POST[ 'post_ID' ] ) && $_POST[ 'post_ID' ] != $pidd )
			|| ( isset( $_POST[ 'post_type' ] ) && $_POST[ 'post_type' ] === 'revision' )
			|| $post_type === 'revision'
			|| get_post_meta( $pidd, '_wp_trash_meta_status', true )
			|| ( isset( $_GET[ 'action' ] ) && $_GET[ 'action' ] === 'restore' )
			|| $post_status === 'auto-draft'
		) {
			return;
		}

		if ( isset( $_POST[ 'icl_trid' ] ) ) {
			$icl_trid = $_POST[ 'icl_trid' ];
		} else {
			// get trid from database.
			$icl_trid_prepared = $wpdb->prepare("SELECT trid FROM {$wpdb->prefix}icl_translations WHERE element_id=%d AND element_type = %s", array($pidd, 'post_' . $post_type));
			$icl_trid = $wpdb->get_var( $icl_trid_prepared );
		}

		if ( $icl_trid ) {
			$language_details = $sitepress->get_element_language_details( $pidd, 'post_' . $post_type );

			// In some cases the sitepress cache doesn't get updated (e.g. when posts are created with wp_insert_post()
			// Only in this case, the sitepress cache will be cleared so we can read the element language details
			if ( !$language_details ) {
				$sitepress->get_translations_cache()->clear();
				$language_details = $sitepress->get_element_language_details( $pidd, 'post_' . $post_type );
			}
			if ( $language_details ) {
				self::duplicate_post_attachments( $pidd, $icl_trid, $language_details->source_language_code, $language_details->language_code );
			}
		}
	}

	public static function duplicate_post_attachments( $pidd, $icl_trid, $source_lang = null, $lang = null ) {
		global $wpdb;

		if ( $icl_trid == "" ) {
			return;
		}

		if ( !$source_lang ) {
			$source_lang_prepared = $wpdb->prepare( "SELECT source_language_code FROM {$wpdb->prefix}icl_translations WHERE element_id = %d AND trid=%d", array($pidd, $icl_trid));
			$source_lang = $wpdb->get_var( $source_lang_prepared );
		}
		
		if ( $source_lang == null || $source_lang == "" ) {
			// This is the original see if we should copy to translations

            if ( get_post_meta( $pidd, '_wpml_media_duplicate', true ) ) {
				$translations_prepared = $wpdb->prepare("SELECT element_id FROM {$wpdb->prefix}icl_translations WHERE trid = %d", array($icl_trid));
				$translations = $wpdb->get_col( $translations_prepared );

				foreach ( $translations as $element_id ) {
					if ( $element_id && $element_id != $pidd && ! get_post_meta( $element_id, '_icl_lang_duplicate_of', true ) && get_post_meta( $element_id, '_wpml_media_duplicate', true ) ) {

						$lang_prepared = $wpdb->prepare( "SELECT language_code FROM {$wpdb->prefix}icl_translations WHERE element_id = %d AND trid = %d", array($element_id, $icl_trid ));
						$lang = $wpdb->get_var( $lang_prepared );
						self::duplicate_post_images($pidd, $element_id, $lang);
					}
				}
			}
		} else {
			// This is a translation.
			// exception for making duplicates. language info not set when this runs and creating the duplicated posts 2/3
			$source_id_prepared = $wpdb->prepare("SELECT element_id FROM {$wpdb->prefix}icl_translations WHERE language_code = %s AND trid = %d", array($source_lang, $icl_trid));
			$source_id = $wpdb->get_var( $source_id_prepared );
		
			if ( !$lang ) {
				$lang_prepared = $wpdb->prepare( "SELECT language_code FROM {$wpdb->prefix}icl_translations WHERE element_id = %d AND trid = %d", array($pidd, $icl_trid));
				$lang = $wpdb->get_var( $lang_prepared );
			}

			$duplicate = get_post_meta( $pidd, '_wpml_media_duplicate', true );
			if ( !$duplicate ) {
				// check the original state
				$duplicate = get_post_meta( $source_id, '_wpml_media_duplicate', true );
			}

			if ( $duplicate ) {
				// Duplicate post images
				self::duplicate_post_images($source_id, $pidd, $lang);
			}
		}
	}

	public static function setup_copy_from_original( $post ) {
		if ( empty( $post ) ) {
			global $post;
		}

		if ( empty( $post ) ) {
			return;
		}

		if ( ! geodir_is_gd_post_type( $post->post_type ) || ! is_post_type_translated( $post->post_type ) ) {
			return;
		}

		$source_lang = filter_var( isset( $_GET['source_lang'] ) ? $_GET['source_lang'] : '', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
		$source_lang = 'all' === $source_lang ? self::get_default_language() : $source_lang;
		$lang        = filter_var( isset( $_GET['lang'] ) ? $_GET['lang'] : '', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
		$source_lang = ! $source_lang && isset( $_GET['post'] ) && $lang !== self::get_default_language() ? self::get_post_source_lang_code( $post->ID ) : $source_lang;

		if ( $source_lang && $source_lang !== $lang ) {
			$trid = self::get_save_post_trid( $post );

			echo '<input type="hidden" id="geodir_copy_from_original" data-tr_lang="' . self::get_post_language( $post->ID ) . '" data-source_lang="' . $source_lang . '" data-trid="' . $trid . '">';
		}
	}

	public static function geodir_bp_listings_count_join($join, $post_type){
        global $table_prefix;

	    $join .= " JOIN " . $table_prefix . "icl_translations AS icl_t ON icl_t.element_id = p.ID";
        return $join;
    }

    public static function geodir_bp_listings_count_where($where, $post_type){
        $lang_code = ICL_LANGUAGE_CODE;

        $where .= " AND icl_t.language_code = '" . $lang_code . "' AND icl_t.element_type = 'post_" . $post_type . "'";
        return $where;
    }

    public static function geodir_bp_listings_join($join, $post_type){
        global $table_prefix, $wpdb;

        $join .= " JOIN " . $table_prefix . "icl_translations AS icl_t ON icl_t.element_id = " . $wpdb->posts . ".ID";
        return $join;
    }

    public static function geodir_bp_listings_where($where, $post_type){
        $lang_code = ICL_LANGUAGE_CODE;

        $where .= " AND icl_t.language_code = '" . $lang_code . "' AND icl_t.element_type = 'post_" . $post_type . "'";
        return $where;
    }

    public static function geodir_bp_favorite_count_where($where, $post_type){
        $lang_code = ICL_LANGUAGE_CODE;

        $where .= " AND icl_t.language_code = '" . $lang_code . "' AND icl_t.element_type = 'post_" . $post_type . "'";
        return $where;
    }

    public static function geodir_bp_reviews_count_join($join, $post_type){
        global $table_prefix;

        $join .= " JOIN " . $table_prefix . "icl_translations AS icl_t ON icl_t.element_id = p.ID";
        return $join;
    }

    public static function geodir_bp_reviews_count_where($where, $post_type){
        $lang_code = ICL_LANGUAGE_CODE;

        $where .= " AND icl_t.language_code = '" . $lang_code . "' AND icl_t.element_type = 'post_" . $post_type . "'";
        return $where;
    }

	public static function allow_invoice_for_listing( $allow, $post_ID ) {
		if ( $allow && is_post_type_translated( get_post_type( $post_ID ) ) && get_post_meta( $post_ID, '_icl_lang_duplicate_of', true ) ) {
			$allow = false; // Do not allow to create invoice for duplicated listing.
		}
		return $allow;
	}
}