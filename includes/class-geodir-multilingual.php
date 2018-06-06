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
        global $wp_version;
        
        $locale = $wp_version >= 4.7 ? get_user_locale() : get_locale();
        
        /**
         * Filter the plugin locale.
         *
         * @since   1.0.0
         * @package GeoDir_Multilingual
         */
        $locale = apply_filters( 'plugin_locale', $locale, 'geodir-multilingual' );

        load_textdomain( 'geodir-multilingual', WP_LANG_DIR . '/' . 'geodir-multilingual' . '/' . 'geodir-multilingual' . '-' . $locale . '.mo' );
        load_plugin_textdomain( 'geodir-multilingual', FALSE, basename( dirname( GEODIR_MULTILINGUAL_PLUGIN_FILE ) ) . '/languages/' );
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

		GeoDir_Multilingual_WPML::init();
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
        add_action( 'init', array( $this, 'init' ), 0 );
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
}
