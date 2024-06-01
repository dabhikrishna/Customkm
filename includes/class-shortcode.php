<?php

namespace CustomkmMenu\Includes;

if ( ! defined( 'PM_PLUGIN_DIR' ) ) {
	define( 'PM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

/**
 * Class Shortcode
 * Handles registration of custom shortcodes and related functionalities.
 */
class Shortcode {
	/**
	 * Constructor.
	 */
	public function __construct() {
		add_shortcode( 'portfolio_submission_form', array( $this, 'customkm_portfolio_submission_form_shortcode' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'customkm_enqueue_scripts' ) );
		add_action( 'wp_ajax_portfolio_submission', array( $this, 'customkm_process_portfolio_submission' ) );
		add_action( 'wp_ajax_nopriv_portfolio_submission', array( $this, 'customkm_process_portfolio_submission' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'customkm_enqueue_styles' ) );
	}
	/**
	* Creates a shortcode for the form.
	*/
	public function customkm_portfolio_submission_form_shortcode( $atts ) {
		// Extract shortcode attributes
		$atts = shortcode_atts(
			array(
				'title' => 'My Form Submission', // Default title if not provided
			),
			$atts,
			'portfolio_submission_form'
		);

		ob_start();
		include_once PM_PLUGIN_DIR . 'templates/portfolio-form.php';
		?>
		<?php
		return ob_get_clean();
	}

	public function customkm_enqueue_scripts() {
		// Enqueue custom script
		wp_enqueue_script(
			'my-custom-script', // Handle
			plugin_dir_url( __FILE__ ) . 'js/custom-script.js', // URL to script
			array( 'jquery' ), // Dependencies
			'1.0', // Version number (optional)
			true // Load script in footer (optional)
		);

		// Pass Ajax URL to script
		wp_localize_script(
			'my-custom-script', // Script handle
			'my_custom_script_object', // Object name
			array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) // Data
		);
	}
	/**
	* Processes form submission for portfolio.
	*/
	public function customkm_process_portfolio_submission() {
		if ( isset( $_POST['portfolio_submission_nonce_field'] ) && wp_verify_nonce( $_POST['portfolio_submission_nonce_field'], 'portfolio_submission_nonce' ) ) {
			if ( isset( $_POST['name'] ) && isset( $_POST['email'] ) ) {

				if ( empty( $_POST['name'] ) || empty( $_POST['email'] ) || empty( $_POST['company_name'] ) || empty( $_POST['phone'] ) || empty( $_POST['address'] ) ) {
					echo 'Please fill out all required fields.';
					die();
				}
				$name         = sanitize_text_field( $_POST['name'] );
				$company_name = sanitize_text_field( $_POST['company_name'] );
				$email        = sanitize_email( $_POST['email'] );
				$phone        = sanitize_text_field( $_POST['phone'] );
				$address      = sanitize_textarea_field( $_POST['address'] );

				$portfolio_data = array(
					'post_title'  => $name,
					'post_type'   => 'portfolio',
					'post_status' => 'publish',
					'meta_input'  => array(
						'client_name'  => $name,
						'email'        => $email,
						'phone'        => $phone,
						'company_name' => $company_name,
						'address'      => $address,
						'mail'         => gmdate( 'Y-m-d H:i:s' ),
					),
				);
				// Insert the post into the database
				$post_id = wp_insert_post( $portfolio_data );

				if ( is_wp_error( $post_id ) ) {
					echo 'Error: ' . esc_html( $post_id->get_error_message() );
				} else {
					include PM_PLUGIN_DIR . 'templates/portfolio-submission.php';
				}
			}
		}
		die();
	}

	/**
	* Enqueues the stylesheet for the plugin.
	*/
	public function customkm_enqueue_styles() {
		if ( has_shortcode( get_post()->post_content, 'portfolio_submission_form' ) ) {
			// Enqueue CSS file located within your plugin directory
			wp_enqueue_style(
				'your_plugin_portfolio_submission_form_style', // Handle
				plugins_url( '/css/portfolio-submission-form.css', __FILE__ ), // URL to CSS file
				array(), // Dependencies
				'1.0', // Version number
				'all' // Media type
			);
		}
	}
}
