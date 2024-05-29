<?php
namespace CustomPlugin\Includes;

use function CustomPlugin\Includes\customkm_portfolio_post_type;
use function CustomPlugin\Includes\customkm_modify_portfolio_columns;
use function CustomPlugin\Includes\customkm_display_portfolio_custom_columns;

/**
 * Registers a custom post type for portfolio items.
 */
function customkm_portfolio_post_type() {
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
add_action( 'init', 'CustomPlugin\Includes\customkm_portfolio_post_type', 0 );

/**
 * Modifies the columns displayed in the portfolio post type admin table.
 *
 * @param array $columns Existing columns in the admin table.
 * @return array Modified columns array.
 */
function customkm_modify_portfolio_columns( $columns ) {
	$columns['client_name']  = 'Name';
	$columns['address']      = 'Address';
	$columns['email']        = 'Email';
	$columns['phone']        = 'Phone';
	$columns['company_name'] = 'company_name';
	unset( $columns['categories'] ); // Remove categories column
	unset( $columns['tags'] ); // Remove tags column
	return $columns;
}
add_filter( 'manage_portfolio_posts_columns', 'CustomPlugin\Includes\customkm_modify_portfolio_columns' );

/**
 * Displays custom data in the columns of the portfolio post type admin table.
 *
 * @param string $column  The name of the column being displayed.
 * @param int    $post_id The ID of the post.
 */
function customkm_display_portfolio_custom_columns( $column, $post_id ) {
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
	}
}
add_action( 'manage_portfolio_posts_custom_column', 'CustomPlugin\Includes\customkm_display_portfolio_custom_columns', 10, 2 );
