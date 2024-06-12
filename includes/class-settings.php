<?php

if ( ! defined( 'CUSTOMKM_MENU_PLUGIN_DIR' ) ) {
	define( 'CUSTOMKM_MENU_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}


class Settings {

	/**
	 * Constructor
	 *
	 * Initializes the class and sets up necessary hooks.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
	}

	/**
	 * Renders the settings page content and handles form submission for enabling/disabling email notifications.
	 *
	 * This method is responsible for rendering the settings page content and handling form submission
	 * to enable or disable email notifications for the Akila Portfolio plugin.
	 *
	 * @since 1.0.0
	 */
	public function settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( isset( $_POST['submit'] ) && wp_verify_nonce( $_POST['settings_nonce'], 'settings_action' ) ) {
			$email_notifications = isset( $_POST['email_notifications'] ) ? 1 : 0;
			update_option( 'email_notifications', $email_notifications );

			$notification_frequency = isset( $_POST['notification_frequency'] ) ? sanitize_text_field( $_POST['notification_frequency'] ) : 'daily';
			update_option( 'notification_frequency', $notification_frequency );

			if ( $email_notifications ) {
				if ( ! wp_next_scheduled( 'portfolio_email_notification_cron' ) ) {
					$interval = $this->get_notification_interval( $notification_frequency );
					wp_schedule_event( time(), $interval, 'portfolio_email_notification_cron' );
				}
			} else {
				wp_clear_scheduled_hook( 'portfolio_email_notification_cron' );
			}

			?>
		<div class="updated"><p><?php esc_html_e( 'Settings saved successfully.', 'portfolio' ); ?></p></div>
			<?php
		}

			$email_notifications = get_option( 'email_notifications', 1 );
			$notification_frequency = get_option( 'notification_frequency', 'daily' );

			include_once CUSTOMKM_MENU_PLUGIN_DIR . 'templates/email-notification.php';
		?>
	
		<?php
	}

	/**
	 * Get notification interval based on selected frequency.
	 *
	 * @param string $frequency Notification frequency.
	 * @return string Interval for scheduling cron job.
	 */
	private function get_notification_interval( $frequency ) {
		switch ( $frequency ) {
			case 'weekly':
				return 'weekly';
			case 'monthly':
				return 'monthly';
			default:
				return 'daily';
		}
	}

	/**
	 * Add Settings Page
	 *
	 * Adds the settings page to the WordPress admin menu.
	 *
	 * @since 1.0.0
	 */
	public function add_settings_page() {
		add_menu_page(
			esc_html__( 'Email Settings', 'portfolio' ),
			esc_html__( 'Email Settings', 'portfolio' ),
			'manage_options',
			'settings',
			array( $this, 'settings_page' ),
			'dashicons-admin-generic',
			30
		);
	}
}

	new Settings();