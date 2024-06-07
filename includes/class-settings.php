<?php
/**
 * Settings Class
 *
 * This class handles the settings related functionalities for the Akila Portfolio plugin,
 * including adding settings page, rendering settings page content, and handling form submissions.
 *
 * @since 1.0.0
 */
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

		$email_notifications    = get_option( 'email_notifications', 1 );
		$notification_frequency = get_option( 'notification_frequency', 'daily' );
		//Searching (notification_frequency) in the database will show that daily, monthly, weekly are set.
		?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Email Settings', 'portfolio' ); ?></h1>
		<p><?php esc_html_e( 'Please Select Email notification send notification enable Or disable', 'portfolio' ); ?></p>	
		<form method="post" action="">
			<?php wp_nonce_field( 'settings_action', 'settings_nonce' ); ?>
			<table class="form-table">
				<tr>
					<th scope="row"><?php esc_html_e( 'Email Notifications', 'portfolio' ); ?></th>
					<td>
						<label>
							<input type="checkbox" name="email_notifications" <?php checked( $email_notifications, 1 ); ?> />
							<?php esc_html_e( 'Enable email notifications', 'portfolio' ); ?>
						</label>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Notification Frequency', 'portfolio' ); ?></th>
					<td>
						<select name="notification_frequency">
							<option value="daily" <?php selected( $notification_frequency, 'daily' ); ?>><?php esc_html_e( 'Daily', 'portfolio' ); ?></option>
							<option value="weekly" <?php selected( $notification_frequency, 'weekly' ); ?>><?php esc_html_e( 'Weekly', 'portfolio' ); ?></option>
							<option value="monthly" <?php selected( $notification_frequency, 'monthly' ); ?>><?php esc_html_e( 'Monthly', 'portfolio' ); ?></option>
						</select>
					</td>
				</tr>
			</table>

			<input type="hidden" name="submit" value="1" />
			<?php submit_button( esc_html__( 'Save Settings', 'portfolio' ), 'primary', 'submit', false ); ?>
		</form>
	</div>
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
			esc_html__( 'Email Settings', 'portfolio' ),   // Page title
			esc_html__( 'Email Settings', 'portfolio' ),   // Menu title
			'manage_options',  // Capability
			'settings',        // Menu slug
			array( $this, 'settings_page' ),   // Callback function
			'dashicons-admin-generic',         // Icon
			30      // Position
		);
	}
}

	new Settings();