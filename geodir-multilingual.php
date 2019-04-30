<?php
/**
 * This is the main GeoDirectory Multilingual plugin file, here we declare and call the important stuff
 *
 * @package           GeoDir_Multilingual
 * @copyright         2018 AyeCode Ltd
 * @license           GPL-2.0+
 * @since             1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       GeoDirectory Multilingual
 * Plugin URI:        https://wpgeodirectory.com/downloads/multilingual/
 * Description:       Allows running your directory fully multilingual with GeoDirectory and WPML.
 * Version:           2.0.0.4
 * Author:            AyeCode Ltd
 * Author URI:        https://wpgeodirectory.com/
 * Requires at least: 4.9
 * Tested up to:      5.2
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       geodir-multilingual
 * Domain Path:       /languages
 * Update URL:        https://github.com/AyeCode/geodir-multilingual/
 * Update ID:         617425
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'GEODIR_MULTILINGUAL_VERSION' ) ) {
	define( 'GEODIR_MULTILINGUAL_VERSION', '2.0.0.4' );
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

	/**
	 * The core plugin class that is used to define internationalization,
	 * dashboard-specific hooks, and public-facing site hooks.
	 */
	require_once ( plugin_dir_path( GEODIR_MULTILINGUAL_PLUGIN_FILE ) . 'includes/class-geodir-multilingual.php' );

    return $geodir_multilingual = GeoDir_Multilingual::instance();
}
add_action( 'wpml_loaded', 'geodir_load_multilingual' );
