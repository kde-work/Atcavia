<?php
/**
 * Installation related functions and actions.
 *
 * @author   Mammen
 * @category Admin
 * @package  Mammen/Classes
 * @version  0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * MM_Install Class.
 */
class MM_Install {

	/** @var object MM_Component class */
	private static $mm_component;

	/**
	 * Hook in tabs.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'init_components' ), 5 );
		add_action( 'init', array( __CLASS__, 'start_parsing_components' ), 7 );
//		add_action( 'init', array( __CLASS__, 'init_background_updater' ), 5 );
//		add_action( 'admin_init', array( __CLASS__, 'install_actions' ) );
//		add_action( 'in_plugin_update_message-woocommerce/woocommerce.php', array( __CLASS__, 'in_plugin_update_message' ) );
//		add_filter( 'plugin_action_links_' . WC_PLUGIN_BASENAME, array( __CLASS__, 'plugin_action_links' ) );
//		add_filter( 'plugin_action_links_' . WC_PLUGIN_BASENAME, array( __CLASS__, 'plugin_action_links' ) );
//		add_filter( 'plugin_action_links_' . WC_PLUGIN_BASENAME, array( __CLASS__, 'plugin_action_links' ) );
//		add_filter( 'plugin_row_meta', array( __CLASS__, 'plugin_row_meta' ), 10, 2 );
//		add_filter( 'wpmu_drop_tables', array( __CLASS__, 'wpmu_drop_tables' ) );
//		add_filter( 'cron_schedules', array( __CLASS__, 'cron_schedules' ) );
	}

	/**
	 * initial components.
	 */
	public static function init_components() {
		if ( current_user_can( 'administrator' ) ) {
			$show_in_menu = true;
		} else {
			$show_in_menu = false;
		}
		register_post_type( 'component',
			array(
				'labels' => array(
					'name' => __( 'Components' ),
					'singular_name' => __( 'Component' )
				),
				'public' => true,
				'show_in_menu' => $show_in_menu,
				'has_archive' => true,
				'exclude_from_search' => false,
				'show_in_nav_menus' => false,
				'rewrite' => array( 'slug' => 'component' ),
				'supports'  => array( 'title', 'editor', 'revisions', 'custom-fields', 'author', 'thumbnail' ),
			)
		);
	}

	/**
	 * Parsing components from files.
	 */
	public static function start_parsing_components() {
		self::$mm_component = new MM_Component_Builder();

		self::$mm_component->init();
	}
}