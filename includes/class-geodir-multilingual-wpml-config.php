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
		// Tools
		add_filter( 'geodir_debug_tools', array( __CLASS__, 'diagnostic_tools' ), 30, 1 );

		add_filter( 'wpml_tm_translation_job_data', array( __CLASS__, 'wpml_tm_translation_job_data' ), 20, 2 );
		add_filter( 'wpml_pre_save_pro_translation', array( __CLASS__, 'wpml_pre_save_pro_translation' ), 20, 2 );
		add_action( 'wpml_pro_translation_completed', array( __CLASS__, 'wpml_pro_translation_completed' ), 20, 3 );
		add_action( 'geodir_post_type_saved', array( __CLASS__, 'on_post_type_saved' ), 20, 3 );
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
			// translate
			$child_node_attr        = $dom->createAttribute( 'translate' );
			$child_node_attr->value = '1';
			$child_node->appendChild( $child_node_attr );
			// automatic
			$child_node_attr        = $dom->createAttribute( 'automatic' );
			$child_node_attr->value = '0';
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
			if ( ! empty( $data['style'] ) && ( $data['style'] == 'textarea' || $data['style'] == 'visual' ) ) {
				$child_node_attr        = $dom->createAttribute( 'style' );
				$child_node_attr->value = $data['style'];
				$child_node->appendChild( $child_node_attr );
			}
		}
	}

	public static function get_custom_fields( $post_types = array() ) {
		global $wpdb;

		$post_types = ! empty( $post_types ) ? $post_types : array_keys( geodir_get_posttypes( 'array' ) );

		$fields = $wpdb->get_results( "SELECT * FROM `" . GEODIR_CUSTOM_FIELDS_TABLE . "` WHERE is_active = 1 AND post_type IN ( '" . implode( "', '", $post_types ) . "' ) GROUP BY htmlvar_name ORDER BY sort_order ASC" );

		$_fields = array();

		if ( ! empty( $fields ) ) {
			foreach ( $fields as $field ) {
				$name = $field->htmlvar_name;

				$skip = in_array( $name, array( 'post_title', 'post_content' ) ) || $field->field_type == 'fieldset' ? true : false;

				if ( apply_filters( 'geodir_wpml_generate_xml_skip_custom_field', $skip, $name, $field ) ) {
					continue;
				}

				if ( in_array( $name, array( 'post_category', 'post_tags', 'business_hours', 'claimed', 'event_dates', 'recurring', 'expire_date', 'package_id', 'franchise', 'franchise_fields', 'franchise_of' ) ) || in_array( $field->field_type, array( 'checkbox', 'radio', 'select', 'multiselect', 'datepicker', 'time' ) ) || in_array( strtolower( $field->data_type ), array( 'int', 'float', 'decimal' ) ) ) {
					$value = 'copy';
				} else if ( in_array( $field->field_type, array( 'phone', 'email', 'url' ) ) ) {
					$value = 'copy-once';
				} else if ( in_array( $field->field_type, array( 'images', 'file' ) ) ) {
					$value = 'ignore';
				} else {
					$value = 'translate';
				}

				// style
				if ( $field->field_type == 'textarea' ) {
					$style = 'textarea';
				} else if ( $field->field_type == 'html' ) {
					$style = 'visual';
				} else {
					$style = 'line';
				}

				$contents = array(
					'type' => 'action',
					'value' => apply_filters( 'geodir_wpml_generate_xml_custom_field_value', $value, $name, $field ),
					'style' => $style
				);

				$contents = apply_filters( 'geodir_wpml_generate_xml_custom_field', $contents, $name, $field );

				if ( $name == 'address' ) {
					$name = 'street';
				}

				if ( ! empty( $contents ) ) {
					$_fields[ 'field-' . $name ] = $contents;

					if ( $name == 'post_category' ) {
						$_fields[ 'field-default_category' ] = $contents;
					} else if ( $name == 'street' ) {
						$address_fields = array( 'street2', 'city', 'region', 'country', 'neighbourhood', 'zip', 'latitude', 'longitude', 'mapview', 'mapzoom' );

						foreach ( $address_fields as $address_field ) {
							$value = 'translate';

							if ( $address_field == 'country' || $address_field == 'latitude' || $address_field == 'longitude' || $address_field == 'zip' || $address_field == 'mapview' || $address_field == 'mapzoom' ) {
								$value = 'copy';
							}

							if ( defined( 'GEODIRLOCATION_VERSION' ) ) {
								if ( $address_field == 'neighbourhood' && ! (bool) GeoDir_Location_Neighbourhood::is_active() ) {
									continue;
								}

								if ( geodir_get_option( 'lm_default_' . $address_field ) == 'default' ) {
									$value = 'copy';
								}
							} else {
								if ( $address_field == 'region' || $address_field == 'city' ) {
									$value = 'copy';
								}
							}

							$_fields[ 'field-' . $address_field ] = array(
								'type' => 'action',
								'value' => $value,
								'style' => $style
							);
						}
					}
				}
			}
		}

		return apply_filters( 'geodir_wpml_generate_xml_custom_fields', $_fields, $fields );
	}

	public static function wpml_tm_translation_job_data( $package, $post ) {
		if ( geodir_is_gd_post_type( $post->post_type ) ) {
			$tp = new WPML_Element_Translation_Package();

			$package_id = geodir_get_post_package_id( (int) $post->ID, $post->post_type );
			$fields = geodir_post_custom_fields( $package_id, 'all', $post->post_type );
			$gd_post = geodir_get_post_info( (int) $post->ID );

			foreach ( $fields as $key => $field ) {
				$name = $field['name'];

				$skip = in_array( $name, array( 'post_title', 'post_content' ) ) || $field['field_type'] == 'fieldset' ? true : false;

				if ( apply_filters( 'geodir_wpml_tm_translation_job_data_skip_cf', $skip, $name, $field, $package, $post ) ) {
					continue;
				}

				if ( in_array( $name, array( 'post_category', 'post_tags', 'business_hours', 'claimed', 'event_dates', 'recurring', 'expire_date', 'package_id', 'franchise', 'franchise_fields', 'franchise_of' ) ) || in_array( $field['field_type'], array( 'checkbox', 'radio', 'select', 'multiselect' ) ) ) {
					$translate = 0;
				} else if ( in_array( $field['field_type'], array( 'images', 'file' ) ) ) {
					$translate = 0;
				} else {
					$translate = 1;
				}

				if ( $name == 'address' ) {
					$name = 'street';
				}

				$value = isset( $gd_post->{$name} ) ? $gd_post->{$name} : '';

				$contents = array(
					'translate' => $translate,
					'data'      => $tp->encode_field_data( $value, 'base64' ),
					'format'    => 'base64'
				);

				$contents = apply_filters( 'geodir_wpml_tm_translation_job_data_cf', $contents, $name, $field, $package, $post );

				if ( ! empty( $contents ) ) {
					$package['contents'][ 'field-' . $name ] = $contents;

					if ( $name == 'post_category' ) {
						$contents['data'] = $tp->encode_field_data( $gd_post->default_category, 'base64' );
						$package['contents'][ 'field-default_category' ] = $contents;
					} else if ( $name == 'street' ) {
						$address_fields = array( 'street2', 'city', 'region', 'country', 'neighbourhood', 'zip', 'latitude', 'longitude', 'mapview', 'mapzoom' );

						foreach ( $address_fields as $address_field ) {
							$value = isset( $gd_post->{$address_field} ) ? $gd_post->{$address_field} : '';
							$translate = 1;

							if ( $address_field == 'country' || $address_field == 'latitude' || $address_field == 'longitude' || $address_field == 'zip' || $address_field == 'mapview' || $address_field == 'mapzoom' ) {
								$translate = 0;
							}

							if ( defined( 'GEODIRLOCATION_VERSION' ) ) {
								if ( $address_field == 'neighbourhood' && ! (bool) GeoDir_Location_Neighbourhood::is_active() ) {
									continue;
								}

								if ( geodir_get_option( 'lm_default_' . $address_field ) == 'default' ) {
									$translate = 0;
								}
							} else {
								if ( $address_field == 'region' || $address_field == 'city' ) {
									$translate = 0;
								}
							}

							$package['contents'][ 'field-' . $address_field ] = array(
								'translate' => $translate,
								'data'      => $tp->encode_field_data( $value, 'base64' ),
								'format'    => 'base64'
							);
						}
					}
				}
			}
		}

		return $package;
	}

	public static function wpml_pre_save_pro_translation( $postarr, $job ) {
		global $wpdb, $iclTranslationManagement;

		if ( ! geodir_is_gd_post_type( $postarr['post_type'] ) ) {
			return $postarr;
		}

		$custom_fields = self::get_custom_fields( array( $postarr['post_type'] ) );

		$element_type_prefix = $iclTranslationManagement->get_element_type_prefix_from_job( $job );
		$original_post       = $iclTranslationManagement->get_post( $job->original_doc_id, $element_type_prefix );
		$original_gd_post     = geodir_get_post_info( (int) $original_post->ID );

		foreach ( $job->elements as $_field ) {
			$field_type = $_field->field_type;

			if ( isset( $custom_fields[ $field_type ] ) ) {
				if ( strpos( $field_type, 'field-' ) === 0 ) {
					$_fields = explode( 'field-', $field_type, 2 );
					$field = $_fields[1];
				} else {
					$field = $field_type;
				}

				if ( ! empty( $original_gd_post ) && $custom_fields[ $field_type ]['value'] == 'copy' && isset( $original_gd_post->{$field} ) ) {
					$value = $original_gd_post->{$field};
				} else {
					$value = self::decode_field_data( $_field->field_data_translated, $_field->field_format );
				}

				if ( $value !== '' ) {
					$postarr[ $field ] = $value;
				}
			}
		}

		// change post_category to an array()
		if ( ! empty( $postarr['post_category'] ) ) {
			$post_category = array();
			$_post_category = array_filter( array_map( 'trim', explode( ',', strip_tags( $postarr['post_category'] ) ) ) );

			if ( ! empty( $_post_category ) ) {
				foreach ( $_post_category as $term_id ) {
					$_term_id = apply_filters( 'translate_object_id', absint( $term_id ), $postarr['post_type'] . 'category', false, $job->language_code );

					$post_category[] = ! empty( $_term_id ) ? (int) $_term_id : (int) $term_id;
				}
			}

			$postarr['tax_input'][$postarr['post_type'] . 'category'] = $post_category;
			$postarr['default_category'] = (int) apply_filters( 'translate_object_id', absint( $original_gd_post->default_category ), $postarr['post_type'] . 'category', false, $job->language_code );

			unset( $postarr['post_category'] );
		}

		// change post_tags to an array()
		if ( ! empty( $postarr['post_tags'] ) ) {
			$taxonomy = $postarr['post_type'].'_tags';
			$terms = get_the_terms( (int) $original_post->ID, $taxonomy );

			if ( $terms ) {
				foreach ( $terms as $term ) {
					$tr_id = apply_filters( 'translate_object_id', $term->term_id, $taxonomy, false, $job->language_code );

					if ( ! is_null( $tr_id ) ) {
						$translated_term = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->terms} t JOIN {$wpdb->term_taxonomy} x ON x.term_id = t.term_id WHERE t.term_id = %d AND x.taxonomy = %s", $tr_id, $taxonomy ) );

						$term_names[] = $translated_term->name;
					}
				}
			}

			$post_tags = ! empty( $term_names ) ? $term_names : array_filter( array_map( 'trim', explode( ',', strip_tags( $postarr['post_tags'] ) ) ) );

			$postarr['tax_input'][ $taxonomy ] = $post_tags;

			unset( $postarr['post_tags'] );
		}

		if ( ! empty( $original_gd_post->featured_image ) ) {
			$postarr['featured_image'] = $original_gd_post->featured_image;
		}

		return $postarr;
	}

	public static function wpml_pro_translation_completed( $new_post_id, $fields, $job ) {
		global $wpdb, $iclTranslationManagement;

		if ( ! geodir_is_gd_post_type( get_post_type( $new_post_id ) ) ) {
			return;
		}

		$element_type_prefix = $iclTranslationManagement->get_element_type_prefix_from_job( $job );
		$original_post = $iclTranslationManagement->get_post( $job->original_doc_id, $element_type_prefix );

		// Duplicate post images
		GeoDir_Multilingual_WPML::duplicate_post_images( $original_post->ID, $new_post_id, $job->language_code, true );

		// Duplicate post files
		GeoDir_Multilingual_WPML::duplicate_post_files( $original_post->ID, $new_post_id, $job->language_code );
	}

	public static function decode_field_data( $data, $format ) {
		if ( $format == 'base64' ) {
			$data = base64_decode( $data );
		} elseif ( $format == 'csv_base64' ) {
			$exp = explode( ',', $data );
			foreach ( $exp as $k => $e ) {
				$exp[ $k ] = base64_decode( trim( $e, '"' ) );
			}
			$data = $exp;
		}

		return $data;
	}

	public static function on_post_type_saved( $post_type, $args, $new = false ) {
		if ( $new ) {
			self::generate_wpml_config();
		}
	}
}