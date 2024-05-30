<?php

namespace CustomkmMenu\Includes;

class Widget {

	public function __construct() {
		add_action( 'widgets_init', array( $this, 'customkm_widget' ) );
		add_action( 'widgets_init', array( $this, 'customkm_widgets_init' ) );
	}
	public function customkm_widget() {
		register_widget( 'Kmd_Widget' );
	}
	public function customkm_widgets_init() {
		// Register the custom widget area
		register_sidebar(
			array(
				'name'          => __( 'Custom Widget Area', 'twentytwentyone' ),
				'id'            => 'custom-widget-area',
				'description'   => __( 'Add widgets here to appear in the custom widget area.', 'twentytwentyone' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);

		// Display recent posts in the custom widget area
		if ( is_active_sidebar( 'custom-widget-area' ) ) {

			// Query recent posts
			$recent_posts = wp_get_recent_posts(
				array(
					'post_type'   => 'portfolio',
					'numberposts' => 5, // Number of posts to display
					'post_status' => 'publish',
				)
			);
			// Output post titles
			$recent_post_html = '<ul>';
			foreach ( $recent_posts as $post ) {
				// Replace placeholders with actual post data
				$recent_post_html  = str_replace( '{permalink}', esc_url( get_permalink( $post['ID'] ) ), $recent_post_html );
				$recent_post_html  = str_replace( '{title}', esc_html( $post['post_title'] ), $recent_post_html );
				$recent_post_html .= '</ul>';
				// Append HTML for each recent post to the main HTML variable
				return $recent_post_html;
			}
		}
	}
}
