<?php
/**
 * GeoDirectory Multilingual Admin
 *
 * @class    GeoDir_Multilingual_Admin
 * @author   AyeCode
 * @package  GeoDir_Multilingual/Admin
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * GeoDir_Multilingual_Admin class.
 */
class GeoDir_Multilingual_Admin {
    
    /**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'includes' ) );
	}

	/**
	 * Include any classes we need within admin.
	 */
	public function includes() {
		include_once( GEODIR_MULTILINGUAL_PLUGIN_DIR . 'includes/admin/admin-functions.php' );
	}
}

return new GeoDir_Multilingual_Admin();
