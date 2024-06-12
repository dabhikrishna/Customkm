<?php

namespace CustomkmMenu\Includes;

class Portfolio_Email_Notification {

	public function __construct() {
		register_activation_hook( __FILE__, array( $this, 'activate_cron_job' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate_cron_job' ) );

		add_action( 'portfolio_email_notification_cron', array( $this, 'send_email_notification' ) );

		// Reschedule the cron job with the current frequency
		$notification_frequency = get_option( 'notification_frequency', 'daily' );
		$this->reschedule_cron_job( $notification_frequency );
	}

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
				$subject = "New Portfolio Post: $post_title";
				$message = "Hello,\n\nA new portfolio post titled '$post_title' has been added.\n\nRegards,\nYour Website";
				$headers = 'From: yourname@example.com'; // Change this to your email

				$debug[ $index++ ] = wp_mail( $email, $subject, $message, $headers );

			}
		}
		// Reset post data
		wp_reset_postdata();
	}

	public function activate_cron_job() {
		$notification_frequency = get_option( 'notification_frequency', 'daily' );
		$this->reschedule_cron_job( $notification_frequency );
	}

	public function deactivate_cron_job() {
		// Unschedule cron job on plugin deactivation
		wp_clear_scheduled_hook( 'portfolio_email_notification_cron' );
	}

	public function reschedule_cron_job( $frequency ) {
		wp_clear_scheduled_hook( 'portfolio_email_notification_cron' ); // Clear existing cron job
		if ( 'daily' === $frequency ) {
			$interval = 'daily';
		} elseif ( 'weekly' === $frequency ) {
			$interval = 'weekly';
		} elseif ( 'monthly' === $frequency ) {
			$interval = 'monthly';
		} else {
			error_log( 'Invalid frequency provided: ' . $frequency );
			return; // Exit the function if the frequency is invalid
		}
		if ( $interval ) {
			wp_schedule_event( time(), $interval, 'portfolio_email_notification_cron' ); // Schedule new cron job
			//error_log( 'Cron job scheduled successfully with frequency: ' . $frequency );
		}
	}
}

// Instantiate the class
new Portfolio_Email_Notification();
