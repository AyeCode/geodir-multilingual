<?php
/**
 * GeoDirectory Multilingual WPML Configuration
 *
 * @class    GeoDir_Multilingual_WPML_Config
 * @author   AyeCode
 * @package  GeoDir_Multilingual/Classes
 * @version  2.1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * GeoDir_Multilingual_WPML class.
 */
class GeoDir_Multilingual_WPML_Config {

	public static function init() {
		global $sitepress;

		// Tools
		add_filter( 'geodir_debug_tools', array( __CLASS__, 'diagnostic_tools' ), 30, 1 );
	}

	/**
	 * Tool to generate WPML wpml-config.xml file.
	 *
	 * @since 2.1.0.1
	 */
	public static function diagnostic_tools( $tools = array() ) {
		$tools['generate_wpml_config'] = array(
			'name' => __( 'Update WPML Configuration File', 'geodir-multilingual' ),
			'button' => __( 'Run', 'geodirectory' ),
			'desc' => __( 'This will update WPML configuration(wpml-config.xml) file.', 'geodir-multilingual' ),
			'callback' => array( 'GeoDir_Multilingual_WPML_Config', 'generate_wpml_config' )
		);

		return $tools;
	}

	/**
	 * Generate XML file
	 *
	 * Generation wpml-config.xml file.
	 * Used as configuration file for WPML plugin.
	 *
	 * @url https://wpml.org/documentation/support/language-configuration-files/
	 */
	public static function generate_wpml_config( $action = 'save' ) {
		$filename = self::get_file_name();

		$dom                     = new DOMDocument();
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput       = true;

		$root = $dom->createElement( 'wpml-config' );
		$root = $dom->appendChild( $root );

		// Post types
		self::generate_custom_types( $dom, $root );

		// Taxonomies
		self::generate_taxonomies( $dom, $root );

		// Custom fields
		self::generate_custom_fields( $dom, $root );

		$xml = $dom->saveXML( $root );

		// Save options
		switch ( $action ) {
			case 'download' :
				header( "Content-Description: File Transfer" );
				header( 'Content-Disposition: attachment; filename="' . self::get_file_name() . '"' );
				header( "Content-Type: application/xml" );
				echo $xml;
				die();
				break;

			case 'save' :
				if ( @file_put_contents( self::get_file_path(), $xml ) ) {
					return true;
				}
				break;
		}

		return false;
	}

	public static function get_file_name() {
		return 'wpml-config.xml';
	}

	public static function get_file_path() {
		return GEODIR_MULTILINGUAL_PLUGIN_DIR . '/' . self::get_file_name();
	}

	public static function get_file_url() {
		return GEODIR_MULTILINGUAL_PLUGIN_URL . '/' . self::get_file_name();
	}

	public static function generate_custom_types( $dom, $root ) {
		$post_types = geodir_get_posttypes( 'array' );

		$parent_node = $dom->createElement( 'custom-types' );
		$parent_node = $root->appendChild( $parent_node );

		foreach ( $post_types as $post_type => $data ) {
			$child_node             = $dom->createElement( 'custom-type', sanitize_key( $post_type ) );
			$child_node             = $parent_node->appendChild( $child_node );
			$child_node_attr        = $dom->createAttribute( 'translate' );
			$child_node_attr->value = '1';
			$child_node->appendChild( $child_node_attr );
		}
	}

	public static function generate_taxonomies( $dom, $root ) {
		$post_types = geodir_get_posttypes( 'array' );

		$parent_node = $dom->createElement( 'taxonomies' );
		$parent_node = $root->appendChild( $parent_node );

		foreach ( $post_types as $post_type => $data ) {
			// Category
			$child_node             = $dom->createElement( 'taxonomy', sanitize_key( $post_type . 'category' ) );
			$child_node             = $parent_node->appendChild( $child_node );
			$child_node_attr        = $dom->createAttribute( 'translate' );
			$child_node_attr->value = '1';
			$child_node->appendChild( $child_node_attr );

			// Tags
			$child_node             = $dom->createElement( 'taxonomy', sanitize_key( $post_type  . '_tags' ) );
			$child_node             = $parent_node->appendChild( $child_node );
			$child_node_attr        = $dom->createAttribute( 'translate' );
			$child_node_attr->value = '1';
			$child_node->appendChild( $child_node_attr );
		}
	}

	public static function generate_custom_fields( $dom, $root ) {
		$custom_fields = self::get_custom_fields();

		if ( empty( $custom_fields ) ) {
			return;
		}

		$parent_node = $dom->createElement( 'custom-fields' );
		$parent_node = $root->appendChild( $parent_node );

		foreach ( $custom_fields as $key => $data ) {
			// Category
			$child_node             = $dom->createElement( 'custom-field', sanitize_key( $key ) );
			$child_node             = $parent_node->appendChild( $child_node );
			$child_node_attr        = $dom->createAttribute( $data['type'] );
			$child_node_attr->value = $data['value'];
			$child_node->appendChild( $child_node_attr );
		}
	}

	public static function get_custom_fields() {
		global $wpdb;

		$post_types = geodir_get_posttypes( 'array' );

		$fields = $wpdb->get_results( "SELECT * FROM `" . GEODIR_CUSTOM_FIELDS_TABLE . "` WHERE is_active = 1 AND post_type IN ( '" . implode( "', '", array_keys( $post_types ) ) . "' ) GROUP BY htmlvar_name ORDER BY sort_order ASC" );

		$_fields = array();

		if ( ! empty( $fields ) ) {
			foreach ( $fields as $field ) {
				if ( apply_filters( 'geodir_wpml_generate_xml_skip_custom_field', in_array( $field->htmlvar_name, array( 'post_title', 'post_content' ) ), $field ) ) {
					continue;
				}

				$xml_fields = array();
				$xml_fields[ $field->htmlvar_name ] = array(
					'type' => 'action',
					'value' => apply_filters( 'geodir_wpml_generate_xml_custom_field_value', 'translate', $field->htmlvar_name, $field )
				);

				$xml_fields = apply_filters( 'geodir_wpml_generate_xml_custom_field', $xml_fields, $field->htmlvar_name, $field );

				if ( ! empty( $xml_fields ) ) {
					$_fields = ! empty( $xml_fields ) ? array_merge( $_fields, $xml_fields ) : $xml_fields;
				}
			}
		}

		return apply_filters( 'geodir_wpml_generate_xml_custom_fields', $_fields, $fields );
	}
}