<?php
/**
 * GeoDirectory Multilingual
 *
 * @package           GeoDir_Multilingual
 * @author            AyeCode Ltd
 * @copyright         2019 AyeCode Ltd
 * @license           GPLv3
 *
 * @wordpress-plugin
 * Plugin Name:       GeoDirectory Multilingual
 * Plugin URI:        https://wpgeodirectory.com/downloads/wpml-multilingual/
 * Description:       Allows running your directory fully multilingual with GeoDirectory and WPML.
 * Version:           2.3.9
 * Requires at least: 5.0
 * Requires PHP:      5.6
 * Author:            AyeCode Ltd
 * Author URI:        https://ayecode.io
 * License:           GPLv3
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Requires Plugins:  geodirectory
 * Text Domain:       geodir-multilingual
 * Domain Path:       /languages
 * Update URL:        https://github.com/AyeCode/geodir-multilingual/
 * Update ID:         617425
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'GEODIR_MULTILINGUAL_VERSION' ) ) {
	define( 'GEODIR_MULTILINGUAL_VERSION', '2.3.9' );
}

if ( ! defined( 'GEODIR_MULTILINGUAL_MIN_CORE' ) ) {
	define( 'GEODIR_MULTILINGUAL_MIN_CORE', '2.3' );
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function geodir_load_multilingual() {
    global $geodir_multilingual;

	if ( ! defined( 'GEODIR_MULTILINGUAL_PLUGIN_FILE' ) ) {
		define( 'GEODIR_MULTILINGUAL_PLUGIN_FILE', __FILE__ );
	}

	// Min core version check
	if ( ! function_exists( 'geodir_min_version_check' ) || ! geodir_min_version_check( 'Multilingual', GEODIR_MULTILINGUAL_MIN_CORE ) ) {
		return '';
	}

	/**
	 * The core plugin class that is used to define internationalization,
	 * dashboard-specific hooks, and public-facing site hooks.
	 */
	require_once ( plugin_dir_path( GEODIR_MULTILINGUAL_PLUGIN_FILE ) . 'includes/class-geodir-multilingual.php' );

    return $geodir_multilingual = GeoDir_Multilingual::instance();
}
add_action( 'wpml_loaded', 'geodir_load_multilingual' );
