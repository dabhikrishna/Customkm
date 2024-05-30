<?php

namespace CustomkmMenu\Includes;

class RestApi {
	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'prefix_register_example_routes' ) );
	}

	/**
	 * Registers routes for the example endpoint.
	 */
	public function prefix_register_example_routes() {
		// register_rest_route() handles more arguments but we are going to stick to the basics for now.
		register_rest_route(
			'hello-world/v1',
			'/phrase',
			array(
				// By using this constant we ensure that when the WP_REST_Server changes our readable endpoints will work as intended.
				'methods'             => \WP_REST_Server::READABLE,
				// Here we register our callback. The callback is fired when this endpoint is matched by the WP_REST_Server class.
				'callback' => array( $this, 'prefix_get_endpoint_phrase' ),
				// Add the permission callback to allow public access
				'permission_callback' => '__return_true',
			)
		);
	}

	/**
	 * Callback function to return a simple response.
	 */
	public function prefix_get_endpoint_phrase() {
		// rest_ensure_response() wraps the data we want to return into a WP_REST_Response, and ensures it will be properly returned.
		return rest_ensure_response( 'Hello World' );
	}
}
