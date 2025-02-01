<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @link       https://wpgeodirectory.com
 * @since      1.0.0
 *
 * @package    GeoDir_Multilingual
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    GeoDir_Multilingual
 * @author     AyeCode Ltd
 */
final class GeoDir_Multilingual {

	/**
	 * GeoDirectory Custom Post Types instance.
	 *
	 * @access private
	 * @since  2.0.0
	 */
	private static $instance = null;

	/**
	 * Main GeoDir_Multilingual Instance.
	 *
	 * Ensures only one instance of GeoDirectory Custom Post Types is loaded or can be loaded.
	 *
	 * @since 2.0.0
	 * @static
	 * @see GeoDir()
	 * @return GeoDir_Multilingual - Main instance.
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof GeoDir_Multilingual ) ) {
			self::$instance = new GeoDir_Multilingual;
			self::$instance->setup_constants();
			
			add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );

			if ( ! class_exists( 'GeoDirectory' ) ) {
				add_action( 'admin_notices', array( self::$instance, 'geodirectory_notice' ) );

				return self::$instance;
			}

			if ( version_compare( PHP_VERSION, '5.5', '<' ) ) {
				add_action( 'admin_notices', array( self::$instance, 'php_version_notice' ) );

				return self::$instance;
			}

			self::$instance->includes();
			self::$instance->init_hooks();

			do_action( 'geodir_multilingual_loaded' );
		}

		return self::$instance;
	}

	/**
	 * Setup plugin constants.
	 *
	 * @access private
	 * @since 2.0.0
	 * @return void
	 */
	private function setup_constants() {
		global $plugin_prefix;

		if ( $this->is_request( 'test' ) ) {
			$plugin_path = dirname( GEODIR_MULTILINGUAL_PLUGIN_FILE );
		} else {
			$plugin_path = plugin_dir_path( GEODIR_MULTILINGUAL_PLUGIN_FILE );
		}
		
		$this->define( 'GEODIR_MULTILINGUAL_PLUGIN_DIR', $plugin_path );
		$this->define( 'GEODIR_MULTILINGUAL_PLUGIN_URL', untrailingslashit( plugins_url( '/', GEODIR_MULTILINGUAL_PLUGIN_FILE ) ) );
		$this->define( 'GEODIR_MULTILINGUAL_PLUGIN_BASENAME', plugin_basename( GEODIR_MULTILINGUAL_PLUGIN_FILE ) );
	}

	/**
	 * Loads the plugin language files
	 *
	 * @access public
	 * @since 2.0.0
	 * @return void
	 */
	public function load_textdomain() {
		// Determines the current locale.
		$locale = determine_locale();

		/**
		 * Filter the plugin locale.
		 *
		 * @since   1.0.0
		 * @package GeoDir_Multilingual
		 */
		$locale = apply_filters( 'plugin_locale', $locale, 'geodir-multilingual' );

		unload_textdomain( 'geodir-multilingual', true );
		load_textdomain( 'geodir-multilingual', WP_LANG_DIR . '/geodir-multilingual/geodir-multilingual-' . $locale . '.mo' );
		load_plugin_textdomain( 'geodir-multilingual', false, basename( dirname( GEODIR_MULTILINGUAL_PLUGIN_FILE ) ) . '/languages/' );
	}

	/**
	 * Check plugin compatibility and show warning.
	 *
	 * @static
	 * @access private
	 * @since 1.0.0
	 * @return void
	 */
	public static function geodirectory_notice() {
		echo '<div class="error"><p>' . __( 'GeoDirectory plugin is required for the GeoDirectory Multilingual plugin to work properly.', 'geodir-multilingual' ) . '</p></div>';
	}

	/**
	 * Show a warning to sites running PHP < 5.5
	 *
	 * @static
	 * @access private
	 * @since 1.0.0
	 * @return void
	 */
	public static function php_version_notice() {
		echo '<div class="error"><p>' . __( 'Your version of PHP is below the minimum PHP version required by GeoDirectory Multilingual. Please contact your host and request that your version be upgraded to 5.5 or later.', 'geodir-multilingual' ) . '</p></div>';
	}

	/**
	 * Include required files.
	 *
	 * @access private
	 * @since 1.0.0
	 * @return void
	 */
	private function includes() {
		global $pagenow, $geodir_options, $geodirectory;

		/**
		 * Class autoloader.
		 */
		include_once( GEODIR_MULTILINGUAL_PLUGIN_DIR . 'includes/class-geodir-multilingual-autoloader.php' );

		require_once( GEODIR_MULTILINGUAL_PLUGIN_DIR . 'includes/functions.php' );

		// Load WPML if installed and active
		if ( defined( 'ICL_SITEPRESS_VERSION' ) && ! ICL_PLUGIN_INACTIVE && class_exists( 'SitePress' ) && function_exists( 'icl_object_id' ) ) {
			GeoDir_Multilingual_WPML::init();
			GeoDir_Multilingual_WPML_Config::init();
		}
		GeoDir_Multilingual_AJAX::init();

		if ( $this->is_request( 'admin' ) || $this->is_request( 'test' ) || $this->is_request( 'cli' ) ) {
			new GeoDir_Multilingual_Admin();

			require_once( GEODIR_MULTILINGUAL_PLUGIN_DIR . 'includes/admin/admin-functions.php' );
			require_once( GEODIR_MULTILINGUAL_PLUGIN_DIR . 'upgrade.php' );
		}
	}

	/**
	 * Hook into actions and filters.
	 * @since  1.0.0
	 */
	private function init_hooks() {
		register_activation_hook( GEODIR_MULTILINGUAL_PLUGIN_FILE, array( $this, 'activate' ) );
		register_deactivation_hook( GEODIR_MULTILINGUAL_PLUGIN_FILE, array( $this, 'deactivate' ) );

		add_action( 'init', array( $this, 'init' ), 0 );

		if ( $this->is_request( 'frontend' ) ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'add_styles' ), 10 );
			add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts' ), 10 );
		}
	}

	/**
	 * Plugin Initialises.
	 */
	public function init() {
		// Before init action.
		do_action( 'geodir_multilingual_before_init' );

		// Init action.
		do_action( 'geodir_multilingual_init' );
	}

	/**
	 * Define constant if not already set.
	 *
	 * @param  string $name
	 * @param  string|bool $value
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Request type.
	 *
	 * @param  string $type admin, frontend, ajax, cron, test or CLI.
	 * @return bool
	 */
	private function is_request( $type ) {
		switch ( $type ) {
			case 'admin' :
				return is_admin();
				break;
			case 'ajax' :
				return wp_doing_ajax();
				break;
			case 'cli' :
				return ( defined( 'WP_CLI' ) && WP_CLI );
				break;
			case 'cron' :
				return wp_doing_cron();
				break;
			case 'frontend' :
				return ( ! is_admin() || wp_doing_ajax() ) && ! wp_doing_cron();
				break;
			case 'test' :
				return defined( 'GD_TESTING_MODE' );
				break;
		}

		return null;
	}

	/**
	 * Get the plugin url.
	 *
	 * @return string
	 */
	public function plugin_url() {
		return GEODIR_MULTILINGUAL_PLUGIN_URL;
	}

	/**
	 * Get the plugin path.
	 *
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit( GEODIR_MULTILINGUAL_PLUGIN_DIR );
	}

	/**
	 * Get Ajax URL.
	 *
	 * @return string
	 */
	public function ajax_url() {
		return admin_url( 'admin-ajax.php', 'relative' );
	}

	/**
	 * Enqueue styles.
	 */
	public function add_styles() {
		return; // No style to include.

		if ( ! geodir_design_style() ) {
			// Register styles
			wp_register_style( 'geodir-multilingual', GEODIR_MULTILINGUAL_PLUGIN_URL . '/assets/css/style.css', array(), GEODIR_MULTILINGUAL_VERSION );

			if ( geodir_is_page( 'detail' ) ) {
				wp_enqueue_style( 'geodir-multilingual' );
			}
		}
	}

	/**
	 * Enqueue scripts.
	 */
	public function add_scripts() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		// Register scripts
		wp_register_script( 'geodir-multilingual', GEODIR_MULTILINGUAL_PLUGIN_URL . '/assets/js/script' . $suffix . '.js', array( 'jquery', 'geodir' ), GEODIR_MULTILINGUAL_VERSION );

		if ( geodir_is_page( 'detail' ) ) {
			wp_enqueue_script( 'geodir-multilingual' );
			wp_localize_script( 'geodir-multilingual', 'geodir_multilingual_params', geodir_multilingual_params() );
		}
	}

	/**
	 * Short Description.
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function activate( $network_wide = false ) {
		global $wpdb;

		if ( is_multisite() && $network_wide ) {
			foreach ( $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs LIMIT 100" ) as $blog_id ) {
				switch_to_blog( $blog_id );

				$updated = $this->install();

				do_action( 'geodir_multilingual_network_activate', $blog_id, $updated );

				restore_current_blog();
			}
		} else {
			$updated = $this->install();

			do_action( 'geodir_multilingual_activate', $updated );
		}

		// Bail if activating from network, or bulk
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
			return;
		}
	}

	/**
	 * Short Description.
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function deactivate() {
		do_action( 'geodir_multilingual_deactivate' );
	}

	public function install() {
		global $geodir_options;

		$current_version = get_option( 'geodir_multilingual_version' );

		if ( $current_version ) {
			update_option( 'geodir_multilingual_version_upgraded_from', $current_version );
		}

		if ( ! empty( $geodir_options ) && is_array( $geodir_options ) ) {
			set_transient( '_geodir_multilingual_installed', $geodir_options, 30 );

			do_action( 'geodir_multilingual_install' );
		}

		update_option( 'geodir_multilingual_version', GEODIR_MULTILINGUAL_VERSION );
	}
}
