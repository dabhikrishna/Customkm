<?php

namespace CustomkmMenu\Includes;

/**
 * Class responsible for managing recent portfolio posts functionality.
 *
 * This class handles two main aspects:
 *  Shortcode: Creates a shortcode named `recent_portfolio_posts` that can be used in posts or pages to display recent portfolio entries.
 *  Cron Event: Schedules a cron event to periodically refresh the displayed recent portfolio posts.
 *
 * This ensures that the displayed portfolio posts are always up-to-date.
 */
class RecentPortfolio {
	public function __construct() {
		// Register shortcode for displaying recent portfolio posts
		add_shortcode( 'recent_portfolio_posts', array( $this, 'customkm_display_recent_portfolio_posts_shortcode' ) );

		// Hook into the 'init' action to schedule the cron event on plugin initialization
		add_action( 'init', array( $this, 'customkm_schedule_portfolio_posts_refresh' ) );

		// Define the callback function for the scheduled cron event
		add_action( 'customkm_refresh_portfolio_posts_event', array( $this, 'customkm_refresh_portfolio_posts' ) );
	}

	// Schedule cron event to refresh portfolio posts
	public function customkm_schedule_portfolio_posts_refresh() {
		if ( ! wp_next_scheduled( 'customkm_refresh_portfolio_posts_event' ) ) {
			wp_schedule_event( time(), 'hourly', 'customkm_refresh_portfolio_posts_event' );
		}
	}

	// Callback function to refresh recent portfolio posts
	public function customkm_refresh_portfolio_posts() {
		$args = array(
			'post_type'      => 'portfolio',
			'posts_per_page' => -1, // Retrieve all posts
			'orderby'        => 'date',
			'order'          => 'DESC',
		);

		// Create a new WP_Query object to retrieve portfolio posts based on the arguments
		$recent_portfolio_posts = new \WP_Query( $args );

		// Check if there are any portfolio posts found
		if ( $recent_portfolio_posts->have_posts() ) {
			$output = '<ul>';

			 // Loop through each portfolio post
			while ( $recent_portfolio_posts->have_posts() ) {
				$recent_portfolio_posts->the_post();
				$output .= '<li><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></li>';
			}
			$output .= '</ul>';
			wp_reset_postdata(); // Reset post data query
		} else {
			$output = esc_html__( 'No recent portfolio posts found.', 'customkm-menu' );
		}

		// Create a transient to store the refreshed portfolio post list (HTML)
		$transient_value = $output;
		set_transient( 'customkm_recent_portfolio_posts', $transient_value, 60 * 60 ); // Cache for 1 hour
	}

	/**
	 * Shortcode callback function to display recent portfolio posts.
	 *
	 * @param array $atts Shortcode attributes (if any).
	 *  @return string HTML content to display recent portfolio posts.
	 */

	// Shortcode callback function to display recent portfolio posts
	public function customkm_display_recent_portfolio_posts_shortcode( $atts ) {
		// Check if transient exists
		$transient_value = get_transient( 'customkm_recent_portfolio_posts' );
		if ( false === $transient_value ) {
			// If transient doesn't exist, refresh portfolio posts
			customkm_refresh_portfolio_posts();
			$transient_value = get_transient( 'customkm_recent_portfolio_posts' );
		}

		return $transient_value;
	}
}
