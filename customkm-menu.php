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
/**
 * Includes necessary files.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-portfolio.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-ajaxplugin.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-shortcode.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-postretrievals.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-custommenu.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-recentportfolio.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-exampleplugin.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-restapi.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-kmd-widget.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-widget.php';

// Instantiate the Portfolio class
use CustomkmMenu\Includes\Portfolio;
$portfolio = new Portfolio();

use CustomkmMenu\Includes\AjaxPlugin;
$ajaxplugin = new AjaxPlugin();

use CustomkmMenu\Includes\Shortcode;
$shortcode = new Shortcode();

use CustomkmMenu\Includes\PostRetrievals;
$postretrievals = new PostRetrievals();

use CustomkmMenu\Includes\CustomMenu;
$custommenu = new CustomMenu();

use CustomkmMenu\Includes\RecentPortfolio;
$recentportfolio = new RecentPortfolio();

use CustomkmMenu\Includes\ExamplePlugin;
$exampleplugin = new ExamplePlugin();

use CustomkmMenu\Includes\RestApi;
$restapi = new RestApi();


use CustomkmMenu\Includes\Widget;
$widget = new Widget();

/**
 *Add a custom button next to Activate button on the plugins page
 */
function customkm_add_custom_plugin_button( $links ) {
	$custom_plugin_page = admin_url( 'admin.php?page=custom-ajax-plugin-settings' );

	// Add the custom button link.
	$custom_link = '<a href="' . esc_url( $custom_plugin_page ) . '">Plugin details</a>';
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
