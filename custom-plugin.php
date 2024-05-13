<?php
/**
 * Plugin Name: Custom Menu
 * Description: A simple Plugin for storing and displaying custom data.
 * Version: 6.5.2
 * Author: krishna
 */

// Add custom menu page
function custom_menu_page() {
	add_menu_page(
		'Custom Menu',              // Page title
		'Custom Menu',              // Menu title
		'manage_options',           // Capability
		'custom-page-slug',         // Menu slug
		'custom_page_content',      // Callback function
		'dashicons-admin-generic',  // Icon
		25                          // Position
	);
}
add_action('admin_menu', 'custom_menu_page');

// Custom page content
function custom_page_content() {
	?>
	<div class="logo-container">
		<img src="<?php echo plugins_url( 'images/custom-logo.png', __FILE__ ); ?>" alt="Plugin Logo">
	</div>
	<div class="wrap">
		<form action="" method="post">
			<?php wp_nonce_field('update_plugin_options', 'plugin_options_nonce'); ?>
			Name: <input type="text" name="name" value="<?php echo esc_attr(get_option('name')); ?>"/>
			<input type="submit" name="submit" value="Submit"/>
		</form>
	</div>
	<?php
}

// Save data using Option API
add_action('init', 'data_save_table');
function data_save_table() {
	if (isset($_POST['plugin_options_nonce']) && wp_verify_nonce($_POST['plugin_options_nonce'], 'update_plugin_options')) {
		$data_to_store = $_POST['name'];
		$key = 'name';
		update_option($key, $data_to_store);
	}
}

// Add shortcode to fetch data
add_shortcode('fetch_data', 'fetch_data_shortcode');
function fetch_data_shortcode() {
	$key = 'name';                  // Specify the key used to save the data
	$saved_data = get_option($key); // Retrieve the saved data
	return $saved_data;             // Return the data
}

// Add submenu page using Option API
function my_plugin_submenu_page() {
	add_submenu_page(
		'options-general.php',      // Parent menu slug
		'My Plugin Settings',       // Page title
		'My Plugin',                // Menu title
		'manage_options',           // Capability
		'my-plugin-submenu',        // Menu slug
		'my_plugin_submenu_settings_page' // Callback function
	);
}
add_action('admin_menu', 'my_plugin_submenu_page');

// Submenu page content
function my_plugin_submenu_settings_page() {
	?>
	<div class="wrap">
		<h2>My Plugin Settings</h2>
		<form method="post" action="">
			Add Data: <input type="text" name="my_data" value="<?php echo esc_attr(get_option('my_data')); ?>"/>
			<input type="submit" name="submit" value="Submit">
		</form>
	</div>
	<?php
}

// Save data using Option API for submenu
add_action('init', 'data_save_table2');
function data_save_table2() {
	if (isset($_POST['submit'])) {
		$data_to_store1 = $_POST['my_data'];
		$keys = 'my_data';
		update_option($keys, $data_to_store1);
	}
}

// Add shortcode to fetch data for submenu
add_shortcode('fetch_data_value', 'fetch_data_value_shortcode');
function fetch_data_value_shortcode() {
	$key = 'my_data';               // Specify the key used to save the data
	$saved_data = get_option($key); // Retrieve the saved data
	return $saved_data;             // Return the data
}

// Add submenu page using Settings API
function my_custom_submenu_page() {
	add_submenu_page(
		'options-general.php',      // Parent menu slug
		'My Submenu Page',          // Page title
		'My Submenu',               // Menu title
		'manage_options',           // Capability required to access
		'my-custom-submenu',        // Menu slug
		'my_custom_submenu_callback' // Callback function to display content
	);
}
add_action('admin_menu', 'my_custom_submenu_page');

// Callback function to display submenu page content
function my_custom_submenu_callback() {
	?>
	<div class="wrap">
		<h2>My Submenu Page</h2>
		<form method="post" action="options.php">
			<?php
			// Display settings fields
			settings_fields( 'my-custom-settings-group' );
			do_settings_sections( 'my-custom-settings-group' );
			?>
			<input type="submit" class="button-primary" value="Save Changes">
		</form>
	</div>
	<?php
}

// Register settings and fields
function my_custom_settings_init() {
	register_setting(
		'my-custom-settings-group',  // Option group
		'my_option_name',             // Option name
		'my_sanitize_callback'       // Sanitization callback function
	);

	add_settings_section(
		'my-settings-section',       // Section ID
		'My Settings Section',       // Section title
		'my_settings_section_callback', // Callback function to display section description (optional)
		'my-custom-settings-group'   // Parent page slug
	);

	add_settings_field(
		'my-setting-field',          // Field ID
		'My Setting Field',          // Field title
		'my_setting_field_callback', // Callback function to display field input
		'my-custom-settings-group',  // Parent page slug
		'my-settings-section'        // Section ID
	);
}
add_action( 'admin_init', 'my_custom_settings_init' );

// Callback function to display section description (optional)
function my_settings_section_callback() {
	echo '<p>This is a description of my settings section.</p>';
}

// Callback function to display field input
function my_setting_field_callback() {
	$option_value = get_option( 'my_option_name' );
	?>
	<input type="text" name="my_option_name" value="<?php echo esc_attr( $option_value ); ?>">
	<?php
}

// Sanitization callback function
function my_sanitize_callback( $input ) {
	return sanitize_text_field( $input );
}

function custom_portfolio_post_type() {

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
	$args = array(
		'label'                 => __( 'Portfolio Item', 'text_domain' ),
		'description'           => __( 'Portfolio Item Description', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-portfolio',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'portfolio', $args );

}
add_action( 'init', 'custom_portfolio_post_type', 0 );

// Add Custom Fields
function custom_portfolio_custom_fields() {
	add_meta_box(
		'portfolio_fields',
		'Portfolio Fields',
		'render_portfolio_fields',
		'portfolio',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes', 'custom_portfolio_custom_fields' );

function render_portfolio_fields( $post ) {
	// Retrieve existing values for fields
	$client_name = get_post_meta( $post->ID, 'client_name', true );
	$project_url = get_post_meta( $post->ID, 'project_url', true );

	// Render fields
	?>
	<p>
		<label for="client_name">Client Name:</label>
		<input type="text" id="client_name" name="client_name" value="<?php echo esc_attr( $client_name ); ?>">
	</p>
	<p>
		<label for="project_url">Project URL:</label>
		<input type="text" id="project_url" name="project_url" value="<?php echo esc_attr( $project_url ); ?>">
	</p>
	<?php
}

// Save Custom Fields
function save_portfolio_custom_fields( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Save client name
	if ( isset( $_POST['client_name'] ) ) {
		update_post_meta( $post_id, 'client_name', sanitize_text_field( $_POST['client_name'] ) );
	}

	// Save project URL
	if ( isset( $_POST['project_url'] ) ) {
		update_post_meta( $post_id, 'project_url', esc_url( $_POST['project_url'] ) );
	}
}
add_action( 'save_post', 'save_portfolio_custom_fields' );


add_shortcode('recent_portfolio_posts', 'display_recent_portfolio_posts_shortcode');

// Shortcode callback function to display recent portfolio posts
function display_recent_portfolio_posts_shortcode($atts) {
	$atts = shortcode_atts(array(
		'count' => 4,               // Default number of posts to display
	), $atts);

	$args = array(
		'post_type'      => 'portfolio', // Custom post type name
		'posts_per_page' => $atts['count'],
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	$recent_portfolio_posts = new WP_Query($args);

	if ($recent_portfolio_posts->have_posts()) {
		$output = '<ul>';
		while ($recent_portfolio_posts->have_posts()) {
			$recent_portfolio_posts->the_post();
			$output .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
		}
		$output .= '</ul>';
		wp_reset_postdata(); // Reset post data query
	} else {
		$output = 'No recent portfolio posts found.';
	}

	return $output;
}


class My_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'my-text',                  // Base ID
			'My Text'                   // Name
		);
		add_action( 'widgets_init', function() {
			register_widget( 'My_Widget' );
		});
	}

	public function widget( $args, $instance ) {
		$args = array(
			'before_title'  => '<h4 class="widgettitle">',
			'after_title'   => '</h4>',
			'before_widget' => '<div class="widget-wrap">',
			'after_widget'  => '</div></div>',
		);
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		echo '<div class="textwidget">';
		echo esc_html__( $instance['text'], 'text_domain' );
		echo '</div>';
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'text_domain' );
		$text  = ! empty( $instance['text'] ) ? $instance['text'] : esc_html__( '', 'text_domain' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'text_domain' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'Text' ) ); ?>"><?php echo esc_html__( 'Text:', 'text_domain' ); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" type="text" cols="30" rows="10"><?php echo esc_attr( $text ); ?></textarea>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['text']  = ( ! empty( $new_instance['text'] ) ) ? $new_instance['text'] : '';
		return $instance;
	}
}
$my_widget = new My_Widget();