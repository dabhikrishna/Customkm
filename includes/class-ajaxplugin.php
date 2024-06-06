<?php

namespace CustomkmMenu\Includes;

if ( ! defined( 'CUSTOMKM_MENU_PLUGIN_DIR' ) ) {
	define( 'CUSTOMKM_MENU_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

/**
 * Class AjaxPlugin
 * Handles AJAX functionality for the custom plugin.
 */
class AjaxPlugin {
	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'ajax_plugin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'customkm_ajax_plugin_enqueue_scripts' ) );
		add_action( 'wp_ajax_custom_ajax_plugin_update_store_name', array( $this, 'customkm_ajax_plugin_ajax_handler' ) );
	}

	/**
	 * Adds the plugin menu page to the WordPress admin dashboard.
	 */
	public function ajax_plugin_menu() {
		add_menu_page(
			'Custom AJAX Plugin Settings',    // Page title
			esc_html__( 'Custom AJAX Plugin', 'customkm-menu' ),         // Menu title
			'manage_options',         // Capability
			'custom-ajax-plugin-settings',         // Menu slug
			array( $this, 'settings_page' ),    // Callback function
			'dashicons-menu', // Icon
			28 // Position of the menu in the admin sidebar
		);
	}

	/**
	 * Callback function to display the plugin settings page.
	 */
	public function settings_page() {
		require_once CUSTOMKM_MENU_PLUGIN_DIR . 'templates/custom-ajax.php';
		//include_once plugin_dir_path( __FILE__ ) . 'templates/custom-ajax.php';
	}

	/**
	* Handles AJAX request to update store name.
	*/
	public function customkm_ajax_plugin_ajax_handler() {
		if ( isset( $_POST['store_name'] ) ) {
			// Verify nonce
			if ( ! wp_verify_nonce( $_POST['nonce'], 'custom_ajax_plugin_ajax_nonce' ) ) {
				echo 'ok';
			}
			// Sanitize and save store name
			$store_name = sanitize_text_field( $_POST['store_name'] );
			update_option( 'store_name', $store_name );
			echo 'Store name updated successfully!';
		}
		wp_die();
	}

	/**
	* Enqueues JavaScript for AJAX.
	*/
	public function customkm_ajax_plugin_enqueue_scripts( $hook ) {
		if ( 'toplevel_page_custom-ajax-plugin-settings' !== $hook ) {
			return;
		}
		wp_enqueue_script( 'custom-ajax-plugin-script', plugins_url( '/js/custom-ajax-plugin-script.js', __FILE__ ), array( 'jquery' ), '1.0', true );
		wp_localize_script(
			'custom-ajax-plugin-script',
			'custom_ajax_plugin_ajax_object',
			array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
		);
	}
}
