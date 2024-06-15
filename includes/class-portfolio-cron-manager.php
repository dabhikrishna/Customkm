<?php

namespace CustomkmMenu\Includes;

/**
 * Portfolio Cron Manager Class
 *
 * This class manages cron scheduling for portfolio email notifications.
 *
 * @package CustomkmMenu
 * @subpackage Includes
 * @since 1.0.0
 */
class Portfolio_Cron_Manager {

	/**
	 * Constructor.
	 * Initializes hooks for cron management.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'init_cron_jobs' ) );
		add_filter( 'cron_schedules', array( $this, 'add_custom_cron_schedules' ) ); // Add custom cron schedule
	}

	/**
	 * Initialize cron jobs.
	 */
	public function init_cron_jobs() {
		$notification_frequency = get_option( 'notification_frequency', 'daily' );
		$this->reschedule_cron_job( $notification_frequency );
	}

	/**
	 * Reschedules the cron job based on the specified frequency.
	 *
	 * @param string $frequency The frequency at which the cron job should run ('daily', 'weekly', 'monthly').
	 */
	public function reschedule_cron_job( $frequency ) {
		wp_clear_scheduled_hook( 'portfolio_email_notification_cron' ); // Clear existing cron job

		$interval = $this->get_interval_from_frequency( $frequency );

		if ( $interval ) {
			wp_schedule_event( time(), $interval, 'portfolio_email_notification_cron' ); // Schedule new cron job
		}
	}

	/**
	 * Retrieves the interval for the given frequency.
	 *
	 * @param string $frequency The frequency at which the cron job should run ('daily', 'weekly', 'monthly').
	 * @return string|false The interval for the cron job or false if frequency is invalid.
	 */
	private function get_interval_from_frequency( $frequency ) {
		switch ( $frequency ) {
			case 'hourly':
				return 'hourly';
			case 'daily':
				return 'daily';
			case 'weekly':
				return 'weekly';
			case 'monthly':
				return 'monthly';
			default:
				return false;
		}
	}

	/**
	 * Adds custom cron schedules.
	 *
	 * @param array $schedules Existing cron schedules.
	 * @return array Modified cron schedules.
	 */
	public function add_custom_cron_schedules( $schedules ) {
		$schedules['monthly'] = array(
			'interval' => 30 * DAY_IN_SECONDS, // Approximate monthly interval
			'display'  => __( 'Once a Month', 'customkm-menu' ),
		);
		return $schedules;
	}
}
