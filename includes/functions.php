<?php
/**
 * Plugin core functions.
 *
 * @since 1.0.0
 * @package GeoDir_Multilingual
 */
 
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

 /**
 * Register Widgets.
 *
 * @since 1.0.0
 */
function goedir_multilingual_register_widgets() {
	if ( defined( 'ICL_SITEPRESS_VERSION' ) && ! ICL_PLUGIN_INACTIVE && class_exists( 'SitePress' ) && function_exists( 'icl_object_id' ) ) {
		register_widget( 'GeoDir_Multilingual_Widget_Post_WPML_Translation' );
	}
}
add_action( 'widgets_init', 'goedir_multilingual_register_widgets' );

function geodir_multilingual_params() {
	$params = array(
    );

    return apply_filters( 'geodir_multilingual_params', $params );
}

function geodir_multilingual_admin_params() {
	$params = array(
    );

    return apply_filters( 'geodir_multilingual_admin_params', $params );
}