<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Mammen' ) ) :

	/**
	 * Main Mammen Page Builder.
	 *
	 * @class MM_Mammen
	 * @version	0.0.1
	 */
	final class MM_Mammen {

		/**
		 * MM_Mammen version.
		 *
		 * @var string
		 */
		public $version = '0.0.1';

		/**
		 * The single instance of the class.
		 *
		 * @var MM_Mammen
		 */
		protected static $_instance = null;

		/**
		 * Main WooCommerce Instance.
		 *
		 * Ensures only one instance of Mammen is loaded or can be loaded.
		 *
		 * @static
		 * @see MM()
		 * @return MM_Mammen - Main instance.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * MM_Mammen Constructor.
		 */
		public function __construct() {
			$this->define_constants();
			$this->includes();
			$this->init_hooks();

			do_action( 'mammen_loaded' );
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
		 * Define Mammen Constants.
		 */
		private function define_constants() {
			$this->define( 'MM_PLUGIN_DIR', str_replace( '\\', '/', dirname( __FILE__ ) ) );
			$this->define( 'MM_COMPONENT_DIR', MM_PLUGIN_DIR . '/components' );
			$this->define( 'MM_ASSETS_DIR', MM_PLUGIN_DIR . '/assets' );
			$this->define( 'MM_ASSETS_REL_DIR', get_option( 'siteurl' ) . str_replace( str_replace( '\\', '/', ABSPATH ), '/', MM_ASSETS_DIR ) );
			$this->define( 'MM_VERSION', $this->version );
			$this->define( 'MM_TEMPLATE_COMPONENT_DIR', get_stylesheet_directory() . '/template-parts/components' );
		}

		/**
		 * Hook into actions and filters.
		 */
		private function init_hooks() {
			add_action( 'init', array( 'MM_Install', 'init' ), 0 );
			add_action( 'init', array( 'MM_Content', 'init' ), 10 );
			add_shortcode( 'mammen', array( 'MM_Shortcodes', 'Mammen' ) );
		}


		/**
		 * Include required core files used in admin and on the frontend.
		 */
		public function includes() {
			include_once( 'includes/MM_Install.php' );
			include_once( 'includes/MM_Component.php' );
			include_once( 'includes/MM_Component_Builder.php' );
			include_once( 'includes/MM_Content.php' );
			include_once( 'includes/MM_Component_Page.php' );
			include_once( 'includes/MM_Shortcodes.php' );
			include_once( 'includes/Mammen.php' );
		}
	}

	/**
	 * Main instance of Mammen.
	 *
	 * Returns the main instance of Mammen to prevent the need to use globals.
	 *
	 * @return MM_Mammen
	 */
	function MM() {
		return MM_Mammen::instance();
	}

// Global for backwards compatibility.
	$GLOBALS['mammen'] = MM();

endif;
//die;