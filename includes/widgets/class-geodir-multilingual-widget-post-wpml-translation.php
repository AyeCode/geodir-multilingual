<?php
/**
 * GeoDirectory Multilingual Widget Post WPML Translation
 *
 * @class    GeoDir_Multilingual_Widget_Post_WPML_Translation
 * @author   AyeCode
 * @package  GeoDir_Multilingual/Widget
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * GeoDir_Multilingual_Widget_Post_WPML_Translation class.
 */
class GeoDir_Multilingual_Widget_Post_WPML_Translation extends WP_Super_Duper {

	public function __construct() {

		$options = array(
			'textdomain'    	=> 'geodir-multilingual',
			'block-icon'    	=> 'translation',
			'block-category'	=> 'geodirectory',
			'block-keywords'	=> "['geodir','translate','wpml']",
			'class_name'    	=> __CLASS__,
			'base_id'       	=> 'gd_post_wpml_translation',
			'name'          	=> __( 'GD > Post WPML Duplicate', 'geodir-multilingual' ),
			'widget_ops'    	=> array(
				'classname'   		=> 'geodir-post-wpml-translation' . ( geodir_design_style() ? ' bsui' : '' ),
				'description' 		=> esc_html__( 'Show WPML duplicate translation on the listing detail page.', 'geodir-multilingual' ),
				'geodirectory' 		=> true,
				'gd_wgt_showhide' 	=> 'show_on',
				'gd_wgt_restrict' 	=> array( 'gd-detail' ),
			),
			'arguments'     => array(
				'title'        => array(
					'type'     => 'text',
					'title'    => __( 'Title:', 'geodir-multilingual' ),
					'desc'     => __( 'The widget title.', 'geodir-multilingual' ),
					'default'  => '',
					'desc_tip' => true,
					'advanced' => false
				)
			)
		);

		parent::__construct( $options );
	}

	/**
	 * Output HTML.
	 *
	 * @param array $args
	 * @param array $widget_args
	 * @param string $content
	 *
	 * @return mixed|string|void
	 */
	public function output( $args = array(), $widget_args = array(), $content = '' ) {
		global $gd_post;

		if ( ! ( ! empty( $gd_post ) && geodir_is_page( 'detail' ) ) ) {
			return;
		}

		$args = wp_parse_args(
			(array) $args,
			array(
				'title' => ''
			)
		);

		ob_start();

		self::output_html( $widget_args, $args );

		return ob_get_clean();
	}

	/**
	 * Get the widget HTML.
	 *
	 * @param array|string $args               Widget arguments.
	 * @param array|string $instance           The settings for the particular instance of the widget.
	 */
	public static function output_html( $args = '', $instance = '' ) {
		echo GeoDir_Multilingual_WPML::post_detail_duplicates( $args, $instance );
	}
}