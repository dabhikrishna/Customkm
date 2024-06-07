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
			array( $this, 'page_contents' )  // Callback function for submenu content
		);
	}

	/**
	 * Callback function to render plugin page content.
	 */
	public function page_contents() {
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

		<?php
	}

	/**
	* Enqueue the external JavaScript file.
	*/
	public function customkm_enqueue_delete_post_script() {
		// Create a nonce
		$nonce = wp_create_nonce( 'delete_post_nonce' );
		wp_enqueue_script( 'delete-post-js', plugins_url( 'js/delete-post.js', __FILE__ ), array( 'jquery' ), '1.0', true );
		// Localize the script with the 'ajaxurl' and the nonce
		wp_localize_script(
			'delete-post-js',
			'delete_post_object',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => $nonce,
			)
		);
	}

	/**
	* Handle AJAX request to delete post.
	*/
	public function customkm_delete_post_action_callback() {
		check_ajax_referer( 'delete_post_nonce', 'nonce' );
		$post_id = isset( $_POST['post_id'] ) ? intval( $_POST['post_id'] ) : 0;

		// Check if user has permission to delete post
		if ( current_user_can( 'delete_post', $post_id ) ) {
			// Delete the post
			wp_delete_post( $post_id, true );
			echo 'success';
		} else {
			echo 'error';
		}

		// Always exit to avoid further execution
		wp_die();
	}
}
