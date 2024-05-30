<?php

namespace CustomkmMenu\Includes;

class RecentPortfolio {
	public function __construct() {
		// Add shortcode and cron event initialization
		add_shortcode( 'recent_portfolio_posts', array( $this, 'customkm_display_recent_portfolio_posts_shortcode' ) );
		add_action( 'init', array( $this, 'customkm_schedule_portfolio_posts_refresh' ) );

		// Schedule cron event to refresh portfolio posts
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

		$recent_portfolio_posts = new \WP_Query( $args );

		if ( $recent_portfolio_posts->have_posts() ) {
			$output = '<ul>';
			while ( $recent_portfolio_posts->have_posts() ) {
				$recent_portfolio_posts->the_post();
				$output .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
			}
			$output .= '</ul>';
			wp_reset_postdata(); // Reset post data query
		} else {
			$output = 'No recent portfolio posts found.';
		}

		// Update transient with refreshed portfolio posts
		$transient_value = $output;
		set_transient( 'customkm_recent_portfolio_posts', $transient_value, 60 * 60 ); // Cache for 1 hour
	}

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
