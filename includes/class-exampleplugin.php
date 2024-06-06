<?php


namespace CustomkmMenu\Includes;

if ( ! defined( 'CUSTOMKM_MENU_PLUGIN_DIR' ) ) {
	define( 'CUSTOMKM_MENU_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

/**
 * Class ExamplePlugin
 * @package CustomkmMenu\Includes
 */
class ExamplePlugin {
	/**
	 * ExamplePlugin constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'customkm_example_plugin_menu' ) );
	}
	/**
	 * Adds a plugin page to the admin menu.
	 */
	public function customkm_example_plugin_menu() {
		add_submenu_page(
			'customkm-ajax-plugin-settings',
			'Example Plugin Page',    // Page title
			esc_html__( 'Plugin Page', 'customkm-menu' ),        // Menu title
			'manage_options',         // Capability
			'example-plugin',         // Menu slug
			array( $this, 'plugin_page' ),    // Callback function
			27, // Position of the menu in the admin sidebar
			'dashicons-admin-page' // Icon
		);
	}

	/**
	 * Plugin page content
	 */
	public function plugin_page() {
		wp_enqueue_style( 'plugin-custom-styles', plugin_dir_url( __FILE__ ) . 'css/plugin-styles.css', array(), '1.0' );
		include_once CUSTOMKM_MENU_PLUGIN_DIR . 'templates/example-plugin.php';
	}
}
