<?php
/**
 * Plugin Name: Customkm Menu
 * Plugin URI: https://qrolic.com
 * Description: Customkm Plugin for your site.
 * Version: 6.5.2
 * Author: krishna
 * Author URI:https://qrolic.com
 * Text Domain: customkm-menu
 * Domain Path: /languages
 *
 * Customkm Menu plugin use for add CUSTOM MENU,CUSTOM SUBMENU,create field and save data using ,
 * OPTION API AND SETTING API.
 *
 * Create register post type PORTFOLIO and save their custom field with view.
 *
 * Create code for display recent post type from portfolio menu.
 *
 * Build a widget that displays recent comments or posts in the sidebar of your WordPress site.
 *
 * Incorporate AJAX into customkm plugin to perform asynchronous tasks, such as loading content dynamically or submitting form data without page reloads.
 *
 * Create shortcode for Add form with different fields and insert data in custom post type Portfolio.
 */


/**
 * Enqueues the stylesheet for the plugin.
 */
function your_plugin_enqueue_styles() {
	// Enqueue CSS file located within your plugin directory
	wp_enqueue_style( 'your-plugin-style', plugins_url( '/css/portfolio-submission-form.css', __FILE__ ), array(), '1.0', 'all' );
}
add_action( 'wp_enqueue_scripts', 'your_plugin_enqueue_styles' );

/**
 * Registers a custom post type for portfolio items.
 */
function custom_portfolio_post_type() {
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
add_action( 'init', 'custom_portfolio_post_type', 0 );

/**
 * Adds custom fields to the portfolio post type.
 */
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

/**
 * Renders the custom fields for the portfolio post type.
 */
function render_portfolio_fields() {
	// Include the template file for rendering the custom fields
	include_once plugin_dir_path( __FILE__ ) . 'templates/portfolio-renders.php';
}

/**
 * Saves the custom fields for the portfolio post type.
 *
 * @param int $post_id The ID of the post being saved.
 */
function save_portfolio_custom_fields( $post_id ) {
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
add_action( 'save_post', 'save_portfolio_custom_fields' );

/**
 * Modifies the columns displayed in the portfolio post type admin table.
 *
 * @param array $columns Existing columns in the admin table.
 * @return array Modified columns array.
 */
function modify_portfolio_columns( $columns ) {
	$columns['client_name']  = 'Name';
	$columns['address']      = 'Address';
	$columns['email']        = 'Email';
	$columns['phone']        = 'Phone';
	$columns['company_name'] = 'company_name';
	unset( $columns['categories'] ); // Remove categories column
	unset( $columns['tags'] ); // Remove tags column
	return $columns;
}
add_filter( 'manage_portfolio_posts_columns', 'modify_portfolio_columns' );

/**
 * Displays custom data in the columns of the portfolio post type admin table.
 *
 * @param string $column  The name of the column being displayed.
 * @param int    $post_id The ID of the post.
 */
function display_portfolio_custom_columns( $column, $post_id ) {
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
add_action( 'manage_portfolio_posts_custom_column', 'display_portfolio_custom_columns', 10, 2 );

/**
 * Adds a custom menu page in the admin menu.
 */
function custom_ajax_plugin_menu() {
	add_menu_page(
		'Custom AJAX Plugin Settings',    // Page title
		esc_html__( 'Custom AJAX Plugin', 'customkm-menu' ),         // Menu title
		'manage_options',         // Capability
		'custom-ajax-plugin-settings',         // Menu slug
		'custom_ajax_plugin_settings_page',    // Callback function
		'dashicons-menu', // Icon
		28 // Position of the menu in the admin sidebar
	);
}

/**
 * Callback function to display the plugin settings page.
 */
function custom_ajax_plugin_settings_page() {
	include_once plugin_dir_path( __FILE__ ) . 'templates/custom-ajax.php';
}
add_action( 'admin_menu', 'custom_ajax_plugin_menu' );

/**
 * Handles AJAX request to update store name.
 */
function custom_ajax_plugin_ajax_handler() {
	if ( isset( $_POST['store_name'] ) ) {
		// Verify nonce
		if ( ! wp_verify_nonce( $_POST['nonce'], 'custom_ajax_plugin_ajax_nonce' ) ) {
			echo 'ok';
		}
		// Sanitize and save store name
		$store_name = sanitize_text_field( $_POST['store_name'] );
		update_option( 'store_name', $store_name );
		echo 'Store name updated successfully!';
	}
	wp_die();
}
add_action( 'wp_ajax_custom_ajax_plugin_update_store_name', 'custom_ajax_plugin_ajax_handler' );

/**
 * Enqueues JavaScript for AJAX.
 */
function custom_ajax_plugin_enqueue_scripts( $hook ) {
	if ( 'toplevel_page_custom-ajax-plugin-settings' !== $hook ) {
		return;
	}
	wp_enqueue_script( 'custom-ajax-plugin-script', plugins_url( '/js/custom-ajax-plugin-script.js', __FILE__ ), array( 'jquery' ), '1.0', true );
	wp_localize_script(
		'custom-ajax-plugin-script',
		'custom_ajax_plugin_ajax_object',
		array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
	);
}
add_action( 'admin_enqueue_scripts', 'custom_ajax_plugin_enqueue_scripts' );

/**
 * Registers a shortcode to display recent portfolio posts.
 */
add_shortcode( 'recent_portfolio_posts', 'display_recent_portfolio_posts_shortcode' );
// Shortcode callback function to display recent portfolio posts
function display_recent_portfolio_posts_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'count' => 4,               // Default number of posts to display
		),
		$atts
	);

	$args = array(
		'post_type'      => 'portfolio', // Custom post type name
		'posts_per_page' => $atts['count'],
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	$recent_portfolio_posts = new WP_Query( $args );

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

	return $output;
}

require_once plugin_dir_path( __FILE__ ) . 'includes/class-kmd-widget.php';

/**
 * Registers the custom widget area and adds the recent posts widget to it.
 */
function custom_widget() {
	register_widget( 'Kmd_Widget' );
}
add_action( 'widgets_init', 'custom_widget' );

function widgets_init() {
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

	// Add recent posts widget to the custom widget area
	if ( is_active_sidebar( 'custom-widget-area' ) ) {
		// Instantiate the custom recent posts widget
		$recent_posts_widget = new Custom_Widget();

		// Add the widget to the custom widget area
		the_widget(
			'Custom_Widget', // Widget class name
			array(), // Widget arguments (empty for default settings)
			array(
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
	}
}
add_action( 'widgets_init', 'widgets_init' );

// Enqueue jQuery in WordPress
function enqueue_jquery() {
	wp_enqueue_script( 'jquery' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_jquery' );

/**
 * Creates a shortcode for the form.
 */
function portfolio_submission_form_shortcode( $atts ) {
		// Extract shortcode attributes
		$atts = shortcode_atts(
			array(
				'title' => 'My Form Submission', // Default title if not provided
			),
			$atts,
			'portfolio_submission_form'
		);

	ob_start();
	?>
	<div class="my">
	<h2 style="font-weight: bold;"><?php echo esc_html( $atts['title'] ); ?></h2>
	<?php include_once plugin_dir_path( __FILE__ ) . 'templates/portfolio-form.php'; ?>
	<div id="response_msg"></div>
	</div>

	<?php
	return ob_get_clean();
}
add_shortcode( 'portfolio_submission_form', 'portfolio_submission_form_shortcode' );

function my_plugin_enqueue_scripts() {
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
		'ajaxurl', // Object name
		admin_url( 'admin-ajax.php' ) // Data
	);
}

// Hook into appropriate action
add_action( 'wp_enqueue_scripts', 'my_plugin_enqueue_scripts' );

/**
 * Processes form submission for portfolio.
 */
function process_portfolio_submission() {
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
					'email_result' => $email_result,
				),
			);
			// Insert the post into the database
			$post_id = wp_insert_post( $portfolio_data );

			if ( is_wp_error( $post_id ) ) {
				echo 'Error: ' . esc_html( $post_id->get_error_message() );
			} else {
				echo '<div id="success-message">Success! Your portfolio has been submitted with email .</div>';
				echo '<script>
						setTimeout(function() {
							document.getElementById("success-message").style.display = "none";
						}, 5000); // Hide after 5 seconds
						</script>';
			}
		}
	}
	die();
}
add_action( 'wp_ajax_portfolio_submission', 'process_portfolio_submission' );
add_action( 'wp_ajax_nopriv_portfolio_submission', 'process_portfolio_submission' );

/**
 * Adds a submenu page to the custom AJAX plugin settings.
 */
function my_plugin_submenu() {
		add_submenu_page(
			'custom-ajax-plugin-settings',
			'Submenu Page Title',       // Page title
			esc_html__( 'Submenu Menu Title', 'customkm-menu' ),       // Menu title
			'manage_options',           // Capability
			'customkm-submenu-slug',    // Submenu slug
			'my_plugin_page_content'  // Callback function for submenu content
		);
}
add_action( 'admin_menu', 'my_plugin_submenu' );

/**
 * Callback function to render plugin page content.
 */
function my_plugin_page_content() {
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
				include_once plugin_dir_path( __FILE__ ) . 'templates/form.php';

				foreach ( $posts as $post ) {
					$query = new WP_Query(
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
						echo '<tr style="background-color: #ddd;">';
						echo '<style>
						td {
							border: 1px solid #ddd;
							padding: 8px;
							text-align: left;
						}
						</style>';
						echo '<td>' . esc_html( get_the_title( $post_id ) ) . '</td>';
						echo '<td>' . esc_html( $client_name ) . '</td>';
						echo '<td>' . esc_html( $address ) . '</td>';
						echo '<td>' . esc_html( $email ) . '</td>';
						echo '<td>' . esc_html( $phone ) . '</td>';
						echo '<td>' . esc_html( $company ) . '</td>';
						echo '<td>' . esc_html( get_the_date() ) . '</td>';
						echo '<td><button class="delete-post-button" data-post-id="' . esc_html( $post_id ) . '" data-nonce="' . esc_attr( wp_create_nonce( 'delete_post_nonce' ) ) . '">Delete Post</button></td>';
						echo '</tr>';
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
function enqueue_delete_post_script() {
	// Create a nonce
	$nonce = wp_create_nonce( 'delete_post_nonce' );

	// Enqueue the JavaScript file
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
add_action( 'admin_enqueue_scripts', 'enqueue_delete_post_script' );
/**
 * Handle AJAX request to delete post.
 */
add_action( 'wp_ajax_delete_post_action', 'delete_post_action_callback' );
function delete_post_action_callback() {
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
/**
 * Callback function to return a simple response.
 */
function prefix_get_endpoint_phrase() {
	// rest_ensure_response() wraps the data we want to return into a WP_REST_Response, and ensures it will be properly returned.
	return rest_ensure_response( 'Hello World, this is the WordPress REST API' );
}

/**
 * Registers routes for the example endpoint.
 */
function prefix_register_example_routes() {
	// register_rest_route() handles more arguments but we are going to stick to the basics for now.
	register_rest_route(
		'hello-world/v1',
		'/phrase',
		array(
			// By using this constant we ensure that when the WP_REST_Server changes our readable endpoints will work as intended.
			'methods'  => WP_REST_Server::READABLE,
			// Here we register our callback. The callback is fired when this endpoint is matched by the WP_REST_Server class.
			'callback' => 'prefix_get_endpoint_phrase',
		)
	);
}
add_action( 'rest_api_init', 'prefix_register_example_routes' );

/**
 * Adds a plugin page to the admin menu.
 */
function example_plugin_menu() {
	add_submenu_page(
		'custom-ajax-plugin-settings',
		'Example Plugin Page',    // Page title
		esc_html__( 'Plugin Page', 'customkm-menu' ),        // Menu title
		'manage_options',         // Capability
		'example-plugin',         // Menu slug
		'example_plugin_page',    // Callback function
		'dashicons-admin-page', // Icon
		27 // Position of the menu in the admin sidebar
	);
}
add_action( 'admin_menu', 'example_plugin_menu' );

// Plugin page content
function example_plugin_page() {
	wp_enqueue_style( 'plugin-custom-styles', plugin_dir_url( __FILE__ ) . 'css/plugin-styles.css' );
	include_once plugin_dir_path( __FILE__ ) . 'templates/example-plugin.php';
}

/**
 * Adds a submenu page to the custom AJAX plugin settings.
 */
function customkm_menu_page() {
	add_submenu_page(
		'custom-ajax-plugin-settings',
		'Customkm Menu',              // Page title
		esc_html__( 'Customkm Menu', 'customkm-menu' ),              // Menu title
		'manage_options',           // Capability
		'customkm-page-slug',         // Menu slug
		'customkm_page_content',      // Callback function
		'dashicons-admin-generic',  // Icon
		25                          // Position
	);
}
add_action( 'admin_menu', 'customkm_menu_page' );

/**
 * Custom page content for submenu.
 */
function customkm_page_content() {
	include_once plugin_dir_path( __FILE__ ) . 'templates/customkm-page.php';
}

/**
 * Saves data using Option API.
 */
add_action( 'init', 'data_save_table' );
function data_save_table() {
	if ( isset( $_POST['plugin_options_nonce'] ) && wp_verify_nonce( $_POST['plugin_options_nonce'], 'update_plugin_options' ) ) {
		$data_to_store = $_POST['name'];
		$key           = 'name';
		update_option( $key, $data_to_store );
	}
}

/**
 * Adds shortcode to fetch data.
 */
add_shortcode( 'fetch_data', 'fetch_data_shortcode' );
function fetch_data_shortcode() {
	$key        = 'name';                  // Specify the key used to save the data
	$saved_data = get_option( $key ); // Retrieve the saved data
	return $saved_data;             // Return the data
}

/**
 * Adds a submenu page using Settings API.
 */
function my_custom_submenu_page() {
	add_submenu_page(
		'options-general.php', // Parent menu slug
		'My Submenu Page', // Page title
		'My Submenu', // Menu title
		'manage_options', // Capability required to access
		'my-custom-submenu', // Menu slug
		'my_custom_submenu_callback' // Callback function to display content
	);
}
add_action( 'admin_menu', 'my_custom_submenu_page' );

/**
 * Callback function to display submenu page content.
 */
function my_custom_submenu_callback() {
	include_once plugin_dir_path( __FILE__ ) . 'templates/custom-submenu.php';
}

/**
 * Registers settings and fields.
 */
function my_custom_settings_init() {
	register_setting(
		'my-custom-settings-group', // Option group
		'my_option_name', // Option name
		'my_sanitize_callback' // Sanitization callback function
	);

	add_settings_section(
		'my-settings-section', // Section ID
		'My Settings Section', // Section title
		'my_settings_section_callback', // Callback function to display section description (optional)
		'my-custom-settings-group' // Parent page slug
	);

	add_settings_field(
		'my-setting-field', // Field ID
		'My Setting Field', // Field title
		'my_setting_field_callback', // Callback function to display field input
		'my-custom-settings-group', // Parent page slug
		'my-settings-section' // Section ID
	);
}
add_action( 'admin_init', 'my_custom_settings_init' );

/**
 * Callback function to display section description (optional).
 */
function my_settings_section_callback() {
	echo '<p>This is a description of my settings section.</p>';
}

/**
 * Callback function to display field input.
 */
function my_setting_field_callback() {
	$option_value = get_option( 'my_option_name' );
	?>
	<input type="text" name="my_option_name" value="<?php echo esc_attr( $option_value ); ?>">
	<?php
}

/**
 * Sanitization callback function.
 */
function my_sanitize_callback( $input ) {
	return sanitize_text_field( $input );
}

/**
 * Loads text domain for localization.
 */
function load_customkm_menu_textdomain() {
	load_plugin_textdomain( 'customkm-menu', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'load_customkm_menu_textdomain' );
