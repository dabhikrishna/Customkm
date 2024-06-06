<?php
namespace CustomkmMenu\Includes;

//var_dump( $portfolio_posts->request );
//error_log( 'Cron job started for portfolio email notification.' );
class Portfolio_Email_Notification {

	public function __construct() {
		register_activation_hook( __FILE__, array( $this, 'activate_cron_job' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate_cron_job' ) );

		add_action( 'portfolio_email_notification_cron', array( $this, 'send_email_notification' ) );
		$this->schedule_cron_job();
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
		// Schedule cron job on plugin activation
		$this->schedule_cron_job();
	}

	public function deactivate_cron_job() {
		// Unschedule cron job on plugin deactivation
		wp_clear_scheduled_hook( 'portfolio_email_notification_cron' );
	}


	private function schedule_cron_job() {
		// Schedule cron job
		if ( ! wp_next_scheduled( 'portfolio_email_notification_cron' ) ) {
			wp_schedule_event( time(), 'daily', 'portfolio_email_notification_cron' );
		}
	}
}

// Instantiate the class
new Portfolio_Email_Notification();
