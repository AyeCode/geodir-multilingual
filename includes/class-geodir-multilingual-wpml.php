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

		// WordPress
		if ( ! is_admin() ) {
			add_action( 'wp_loaded', array( __CLASS__, 'wp_loaded' ), 11 );
			add_filter( 'preview_post_link', array( __CLASS__, 'preview_post_link' ), 999, 2 );
		}

		add_filter( 'wpml_current_language', array( __CLASS__, 'wpml_current_language' ), 999, 1 );
		add_filter( 'icl_ls_languages', array( __CLASS__, 'icl_ls_languages' ), 11, 1 );
		add_filter( 'icl_lang_sel_copy_parameters', array( __CLASS__, 'icl_lang_sel_copy_parameters' ), 11, 1 );
		add_filter( 'geodir_get_page_id', array( __CLASS__, 'get_page_id' ), 10, 4 );
		add_filter( 'geodir_get_noindex_page_ids', array( __CLASS__, 'get_noindex_page_ids' ), 10, 1 );
		add_filter( 'geodir_is_archive_page_id', array( __CLASS__, 'is_archive_page_id' ), 10, 2 );
		add_filter( 'geodir_is_geodir_page_id', array( __CLASS__, 'is_geodir_page_id' ), 10, 2 );
		add_filter( 'geodir_post_permalink_structure_cpt_slug', array( __CLASS__, 'post_permalink_structure_cpt_slug' ), 10, 3 );
		add_filter( 'geodir_post_url_filter_term', array( __CLASS__, 'post_url_filter_term' ), 10, 3 );
		add_filter( 'geodir_cpt_permalink_rewrite_slug', array( __CLASS__, 'cpt_permalink_rewrite_slug' ), 10, 3 );
		add_filter( 'geodir_cpt_template_pages', array( __CLASS__, 'cpt_template_pages' ), 10, 2 );
		add_filter( 'post_type_archive_link', array( __CLASS__, 'post_type_archive_link' ), 1000, 2 );
		add_filter( 'geodir_term_link', array( __CLASS__, 'term_link' ), 10, 3 );
		add_filter( 'geodir_posts_join', array( __CLASS__, 'posts_join' ), 10, 2 );
		add_filter( 'geodir_posts_where', array( __CLASS__, 'posts_where' ), 10, 2 );
		add_filter( 'geodir_filter_widget_listings_join', array( __CLASS__, 'widget_posts_join' ), 10, 2 );
		add_filter( 'geodir_filter_widget_listings_where', array( __CLASS__, 'widget_posts_where' ), 10, 2 );
		add_filter( 'geodir_rest_markers_query_join', array( __CLASS__, 'rest_markers_query_join' ), 10, 2 );
		add_filter( 'geodir_rest_markers_query_where', array( __CLASS__, 'rest_markers_query_where' ), 10, 2 );
		add_filter( 'geodir_filter_query_var_categories', array( __CLASS__, 'filter_query_var_categories' ), 10, 2 );
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
		add_filter( 'geodir_rest_url', array( __CLASS__, 'rest_url' ), 10, 4 );
		add_filter( 'geodir_ninja_form_widget_action_text', array( __CLASS__, 'register_dynamic_string' ), 99, 3 );
		add_filter( 'geodir_claim_widget_button_text', array( __CLASS__, 'register_dynamic_string' ), 99, 3 );

		add_action( 'sanitize_comment_cookies', array( __CLASS__, 'ajax_set_guest_lang' ), 1 );
		add_action( 'icl_make_duplicate', array( __CLASS__, 'make_duplicate' ), 11, 4 );
		add_action( 'geodir_language_file_add_string', array( __CLASS__, 'register_string' ), 10, 1 );
		add_action( 'geodir_category_imported', array( __CLASS__, 'category_imported' ), 10, 2 );
		add_action( 'geodir_before_count_terms', array( __CLASS__, 'before_count_terms' ), -100, 3 );
		add_action( 'geodir_after_count_terms', array( __CLASS__, 'after_count_terms' ), -100, 3 );
		add_action( 'save_post', array( __CLASS__, 'setup_save_post' ), 0, 3 );
		add_action( 'save_post', array( __CLASS__, 'wpml_media_duplicate' ), 101, 2 );
		add_action( 'icl_post_languages_options_after', array( __CLASS__, 'setup_copy_from_original' ), 10, 1 );
		add_action( 'geodir_location_get_terms_set_globals', array( __CLASS__, 'location_get_terms_set_globals' ), 10, 5 );
		add_action( 'geodir_location_get_terms_reset_globals', array( __CLASS__, 'location_get_terms_reset_globals' ), 10, 5 );
		add_filter( 'geodir_add_listing_page_url', array( __CLASS__, 'add_listing_page_url' ), 1, 3 );

		add_action( 'geodir_bp_listings_count_where', array( __CLASS__, 'geodir_bp_listings_count_where' ), 10, 2 );
		add_action( 'geodir_bp_listings_count_join', array( __CLASS__, 'geodir_bp_listings_count_join' ), 10, 2 );
		add_action( 'geodir_bp_listings_join', array( __CLASS__, 'geodir_bp_listings_join' ), 10, 2 );
		add_action( 'geodir_bp_listings_where', array( __CLASS__, 'geodir_bp_listings_where' ), 10, 2 );
		add_action( 'geodir_bp_favorite_count_join', array( __CLASS__, 'geodir_bp_favorite_count_join' ), 10, 2 );
		add_action( 'geodir_bp_favorite_count_where', array( __CLASS__, 'geodir_bp_favorite_count_where' ), 10, 2 );
		add_action( 'geodir_bp_reviews_count_join', array( __CLASS__, 'geodir_bp_reviews_count_join' ), 10, 2 );
		add_action( 'geodir_bp_reviews_count_where', array( __CLASS__, 'geodir_bp_reviews_count_where' ), 10, 2 );
		add_action( 'geodir_cp_search_posts_query_join', array( __CLASS__, 'cp_search_posts_query_join' ), 10, 4 );
		add_action( 'geodir_cp_search_posts_query_where', array( __CLASS__, 'cp_search_posts_query_where' ), 10, 4 );

		if ( $sitepress->get_setting( 'sync_comments_on_duplicates' ) ) {
			add_action( 'comment_post', array( __CLASS__, 'sync_comment' ), 100, 1 );
		}

		// Pricing manager
		add_filter( 'geodir_wpi_allow_invoice_for_listing', array( __CLASS__, 'allow_invoice_for_listing' ), 10, 2 );

		// Event Manager
		add_filter( 'geodir_event_calendar_extra_params', array( __CLASS__, 'event_calendar_extra_params' ), 10, 1 );

		// Add rewrite rules for translated slugs
		add_action( 'geodir_permalinks_post_rewrite_rule', array( __CLASS__, 'permalinks_post_rewrite_rule' ), 10, 6 );
		add_action( 'geodir_permalinks_author_rewrite_rule', array( __CLASS__, 'permalinks_author_rewrite_rule' ), 10, 6 );
		add_action( 'geodir_location_permalinks_post_rewrite_rule', array( __CLASS__, 'location_permalinks_post_rewrite_rule' ), 10, 7 );
		add_action( 'geodir_location_permalinks_cat_rewrite_rule', array( __CLASS__, 'location_permalinks_cat_rewrite_rule' ), 10, 8 );
		add_action( 'geodir_location_permalinks_tag_rewrite_rule', array( __CLASS__, 'location_permalinks_tag_rewrite_rule' ), 10, 8 );
		add_action( 'geodir_get_add_listing_rewrite_rules', array( __CLASS__, 'get_add_listing_rewrite_rules' ), 10, 1 );

		// Disable "Use WPML's Translation Editor" for GD CPTs
		add_filter( 'get_post_metadata', array( __CLASS__, 'get_post_metadata' ), 100, 4 );
		add_filter( 'rewrite_rules_array', array( __CLASS__, 'rewrite_rules_array' ), 11, 1 );
		
		// Import / Export
		add_action( 'geodir_import_post_before',  array( __CLASS__, 'import_post_before' ), 10, 1 );
		add_action( 'geodir_import_post_after',  array( __CLASS__, 'import_post_after' ), 10, 2 );
		add_filter( 'geodir_save_post_temp_data',  array( __CLASS__, 'save_post_temp_data' ), 1, 3 );
		
		add_action( 'template_redirect',  array( __CLASS__, 'on_template_redirect' ), 99 );

		// GetPaid
		add_filter( 'wpinv_is_success_page', array( __CLASS__, 'getpaid_is_success_page' ), 10, 1 );
		add_filter( 'wpinv_is_invoice_history_page', array( __CLASS__, 'getpaid_is_invoice_history_page' ), 10, 1 );
		add_filter( 'wpinv_is_subscriptions_history_page', array( __CLASS__, 'getpaid_is_subscriptions_history_page' ), 10, 1 );

		// Woo
		add_filter( 'geodir_pricing_wc_cart_product_id', array( __CLASS__, 'pricing_wc_cart_product_id' ), 20, 5 );
		add_filter( 'geodir_pricing_wc_get_package_id', array( __CLASS__, 'pricing_wc_get_package_id' ), 20, 2 );
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
	public static function get_original_element_id( $element_id, $element_type, $skip_empty = false, $all_statuses = true, $skip_cache = false ) {
		global $sitepress;

		$original_element_id = $sitepress->get_original_element_id( $element_id, $element_type, $skip_empty, $all_statuses, $skip_cache );
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

	public static function get_element_ids( $id, $element_type, $skip_empty = false, $all_statuses = true, $skip_cache = false ) {
		global $sitepress;

		$page_ids = array( absint( $id ) );

		$original_id = $sitepress->get_original_element_id( $id, $element_type, $skip_empty, $all_statuses, $skip_cache );

		if ( ! empty( $original_id ) ) {
			$page_ids[] = absint( $original_id );

			$trid = $sitepress->get_element_trid( $original_id, $element_type );

			if ( ! empty( $trid ) && ( $translations = $sitepress->get_element_translations( $trid, $element_type, $skip_empty, $all_statuses, $skip_cache ) ) ) {
				foreach ( $translations as $lang => $translation ) {
					if ( ! empty( $translation->element_id ) ) {
						$page_ids[] = absint( $translation->element_id );
					}
				}
			}

			$page_ids = array_unique( $page_ids );
		}

		return $page_ids;
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
		global $geodir_wpml_tmp_lang;

		if ( $translated ) {
			if ( $geodir_wpml_tmp_lang ) {
				$page_id = self::get_object_id( $page_id, 'page', true, $geodir_wpml_tmp_lang );
			} else {
				$page_id = self::get_object_id( $page_id, 'page', true );
			}
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
		global $sitepress;

		if ( wpml_is_ajax() && ! is_user_logged_in() ) {
			$cookie_setting_field = class_exists( 'WPML_Cookie_Setting' ) ? $sitepress->get_setting( WPML_Cookie_Setting::COOKIE_SETTING_FIELD ) : false;

			if ( ! $cookie_setting_field && empty( $_GET['lang'] ) && !( !empty( $_SERVER['REQUEST_URI'] ) && preg_match( '@\.(css|js|png|jpg|gif|jpeg|bmp)@i', basename( preg_replace( '@\?.*$@', '', $_SERVER['REQUEST_URI'] ) ) ) ) ) {
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
	public static function icl_ls_languages( $languages ) {
		global $wp_query, $sitepress, $wpml_post_translations, $wpml_term_translations;

		if ( geodir_is_page( 'search' ) || geodir_is_page( 'post_type' ) || geodir_is_page( 'location' ) || geodir_is_page( 'add-listing' ) ) {
			$current_language = $sitepress->get_current_language();
			$default_language = $sitepress->get_default_language();

			if ( geodir_is_page( 'post_type' ) ) {
				$post_type = geodir_get_current_posttype();

				if ( $current_language != $default_language && ! empty( $post_type ) && self::is_translated_post_type( $post_type ) && self::is_slug_translation_on( $post_type ) ) {
					$slash_helper = new WPML_Slash_Management();
					$post_type_object = get_post_type_object( $post_type );

					if ( isset( $post_type_object->rewrite ) ) {
						$slug = trim( $post_type_object->rewrite['slug'], '/' );
					} else {
						$slug = $post_type_object->name;
					}

					$slug = apply_filters( 'wpml_get_translated_slug', $slug, $post_type, $current_language );

					foreach ( $languages as $k => $lang ) {
						if ( empty( $lang[ 'missing' ] ) && $current_language != $lang['language_code'] ) {
							$translated_slug = apply_filters( 'wpml_get_translated_slug', $slug, $post_type, $lang['language_code'] );

							$link = $lang['url'];
							if ( is_string( $translated_slug ) ) {
								$link_parts = explode( '?', $link, 2 );

								$pattern = '#\/' . preg_quote( $slug, '#' ) . '\/#';
								$link_new = trailingslashit( preg_replace( $pattern, '/' . $translated_slug . '/', trailingslashit( $link_parts[0] ), 1 ) );
								$link = $slash_helper->match_trailing_slash_to_reference( $link_new, $link_parts[0] );
								$languages[ $k ][ 'url' ] = isset( $link_parts[1] ) ? $link . '?' . $link_parts[1] : $link;
							}
						}
					}
				}
			} else {
				$post_type = ! empty( $_REQUEST['stype'] ) ? sanitize_text_field( $_REQUEST['stype'] ) : '';
				$categories = ! empty( $_REQUEST['spost_category'] ) ? $_REQUEST['spost_category'] : NULL;
				if ( is_array( $categories ) ) {
					$categories = array_values( $categories );
				}

				$is_add_listing = false;
				$is_search = false;
				$is_location = false;
				$post_id = 0;

				if ( geodir_is_page( 'add-listing' ) ) {
					$is_add_listing = true;
					$post_type = ! empty( $_REQUEST['listing_type'] ) ? sanitize_text_field( $_REQUEST['listing_type'] ) : '';
					$post_id = ! empty( $_REQUEST['pid'] ) ? absint( $_REQUEST['pid'] ) : 0;
					$default_page_id = geodir_get_page_id( 'add', $post_type, false );
				} else if ( geodir_is_page( 'search' ) ) {
					$is_search = true;
					$default_page_id = geodir_get_page_id( 'search', '', false );
				} else {
					$is_location = true;
					$default_page_id = geodir_get_page_id( 'location', '', false );
				}

				$w_active_languages = apply_filters( 'wpml_active_languages_access', $sitepress->get_active_languages(), array( 'action' => 'read' ) );

				$languages_helper = new WPML_Languages( $wpml_term_translations, $sitepress, $wpml_post_translations );

				$translate_values = array();

				// 2. determine url
				foreach ( $w_active_languages as $k => $lang ) {
					$skip_lang = false;
					$translate_values[ $lang['code'] ] = array();

					$this_lang_tmp = $sitepress->get_current_language();

					$sitepress->switch_lang( $lang['code'] );

					if ( $is_add_listing ) {
						$page_id = absint( geodir_add_listing_page_id( $post_type ) );
					} else if ( $is_search ) {
						$page_id = absint( geodir_search_page_id() );
					} else {
						$page_id = absint( geodir_location_page_id() );
					}

					if ( ! empty( $categories ) && ! empty( $post_type ) ) {
						$is_array = is_array( $categories ) ? true : false;

						$translate_categories = apply_filters( 'geodir_filter_query_var_categories', $categories, $post_type );

						if ( ! empty( $translate_categories ) ) {
							$translate_values[ $lang['code'] ]['spost_category'] = $is_array ? $translate_categories : $translate_categories[0];
						}
					}

					if ( $default_language != $lang['code'] && $default_page_id == $page_id ) {
						$skip_lang = true;
					} else {
						if ( $is_add_listing ) {
							$post_id = $post_id > 0 ? self::get_object_id( $post_id, $post_type, true ) : 0;
							$page_url = geodir_add_listing_page_url( $post_type, $post_id );
						} else if ( $is_location ) {
							$page_url = geodir_get_location_link( 'current' );
						} else {
							$page_url = get_permalink( absint( $page_id ) );
						}

						$lang[ 'translated_url' ] = apply_filters( 'geodir_wpml_language_page_url', $page_url, $page_id, $lang['code'] );
						$lang[ 'missing' ]        = 0;
					}

					$sitepress->switch_lang( $this_lang_tmp );

					if ( ! $skip_lang ) {
						$w_active_languages[ $k ] = $lang;
					} else {
						unset( $w_active_languages[ $k ] );
					}
				}

				// 3.
				foreach ( $w_active_languages as $k => $v ) {
					$w_active_languages[ $k ] = $languages_helper->get_ls_language (
						$k,
						$current_language,
						$w_active_languages[ $k ]
					);
				}

				// 4. pass GET parameters
				$parameters_copied = apply_filters( 'icl_lang_sel_copy_parameters', array_map( 'trim', explode( ',', wpml_get_setting_filter( '', 'icl_lang_sel_copy_parameters' ) ) ) );
				if ( $parameters_copied ) {
					foreach ( $_GET as $k => $v ) {
						if ( in_array( $k, $parameters_copied ) ) {
							$gets_passed[ $k ] = $v;
						}
					}
				}
				if ( ! empty( $gets_passed ) ) {
					foreach ( $w_active_languages as $code => $al ) {
						if ( empty( $al[ 'missing' ] ) ) {
							$gets_passed = apply_filters( 'geodir_wpml_url_parameters_gets_passed', $gets_passed, $code, $w_active_languages[ $code ][ 'url' ] );

							$set_params = array();
							foreach ( $gets_passed as $k => $v ) {
								if ( isset( $translate_values[ $code ] ) && isset( $translate_values[ $code ][ $k ] ) ) {
									$v = $translate_values[ $code ][ $k ];
								}

								$set_params[ $k ] = $v;
							}

							$w_active_languages[ $code ][ 'url' ] = add_query_arg( $set_params, $w_active_languages[ $code ][ 'url' ] );
						}
					}
				}

				$languages = $w_active_languages;
			}
		}

		return $languages;
	}

	/**
	 * Filters the WPML language switcher urls copy $_GET params.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $copy_parameters Url copy parameters.
	 * @return array Filtered parameters.
	 */
	public static function icl_lang_sel_copy_parameters( $copy_parameters = array() ) {
		if ( ! geodir_is_geodir_page() ) {
			return $copy_parameters;
		}

		$gd_parameters = self::get_copy_parameters();

		if ( ! empty( $gd_parameters ) ) {
			$copy_parameters = array_merge( $copy_parameters, $gd_parameters );
		}

		return $copy_parameters;
	}

	public static function get_copy_parameters() {
		global $wpdb;

		$parameters = array( 'listing_type', 'package_id', 'geodir_search', 'stype', 'snear', 'set_location_type', 'set_location_val', 'sgeo_lat', 'sgeo_lon', 'geodir_dashbord', 'stype', 'list', 's', 'country', 'region', 'city', 'neighbourhood', 'pid', 'sort_by', 'etype', 'dist' );

		if ( defined( 'GEODIR_ADV_SEARCH_VERSION' ) ) {
			$results = $wpdb->get_results( "SELECT DISTINCT htmlvar_name FROM " . GEODIR_ADVANCE_SEARCH_TABLE );

			if ( ! empty( $results ) ) {
				foreach ( $results as $row ) {
					$parameters[] = 's' . $row->htmlvar_name;
				}
			}
		}

		$parameters = apply_filters( 'geodir_wpml_url_copy_parameters', $parameters );

		if ( ! empty( $parameters ) ) {
			$parameters = array_unique( $parameters );
		}

		return $parameters;
	}

	public static function cpt_permalink_rewrite_slug( $slug, $post_type, $post_type_obj ) {
		if ( is_post_type_translated( $post_type ) && self::is_slug_translation_on( $post_type ) && ( $current_lang = self::get_current_language() ) ) {
			$slug = self::get_translated_cpt_slug( $slug, $post_type, $current_lang );
		}

		return $slug;
	}

	public static function cpt_template_pages( $page_ids, $page = '' ) {
		if ( ! empty( $page_ids ) ) {
			$tr_page_ids = array();

			foreach ( $page_ids as $page_id ) {
				$tr_page_ids = array_merge( $tr_page_ids, self::get_element_ids( $page_id, 'post_page' ) );
			}

			$page_ids = array_unique( array_merge( $page_ids, $tr_page_ids ) );
		}

		return $page_ids;
	}

	public static function post_permalink_structure_cpt_slug( $cpt_slug, $gd_post, $post_link ) {
		// Alter the CPT slug if WPML is set to do so
		if ( !empty( $gd_post ) && !empty( $gd_post->post_type ) && is_post_type_translated( $gd_post->post_type ) ) {
			if ( self::is_slug_translation_on( $gd_post->post_type ) && ( $language_code = self::get_post_language( $gd_post->ID ) ) ) {
				$cpt_slug = self::get_translated_cpt_slug( $cpt_slug, $gd_post->post_type, $language_code );
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
		$post_types   = geodir_get_posttypes( 'array' );
		
		if ( isset( $post_types[ $post_type ] ) ) {
			$slug = $post_types[ $post_type ]['rewrite']['slug'];

			// Alter the CPT slug if WPML is set to do so
			if ( is_post_type_translated( $post_type ) && self::is_slug_translation_on( $post_type ) && ( $language_code = self::get_lang_from_url( $link ) ) ) {
				$translated_slug = self::get_translated_cpt_slug( $slug, $post_type, $language_code );

				if ( ! empty( $translated_slug ) && is_string( $translated_slug ) ) {
					$slash_helper = new WPML_Slash_Management();
					$link_parts = explode( '?', $link, 2 );

					$pattern = '#\/' . preg_quote( $slug, '#' ) . '\/#';
					$link_new = trailingslashit( preg_replace( $pattern, '/' . $translated_slug . '/', trailingslashit( $link_parts[0] ), 1 ) );
					$link = $slash_helper->match_trailing_slash_to_reference( $link_new, $link_parts[0] );
					$link = isset( $link_parts[1] ) ? $link . '?' . $link_parts[1] : $link;
				}
			}
		}

		return $link;
	}

	public static function term_link( $term_link, $term, $taxonomy ) {
		global $sitepress;

		$post_types = geodir_get_posttypes('array');
		$post_type = str_replace("category","",$taxonomy);
		$post_type = str_replace("_tags","",$post_type);
		$slug = $post_types[$post_type]['rewrite']['slug'];

		if ( is_post_type_translated( $post_type ) && self::is_slug_translation_on( $post_type ) ) {
			$default_lang = $sitepress->get_default_language();
			$language_code = self::get_lang_from_url( $term_link );
			if ( ! $language_code ) {
				$language_code  = $default_lang;
			}

			$translated_slug = self::get_translated_cpt_slug( $slug, $post_type, $language_code );

			if ( ! empty( $translated_slug ) && is_string( $translated_slug ) ) {
				$slash_helper = new WPML_Slash_Management();
				$link_parts = explode( '?', $term_link, 2 );

				$pattern = '#\/' . preg_quote( $slug, '#' ) . '\/#';
				$link_new = trailingslashit( preg_replace( $pattern, '/' . $translated_slug . '/', trailingslashit( $link_parts[0] ), 1 ) );
				$term_link = $slash_helper->match_trailing_slash_to_reference( $link_new, $link_parts[0] );
				$term_link = isset( $link_parts[1] ) ? $term_link . '?' . $link_parts[1] : $term_link;
			}
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
		
		$icl_ajx_action = self::icl_ajx_action() == 'make_duplicates' ? true : false;
		if (!empty($_REQUEST['action']) && $_REQUEST['action'] == 'wpml_duplicate_dashboard' && !empty($_REQUEST['duplicate_post_ids'])) {
			$icl_ajx_action = true;
		}
		
		if (!$icl_ajx_action && geodir_is_gd_post_type( get_post_type( $post_id ) ) && $post_duplicates = $sitepress->get_duplicates($post_id)) {
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
		$icl_ajx_action = self::icl_ajx_action() == 'make_duplicates' || self::icl_ajx_action() == 'set_duplication' ? true : false;
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

				// Duplicate post files
				self::duplicate_post_files($master_post_id, $tr_post_id, $lang);

				// Duplicate event schedules
				if ( GeoDir_Post_types::supports( $post_type, 'events' ) ) {
					self::duplicate_event_schedules( $master_post_id, $tr_post_id, $lang );
				}
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
	public static function duplicate_post_images( $master_post_id, $tr_post_id, $lang, $save_featured = false ) {
		global $wpdb;

		$wpdb->query( $wpdb->prepare( "DELETE FROM " . GEODIR_ATTACHMENT_TABLE . " WHERE type = %s AND post_id = %d", array( 'post_images', $tr_post_id ) ) );

		$post_images = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM " . GEODIR_ATTACHMENT_TABLE . " WHERE type = %s AND post_id = %d ORDER BY menu_order ASC", array( 'post_images', $master_post_id ) ) );

		if ( ! empty( $post_images ) ) {
			foreach ( $post_images as $post_image ) {
				$image_data = (array) $post_image;
				unset( $image_data['ID'] );
				$image_data['post_id'] = $tr_post_id;

				if ( $save_featured && ! empty( $post_image->file ) && ( (int) $post_image->featured === 1 || (int) $post_image->menu_order === 0 ) ) {
					geodir_save_post_meta( $tr_post_id, 'featured_image', $post_image->file );
				}

				$wpdb->insert( GEODIR_ATTACHMENT_TABLE, $image_data );
			}

			return true;
		}

		return false;
	}

	/**
	 * Duplicate post files for WPML translation post.
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
	public static function duplicate_post_files( $master_post_id, $tr_post_id, $lang ) {
		global $wpdb;

		$wpdb->query( $wpdb->prepare( "DELETE FROM " . GEODIR_ATTACHMENT_TABLE . " WHERE type != %s AND post_id = %d", array( 'post_images', $tr_post_id ) ) );

		$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM " . GEODIR_ATTACHMENT_TABLE . " WHERE type != %s AND post_id = %d ORDER BY menu_order ASC", array( 'post_images', $master_post_id ) ) );

		if ( ! empty( $results ) ) {
			$wp_upload_dir = wp_upload_dir();
			$table = geodir_db_cpt_table( get_post_type( $master_post_id ) );

			$attachments = array();

			foreach ( $results as $key => $row ) {
				$data = (array)$row;
				unset( $data['ID'] );
				$data['post_id'] = $tr_post_id;

				if ( $wpdb->insert( GEODIR_ATTACHMENT_TABLE, $data ) && ! empty( $data['type'] ) ) {
					$attachment = array();
					$attachment[] = $wp_upload_dir['baseurl'] . $data['file']; // file url
					$attachment[] = $wpdb->insert_id; // file id
					$attachment[] = $data['title']; // file title
					$attachment[] = $data['caption']; // file caption

					if ( ! isset( $attachments[ $data['type'] ] ) ) {
						$attachments[ $data['type'] ] = array();
					}
					$attachments[ $data['type'] ][] = implode( '|', $attachment );
				}
			}

			if ( ! empty( $attachments ) ) {
				$detail_data = array();
				$value_type = array();
				foreach ( $attachments as $field => $files ) {
					$detail_data[ $field ] = implode( ',', $files );
					$value_type[] = '%s';
				}

				$wpdb->update( $table, $detail_data, array( 'post_id' => $tr_post_id ), $value_type, array( '%d' ) );
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

		$review['comment_id'] = $tr_comment_id;
		$review['post_id'] = $tr_post_id;

		$post_type = get_post_type($master_post_id);

		if ( GeoDir_Post_types::supports( $post_type, 'location' ) ) {
			$post_table = $plugin_prefix . $post_type . '_detail';

			$translated_post = $wpdb->get_row($wpdb->prepare("SELECT latitude, longitude, city, region, country FROM " . $post_table . " WHERE post_id = %d", $tr_post_id), ARRAY_A);

			if ( ! empty( $translated_post ) ) {
				$review['city'] = $translated_post['city'];
				$review['region'] = $translated_post['region'];
				$review['country'] = $translated_post['country'];
				$review['latitude'] = $translated_post['latitude'];
				$review['longitude'] = $translated_post['longitude'];
			}
		}

		$tr_review_id = $wpdb->get_var($wpdb->prepare("SELECT comment_id FROM " . GEODIR_REVIEW_TABLE . " WHERE comment_id=%d AND post_id=%d ORDER BY comment_id ASC", $tr_comment_id, $tr_post_id));

		if ($tr_review_id) { // update review
			$wpdb->update(GEODIR_REVIEW_TABLE, $review, array('comment_id' => $tr_review_id));
		} else { // insert review
			$wpdb->insert(GEODIR_REVIEW_TABLE, $review);
			$tr_review_id = $wpdb->insert_id;
		}

		if ($tr_post_id) {
			GeoDir_Comments::update_post_rating($tr_post_id, $post_type);
			
			if (defined('GEODIR_REVIEWRATING_VERSION') && geodir_get_option('rr_enable_rate_comment') && $sitepress->get_setting('sync_comments_on_duplicates')) {
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
	 * Duplicate event schedules for WPML translation post.
	 *
	 * @since 2.0.0.10
	 *
	 * @global object $wpdb WordPress Database object.
	 *
	 * @param int $master_post_id Original Post ID.
	 * @param int $tr_post_id Translation Post ID.
	 * @param string $lang Language code for translating post.
	 * @return bool True for success, False for fail.
	 */
	public static function duplicate_event_schedules( $master_post_id, $tr_post_id, $lang ) {
		global $wpdb;

		if ( ! class_exists( 'GeoDir_Event_Schedules' ) ) {
			return false;
		}

		$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM " . GEODIR_EVENT_SCHEDULES_TABLE . " WHERE event_id = %d ORDER BY schedule_id ASC", array( $master_post_id ) ) );
		$schedules = array();

		if ( ! empty( $results ) ) {
			foreach ( $results as $key => $row ) {
				$schedule = (array) $row;
				unset( $schedule['schedule_id'] );
				$schedule['event_id'] = $tr_post_id;

				$schedules[] = $schedule;
			}
		}

		// Create schedules
		return GeoDir_Event_Schedules::create_schedules( $schedules, $tr_post_id );
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
	 * @global object $gd_post GeoDirectory post object.
	 * @global bool $preview True if the current page is add listing preview page. False if not.
	 * @global object $sitepress Sitepress WPML object.
	 *
	 * @return string Filtered html of the geodir_edit_post_link() function.
	 */
	public static function post_detail_duplicates() {
		global $gd_post, $preview, $sitepress;

		if ( geodir_design_style() ) {
			return self::post_detail_duplicates_aui();
		}

		$content = '';

		if ( !empty( $gd_post->ID ) && !$preview && geodir_is_page( 'detail' ) ) {
			if ( self::is_duplicate_allowed( $gd_post->ID ) ) {
				$post_id = $gd_post->ID;
				$element_type = 'post_' . get_post_type( $post_id );
				$original_post_id = $sitepress->get_original_element_id( $post_id, $element_type, false, true );
				
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
									$duplicates_text = ' <span class="geodir-translation-status">' . __( '(duplicate)', 'geodir-multilingual' ) . '</span>';
									$duplicates_text .= ' <a href="javascript:void(0)" title="' . esc_attr__( 'Disable the WPML duplication translation to translate independently.', 'geodir-multilingual' ) . '" class="geodir-tr-independent" data-post-id="' . absint( $duplicates[ $lang_code ] ) . '" data-nonce="' . esc_attr( wp_create_nonce( 'geodir_check_duplicates' ) ) . '">' . __( 'Translate Independently', 'geodir-multilingual' ) . '</a>&nbsp;<i style="display:none" class="fas fa-sync fa-spin"></i>';
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
							$wpml_content .= '<tr><td colspan="3" style="text-align:right"><i style="display:none" class="fas fa-sync fa-spin"></i> <button data-nonce="' . esc_attr( wp_create_nonce( 'geodir-duplicate-post' ) ) . '" data-post-id="' . $post_id . '" id="gd_make_duplicates" class="button-secondary">' . __( 'Duplicate', 'geodir-multilingual' ) . '</button></td></tr>';
						}
						
						$wpml_content .= '</tbody></table>';
						$wpml_content .= '</div>';
						
						$content .= $wpml_content;
					}
				}
			} elseif ( self::is_translate_independently_allowed( $gd_post->ID ) ) {
				$post_id = $gd_post->ID;
				$element_type = 'post_' . get_post_type( $post_id );
				$original_post_id = $sitepress->get_original_element_id( $post_id, $element_type, false, true );
				
				if ( $original_post_id != $post_id ) {
					$wpml_languages = $sitepress->get_active_languages();
					$post_language = $sitepress->get_language_for_element( $post_id, $element_type );
					
					if ( !empty( $wpml_languages ) && isset( $wpml_languages[ $post_language ] ) ) {
						unset( $wpml_languages[ $post_language ] );
					}

					if ( !empty( $wpml_languages ) ) {
						$trid  = $sitepress->get_element_trid( $post_id, $element_type );
						$element_translations = $sitepress->get_element_translations( $trid, $element_type );
						$duplicates = $sitepress->get_duplicates( $post_id );
						
						$content .= '<div class="geodir-company_info gd-detail-duplicate">';
						$content .= wp_sprintf( __( 'This post is a duplicate of %s and it is translated via WPML duplicate translation.', 'geodir-multilingual' ), '<a href="' . esc_url( get_permalink( $original_post_id ) ) . '" target="_blank">' . get_the_title( $original_post_id ) . '</a>' );
						$content .= '<br><br><a href="javascript:void(0)" title="' . esc_attr__( 'Disable the WPML duplication translation to translate independently.', 'geodir-multilingual' ) . '" class="geodir-tr-independent button button-secondary" data-post-id="' . absint( $post_id ) . '" data-nonce="' . esc_attr( wp_create_nonce( 'geodir_check_duplicates' ) ) . '" data-reload=1>' . __( 'Translate Independently', 'geodir-multilingual' ) . '</a>&nbsp;<i style="display:none" class="fas fa-sync fa-spin"></i>';
						$content .= '</div>';
					}
				}
			}
		}
		
		return $content;
	}

	/**
	 * Display WPML languages option in sidebar to allow authors to duplicate their listing.
	 *
	 * @since 2.1.0.0
	 *
	 * @global object $gd_post GeoDirectory post object.
	 * @global bool $preview True if the current page is add listing preview page. False if not.
	 * @global object $sitepress Sitepress WPML object.
	 *
	 * @return string Filtered html of the geodir_edit_post_link() function.
	 */
	public static function post_detail_duplicates_aui() {
		global $aui_bs5, $gd_post, $preview, $sitepress;

		$content = '';

		if ( !empty( $gd_post->ID ) && !$preview && geodir_is_page( 'detail' ) ) {
			if ( self::is_duplicate_allowed( $gd_post->ID ) ) {
				$post_id = $gd_post->ID;
				$element_type = 'post_' . get_post_type( $post_id );
				$original_post_id = $sitepress->get_original_element_id( $post_id, $element_type, false, true );

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

						$wpml_content = '<div class="card gd-detail-duplicate">';
						$wpml_content .= '<table class="table table-md m-0 gd-duplicate-table"><thead><tr><th scope="col">' . __( 'Language', 'geodir-multilingual' ) . '</th><th scope="col" class="text-center">' . __( 'Translate', 'geodir-multilingual' ) . '</th></tr></thead><tbody>';

						$needs_translation = false;

						foreach ( $wpml_languages as $lang_code => $lang ) {
							$duplicates_text = '';
							$translated = false;

							if ( !empty( $element_translations ) && isset( $element_translations[$lang_code] ) ) {
								$translated = true;

								if ( !empty( $duplicates ) && isset( $duplicates[$lang_code] ) ) {
									$duplicates_text = ' <span class="geodir-translation-status">' . __( '(duplicate)', 'geodir-multilingual' ) . '</span>';
									$duplicates_text .= '<a href="javascript:void(0)" title="' . esc_attr__( 'Disable the WPML duplication translation to translate independently.', 'geodir-multilingual' ) . '" class="geodir-tr-independent btn btn-sm btn-secondary mt-2 clear-both" data-post-id="' . absint( $duplicates[ $lang_code ] ) . '" data-nonce="' . esc_attr( wp_create_nonce( 'geodir_check_duplicates' ) ) . '"><i style="display:none" class="fas fa-sync fa-spin ' . ( $aui_bs5 ? 'me-1' : 'mr-1' ) . '"></i>' . __( 'Translate Independently', 'geodir-multilingual' ) . '</a>';
								}
							} else {
								$needs_translation = true;
							}

							$wpml_content .= '<tr><td>' . $lang['english_name'] . $duplicates_text . '</td><td class="text-center">';

							if ( $translated ) {
								$wpml_content .= '<span title="' . esc_attr__( 'Translated', 'geodir-multilingual' ) . '"><i class="fa fa-check text-success" aria-hidden="true"></i></span>';
							} else {
								$wpml_content .= '<input name="gd_icl_dup[]" aria-label="' . esc_attr__( 'Create duplicate', 'geodir-multilingual' ) . '" value="' . $lang_code . '" title="' . esc_attr__( 'Create duplicate', 'geodir-multilingual' ) . '" type="checkbox">';
							}

							$wpml_content .= '</td></tr>';
						}

						if ( $needs_translation ) {
							$wpml_content .= '<tr><td></td><td class="text-center"><button data-nonce="' . esc_attr( wp_create_nonce( 'geodir-duplicate-post' ) ) . '" data-post-id="' . $post_id . '" id="gd_make_duplicates" class="btn btn-sm btn-primary"><i style="display:none" class="fas fa-sync fa-spin ' . ( $aui_bs5 ? 'me-1' : 'mr-1' ) . '" aria-hidden="true"></i>' . __( 'Duplicate', 'geodir-multilingual' ) . '</button></td></tr>';
						}

						$wpml_content .= '</tbody></table>';
						$wpml_content .= '</div>';

						$content .= $wpml_content;
					}
				}
			} elseif ( self::is_translate_independently_allowed( $gd_post->ID ) ) {
				$post_id = $gd_post->ID;
				$element_type = 'post_' . get_post_type( $post_id );
				$original_post_id = $sitepress->get_original_element_id( $post_id, $element_type, false, true );
				
				if ( $original_post_id != $post_id ) {
					$wpml_languages = $sitepress->get_active_languages();
					$post_language = $sitepress->get_language_for_element( $post_id, $element_type );
					
					if ( !empty( $wpml_languages ) && isset( $wpml_languages[ $post_language ] ) ) {
						unset( $wpml_languages[ $post_language ] );
					}

					if ( !empty( $wpml_languages ) ) {
						$trid  = $sitepress->get_element_trid( $post_id, $element_type );
						$element_translations = $sitepress->get_element_translations( $trid, $element_type );
						$duplicates = $sitepress->get_duplicates( $post_id );
						
						$content .= '<div class="geodir-company_info gd-detail-duplicate">';
						$content .= wp_sprintf( __( 'This post is a duplicate of %s and it is translated via WPML duplicate translation.', 'geodir-multilingual' ), '<a href="' . esc_url( get_permalink( $original_post_id ) ) . '" target="_blank">' . get_the_title( $original_post_id ) . '</a>' );
						$content .= '<a href="javascript:void(0)" title="' . esc_attr__( 'Disable the WPML duplication translation to translate independently.', 'geodir-multilingual' ) . '" class="geodir-tr-independent btn btn-secondary btn-sm clear-both mt-3" data-post-id="' . absint( $post_id ) . '" data-nonce="' . esc_attr( wp_create_nonce( 'geodir_check_duplicates' ) ) . '" data-reload=1><i style="display:none" class="fas fa-sync fa-spin ' . ( $aui_bs5 ? 'me-1' : 'mr-1' ) . '"></i>' . __( 'Translate Independently', 'geodir-multilingual' ) . '</a>';
						$content .= '</div>';
					}
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
					$master_post_id = $sitepress->get_original_element_id( $post_id, $element_type, false, true );
					
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
	 * Set translate independently.
	 *
	 * @since 2.1.0.2
	 *
	 * @return mixed
	 */
	public static function translate_independently() {
		check_ajax_referer( 'geodir_check_duplicates', 'security' );

		$post_id = !empty( $_REQUEST['post_id'] ) ? absint( $_REQUEST['post_id'] ) : 0;

		try {
			$data = array();
			if ( !empty( $post_id ) ) {
				if ( self::is_translate_independently_allowed( $post_id ) ) {
					delete_post_meta( $post_id, '_icl_lang_duplicate_of' );

					wp_send_json_success( true );
				} else {
					throw new Exception( __( 'You are not allowed to manage translation for this listing.', 'geodir-multilingual' ) );
				}
			} else {
				throw new Exception( __( 'You are not allowed to manage translation for this listing.', 'geodir-multilingual' ) );
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
	 * Checks the user allowed to translate independently listing or not for WPML.
	 *
	 * @since 2.1.0.2
	 *
	 * @param int $post_id The post ID.
	 * @return bool True if allowed.
	 */
	public static function is_translate_independently_allowed( $post_id ) {
		$allowed = false;
		
		if ( empty( $post_id ) ) {
			return $allowed;
		}
		
		$user_id = (int)get_current_user_id();
		
		if ( empty( $user_id ) ) {
			return $allowed;
		}
		
		$post_type = get_post_type( $post_id );
		if ( ! ( is_post_type_translated( $post_type ) && get_post_meta( $post_id, '_icl_lang_duplicate_of', true ) ) ) {
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
		return apply_filters( 'geodir_multilingual_wpml_is_translate_independently_allowed', $allowed, $post_id );
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
		return isset( $settings['posts_slug_translation']['types'][ $post_type ] )
					&& $settings['posts_slug_translation']['types'][ $post_type ]
					&& get_option( 'wpml_base_slug_translation' );
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
		
		if (!empty($sitepress) && $sitepress->is_post_edit_screen() && $post_type && geodir_is_gd_post_type( $post_type ) && $current_lang = $sitepress->get_current_language()) {
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

	/**
	 * Registers a dynamic text string for WPML translation.
	 *
	 * @since 2.0.1.1
	 *
	 * @param string $string The string that needs to be translated.
	 * @param int $post_ID The post ID.
	 * @param array $args Array of arguments.
	 */
	public static function register_dynamic_string( $string, $post_ID = 0, $args = array() ) {
		self::register_string( $string );

		return $string;
	}

	public static function get_post_type_slug( $post_type ) {
		$post_type_object = geodir_post_type_object( $post_type );

		$slug = GeoDir_Post_types::get_rewrite_slug( $post_type, $post_type_obj );

		return $slug;
	}

	public static function get_translated_cpt_slug( $slug, $post_type, $language = false ) {
		if ( ! $language ) {
			$language = self::get_current_language();
		}

		if ( ! $slug ) {
			$slug = self::get_post_type_slug( $post_type );
		}

		if ( apply_filters( 'wpml_slug_translation_available', false ) ) {
			$translated_slug = apply_filters( 'wpml_get_translated_slug', $slug, $post_type, $language );
		} else {
			$translated_slug = self::translate_slug( $slug, $post_type, $language );
		}

		return $translated_slug;
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
		global $sitepress, $wpml_term_translations, $geodir_post_type;

		if ( ! empty( $_REQUEST['stype'] ) && geodir_is_page( 'search' ) ) {
			$post_type = sanitize_text_field( $_REQUEST['stype'] );
		} else {
			$post_type = $geodir_post_type;
		}

		if ( $post_type ) {
			$where = self::filter_single_type_where( $where, $post_type );

			// Translated tax query.
			if ( geodir_is_page( 'archive' ) && GeoDir_Query::is_gd_main_query( $query ) ) {
				$wpml_display_as_translated_tax_query = new WPML_Display_As_Translated_Tax_Query( $sitepress, $wpml_term_translations );

				$where = $wpml_display_as_translated_tax_query->posts_where_filter( $where, $query );
			}
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
		global $sitepress, $gd_query_args_widgets;

		if ( $post_type ) {
			$where = self::filter_single_type_where( $where, $post_type );

			if ( ! empty( $gd_query_args_widgets['tax_query'] ) && self::get_default_language() !== self::get_current_language() && $sitepress->is_display_as_translated_post_type( $post_type ) ) {
				$terms = self::find_terms( $where );

				if ( ! empty( $terms ) ) {
					$fallback_terms = self::get_fallback_terms( $terms );
					$where = self::add_fallback_terms_to_where_clause( $where, $fallback_terms, $gd_query_args_widgets );
				}
			}
		}

		return $where;
	}

	public static function rest_markers_query_join( $join, $request ) {
		global $wpdb;

		// Skip for single post.
		if ( ! empty( $request['post'] ) && is_array( $request['post'] ) && count( $request['post'] ) === 1 ) {
			return $join;
		}

		if ( ! empty( $request['post_type'] ) ) {
			$wpml_join = self::filter_single_type_join( '', $request['post_type'] );
			$wpml_join = str_replace( array( "\t{$wpdb->posts}.", " {$wpdb->posts}." ), array( "\tp.", " p." ), $wpml_join );

			$join .= $wpml_join;
		}

		return $join;
	}

	public static function rest_markers_query_where( $where, $request ) {
		global $wpdb;

		// Skip for single post.
		if ( ! empty( $request['post'] ) && is_array( $request['post'] ) && count( $request['post'] ) === 1 ) {
			return $where;
		}

		if ( ! empty( $request['post_type'] ) ) {
			$wpml_where = self::filter_single_type_where( '', $request['post_type'] );
			$wpml_where = str_replace( array( "\t{$wpdb->posts} p", " {$wpdb->posts} p", "\tp.", " p." ), array( "\t{$wpdb->posts} wpml_p", " {$wpdb->posts} wpml_p", "\twpml_p.", " wpml_p." ), $wpml_where );
			$wpml_where = str_replace( array( "\t{$wpdb->posts}.", " {$wpdb->posts}." ), array( "\tp.", " p." ), $wpml_where );

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
			$row[] = 'wpml_lang';
			$row[] = 'wpml_translation_of';
			$row[] = 'wpml_is_duplicate';
		}
		return $row;
	}

	public static function export_posts_csv_row( $row, $post_id, $post_type ) {
		if ( is_post_type_translated( $post_type ) ) {
			$row[] = self::get_language_for_element( $post_id, 'post_' . $post_type ); // wpml_lang
			$row[] = self::get_original_element_id( $post_id, 'post_' . $post_type ); // wpml_translation_of
			$row[] = absint( get_post_meta( $post_id, '_icl_lang_duplicate_of', true ) ) ? 1 : '0'; // wpml_is_duplicate
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
		global $sitepress;

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
		$post_types = geodir_get_posttypes( 'array' );

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
					$address_fields = array( 'street', 'street2', 'country', 'region', 'city', 'neighbourhood', 'zip', 'latitude', 'longitude', 'mapview', 'mapzoom' );

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
			$slug = self::get_translated_cpt_slug( $slug, $post_type, $language_code );
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

		$request_post_icl_ajx_action = self::icl_ajx_action();

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

						// post images
						self::duplicate_post_images($pidd, $element_id, $lang);

						// post files
						self::duplicate_post_files($pidd, $element_id, $lang);
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

				// Duplicate post files
				self::duplicate_post_files($source_id, $pidd, $lang);
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

	public static function geodir_bp_listings_count_join( $join, $post_type ) {
        global $wpdb;

        if ( $post_type ) {
            $wpml_join = self::filter_single_type_join( '', $post_type );
            $wpml_join = str_replace( array( " {$wpdb->posts}.", "\t{$wpdb->posts}." ), array( " p.", "\tp." ), $wpml_join );

            $join .= $wpml_join;
        }

        return $join;
    }

    public static function geodir_bp_listings_count_where( $where, $post_type ) {
        global $wpdb;

        if ( $post_type ) {
            $wpml_where = self::filter_single_type_where( '', $post_type );
            $wpml_where = str_replace( array( " {$wpdb->posts} p", "\t{$wpdb->posts} p", " p.", "\tp." ), array( " {$wpdb->posts} wpml_p", "\t{$wpdb->posts} wpml_p", " wpml_p.", "\twpml_p." ), $wpml_where );
            $wpml_where = str_replace( array( " {$wpdb->posts}.", "\t{$wpdb->posts}." ), array( " p.", "\tp." ), $wpml_where );

            $where .= $wpml_where;
        }

        return $where;
    }

    public static function geodir_bp_listings_join( $join, $post_type ) {
        global $wpdb;

        if ( $post_type ) {
            $wpml_join = self::filter_single_type_join( '', $post_type );

            $join .= $wpml_join;
        }

        return $join;
    }

    public static function geodir_bp_listings_where( $where, $post_type ) {
        global $wpdb;

        if ( $post_type ) {
            $wpml_where = self::filter_single_type_where( '', $post_type );
            $wpml_where = str_replace( array( " {$wpdb->posts} p", "\t{$wpdb->posts} p", " p.", "\tp." ), array( " {$wpdb->posts} wpml_p", "\t{$wpdb->posts} wpml_p", " wpml_p.", "\twpml_p." ), $wpml_where );

            $where .= $wpml_where;
        }

        return $where;
    }

    public static function geodir_bp_favorite_count_join( $join, $post_type ) {
        return self::geodir_bp_listings_count_join( $join, $post_type );
    }

    public static function geodir_bp_favorite_count_where( $where, $post_type ) {
        return self::geodir_bp_listings_count_where( $where, $post_type );
    }

    public static function geodir_bp_reviews_count_join( $join, $post_type ) {
        return self::geodir_bp_listings_count_join( $join, $post_type );
    }

    public static function geodir_bp_reviews_count_where( $where, $post_type ) {
        return self::geodir_bp_listings_count_where( $where, $post_type );
    }

	public static function cp_search_posts_query_join( $join, $search, $post_type, $custom_field ) {
		global $wpdb;

		if ( $post_type ) {
			$wpml_join = self::filter_single_type_join( '', $post_type );
			$wpml_join = str_replace( array( " {$wpdb->posts}.", "\t{$wpdb->posts}." ), array( " p.", "\tp." ), $wpml_join );

			if ( $wpml_join ) {
				$join .= $wpml_join;
			}
		}

		return $join;
	}

	public static function cp_search_posts_query_where( $where, $search, $post_type, $custom_field ) {
		global $wpdb;

		if ( $post_type ) {
			$wpml_where = self::filter_single_type_where( '', $post_type );

			if ( $wpml_where ) {
				$wpml_where = str_replace( array( " {$wpdb->posts} p", "\t{$wpdb->posts} p", " p.", "\tp." ), array( " {$wpdb->posts} wpml_p", "\t{$wpdb->posts} wpml_p", " wpml_p.", "\twpml_p." ), $wpml_where );
				$wpml_where = str_replace( array( " {$wpdb->posts}.", "\t{$wpdb->posts}." ), array( " p.", "\tp." ), $wpml_where );

				$where .= $wpml_where;
			}
		}

		return $where;
	}

	public static function allow_invoice_for_listing( $allow, $post_ID ) {
		if ( $allow && is_post_type_translated( get_post_type( $post_ID ) ) && get_post_meta( $post_ID, '_icl_lang_duplicate_of', true ) ) {
			$allow = false; // Do not allow to create invoice for duplicated listing.
		}
		return $allow;
	}

	public static function permalinks_post_rewrite_rule( $post_type, $post_type_arr, $geodir_permalinks, $regex_part, $redirect, $after ) {
		global $sitepress;

		if ( is_post_type_translated( $post_type ) && self::is_slug_translation_on( $post_type ) ) {
			$slug = $post_type_arr['rewrite']['slug'];
			$languages = $sitepress->get_active_languages();

			foreach ( $languages as $lang_code => $lang ) {
				$translated_slug = self::get_translated_cpt_slug( $slug, $post_type, $lang_code );

				if ( $translated_slug != $slug ) {
					$regex      = '^' . $translated_slug . $regex_part;

					$geodir_permalinks->add_rewrite_rule( $regex, $redirect, $after );
				}
			}
		}
	}

	public static function location_permalinks_post_rewrite_rule( $post_type, $slug, $cpt_match, $redirect, $cpt_query_vars, $after, $geodir_location_permalinks ) {
		global $wp_rewrite, $sitepress;

		$feedindex = $wp_rewrite->index;

		// Build a regex to match the feed section of URLs, something like (feed|atom|rss|rss2)/?
		$feedregex2 = '';
		foreach ( (array) $wp_rewrite->feeds as $feed_name ) {
			$feedregex2 .= $feed_name . '|';
		}
		$feedregex2 = '(' . trim( $feedregex2, '|' ) . ')/?$';

		/*
		 * $feedregex is identical but with /feed/ added on as well, so URLs like <permalink>/feed/atom
		 * and <permalink>/atom are both possible
		 */
		$feedregex = $wp_rewrite->feed_base . '/' . $feedregex2;
		$feedbase = $wp_rewrite->feed_base;

		if ( is_post_type_translated( $post_type ) && self::is_slug_translation_on( $post_type ) ) {
			$languages = $sitepress->get_active_languages();

			foreach ( $languages as $lang_code => $lang ) {
				$translated_slug = self::get_translated_cpt_slug( $slug, $post_type, $lang_code );

				if ( $translated_slug != $slug ) {
					// Add rule for /feed/(feed|atom|rss|rss2|rdf).
					$geodir_location_permalinks->add_rewrite_rule(
						'^' . $translated_slug . '/' . implode( "", array_fill( 0, count( $cpt_query_vars ) , '([^/]*)/' ) ) . $feedregex,
						$redirect . implode( '&', $cpt_query_vars ) . '&feed=$matches[' . $cpt_match . ']',
						$after
					);
					// Add rule for /(feed|atom|rss|rss2|rdf) (see comment near creation of $feedregex).
					$geodir_location_permalinks->add_rewrite_rule(
						'^' . $translated_slug . '/' . implode( "", array_fill( 0, count( $cpt_query_vars ) , '([^/]*)/' ) ) . $feedregex2,
						$redirect . implode( '&', $cpt_query_vars ) . '&feed=$matches[' . $cpt_match . ']',
						$after
					);
					// paged
					$geodir_location_permalinks->add_rewrite_rule(
						'^' . $translated_slug . '/' . implode( "", array_fill( 0, count( $cpt_query_vars ) , '([^/]*)/' ) ) . 'page/?([0-9]{1,})/?$',
						$redirect . implode( '&', $cpt_query_vars ).'&paged=$matches['.$cpt_match.']',
						$after
					);

					// non paged
					$geodir_location_permalinks->add_rewrite_rule(
						'^' . $translated_slug . '/' . implode( "", array_fill( 0, count( $cpt_query_vars ) , '([^/]*)/' ) ) . '?$',
						$redirect . implode( '&', $cpt_query_vars ),
						$after
					);
				}
			}
		}
	}

	public static function location_permalinks_cat_rewrite_rule( $post_type, $cpt_slug, $cat_base, $redirect, $cat_match, $cat_query_vars, $after, $geodir_location_permalinks ) {
		global $wp_rewrite, $sitepress;

		$feedindex = $wp_rewrite->index;

		// Build a regex to match the feed section of URLs, something like (feed|atom|rss|rss2)/?
		$feedregex2 = '';
		foreach ( (array) $wp_rewrite->feeds as $feed_name ) {
			$feedregex2 .= $feed_name . '|';
		}
		$feedregex2 = '(' . trim( $feedregex2, '|' ) . ')/?$';

		/*
		 * $feedregex is identical but with /feed/ added on as well, so URLs like <permalink>/feed/atom
		 * and <permalink>/atom are both possible
		 */
		$feedregex = $wp_rewrite->feed_base . '/' . $feedregex2;
		$feedbase = $wp_rewrite->feed_base;

		if ( is_post_type_translated( $post_type ) && self::is_slug_translation_on( $post_type ) ) {
			$languages = $sitepress->get_active_languages();

			foreach ( $languages as $lang_code => $lang ) {
				$translated_slug = self::get_translated_cpt_slug( $cpt_slug, $post_type, $lang_code );

				if ( $translated_slug != $cpt_slug ) {
					// Add rule for /feed/(feed|atom|rss|rss2|rdf).
					$geodir_location_permalinks->add_rewrite_rule(
						'^' . $translated_slug . '/' . $cat_base . implode( "", array_fill( 0, count( $cat_query_vars ) , '([^/]*)/' ) ) . $feedregex,
						$redirect . implode( '&', $cat_query_vars ) . '&feed=$matches[' . ( $cat_match + 1 ) . ']',
						$after
					);
					// Add rule for /(feed|atom|rss|rss2|rdf) (see comment near creation of $feedregex).
					$geodir_location_permalinks->add_rewrite_rule(
						'^' . $translated_slug . '/' . $cat_base . implode( "", array_fill( 0, count( $cat_query_vars ) , '([^/]*)/' ) ) . $feedregex2,
						$redirect . implode( '&', $cat_query_vars ) . '&feed=$matches[' . ( $cat_match + 1 ) . ']',
						$after
					);
					// paged
					$geodir_location_permalinks->add_rewrite_rule(
						'^' . $translated_slug . '/' . $cat_base . implode( "", array_fill( 0, count( $cat_query_vars ) , '([^/]*)/' ) ) . 'page/?([0-9]{1,})/?$',
						$redirect . implode( '&', $cat_query_vars ).'&paged=$matches['.( $cat_match + 1 ).']',
						$after
					);
					// non paged
					$geodir_location_permalinks->add_rewrite_rule(
						'^' . $translated_slug . '/' . $cat_base . implode( "", array_fill( 0, count( $cat_query_vars )  , '([^/]*)/' ) ) . '?$',
						$redirect . implode( '&', $cat_query_vars ) ,
						$after
					);
				}
			}
		}
	}

	public static function location_permalinks_tag_rewrite_rule( $post_type, $cpt_slug, $tag_base, $redirect, $tag_match, $tag_query_vars, $after, $geodir_location_permalinks ) {
		global $wp_rewrite, $sitepress;

		$feedindex = $wp_rewrite->index;

		// Build a regex to match the feed section of URLs, something like (feed|atom|rss|rss2)/?
		$feedregex2 = '';
		foreach ( (array) $wp_rewrite->feeds as $feed_name ) {
			$feedregex2 .= $feed_name . '|';
		}
		$feedregex2 = '(' . trim( $feedregex2, '|' ) . ')/?$';

		/*
		 * $feedregex is identical but with /feed/ added on as well, so URLs like <permalink>/feed/atom
		 * and <permalink>/atom are both possible
		 */
		$feedregex = $wp_rewrite->feed_base . '/' . $feedregex2;
		$feedbase = $wp_rewrite->feed_base;

		if ( is_post_type_translated( $post_type ) && self::is_slug_translation_on( $post_type ) ) {
			$languages = $sitepress->get_active_languages();

			foreach ( $languages as $lang_code => $lang ) {
				$translated_slug = self::get_translated_cpt_slug( $cpt_slug, $post_type, $lang_code );

				if ( $translated_slug != $cpt_slug ) {
					// Add rule for /feed/(feed|atom|rss|rss2|rdf).
					$geodir_location_permalinks->add_rewrite_rule(
						'^' . $translated_slug . '/' . trailingslashit( $tag_base ) . implode( "", array_fill( 0, count( $tag_query_vars ) , '([^/]*)/' ) ) . $feedregex,
						$redirect . implode( '&', $tag_query_vars ) . '&feed=$matches[' . ( $tag_match + 1 ) . ']',
						$after
					);
					// Add rule for /(feed|atom|rss|rss2|rdf) (see comment near creation of $feedregex).
					$geodir_location_permalinks->add_rewrite_rule(
						'^' . $translated_slug . '/' . trailingslashit( $tag_base ) . implode( "", array_fill( 0, count( $tag_query_vars ) , '([^/]*)/' ) ) . $feedregex2,
						$redirect . implode( '&', $tag_query_vars ) . '&feed=$matches[' . ( $tag_match + 1 ) . ']',
						$after
					);
					// paged
					$geodir_location_permalinks->add_rewrite_rule(
						'^' . $translated_slug . '/' . trailingslashit($tag_base) . implode( "", array_fill( 0, count( $tag_query_vars ) , '([^/]*)/' ) ) . 'page/?([0-9]{1,})/?$',
						$redirect . implode( '&', $tag_query_vars ).'&paged=$matches['.($tag_match + 1).']',
						$after
					);
					// non pages
					$geodir_location_permalinks->add_rewrite_rule(
						'^' . $translated_slug . '/' . trailingslashit($tag_base) . implode( "", array_fill( 0, count( $tag_query_vars ) , '([^/]*)/' ) ) . '?$',
						$redirect . implode( '&', $tag_query_vars ),
						$after
					);
				}
			}
		}
	}

	public static function get_add_listing_rewrite_rules( $rules ) {
		global $sitepress, $geodirectory, $geodir_wpml_tmp_lang;

		$post_types = geodir_get_posttypes( 'array' );

		$w_active_languages = apply_filters( 'wpml_active_languages_access', $sitepress->get_active_languages(), array( 'action' => 'read' ) );

		if ( empty( $w_active_languages ) ) {
			return $rules;
		}

		foreach ( $w_active_languages as $k => $lang ) {
			$geodir_wpml_tmp_lang = $lang['code'];

			$page_slug = $geodirectory->permalinks->add_listing_slug();

			foreach ( $post_types as $post_type => $cpt ) {
				$cpt_slug = self::get_translated_cpt_slug( $cpt['rewrite']['slug'], $post_type, $lang['code'] );

				$rules[ '^' . $page_slug . '/' . $cpt_slug . '/?$' ] = 'index.php?pagename=' . $page_slug . '&listing_type=' . $post_type;
				$rules[ '^' . $page_slug . '/' . $cpt_slug . '/?([0-9]{1,})/?$' ] = 'index.php?pagename=' . $page_slug . '&listing_type=' . $post_type . '&pid=$matches[1]';

				$cpt_page_slug = $geodirectory->permalinks->add_listing_slug( $post_type );

				if ( $cpt_page_slug != $cpt_slug ) {
					$rules[ '^' . $cpt_page_slug . '/' . $cpt_slug . '/?$' ] = 'index.php?pagename=' . $cpt_page_slug . '&listing_type=' . $post_type;
					$rules[ '^' . $cpt_page_slug . '/' . $cpt_slug . '/?([0-9]{1,})/?$' ] = 'index.php?pagename=' . $cpt_page_slug . '&listing_type=' . $post_type . '&pid=$matches[1]';
				}
			}

			$geodir_wpml_tmp_lang = null;
		}

		return $rules; 
	}

	public static function permalinks_author_rewrite_rule( $post_type, $post_type_arr, $geodir_permalinks, $cpt_slug, $favs_slug, $favs_slug_arr ) {
		global $wp_rewrite, $sitepress;
		
		if ( is_post_type_translated( $post_type ) && self::is_slug_translation_on( $post_type ) ) {
			$languages = $sitepress->get_active_languages();
			$author_base = $wp_rewrite->author_base;

			foreach ( $languages as $lang_code => $lang ) {
				$translated_slug = self::get_translated_cpt_slug( $cpt_slug, $post_type, $lang_code );

				if ( $translated_slug != $cpt_slug ) {
					$favs_translated_slug = self::favs_slug( $favs_slug, $post_type, $cpt_slug, $translated_slug, $lang_code );

					// add CPT author rewrite rules
					$geodir_permalinks->add_rewrite_rule( "^" . $author_base . "/([^/]+)/$translated_slug/?$", 'index.php?author_name=$matches[1]&post_type=' . $post_type, 'top' );
					$geodir_permalinks->add_rewrite_rule( "^" . $author_base . "/([^/]+)/$translated_slug/page/?([0-9]{1,})/?$", 'index.php?author_name=$matches[1]&post_type=' . $post_type . '&paged=$matches[2]', 'top' );

					// favs
					if ( $favs_slug != $favs_translated_slug && ! isset( $favs_slug_arr[ $favs_translated_slug ] ) ) { // only add this once unless the favs slug changes per CPT
						$geodir_permalinks->add_rewrite_rule( "^" . $author_base . "/([^/]+)/$favs_translated_slug/?$", 'index.php?author_name=$matches[1]&gd_favs=1' );
						$geodir_permalinks->add_rewrite_rule( "^" . $author_base . "/([^/]+)/$favs_translated_slug/page/?([0-9]{1,})/?$", 'index.php?author_name=$matches[1]&gd_favs=1&paged=$matches[2]', 'top');
					}

					$geodir_permalinks->add_rewrite_rule( "^" . $author_base . "/([^/]+)/$favs_translated_slug/$translated_slug/?$",'index.php?author_name=$matches[1]&gd_favs=1&post_type=' . $post_type, 'top' );
					$geodir_permalinks->add_rewrite_rule( "^" . $author_base . "/([^/]+)/$favs_translated_slug/$translated_slug/page/?([0-9]{1,})/?$", 'index.php?author_name=$matches[1]&gd_favs=1&post_type=' . $post_type . '&paged=$matches[2]', 'top' );

					$saves_slug_arr[ $favs_translated_slug ] = $favs_translated_slug;
				}
			}
		}
	}

	public static function favs_slug( $favs_slug, $post_type, $cpt_slug, $translated_slug, $lang_code ) {
		return apply_filters( 'geodir_wpml_rewrite_favs_slug', $favs_slug, $post_type, $cpt_slug, $translated_slug, $lang_code );
	}

	public static function is_archive_page_id( $check, $page_id ) {
		if ( ! $check ) {
			$page_ids = self::get_element_ids( $page_id, 'post_page' );

			if ( in_array( $page_id, $page_ids ) ) {
				$check = true;
			}
		}

		return $check;
	}

	public static function is_geodir_page_id( $is_geodir_page, $id ) {
		global $geodirectory;

		if ( ! $is_geodir_page && $id ) {
			$page_ids = self::get_element_ids( $id, 'post_page' );

			if ( ! empty( $geodirectory->settings['page_add'] ) && in_array( (int) $geodirectory->settings['page_add'], $page_ids ) ) {
				$is_geodir_page = true;
			} elseif ( ! empty( $geodirectory->settings['page_location'] ) && in_array( (int) $geodirectory->settings['page_location'], $page_ids ) ) {
				$is_geodir_page = true;
			} elseif ( ! empty( $geodirectory->settings['page_search'] ) && in_array( (int) $geodirectory->settings['page_search'], $page_ids ) ) {
				$is_geodir_page = true;
			} elseif ( ! empty( $geodirectory->settings['page_terms_conditions'] ) && in_array( (int) $geodirectory->settings['page_terms_conditions'], $page_ids ) ) {
				$is_geodir_page = true;
			} elseif ( ! empty( $geodirectory->settings['page_details'] ) && in_array( (int) $geodirectory->settings['page_details'], $page_ids ) ) {
				$is_geodir_page = true;
			} elseif ( ! empty( $geodirectory->settings['page_archive'] ) && in_array( (int) $geodirectory->settings['page_archive'], $page_ids ) ) {
				$is_geodir_page = true;
			} elseif ( ! empty( $geodirectory->settings['page_archive_item'] ) && in_array( (int) $geodirectory->settings['page_archive_item'], $page_ids ) ) {
				$is_geodir_page = true;
			} elseif ( geodir_is_cpt_template_page( $id ) ) {
				$is_geodir_page = true;
			}
		}

		return $is_geodir_page;
	}

	public static function rest_url( $url, $query_args, $namespace = '', $rest_base = '' ) {
		if ( $namespace == '' ) {
			$namespace = GEODIR_REST_SLUG . '/v' . GEODIR_REST_API_VERSION;
		}

		// Add lang in rest api url.
		add_filter( 'rest_url', 'wpml_permalink_filter' );

		if ( $rest_base ) {
			$url = rest_url( sprintf( '%s/%s/', $namespace, $rest_base ) );
		} else {
			$url = rest_url( sprintf( '%s/', $namespace ) );
		}

		if ( ! empty( $query_args ) && is_array( $query_args ) ) {
			$url = add_query_arg( $query_args, $url );
		}

		return $url;
	}

	public static function location_get_terms_set_globals( $post_type, $taxonomy, $location_type, $loc, $count_type ) {
		self::remove_terms_filter();
	}

	public static function location_get_terms_reset_globals( $post_type, $taxonomy, $location_type, $loc, $count_type ) {
		self::set_terms_filter();
	}

	public static function remove_terms_filter() {
		global $sitepress, $geodir_has_get_terms_args_filter, $geodir_has_get_term_filter, $geodir_has_terms_clauses_filter;

		$geodir_has_get_terms_args_filter = remove_filter( 'get_terms_args', array( $sitepress, 'get_terms_args_filter' ) );
		$geodir_has_get_term_filter = remove_filter( 'get_term', array( $sitepress, 'get_term_adjust_id' ), 1 );
		$geodir_has_terms_clauses_filter = remove_filter( 'terms_clauses', array( $sitepress, 'terms_clauses' ) );
	}

	public static function set_terms_filter() {
		global $sitepress, $geodir_has_get_terms_args_filter, $geodir_has_get_term_filter, $geodir_has_terms_clauses_filter;

		if ( $geodir_has_get_terms_args_filter ) {
			add_filter( 'terms_clauses', array( $sitepress, 'terms_clauses' ), 10, 3 );
		}

		if ( $geodir_has_get_term_filter ) {
			add_filter( 'get_term', array( $sitepress, 'get_term_adjust_id' ), 1, 1 );
		}

		if ( $geodir_has_terms_clauses_filter ) {
			add_filter( 'get_terms_args', array( $sitepress, 'get_terms_args_filter' ), 10, 2 );
		}
	}

	public static function icl_ajx_action() {
		$icl_ajx_action = '';

		if ( ! empty( $_REQUEST['icl_ajx_action'] ) ) {
			$icl_ajx_action = sanitize_text_field( $_REQUEST['icl_ajx_action'] );
		} elseif ( ! empty( $_REQUEST['action'] ) && wpml_is_ajax() ) {
			$icl_ajx_action = sanitize_text_field( $_REQUEST['action'] );
		}

		return $icl_ajx_action;
	}

	public static function post_url_filter_term( $term, $gd_post, $term_id = 0 ) {
		global $sitepress;

		if ( ! empty( $term ) && ! is_wp_error( $term ) && ! empty( $gd_post ) && is_taxonomy_translated( $term->taxonomy ) && is_post_type_translated( $gd_post->post_type ) ) {
			$term_lang = self::get_language_for_element( $term->term_id, 'tax_' . $term->taxonomy );

			if ( $term_id > 0 ) {
				$to_lang = self::get_language_for_element( $term_id, 'tax_' . $term->taxonomy );
			} else {
				$to_lang = self::get_language_for_element( $gd_post->ID, 'post_' . $gd_post->post_type );
			}

			if ( $term_lang && $term_lang != 'all' && $term_lang != $to_lang ) {
				$_term_id = self::get_object_id( $term->term_id, $term->taxonomy, true, $to_lang );

				if ( ! empty( $_term_id ) && $_term_id != $term->term_id ) {
					$has_filter = remove_filter( 'get_term', array( $sitepress, 'get_term_adjust_id' ), 1 );

					$_term = get_term( $_term_id, $term->taxonomy );

					if ( $has_filter ) {
						add_filter( 'get_term', array( $sitepress, 'get_term_adjust_id' ), 1, 1 );
					}

					if ( ! empty( $_term ) && ! is_wp_error( $_term ) ) {
						$term = $_term;
					}
				}
			}
		}
		return $term;
	}

	/**
	 * Filter & disable "Use WPML's Translation Editor" for GD CPTs.
	 *
	 * @since 2.0.0.8
	 *
	 * @param null|array|string $value     The value get_metadata() should return - a single metadata value,
	 *                                     or an array of values.
	 * @param int               $object_id Object ID.
	 * @param string            $meta_key  Meta key.
	 * @param bool              $single    Whether to return only the first value of the specified $meta_key.
	 * @return mixed Single metadata value, or array of values.
	 */
	public static function get_post_metadata( $value, $object_id, $meta_key, $single ) {
		if ( $meta_key == '_wpml_post_translation_editor_native' && ! empty( $object_id ) && geodir_is_gd_post_type( get_post_type( $object_id ) ) ) {
			//$value = 'yes';
		}

		return $value;
	}

	/**
	 * @since 2.0.0.9
	 */
	public static function rewrite_rules_array( $rules ) {
		global $sitepress;

		$element_type = 'post_page';
		$page_id = geodir_get_option( 'page_location' );
		$trid = $sitepress->get_element_trid( $page_id, $element_type );
		$translations = $sitepress->get_element_translations( $trid, $element_type );

		if ( ! empty( $translations ) ) {
			$post_name = get_post_field( 'post_name', $page_id );
			$_rules = array();

			foreach ( $rules as $key => $rule ) {
				$_rules[ $key ] = $rule;

				if ( strpos( $key, '^' . $post_name . '/' ) === false ) {
					continue;
				}

				foreach ( $translations as $lang => $translation ) {
					if ( $translation->element_id != $page_id ) {
						$tr_post_name = get_post_field( 'post_name', $translation->element_id );

						if ( $tr_post_name && $tr_post_name != $post_name ) {
							$tr_key = str_replace( '^' . $post_name . '/', '^' . $tr_post_name . '/', $key );
							$tr_rule = str_replace( 'pagename=' . $post_name . '&', 'pagename=' . $tr_post_name . '&', $rule );

							if ( ! isset( $rules[ $tr_key ] ) ) {
								$_rules[ $tr_key ] = $tr_rule;
							}
						}
					}
				}
			}

			$rules = $_rules;
		}

		return $rules;
	}

	/**
	 * @since 2.0.0.9
	 */
	public static function get_noindex_page_ids( $page_ids ) {
		if ( ! is_array( $page_ids ) ) {
			$page_ids = array();
		}

		$_page_ids = array();
		$_page_ids[] = geodir_get_page_id( 'details', '', false ); // Details page
		$_page_ids[] = geodir_get_page_id( 'archive', '', false ); // Archive page
		$_page_ids[] = geodir_get_page_id( 'archive_item', '', false ); // Archive item page

		foreach ( $_page_ids as $page_id ) {
			if ( empty( $page_id ) ) {
				continue;
			}

			$tr_page_ids = self::get_element_ids( $page_id, 'post_page' );

			if ( ! empty( $tr_page_ids ) && is_array( $tr_page_ids ) ) {
				$page_ids = array_merge( $page_ids, $tr_page_ids );
			}
		}

		return array_unique( $page_ids );
	}

	/**
	 * @since 2.0.0.9
	 */
	public static function import_post_before( $gd_post ) {
		global $gd_wpml_switch_post_lang;

		$gd_wpml_switch_post_lang = -1;

		if ( ! empty( $gd_post['post_type'] ) && is_post_type_translated( $gd_post['post_type'] ) && ( ! empty( $gd_post['wpml_lang'] ) || ! empty( $gd_post['wpml_translation_of'] ) ) ) {
			$post_id = ! empty( $gd_post['ID'] ) ? absint( $gd_post['ID'] ) : 0;
			$post_lang = $post_id ? self::get_post_language( $post_id ) : '';
			$wpml_lang = isset( $gd_post['wpml_lang'] ) ? $gd_post['wpml_lang'] : $post_lang;

			$gd_wpml_switch_post_lang = self::switch_lang( $wpml_lang );
		}
	}

	/**
	 * @since 2.0.0.9
	 */
	public static function import_post_after( $gd_post, $success = false ) {
		global $gd_wpml_switch_post_lang;

		if ( $gd_wpml_switch_post_lang !== -1 ) {
			self::switch_lang( $gd_wpml_switch_post_lang );
		}
	}

	/**
	 * @since 2.0.0.9
	 */
	public static function save_post_temp_data( $gd_post, $post, $update ) {
		global $sitepress, $gd_wpml_switch_post_lang;

		if ( $gd_wpml_switch_post_lang !== -1 && ! empty( $gd_post['post_type'] ) && ! empty( $post->ID ) && $gd_post['post_type'] == $post->post_type && is_post_type_translated( $gd_post['post_type'] ) ) {
			if ( ! empty( $gd_post['wpml_translation_of'] ) && ( $translation_of = absint( $gd_post['wpml_translation_of'] ) ) ) {
				$source_lang = self::get_post_language( $translation_of );
				$post_lang = self::get_post_language( $post->ID );
				$trid = $sitepress->get_element_trid( $translation_of, 'post_' . $gd_post['post_type'] );

				// Set/unset duplicate
				if ( isset( $gd_post['wpml_is_duplicate'] ) ) {
					if ( ! empty( $gd_post['wpml_is_duplicate'] ) ) {
						update_post_meta( $post->ID, '_icl_lang_duplicate_of', $translation_of );
					} else {
						delete_post_meta( $post->ID, '_icl_lang_duplicate_of' );
					}
				}

				$sitepress->set_element_language_details( $post->ID, 'post_' . $gd_post['post_type'], $trid, $post_lang, $source_lang );
			}
		}

		return $gd_post;
	}

	/**
	 * @since 2.0.0.10
	 */
	public static function event_calendar_extra_params( $params = '' ) {
		if ( $lang = self::get_current_language() ) {
			$params .= '&lang=' . $lang;
		}

		return $params;
	}

	/**
	 * Filter WPML current language.
	 *
	 * @since 2.1.0.1
	 *
	 * @global object $sitepress Sitepress WPML object.
	 *
	 * @param string|null $lang Language code.
	 * @return string|null Language code.
	 */
	public static function wpml_current_language( $lang = null ) {
		global $sitepress;

		if ( ! empty( $_POST['action'] ) && $_POST['action'] == 'nf_ajax_submit' && ! empty( $_POST['formData'] ) && wp_doing_ajax() ) {
			$form_data = json_decode( $_POST['formData'], TRUE  );
			if ( empty( $form_data ) ) {
				$form_data = json_decode( stripslashes( $_POST['formData'] ), TRUE  );
			}

			if ( ! empty( $form_data ) && is_array( $form_data ) && ! empty( $form_data['settings']['siteLocale'] ) && self::is_geodirectory_ninja_form( $form_data ) ) {
				$_lang = $sitepress->get_language_code_from_locale( $form_data['settings']['siteLocale'] );

				if ( $_lang ) {
					$lang = $_lang;
				}
			}
		}

		return $lang;
	}

	/* Check ninja form is GeoDirectory form.
	 *
	 * @since 2.1.0.1
	 *
	 * @param array $form_data Form data.
	 * @return bool True if GeoDirectory form else False.
	 */
	public static function is_geodirectory_ninja_form( $form_data ) {
		$key = ! empty( $form_data['settings']['key'] ) ? $form_data['settings']['key'] : null;
		$check = $key && in_array( $key, array( 'geodirectory_contact', 'geodirectory_claim' ) ) ? true : false;

		return apply_filters( 'wpml_is_geodirectory_ninja_form', $check, $key, $form_data );
	}

	/**
	 * @since 2.2
	 *
	 * @param string $where
	 *
	 * @return array
	 */
	public static function find_terms( $where ) {
		$term_regex = '/term_taxonomy_id\s+(IN|in)\s*\(([^\)]+)\)/';

		$terms = array();
		if ( preg_match_all( $term_regex, $where, $matches ) ) {
			foreach ( $matches[2] as $terms_string ) {
				$terms_parts = explode( ',', $terms_string );
				$terms = array_unique( array_merge( $terms, $terms_parts ) );
			}
		}

		return $terms;
	}

	/**
	 * @since 2.2
	 *
	 * @param array $terms
	 *
	 * @return array
	 */
	public static function get_fallback_terms( $terms ) {
		global $wpml_term_translations;

		$default_language = self::get_default_language();

		$fallback_terms   = array();
		foreach ( $terms as $term ) {
			$translations = $wpml_term_translations->get_element_translations( (int) $term );
			if ( isset( $translations[ $default_language ] ) && ! in_array( $translations[ $default_language ], $fallback_terms ) ) {
				$fallback_terms[ $term ] = $translations[ $default_language ];
			}
		}

		return $fallback_terms;
	}

	/**
	 * @since 2.2
	 *
	 * @param string   $where
	 * @param array    $fallback_terms
	 * @param array    $query_args
	 *
	 * @return string
	 */
	public static function add_fallback_terms_to_where_clause( $where, $fallback_terms, $query_args ) {
		$term_regex = '/term_taxonomy_id\s+(IN|in)\s*\(([^\)]+)\)/';

		if ( preg_match_all( $term_regex, $where, $matches ) ) {
			foreach ( $matches[2] as $index => $terms_string ) {
				$new_terms_string = self::add_fallback_terms( $terms_string, $fallback_terms, $query_args );
				$original_block   = $matches[0][ $index ];
				$new_block        = str_replace( '(' . $terms_string . ')', '(' . $new_terms_string . ')', $original_block );
				$where            = str_replace( $original_block, $new_block, $where );
			}
		}

		return $where;
	}

	/**
	 * @since 2.2
	 *
	 * @param string   $terms_string
	 * @param array    $fallback_terms
	 * @param WP_Query $query_args
	 *
	 * @return string
	 */
	public static function add_fallback_terms( $terms_string, $fallback_terms, $query_args ) {
		$mergeFallbackTerms = function ( $term ) use ( $fallback_terms ) {
			return isset( $fallback_terms[ $term ] ) ? [ $term, $fallback_terms[ $term ] ] : $term;
		};

		$taxonomy = $query_args['tax_query'][0]['taxonomy'];

		if ( $taxonomy && self::include_term_children( $query_args ) ) {
			$mergeChildren = function ( $term ) use ( $taxonomy ) {
				return [ $term, get_term_children( $term, $taxonomy ) ];
			};
		} else {
			$mergeChildren = \WPML\FP\Fns::identity();
		}

		return wpml_collect( explode( ',', $terms_string ) )
			->map( $mergeFallbackTerms )
			->flatten()
			->map( $mergeChildren )
			->flatten()
			->unique()
			->implode( ',' );
	}

	/**
	 * @since 2.2
	 *
	 * @param WP_Query $query_args
	 *
	 * @return bool
	 */
	public static function include_term_children( $query_args ) {
		return (bool) \WPML\FP\Obj::path( [ 'tax_query', 'queries', 0, 'include_children' ], $query_args );
	}

	/**
	 * @since 2.3.3
	 *
	 * @return bool
	 */
	public static function remove_filter( $hook_name = '', $class_name = '', $method_name = '', $priority = 0 ) {
		global $wp_filter;

		if ( ! isset( $wp_filter[ $hook_name ][ $priority ] ) || ! is_array( $wp_filter[ $hook_name ][ $priority ] ) ) {
			return false;
		}

		foreach ( (array) $wp_filter[ $hook_name ][ $priority ] as $unique_id => $filter_array ) {
			if ( isset( $filter_array['function'] ) && is_array( $filter_array['function'] ) ) {
				if ( is_object( $filter_array['function'][0] ) && get_class( $filter_array['function'][0] ) && get_class( $filter_array['function'][0] ) === $class_name && $filter_array['function'][1] === $method_name ) {
					if ( is_a( $wp_filter[ $hook_name ], 'WP_Hook' ) ) {
						unset( $wp_filter[ $hook_name ]->callbacks[ $priority ][ $unique_id ] );
					} else {
						unset( $wp_filter[ $hook_name ][ $priority ][ $unique_id ] );
					}
				}
			}
		}

		return false;
	}

	/**
	 * @since 2.3.3
	 *
	 * Or add class wpml-ls-link to link.
	 */
	public static function on_template_redirect() {
		if ( class_exists( 'WPML_Fix_Links_In_Display_As_Translated_Content' ) && ( geodir_is_geodir_page() || ( function_exists( 'is_uwp_profile_page' ) && is_uwp_profile_page() ) ) ) {
			self::remove_filter( 'the_content', 'WPML_Fix_Links_In_Display_As_Translated_Content', 'fix_fallback_links', 99 );
		}
	}

	/**
	 * @since 2.3.4
	 */
	public static function add_listing_page_url( $page_url, $post_type, $post_id ) {
		global $sitepress;

		if ( empty( $post_id ) ) {
			return $page_url;
		}

		$main_post_id = $sitepress->get_original_element_id( $post_id, 'post_' . $post_type, false, true );

		if ( ! empty( $main_post_id ) && $post_id != $main_post_id ) {
			$duplicates = $sitepress->get_duplicates( $main_post_id );

			if ( ! empty( $duplicates ) && in_array( $post_id, array_values( $duplicates ) ) ) {
				if ( get_option( 'permalink_structure' ) != '' ) {
					$page_url = str_replace( "/" . $post_id . "/", "/" . $main_post_id . "/", $page_url );
				} else {
					$page_url = add_query_arg( array( 'pid' => $main_post_id ), $page_url );
				}
			}
		}

		return $page_url;
	}

	/**
	 * @since 2.3.4
	 */
	public static function wp_loaded() {
		global $wpml_language_resolution;

		if ( ! empty( $_REQUEST['post_type'] ) && ! empty( $_REQUEST['p'] ) && ! empty( $_REQUEST['preview'] ) && ! empty( $_REQUEST['lang'] ) && get_post_type( (int) $_REQUEST['p'] ) == $_REQUEST['post_type'] && ! is_admin() ) {
			 $set_lang = sanitize_text_field( $_REQUEST['lang'] );
			 $current_lang = self::get_current_language();

			if ( $set_lang != 'all' && $set_lang != $current_lang && in_array( $set_lang, $wpml_language_resolution->get_active_language_codes(), true ) ) {
				self::switch_lang( $set_lang );
			}
		}
	}

	/**
	 * @since 2.3.4
	 */
	public static function preview_post_link( $preview_link, $post ) {
		if ( ! geodir_is_page( 'add-listing' ) ) {
			return $preview_link;
		}

		$default_lang = self::get_default_language();
		$current_lang = self::get_current_language();

		if ( $current_lang && $default_lang && $current_lang != $default_lang ) {
			$preview_link = add_query_arg( array( 'lang' => $current_lang ), $preview_link );
		}

		return $preview_link;
	}

	/**
	 * @since 2.3.7
	 */
	public static function getpaid_is_success_page( $check ) {
		if ( ! $check ) {
			$page_id = wpinv_get_option( 'success_page', false );

			if ( empty( $page_id ) ) {
				return $check;
			}

			$_page_id = self::get_object_id( $page_id, 'page', true );

			if ( ! empty( $_page_id ) && $_page_id != $page_id && is_page( $_page_id ) ) {
				$check = true;
			}
		}

		return $check;
	}

	/**
	 * @since 2.3.7
	 */
	public static function getpaid_is_invoice_history_page( $check ) {
		if ( ! $check ) {
			$page_id = wpinv_get_option( 'invoice_history_page', false );

			if ( empty( $page_id ) ) {
				return $check;
			}

			$_page_id = self::get_object_id( $page_id, 'page', true );

			if ( ! empty( $_page_id ) && $_page_id != $page_id && is_page( $_page_id ) ) {
				$check = true;
			}
		}

		return $check;
	}

	/**
	 * @since 2.3.7
	 */
	public static function getpaid_is_subscriptions_history_page( $check ) {
		if ( ! $check ) {
			$page_id = wpinv_get_option( 'invoice_subscription_page', false );

			if ( empty( $page_id ) ) {
				return $check;
			}

			$_page_id = self::get_object_id( $page_id, 'page', true );

			if ( ! empty( $_page_id ) && $_page_id != $page_id && is_page( $_page_id ) ) {
				$check = true;
			}
		}

		return $check;
	}

	public static function pricing_wc_cart_product_id( $product_id, $task, $post_id, $package_id, $post_data ) {
		return self::get_object_id( $product_id, get_post_type( $product_id ), true );
	}

	/**
	 * @since 2.3.7
	 */
	public static function pricing_wc_get_package_id( $package_id, $product_id ) {
		if ( empty( $package_id ) ) {
			$element_ids = self::get_element_ids( $product_id, 'post_' . get_post_type( $product_id ) );

			if ( ! empty( $element_ids ) ) {
				remove_filter( 'geodir_pricing_wc_get_package_id', array( __CLASS__, 'pricing_wc_get_package_id' ), 20, 2 );

				foreach ( $element_ids as $element_id ) {
					if ( ! empty( $element_id ) && $element_id != $product_id ) {
						// Delete cache
						geodir_cache_delete( 'geodir_pricing_wc_product_package_id-' . $element_id, 'geodir_pricing_wc' );

						$_package_id = geodir_pricing_get_package_id( $element_id );

						if ( ! empty( $_package_id ) ) {
							$package_id = $_package_id;
							break;
						}
					}
				}

				add_filter( 'geodir_pricing_wc_get_package_id', array( __CLASS__, 'pricing_wc_get_package_id' ), 20, 2 );
			}
		}

		return $package_id;
	}
}