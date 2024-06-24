<?php

namespace CustomkmMenu\Includes;

/**
 * Portfolio Email Notification Class
 *
 * This class handles the scheduling and sending of email notifications for new portfolio posts.
 * It registers activation and deactivation hooks, sets up cron jobs based on notification frequency,
 * and sends email notifications to specified recipients when new portfolio posts are added.
 *
 * @package CustomkmMenu
 * @subpackage Includes
 * @since 1.0.0
 */
class Portfolio_Email_Notification {

	/**
	 * Constructor.
	 * Initializes activation and deactivation hooks, sets up cron job for email notifications,
	 * and schedules the cron job based on the notification frequency.
	 */
	public function __construct() {
		add_action( 'portfolio_email_notification_cron', array( $this, 'send_email_notification' ) );
	}

	/**
	 * Sends email notification for new portfolio posts.
	 */
	public function send_email_notification() {
		// Fetch portfolio posts with associated emails
		$args = array(
			'post_type'      => 'portfolio',
			'posts_per_page' => -1,
			'meta_query'     => array(
				array(
					'key'     => 'email',
					'compare' => 'EXISTS', // Check if email meta key exists
				),
			),
		);

		$portfolio_posts = new \WP_Query( $args );

		// Loop through portfolio posts
		if ( $portfolio_posts->have_posts() ) {
			$index = 1;

			while ( $portfolio_posts->have_posts() ) {
				$portfolio_posts->the_post();
				$post_title = get_the_title();
				$email      = get_post_meta( get_the_ID(), 'email', true );

				// Send email notification
				$subject = __( 'New Portfolio Post: ', 'customkm-menu' ) . $post_title;
				$message = __( "Hello,\n\nA new portfolio post titled '", 'customkm-menu' ) . $post_title . __( "' has been added.\n\nRegards,\nYour Website", 'customkm-menu' );
				$headers = 'From: yourname@example.com'; // Change this to your email

				$debug[ $index++ ] = wp_mail( $email, $subject, $message, $headers );

			}
		}
		// Reset post data
		wp_reset_postdata();
	}
}

// Instantiate the class
new Portfolio_Email_Notification();
