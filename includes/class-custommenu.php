<?php

namespace CustomkmMenu\Includes;

if ( ! defined( 'CUSTOMKM_MENU_PLUGIN_DIR' ) ) {
	define( 'CUSTOMKM_MENU_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

/**
 * Class CustomMenu
 * Handles custom menu functionality and settings.
 */
class CustomMenu {
	/**
	* Constructor.
	*/
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'customkm_menu_page' ) );
		add_action( 'init', array( $this, 'customkm_data_save_table' ) );
		add_shortcode( 'fetch_data', array( $this, 'customkm_fetch_data_shortcode' ) );
		add_action( 'admin_menu', array( $this, 'customkm_my_custom_submenu_page' ) );
		add_action( 'admin_init', array( $this, 'customkm_my_custom_settings_init' ) );
	}

	/**
	* Adds a submenu page to the custom AJAX plugin settings.
	*/
	public function customkm_menu_page() {
		add_submenu_page(
			'customkm-ajax-plugin-settings',
			'Customkm Menu',              // Page title
			esc_html__( 'Customkm Menu', 'customkm-menu' ),              // Menu title
			'manage_options',           // Capability
			'customkm-page-slug',         // Menu slug
			array( $this, 'page_content' ),      // Callback function
			25,                          // Position
			'dashicons-admin-generic' // Icon
		);
	}

	/**
	* Custom page content for submenu.
	*/
	public function page_content() {

		include_once CUSTOMKM_MENU_PLUGIN_DIR . 'templates/customkm-page.php';
	}

	/**
	* Saves data using Option API.
	*/
	public function customkm_data_save_table() {
		if ( isset( $_POST['plugin_options_nonce'] ) && wp_verify_nonce( $_POST['plugin_options_nonce'], 'update_plugin_options' ) ) {
			$data_to_store = $_POST['name'];
			$key           = 'name';
			update_option( $key, $data_to_store );
		}
	}

	/**
	* Adds shortcode to fetch data.
	*/
	public function customkm_fetch_data_shortcode() {
		$key        = 'name';                  // Specify the key used to save the data
		$saved_data = get_option( $key ); // Retrieve the saved data
		return $saved_data;             // Return the data
	}

	/**
	* Adds a submenu page using Settings API.
	*/
	public function customkm_my_custom_submenu_page() {
		add_submenu_page(
			'options-general.php', // Parent menu slug
			'My Submenu Page', // Page title
			'My Submenu', // Menu title
			'manage_options', // Capability required to access
			'customkm-my-custom-submenu', // Menu slug
			array( $this, 'customkm_submenu_callback' ), // Callback function to display content
			28
		);
	}
	/**
	* Callback function to display submenu page content.
	*/
	public function customkm_submenu_callback() {
		include_once CUSTOMKM_MENU_PLUGIN_DIR . 'templates/custom-submenu.php';
	}

	/**
	* Registers settings and fields.
	*/
	public function customkm_my_custom_settings_init() {
		register_setting(
			'my-custom-settings-group', // Option group
			'my_option_name', // Option name
			array( $this, 'customkm_my_sanitize_callback' ) // Sanitization callback function
		);

		add_settings_section(
			'my-settings-section', // Section ID
			'My Settings Section', // Section title
			array( $this, 'customkm_settings_section_callback' ), // Callback function to display section description (optional)
			'my-custom-settings-group' // Parent page slug
		);

		add_settings_field(
			'my-setting-field', // Field ID
			'My Setting Field', // Field title
			array( $this, 'customkm_setting_field_callback' ), // Callback function to display field input
			'my-custom-settings-group', // Parent page slug
			'my-settings-section' // Section ID
		);
	}

	/**
	 * Callback function to display section description (optional).
	 */
	public function customkm_settings_section_callback() {
		echo '<p>This is a description of my settings section.</p>';
	}

	/**
	 * Callback function to display field input.
	 */
	public function customkm_setting_field_callback() {
		$option_value = get_option( 'my_option_name' );
		include_once CUSTOMKM_MENU_PLUGIN_DIR . 'templates/setting.php';
		?>
		
		<?php
	}

	/**
	 * Sanitization callback function.
	 */
	public function customkm_my_sanitize_callback( $input ) {
		return sanitize_text_field( $input );
	}
}
