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
		add_filter( 'geodir_get_settings_cpt', array( __CLASS__, 'cpt_settings' ), 20, 3 );
		add_filter( 'geodir_save_post_type', array( __CLASS__, 'sanatize_post_type' ), 10, 3 );
	}

	/**
	 * Include any classes we need within admin.
	 */
	public function includes() {
		include_once( GEODIR_MULTILINGUAL_PLUGIN_DIR . 'includes/admin/admin-functions.php' );
	}

	public static function cpt_settings( $settings, $current_section = '', $post_type_values = array() ) {
		$wpml_duplicate = ! empty( $post_type_values['wpml_duplicate'] ) ? $post_type_values['wpml_duplicate'] : '';

		if ( ! empty( $settings ) ) {
			$settings[] = array(
				'title'    => __( 'WPML', 'geodir-multilingual' ),
				'type'     => 'title',
				'desc'     => '',
				'id'       => 'cpt_settings_wpml',
				'desc_tip' => true,
				'advanced' => true
			);
			$settings[] = array(
				'type' => 'checkbox',
				'name' => __( 'Enable frontend duplicate?', 'geodir-multilingual' ),
				'desc' => __( 'Tick to allow users to translate their listings via WPML duplicate translation.', 'geodir-multilingual' ),
				'id'   => 'wpml_duplicate',
				'std'  => '0',
				'advanced' => true,
				'value'	   => $wpml_duplicate
			);
			$settings[] = array( 
				'type' => 'sectionend',
				'id' => 'cpt_settings_wpml',
				'advanced' => true
			);
		}
		return $settings;
	}

	public static function sanatize_post_type( $data, $post_type, $request ) {
		$wpml_duplicate = ! empty( $request['wpml_duplicate'] ) ? 1 : 0;
		$data[ $post_type ]['wpml_duplicate'] = $wpml_duplicate;
		return $data;
	}
}

return new GeoDir_Multilingual_Admin();
