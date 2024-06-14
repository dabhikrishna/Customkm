<?php

namespace CustomkmMenu\Includes;

// If this file is called directly, abort.
if ( ! defined( 'CUSTOMKM_MENU_PLUGIN_DIR' ) ) {
	define( 'CUSTOMKM_MENU_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

/**
 * Class PostRetrievals
 * Handles functionality related to retrieving and displaying posts.
 */
class PostRetrievals {
	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'customkm_enqueue_delete_post_script' ) );
		add_action( 'wp_ajax_delete_post_action', array( $this, 'customkm_delete_post_action_callback' ) );
		add_action( 'rest_api_init', array( $this, 'register_custom_rest_api' ) );
	}

		/**
	 * Retrieve all portfolio posts' data.
	 */
	public function page_contents() {
		$args = array(
			'post_type'      => 'portfolio',
			'posts_per_page' => -1,
		);

		$query = new \WP_Query( $args );

		$posts_data = array();

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$post_id = get_the_ID();
				// Retrieve necessary post data
				$post_data = array(
					'id'           => $post_id,
					'title'        => get_the_title(),
					'content'      => get_the_content(),
					'address'      => get_post_meta( $post_id, 'address', true ),
					'phone'        => get_post_meta( $post_id, 'phone', true ),
					'email'        => get_post_meta( $post_id, 'email', true ),
					'company_name' => get_post_meta( $post_id, 'company_name', true ),
					'mail'         => get_post_meta( $post_id, 'mail', true ),
					// Add more meta fields as needed
				);
				$posts_data[] = $post_data;

			}
			wp_reset_postdata();
		}
		return new \WP_REST_Response(
			array(
				'data' => $posts_data,
			),
			200,
		);
	}

	/**
	* Enqueue the external JavaScript file.
	*/
	public function customkm_enqueue_delete_post_script() {
		// Create a nonce
		$nonce = wp_create_nonce( 'delete_post_nonce' );
		wp_enqueue_script( 'delete-post-js', plugins_url( 'js/delete-post.js', __FILE__ ), array( 'jquery', 'wp-util' ), '1.0', true );
		// Localize the script with the 'ajaxurl' and the nonce
		$rest_url = esc_url_raw( rest_url( 'custom/v1/portfolio' ) );

		wp_localize_script(
			'delete-post-js',
			'rest_object',
			array(
				'rest_url' => rest_url(),

			)
		);
	}

	/**
	 * Registers custom REST API endpoints for deleting posts and retrieving portfolio content.
	 */
	public function register_custom_rest_api() {
		register_rest_route(
			'custom/v1',
			'/delete-post/(?P<id>\d+)',
			array(
				'methods'  => 'GET',
				'callback' => array( $this, 'custom_delete_post_callback' ),
				'permission_callback' => '__return_true',
			)
		);

		register_rest_route(
			'custom/v1', // Namespace for the route
			'/portfolio/', // Route
			array(
				'methods'  => 'GET',
				'callback' => array( $this, 'page_contents' ),
				'permission_callback' => '__return_true',
			)
		);
	}

	/**
	 * Callback function for the `/delete-post/(?P<id>\d+)` REST API endpoint.
	 *
	 * This function handles deleting a post based on the provided ID in the request.
	 *
	 * @param \WP_REST_Request $request The incoming REST API request object.
	 * @return WP_Error|WP_REST_Response  - A WP_Error object on failure or a WP_REST_Response object on success.
	 */
	public function custom_delete_post_callback( \WP_REST_Request $request ) {

		$params = $request->get_params();

		$post_id = $params['id'];

		if ( ! get_post( $post_id ) ) {
			return new WP_Error( 'invalid_post_id', 'Invalid post ID.', array( 'status' => 404 ) );
		}

		// Delete the post
		$deleted = wp_delete_post( $post_id, true );

		if ( $deleted ) {
			return new \WP_REST_Response( array( 'success' => true ), 200 );
		} else {
			return new \WP_Error( 'failed_to_delete_post', 'Failed to delete the post.', array( 'status' => 500 ) );
		}
	}
}
