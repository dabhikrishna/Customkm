<?php

namespace CustomkmMenu\Includes;

if ( ! defined( 'CUSTOMKM_MENU_PLUGIN_DIR' ) ) {
	define( 'CUSTOMKM_MENU_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

/**
 * Class Setting
 *
 * This class handles the creation and management of custom menus and settings for plugin named "Customkm Menu."
 * @package CustomkmMenu
 * @subpackage Includes
 * @since 1.0.0
 */
class Setting {

	/**
	* Constructor
	* Initializes the functionality of the class by hooking into the `admin_menu` action to create the plugin's menu pages.
	*/
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'ajax_plugin_menu' ) );
	}

	/**
	* Creates the plugin's menu pages
	*/
	public function ajax_plugin_menu() {

		// Create the main plugin page
		add_menu_page(
			'Example Plugin Page',
			esc_html__( 'Plugin Page', 'customkm-menu' ),
			'manage_options',
			'example-plugin-submenu',
			array( $this, 'plugin_pages' ),
			'dashicons-menu', // Icon'
		);

		// Create a submenu page under the main plugin page
		add_submenu_page(
			'example-plugin-submenu',
			'Submenu Page Title',
			esc_html__( 'Post Retrievals Title', 'customkm-menu' ),
			'manage_options',
			'customkm-submenu',
			array( $this, 'page_contents_html' )
		);
	}

	/**
	* Content for the main plugin page
	*/
	public function plugin_pages() {
		wp_enqueue_style( 'plugin-custom-styles', plugin_dir_url( __FILE__ ) . 'css/plugin-styles.css', array(), '1.0' );
		include_once CUSTOMKM_MENU_PLUGIN_DIR . 'templates/example-plugin.php';
	}

	/**
	 * Content for the submenu page
	 */
	public function page_contents_html() {

		include CUSTOMKM_MENU_PLUGIN_DIR . 'templates/tmpl-portfolio.php';
		?>
		<?php
	}
}
