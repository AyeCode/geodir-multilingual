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
 * Register widgets.
 *
 * @since 1.0.0.0
 *
 * @param array $widgets The list of available widgets.
 * @return array Available GD widgets.
 */
function goedir_multilingual_register_widgets( $widgets ) {
	if ( defined( 'ICL_SITEPRESS_VERSION' ) && ! ICL_PLUGIN_INACTIVE && class_exists( 'SitePress' ) && function_exists( 'icl_object_id' ) ) {
		$widgets[] = 'GeoDir_Multilingual_Widget_Post_WPML_Translation';
	}

	return $widgets;
}
add_filter( 'geodir_get_widgets', 'goedir_multilingual_register_widgets', 10, 1 );

function geodir_multilingual_params() {
	$params = array(
		'confirmDuplicate' => addslashes( __( 'Are you sure to duplicate listing in selected languages?', 'geodir-multilingual' ) ),
		'confirmTranslateIndependently' => addslashes( __( 'Are you sure to make duplicated translation independent? WPML will set this post to be translated independently.', 'geodir-multilingual' ) )
	);

	return apply_filters( 'geodir_multilingual_params', $params );
}

function geodir_multilingual_admin_params() {
	$params = array(
    );

    return apply_filters( 'geodir_multilingual_admin_params', $params );
}