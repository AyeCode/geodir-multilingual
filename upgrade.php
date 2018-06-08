<?php
/**
 * GeoDirectory Multilingual upgrade functions.
 *
 * @author   AyeCode
 * @package  GeoDir_Multilingual
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $wpdb;

if ( get_option( 'geodir_multilingual_db_version' ) != GEODIR_MULTILINGUAL_VERSION ) {
    /**
     * Upgrade all versions of the plugin.
     *
     * @since 1.0.0
     * @package GeoDir_Multilingual
     */
    add_action( 'plugins_loaded', 'geodir_multilingual_upgrade_all', 10 );
}

/**
 * Handles upgrade all versions of the plugin.
 *
 * @since 1.0.0
 * @package GeoDir_Multilingual
 */
function geodir_multilingual_upgrade_all() {
}
