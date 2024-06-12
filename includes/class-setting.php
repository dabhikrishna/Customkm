<?php

namespace CustomkmMenu\Includes;

if ( ! defined( 'CUSTOMKM_MENU_PLUGIN_DIR' ) ) {
	define( 'CUSTOMKM_MENU_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

/**
 * Class CustomMenu
 * Handles custom menu functionality and settings.
 */
class Setting {

	//Intialize the plugin
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'ajax_plugin_menu' ) );
	}

	public function ajax_plugin_menu() {
		add_menu_page(
			'My Settings',      // Page title
			'Custom Ajax Plugin',      // Menu title
			'manage_options',   // Capability required to access
			'customkm-ajax-plugin-settings',      // Menu slug
			array( $this, 'settings_page_content' ),   //Callback function to display page content
			'dashicons-menu', // Icon
			28
		);
		add_submenu_page(
			'customkm-ajax-plugin-settings',      // Page title
			esc_html__( 'Email Settings', 'portfolio' ),      // Menu title
			esc_html__( 'Email Settings', 'portfolio' ),   // Capability required to access
			'manage_options',
			'settings-new',
			array( $this, 'settings' ),
			30
		);
		add_submenu_page(
			'customkm-ajax-plugin-settings',
			'Example Plugin Page',    // Page title
			esc_html__( 'Plugin Page', 'customkm-menu' ),        // Menu title
			'manage_options',         // Capability
			'example-plugin-submenu',         // Menu slug
			array( $this, 'plugin_pages' ),    // Callback function
			27, // Position of the menu in the admin sidebar
			'dashicons-admin-page' // Icon
		);
		add_submenu_page(
			'customkm-ajax-plugin-settings',
			'Submenu Page Title',       // Page title
			esc_html__( 'Post Retrievals Title', 'customkm-menu' ),       // Menu title
			'manage_options',           // Capability
			'customkm-submenu',    // Submenu slug
			array( $this, 'page_contents_html' )  // Callback function for submenu content
		);
		add_submenu_page(
			'customkm-ajax-plugin-settings',
			'Customkm Menu',              // Page title
			esc_html__( 'Customkm Menu', 'customkm-menu' ),              // Menu title
			'manage_options',           // Capability
			'customkm-page-slug-submenu',         // Menu slug
			array( $this, 'page_content' ),      // Callback function
			25,                          // Position
			'dashicons-admin-generic' // Icon
		);
	}

	/**
	 * Callback function to display the plugin settings page.
	 */
	public function settings_page_content() {
		require_once CUSTOMKM_MENU_PLUGIN_DIR . 'templates/custom-ajax.php';
	}

	/*
	 * Renders the settings page content and handles form submission for enabling/disabling email notifications.
	 *
	 * This method is responsible for rendering the settings page content and handling form submission
	 * to enable or disable email notifications for the Akila Portfolio plugin.
	 *
	 * @since 1.0.0
	 */
	public function settings() {
		if ( isset( $_POST['submit'] ) && wp_verify_nonce( $_POST['settings_nonce'], 'settings_action' ) ) {
			// Save settings
			$email_notifications = isset( $_POST['email_notifications'] ) ? 1 : 0;
			update_option( 'email_notifications', $email_notifications );

			$notification_frequency = isset( $_POST['notification_frequency'] ) ? sanitize_text_field( $_POST['notification_frequency'] ) : 'daily';
			update_option( 'notification_frequency', $notification_frequency );

			// Display success message
			?>
			<div class="updated"><p><?php esc_html_e( 'Settings saved successfully.', 'portfolio' ); ?></p></div>
				<?php
		}

			// Retrieve current settings
			$email_notifications = get_option( 'email_notifications', 1 );
			$notification_frequency = get_option( 'notification_frequency', 'daily' );

			// Include settings page template
			include_once CUSTOMKM_MENU_PLUGIN_DIR . 'templates/email-notification.php';
	}

	/**
	 * Plugin page content
	 */
	public function plugin_pages() {
		wp_enqueue_style( 'plugin-custom-styles', plugin_dir_url( __FILE__ ) . 'css/plugin-styles.css', array(), '1.0' );
		include_once CUSTOMKM_MENU_PLUGIN_DIR . 'templates/example-plugin.php';
	}

	public function page_contents_html() {

		include CUSTOMKM_MENU_PLUGIN_DIR . 'templates/tmpl-portfolio.php';
		?>
		<?php
	}

	/**
	* Custom page content for submenu.
	*/
	public function page_content() {
		include_once CUSTOMKM_MENU_PLUGIN_DIR . 'templates/customkm-page.php';
	}
}
