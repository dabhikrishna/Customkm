<?php
/**
 * Plugin Name: Customkm Menu
 * Plugin URI: https://qrolic.com
 * Description:Customkm Menu is the ultimate solution for streamlining website enhancement. This plugin enables you to effortlessly create bespoke menus and submenus, integrate fields, and securely store data leveraging the powerful OPTION API and SETTING API. Moreover, it streamlines the process of establishing a PORTFOLIO post type to elegantly showcase your projects. What's more, Customkm Menu seamlessly incorporates shortcode support, empowering you to seamlessly embed dynamic content throughout your website's pages and posts.
 * Version: 1.0.0
 * Author: krishna
 * Author URI:https://qrolic.com
 * Text Domain: customkm-menu
 * Domain Path: /languages
 *
 * Customkm Menu plugin adds custom menus,shortcode and post types to your WordPress site, enhancing its functionality.
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Plugin name constant.
 */
if ( ! defined( 'CUSTOMKM_MENU_PLUGIN_NAME' ) ) {
	define( 'CUSTOMKM_MENU_PLUGIN_NAME', 'customkm-menu' );
}

/**
 * Plugin version constant.
 */
if ( ! defined( 'CUSTOMKM_MENU_PLUGIN_VERSION' ) ) {
	define( 'CUSTOMKM_MENU_PLUGIN_VERSION', '1.0.0' );
}

/**
 * Plugin Folder Path constant.
 */
if ( ! defined( 'CUSTOMKM_MENU_PLUGIN_DIR' ) ) {
	define( 'CUSTOMKM_MENU_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

/**
 * Plugin Folder URL constant.
 */
if ( ! defined( 'CUSTOMKM_MENU_PLUGIN_URL' ) ) {
	define( 'CUSTOMKM_MENU_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

/**
 * Includes necessary files.
 */
require_once CUSTOMKM_MENU_PLUGIN_DIR . 'includes/class-portfolio.php';
require_once CUSTOMKM_MENU_PLUGIN_DIR . 'includes/class-shortcode.php';
require_once CUSTOMKM_MENU_PLUGIN_DIR . 'includes/class-postretrievals.php';
require_once CUSTOMKM_MENU_PLUGIN_DIR . 'includes/class-recentportfolio.php';
require_once CUSTOMKM_MENU_PLUGIN_DIR . 'includes/class-portfolio-email-notification.php'; // Include
require_once CUSTOMKM_MENU_PLUGIN_DIR . 'includes/class-setting.php';
require_once CUSTOMKM_MENU_PLUGIN_DIR . 'includes/class-email-details.php';


//Import the Portfolio class from the CustomkmMenu\Includes namespace.
use CustomkmMenu\Includes\Portfolio;
//Import the Shortcode class from the CustomkmMenu\Includes namespace.
use CustomkmMenu\Includes\Shortcode;
//Import the PostRetrievals class from the CustomkmMenu\Includes namespace.
use CustomkmMenu\Includes\PostRetrievals;
//Import the RecentPortfolio class from the CustomkmMenu\Includes namespace.
use CustomkmMenu\Includes\RecentPortfolio;
//Import the Portfolio_Email_Notification class from the CustomkmMenu\Includes namespace.
use CustomkmMenu\Includes\Portfolio_Email_Notification;
//Import the Setting class from the CustomkmMenu\Includes namespace.
use CustomkmMenu\Includes\Setting;
//Import the Email_Details class from the CustomkmMenu\Includes namespace.
use CustomkmMenu\Includes\Email_Details;


//Initialize a new instance of the Portfolio class for managing portfolio-related functionalities.
$portfolio       = new Portfolio();
// Initialize a new instance of the Shortcode class for managing custom shortcodes.
$shortcode       = new Shortcode();
// Initialize a new instance of the PostRetrievals class for retrieving posts.
$postretrievals  = new PostRetrievals();
// Initialize a new instance of the RecentPortfolio class for managing recent portfolio items.
$recentportfolio = new RecentPortfolio();
//Initialize a new instance of the portfolio_email_notification for email.
$cron            = new Portfolio_Email_Notification();
//Initialize a new instance of the setting class for display menus.
$settings          = new Setting();
//Initialize a new instance of the email_details class for display menus.
$settings          = new Email_Details();


/**
 *Add a custom button next to Activate button on the plugins page
 */
function customkm_add_custom_plugin_button( $links ) {
	$custom_plugin_page = admin_url( 'admin.php?page=customkm-ajax-plugin-settings' );
	$custom_link_text   = esc_html__( 'Plugin details', 'customkm-menu' );

	$custom_link = '<a href="' . esc_url( $custom_plugin_page ) . '">' . esc_html( $custom_link_text ) . '</a>';
	array_unshift( $links, $custom_link );

	return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'customkm_add_custom_plugin_button' );

/**
 * Loads text domain for localization.
 */
function load_customkm_menu_textdomain() {
	load_plugin_textdomain( 'customkm-menu', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'load_customkm_menu_textdomain' );

// Activation hook
function customkm_activate_plugin() {
	// Change permalink structure to Post name
	global $wp_rewrite;
	$wp_rewrite->set_permalink_structure( '/%postname%/' );
	$wp_rewrite->flush_rules(); // To make sure the changes take effect immediately
}
register_activation_hook( __FILE__, 'customkm_activate_plugin' );

function customkm_deactivate_plugin() {
	// Change permalink structure to Plain
	global $wp_rewrite;
	$wp_rewrite->flush_rules(); // To make sure the changes take effect immediately
}
register_deactivation_hook( __FILE__, 'customkm_deactivate_plugin' );
