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
 * Customkm Menu plugin adds custom menus, submenus, fields, shortcode and post types to your WordPress site, enhancing its functionality.
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Plugin name constant.
 */
if ( ! defined( 'PM_PLUGIN_NAME' ) ) {
	define( 'PM_PLUGIN_NAME', 'customkm-menu' );
}

/**
 * Plugin version constant.
 */
if ( ! defined( 'PM_PLUGIN_VERSION' ) ) {
	define( 'PM_PLUGIN_VERSION', '1.0.0' );
}


/**
 * Plugin Folder Path constant.
 */
if ( ! defined( 'PM_PLUGIN_DIR' ) ) {
	define( 'PM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

/**
 * Plugin Folder URL constant.
 */
if ( ! defined( 'PM_PLUGIN_URL' ) ) {
	define( 'PM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}
/**
 * Includes necessary files.
 */
require_once PM_PLUGIN_DIR . 'includes/class-portfolio.php';
require_once PM_PLUGIN_DIR . 'includes/class-ajaxplugin.php';
require_once PM_PLUGIN_DIR . 'includes/class-shortcode.php';
require_once PM_PLUGIN_DIR . 'includes/class-postretrievals.php';
require_once PM_PLUGIN_DIR . 'includes/class-custommenu.php';
require_once PM_PLUGIN_DIR . 'includes/class-recentportfolio.php';
require_once PM_PLUGIN_DIR . 'includes/class-exampleplugin.php';
require_once PM_PLUGIN_DIR . 'includes/class-restapi.php';
require_once PM_PLUGIN_DIR . 'includes/class-kmd-widget.php';
require_once PM_PLUGIN_DIR . 'includes/class-widget.php';
require_once PM_PLUGIN_DIR . 'includes/class-portfolio-email-notification.php'; // Include


use CustomkmMenu\Includes\Portfolio; //Import the Portfolio class from the CustomkmMenu\Includes namespace.
use CustomkmMenu\Includes\AjaxPlugin; //Import the AjaxPlugin class from the CustomkmMenu\Includes namespace.
use CustomkmMenu\Includes\Shortcode; //Import the Shortcode class from the CustomkmMenu\Includes namespace.
use CustomkmMenu\Includes\PostRetrievals; //Import the PostRetrievals class from the CustomkmMenu\Includes namespace.
use CustomkmMenu\Includes\CustomMenu; //Import the CustomMenu class from the CustomkmMenu\Includes namespace.
use CustomkmMenu\Includes\RecentPortfolio; //Import the RecentPortfolio class from the CustomkmMenu\Includes namespace.
use CustomkmMenu\Includes\ExamplePlugin; //Import the ExamplePlugin class from the CustomkmMenu\Includes namespace.
use CustomkmMenu\Includes\RestApi; //Import the RestApi class from the CustomkmMenu\Includes namespace.
use CustomkmMenu\Includes\Widget; //Import the RestApi class from the CustomkmMenu\Includes namespace.
use CustomkmMenu\Includes\Portfolio_Email_Notification;

$portfolio       = new Portfolio(); //Initialize a new instance of the Portfolio class for managing portfolio-related functionalities.
$ajaxplugin      = new AjaxPlugin(); // Initialize a new instance of the AjaxPlugin class for handling Ajax functionality within the plugin.
$shortcode       = new Shortcode(); // Initialize a new instance of the Shortcode class for managing custom shortcodes.
$postretrievals  = new PostRetrievals(); // Initialize a new instance of the PostRetrievals class for retrieving posts.
$custommenu      = new CustomMenu(); //Initialize a new instance of the CustomMenu class for managing custom menus.
$recentportfolio = new RecentPortfolio(); // Initialize a new instance of the RecentPortfolio class for managing recent portfolio items.
$exampleplugin   = new ExamplePlugin(); //Initialize a new instance of the ExamplePlugin class (replace with actual purpose).
$restapi         = new RestApi(); //Initialize a new instance of the RestApi class for handling REST API functionalities.
$widget          = new Widget(); ////Initialize a new instance of the widget class for display recent posts using widget.
$cron            = new Portfolio_Email_Notification();
/**
 *Add a custom button next to Activate button on the plugins page
 */
function customkm_add_custom_plugin_button( $links ) {
	$custom_plugin_page = admin_url( 'admin.php?page=custom-ajax-plugin-settings' );
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
	$wp_rewrite->set_permalink_structure( '' );
	$wp_rewrite->flush_rules(); // To make sure the changes take effect immediately
}
register_deactivation_hook( __FILE__, 'customkm_deactivate_plugin' );


/**
 * Shortcode function to display sent email details
 */
function display_sent_emails() {
	// Query sent emails
	$sent_emails = get_posts(
		array(
			'post_type'      => 'portfolio', // Assuming 'portfolio' is the post type where email details are stored
			'meta_key'       => 'email', // Assuming 'email' is the meta key for storing email addresses
			'posts_per_page' => -1, // Retrieve all sent emails
		)
	);

	// Display sent emails
	$output = '';
	if ( $sent_emails ) {
		$output .= '<ul>';
		foreach ( $sent_emails as $email ) {
			$email_address = get_post_meta( $email->ID, 'email', true );
			$sent_time     = get_post_meta( $email->ID, 'mail', true ); // Assuming 'mail' is the meta key for storing sent time
			$output       .= '<li>Email: ' . $email_address . ' - Sent Time: ' . $sent_time . '</li>';
		}
		$output .= '</ul>';
	} else {
		$output .= 'No emails have been sent yet.';
	}

	return $output;
}

// Register the shortcode
add_shortcode( 'sent_emails', 'display_sent_emails' );
