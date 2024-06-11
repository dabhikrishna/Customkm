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
		add_action( 'admin_menu', array( $this, 'customkm_submenu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'customkm_enqueue_delete_post_script' ) );
		add_action( 'wp_ajax_delete_post_action', array( $this, 'customkm_delete_post_action_callback' ) );
		add_action( 'rest_api_init', array( $this, 'register_custom_rest_api' ) );
	}

	/**
	* Adds a submenu page to the custom AJAX plugin settings.
	*/
	public function customkm_submenu() {
		add_submenu_page(
			'customkm-ajax-plugin-settings',
			'Submenu Page Title',       // Page title
			esc_html__( 'Post Retrievals Title', 'customkm-menu' ),       // Menu title
			'manage_options',           // Capability
			'customkm-submenu-slug',    // Submenu slug
			array( $this, 'page_contents_html' )  // Callback function for submenu content
		);
	}

		/**
	 * Retrieve all portfolio posts' data.
	 */
	public function page_contents() {
<<<<<<< HEAD
		$args = array(
			'post_type'      => 'portfolio',
			'posts_per_page' => -1,
		);
=======
		?>
	<div class="wrap">
		<h1><?php echo esc_html__( 'Post Retrievals', 'customkm-menu' ); ?></h1>
		<p><?php echo esc_html__( 'Retrieve posts using the REST API', 'customkm-menu' ); ?></p>
		<?php
		// Retrieve posts using REST API
		$url      = home_url();
		$response = wp_remote_get( rest_url( 'wp/v2/portfolio' ) );
		// Check if request was successful
		if ( 200 === wp_remote_retrieve_response_code( $response ) ) {
			// Decode the JSON response body
			$posts = json_decode( wp_remote_retrieve_body( $response ), true );
			// Check if there are posts
			if ( ! empty( $posts ) ) {
				include_once CUSTOMKM_MENU_PLUGIN_DIR . 'templates/form.php';
				foreach ( $posts as $post ) {
					$query = new \WP_Query(
						array(
							'post_type' => 'portfolio',
							'p'         => $post['id'],
						)
					); // Specify post type as portfolio
					while ( $query->have_posts() ) :
						$query->the_post(); // Using $query to iterate through posts
						// Get the post ID
						$post_id     = get_the_ID();
						$client_name = get_post_meta( $post_id, 'client_name', true );
						$address     = get_post_meta( $post_id, 'address', true );
						$email       = get_post_meta( $post_id, 'email', true );
						$phone       = get_post_meta( $post_id, 'phone', true );
						$company     = get_post_meta( $post_id, 'company_name', true );
						include CUSTOMKM_MENU_PLUGIN_DIR . 'templates/post-row.php';
					endwhile;
					wp_reset_postdata(); // Reset post data
				}
				echo '</table>';
			} else {
				// No posts found message
				echo '<p>No posts found.</p>';
			}
		} else {
			// Error message if request was not successful
			echo '<p>An error occurred while retrieving posts.</p>';
		}
		?>
	</div>
>>>>>>> a6719ac514c5ab92aa59c39115dbb0e99ff6b942

		$query = new \WP_Query( $args );

		$posts_data = array();
		//include_once CUSTOMKM_MENU_PLUGIN_DIR . 'templates/form.php';
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

				//print_r( $post_data['email'] );
				//include CUSTOMKM_MENU_PLUGIN_DIR . 'templates/post-row.php';
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

	public function page_contents_html() {

		include CUSTOMKM_MENU_PLUGIN_DIR . 'templates/tmpl-portfolio.php';
		?>
		<div id="page-content"></div>
		<?php
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
		//var_dump( $rest_url );
		wp_localize_script(
			'delete-post-js',
			'rest_object',
			array(
				'rest_url' => rest_url(),

			)
		);
	}

	public function register_custom_rest_api() {
		register_rest_route(
			'custom/v1',
			'/delete-post/(?P<id>\d+)',
			array(
				'methods'  => 'GET',
				'callback' => array( $this, 'custom_delete_post_callback' ),
			)
		);

		register_rest_route(
			'custom/v1', // Namespace for the route
			'/portfolio/', // Route
			array(
				'methods'  => 'GET',
				'callback' => array( $this, 'page_contents' ),
			)
		);
	}

	public function custom_delete_post_callback( \WP_REST_Request $request ) {

		$params = $request->get_params();
		//var_dump( $request );
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
