<?php

namespace CustomkmMenu\Includes;

if ( ! defined( 'PM_PLUGIN_DIR' ) ) {
	define( 'PM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

/**
 * Class Portfolio
 * Handles functionality related to the portfolio custom post type.
 */
class Portfolio {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'save_post', array( $this, 'customkm_save_portfolio_custom_fields' ) );
		add_filter( 'manage_portfolio_posts_columns', array( $this, 'customkm_modify_portfolio_columns' ) );
		add_action( 'manage_portfolio_posts_custom_column', array( $this, 'customkm_display_portfolio_custom_columns' ), 10, 2 );
		add_action( 'add_meta_boxes', array( $this, 'customkm_portfolio_custom_fields' ) );
	}

	/**
	 * Registers the portfolio custom post type.
	 */
	public function register_post_type() {
		// Labels for the custom post type
		$labels = array(
			'name'                  => _x( 'Portfolio', 'Post Type General Name', 'text_domain' ),
			'singular_name'         => _x( 'Portfolio Item', 'Post Type Singular Name', 'text_domain' ),
			'menu_name'             => __( 'Portfolio', 'text_domain' ),
			'name_admin_bar'        => __( 'Portfolio', 'text_domain' ),
			'archives'              => __( 'Portfolio Archives', 'text_domain' ),
			'attributes'            => __( 'Portfolio Attributes', 'text_domain' ),
			'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
			'all_items'             => __( 'All Items', 'text_domain' ),
			'add_new_item'          => __( 'Add New Item', 'text_domain' ),
			'add_new'               => __( 'Add New', 'text_domain' ),
			'new_item'              => __( 'New Item', 'text_domain' ),
			'edit_item'             => __( 'Edit Item', 'text_domain' ),
			'update_item'           => __( 'Update Item', 'text_domain' ),
			'view_item'             => __( 'View Item', 'text_domain' ),
			'view_items'            => __( 'View Items', 'text_domain' ),
			'search_items'          => __( 'Search Item', 'text_domain' ),
			'not_found'             => __( 'Not found', 'text_domain' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
			'featured_image'        => __( 'Featured Image', 'text_domain' ),
			'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
			'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
			'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
			'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
			'items_list'            => __( 'Items list', 'text_domain' ),
			'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
			'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
		);

		// Arguments for registering the custom post type
		$args = array(
			'label'               => __( 'Portfolio Item', 'text_domain' ),
			'description'         => __( 'Portfolio Item Description', 'text_domain' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
			'taxonomies'          => array(),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 24,
			'menu_icon'           => 'dashicons-portfolio',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
			'show_in_rest'        => true, // Ensure REST API support
		);

		// Register the custom post type
		register_post_type( 'portfolio', $args );
	}

	/**
	 * Saves the custom fields for the portfolio post type.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function customkm_save_portfolio_custom_fields( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Save client name
		if ( isset( $_POST['plugin_options_nonce'] ) && wp_verify_nonce( $_POST['plugin_options_nonce'], 'update_plugin_options' ) ) {
			update_post_meta( $post_id, 'client_name', sanitize_text_field( $_POST['client_name'] ) );
		}

		// Save project URL
		if ( isset( $_POST['plugin_options_nonce'] ) && wp_verify_nonce( $_POST['plugin_options_nonce'], 'update_plugin_options' ) ) {
			update_post_meta( $post_id, 'project_url', esc_url( $_POST['project_url'] ) );
		}
	}

	/**
	 * Modifies the columns displayed in the portfolio post type admin table.
	 *
	 * @param array $columns Existing columns in the admin table.
	 * @return array Modified columns array.
	 */
	public function customkm_modify_portfolio_columns( $columns ) {
		$columns['client_name']  = 'Name';
		$columns['address']      = 'Address';
		$columns['email']        = 'Email';
		$columns['phone']        = 'Phone';
		$columns['company_name'] = 'company_name';
		$columns['mail']         = 'Mail_sent';
		unset( $columns['categories'] ); // Remove categories column
		unset( $columns['tags'] ); // Remove tags column
		return $columns;
	}

	/**
 * Displays custom data in the columns of the portfolio post type admin table.
 *
 * @param string $column  The name of the column being displayed.
 * @param int    $post_id The ID of the post.
 */
	public function customkm_display_portfolio_custom_columns( $column, $post_id ) {
		switch ( $column ) {
			case 'company_name':
				echo esc_html( get_post_meta( $post_id, 'company_name', true ) );
				break;
			case 'address':
				echo esc_html( get_post_meta( $post_id, 'address', true ) );
				break;
			case 'email':
				echo esc_html( get_post_meta( $post_id, 'email', true ) );
				break;
			case 'phone':
				echo esc_html( get_post_meta( $post_id, 'phone', true ) );
				break;
			case 'client_name':
				echo esc_html( get_post_meta( $post_id, 'client_name', true ) );
				break;
			case 'mail':
				echo esc_html( get_post_meta( $post_id, 'mail', true ) );
				break;
		}
	}

	/**
	* Adds custom fields to the portfolio post type.
	*/
	public function customkm_portfolio_custom_fields() {
		add_meta_box(
			'portfolio_fields',
			'Portfolio Fields',
			array( $this, 'render_portfolio_fields' ),
			'portfolio',
			'normal',
			'default'
		);
	}
	/**
	 * Renders the custom fields for the portfolio post type.
	 */
	public function render_portfolio_fields() {
		// Include the template file for rendering the custom fields
		include_once PM_PLUGIN_DIR . 'templates/portfolio-renders.php';
	}
}
