<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * GeoDirectory Multilingual AJAX class.
 *
 * AJAX Event Handler.
 *
 * @class    GeoDir_Multilingual_AJAX
 * @package  GeoDir_Multilingual/Classes
 * @category Class
 * @author   AyeCode
 */
class GeoDir_Multilingual_AJAX {

	/**
	 * Hook in ajax handlers.
	 */
	public static function init() {
		self::add_ajax_events();
	}

	/**
	 * Hook in methods - uses WordPress ajax handlers (admin-ajax).
	 */
	public static function add_ajax_events() {
		// geodirectory_EVENT => nopriv
		$ajax_events = array(
			'wpml_duplicate'				=> true,
			'wpml_translate_independently'	=> true,
		);

		foreach ( $ajax_events as $ajax_event => $nopriv ) {
			add_action( 'wp_ajax_geodir_' . $ajax_event, array( __CLASS__, $ajax_event ) );

			if ( $nopriv ) {
				add_action( 'wp_ajax_nopriv_geodir_' . $ajax_event, array( __CLASS__, $ajax_event ) );

				// GeoDir AJAX can be used for frontend ajax requests.
				add_action( 'geodir_multilingual_ajax_' . $ajax_event, array( __CLASS__, $ajax_event ) );
			}
		}
	}

	public static function wpml_duplicate() {
		GeoDir_Multilingual_WPML::frontend_duplicate();
	}

	/**
	 * Handle translate independently AJAX event.
	 *
	 * @since 2.1.0.2
	 *
	 * @return mixed
	 */
	public static function wpml_translate_independently() {
		GeoDir_Multilingual_WPML::translate_independently();
	}
}