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



// Register cron event on plugin activation
/*register_activation_hook( __FILE__, 'portfolio_email_notifications_activation' );

function portfolio_email_notifications_activation() {
	if ( ! wp_next_scheduled( 'send_portfolio_email_notifications' ) ) {
		wp_schedule_single_event( time() + 5, 'send_portfolio_email_notifications' ); // Event scheduled to run after 5 seconds
	}
}

// Hook into cron event to send email notifications
add_action( 'send_portfolio_email_notifications', 'send_portfolio_email_notifications_function' );

function send_portfolio_email_notifications_function() {
	// Get all portfolio posts
	// Get all portfolio posts
	$portfolio_posts = get_posts(
		array(
			'post_type'      => 'portfolio',
			'posts_per_page' => -1,
		)
	);

	// Check if there are any portfolio posts
	if ( $portfolio_posts ) {
		// Loop through each portfolio post
		foreach ( $portfolio_posts as $post ) {
			// Get email records associated with the post (assuming they are stored in post meta)
			$email = get_post_meta( $post->ID, 'email', true );

			// Check if there are any email records
			if ( $email ) {
				// If $email is not an array, make it an array
				if ( ! is_array( $email ) ) {
					$email = array( $email );
				}
				// Send email notification to each email record
				foreach ( $email as $recipient_email ) {
					$subject = 'New Portfolio Update';
					$message = 'Hello, a new update has been posted on our portfolio. Check it out!';
					wp_mail( $recipient_email, $subject, $message );
				}
			}
		}
	}
}

// Register shortcode
add_shortcode( 'trigger_portfolio_email_notifications', 'trigger_portfolio_email_notifications_shortcode' );

function trigger_portfolio_email_notifications_shortcode( $atts ) {
	// Trigger the cron event immediately
	send_portfolio_email_notifications_function();
	return 'Email notifications for portfolio posts have been triggered.';
}
*/
// Register the cron event to run every 5 seconds
/*function schedule_portfolio_email_notifications() {
	if ( ! wp_next_scheduled( 'send_portfolio_email_notifications_event' ) ) {
		error_log( 'scheduled' );
		wp_schedule_event( time(), 'every_five_seconds', 'send_portfolio_email_notifications_event' );
	}
}
add_action( 'init', 'schedule_portfolio_email_notifications' );
// Hook the function to the scheduled event
add_action( 'send_portfolio_email_notifications_event', 'send_portfolio_email_notifications' );

// Define function to send email notifications and register it as a shortcode
function send_portfolio_notifications_shortcode() {
	// Define a function to send email notifications to all email records of portfolio posts
	function send_portfolio_email_notifications() {
		// Query portfolio posts and retrieve email records
		$portfolio_posts = new WP_Query(
			array(
				'post_type'      => 'portfolio', // Change 'portfolio' to your actual post type
				'posts_per_page' => -1,
			// Add any other query parameters as needed
			)
		);
		//var_dump( $portfolio_posts );

		if ( $portfolio_posts->have_posts() ) {
			while ( $portfolio_posts->have_posts() ) {
				$portfolio_posts->the_post();
				$emails = get_post_meta( get_the_ID(), 'email', true ); // Change 'email_records_meta_key' to your actual meta key
				//var_dump( $emails );

				// Ensure $emails is always an array
				if ( ! is_array( $emails ) ) {
					$emails = array( $emails );
				}

				// Loop through email records and send email
				foreach ( $emails as $email ) {
					// Send email to $email
					$data = wp_mail( $email, 'Notification Subject', 'Notification Message' );
				}
				var_dump( wp_mail( $email, 'Notification Subject', 'Notification Message' ) );
			}
			wp_reset_postdata();
		}
	}

	// Trigger the function to send email notifications immediately
	send_portfolio_email_notifications();

	// Return success message
	return 'Email notifications sent successfully.';
}
// Register shortcode
add_shortcode( 'send_portfolio_notifications', 'send_portfolio_notifications_shortcode' );*/
// Hook into the PHP mail function to log the time when an email is sent
