<?php
/**
 * Plugin Name: Customkm Menu
 * Plugin URI: https://custom-plugin.com
 * Description: Customkm Plugin for your site.
 * Version: 6.5.2
 * Author: krishna
 * Author URI: http://custom-plugin.com
 * Text Domain: customkm_menu
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
function portfolio_submission_form_shortcode_function( $atts ) {
	// Shortcode functionality
	return 'This is an example shortcode output.';
}
add_shortcode( 'portfolio_submission_form', 'portfolio_submission_form_shortcode_function' );

// Add plugin page in admin menu
function example_plugin_menu() {
	add_menu_page(
		'Example Plugin Page',    // Page title
		'Plugin Page',         // Menu title
		'manage_options',         // Capability
		'example-plugin',         // Menu slug
		'example_plugin_page',    // Callback function
		'dashicons-admin-plugins', // Icon
		27 // Position of the menu in the admin sidebar
	);
}
add_action( 'admin_menu', 'example_plugin_menu' );

// Plugin page content
function example_plugin_page() {
	?>
	<div class="wrap">
		<h2>My Plugin Settings</h2>
		<!-- Create tabs navigation -->
		
		<h2 class="nav-tab-wrapper">
			<a href="?page=example-plugin&tab=pluginbasic" class="nav-tab <?php echo 'pluginbasic' === ( isset( $_GET['tab'] ) ? $_GET['tab'] : '' ) || ! isset( $_GET['tab'] ) ? 'nav-tab-active' : ''; ?>">Plugin Basic</a>
			<a href="?page=example-plugin&tab=shortcode" class="nav-tab <?php echo 'shortcode' === ( isset( $_GET['tab'] ) ? $_GET['tab'] : '' ) ? 'nav-tab-active' : ''; ?>">Shortcode</a>
			<a href="?page=example-plugin&tab=recentpost" class="nav-tab <?php echo 'recentpost' === ( isset( $_GET['tab'] ) ? $_GET['tab'] : '' ) ? 'nav-tab-active' : ''; ?>">Recent Post</a>
			<a href="?page=example-plugin&tab=fetchdata" class="nav-tab <?php echo 'fetchdata' === ( isset( $_GET['tab'] ) ? $_GET['tab'] : '' ) ? 'nav-tab-active' : ''; ?>">Fetch Data Shortcode</a>
		</h2>
	
		
		<!-- Display tab content -->
		<div class="tab-content">
			<?php
			$active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'pluginbasic';

			switch ( $active_tab ) {
				case 'pluginbasic':
					echo '<h3>Plugin Information</h3>';
					echo '<p>Plugin Name :  Customkm Menu</p>';
					echo '<p>Author :  Krishna</p>';
					echo '<p>Description : Customkm Plugin for your site.</p>';
					echo '<P>Version: 6.5.2</P>';
					break;
				case 'shortcode':
					echo '<h3>Shortcode Usage</h3>';
					echo '<p>Use the following shortcode to display dynamic content:</p>';
					echo '<code>[portfolio_submission_form]</code>';
					echo '<h3>Functionality of Shortcode</h3>';
					echo '<p>The <code>[portfolio_submission_form]</code> shortcode displays a simple message. You can customize the functionality by modifying the <code> portfolio_submission_form_shortcode_function </code>function in the plugin file.</p>';
					echo '<form id="portfolio_submission_form">
					<input type="hidden" name="action" value="portfolio_submission">

					<label for="name">Name:</label>
					<input type="text" id="name" name="name" autocomplete="name" required/><br><br>
					<label for="company_name">Company Name:</label>
					<input type="text" id="company_name" name="company_name" autocomplete="on" /><br><br>
					<label for="email">Email:</label>
					<input type="email" id="email" name="email" autocomplete="email" required/><br><br>
					<label for="phone">Phone:</label>
					<input type="tel" id="phone" name="phone" autocomplete="phone"/><br><br>
					<label for="address">Address:</label>
					<textarea id="address" name="address" autocomplete="address"></textarea><br><br>
					</form>';
					break;
				case 'recentpost':
					echo '<h3>Recent Post</h3>';
					echo '<p>Use the following shortcode to display dynamic content:</p>
					<code>[recent_portfolio_posts]</code>';
					echo 'using this shortcode you display recent posts from the portfolio.';
					break;
				case 'fetchdata':
					echo '<h3>Fetch Data Shortcode</h3>';
					echo '<p>Use the following shortcode to display dynamic content:</p>
					<code>[fetch_data]</code>';
					echo 'using this shortcode you display name of the field.';
					break;
				default:
					// Fallback if invalid tab is accessed
					echo '<h3>Invalid Tab</h3>';
					break;
			}
			?>
		</div>
	</div>
	
	<style>

.plugin-container {
	max-width: 600px;
	margin: 50px auto;
	background-color: #fff;
	padding: 20px;
	border-radius: 8px;
	box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
.plugin_container_shortcode
{
	margin-top:20px;
	max-width: 600px;
	margin: 50px auto;
	background-color: #fff;
	padding: 20px;
	border-radius: 8px;
	box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
.plugin_container_shortcode p {
	font-size: 16px;
	margin-bottom: 20px;
}
.plugin_container_shortcode code {
	font-size: 16px;
	margin-bottom: 20px;
}
.plugin-container p {
	font-size: 16px;
	margin-bottom: 20px;
}

	</style>
	<?php
}
// Enqueue CSS file
function your_plugin_enqueue_styles() {
	// Enqueue CSS file located within your plugin directory
	wp_enqueue_style( 'your-plugin-style', plugins_url( '/css/portfolio-submission-form.css', __FILE__ ), array(), '1.0', 'all' );
}
add_action( 'wp_enqueue_scripts', 'your_plugin_enqueue_styles' );

// Add custom menu page
function customkm_menu_page() {
	add_menu_page(
		'Customkm Menu',              // Page title
		'Customkm Menu',              // Menu title
		'manage_options',           // Capability
		'customkm-page-slug',         // Menu slug
		'customkm_page_content',      // Callback function
		'dashicons-admin-generic',  // Icon
		25                          // Position
	);
}
add_action( 'admin_menu', 'customkm_menu_page' );

// Custom page content
function customkm_page_content() {
	?>
	<div class="logo-container">
		<img src="<?php echo esc_url( plugins_url( 'images/custom-logo.png', __FILE__ ) ); ?>" alt="Plugin Logo">
	</div>
	<div class="wrap">
		<form action="" method="post">
			<?php wp_nonce_field( 'update_plugin_options', 'plugin_options_nonce' ); ?>
			Name: <input type="text" name="name" value="<?php echo esc_attr( get_option( 'name' ) ); ?>"/>
			<input type="submit" name="submit" value="Submit"/>
		</form>
	</div>
	<?php
}

// Save data using Option API
add_action( 'init', 'data_save_table' );
function data_save_table() {
	if ( isset( $_POST['plugin_options_nonce'] ) && wp_verify_nonce( $_POST['plugin_options_nonce'], 'update_plugin_options' ) ) {
		$data_to_store = $_POST['name'];
		$key           = 'name';
		update_option( $key, $data_to_store );
	}
}

// Add shortcode to fetch data
add_shortcode( 'fetch_data', 'fetch_data_shortcode' );
function fetch_data_shortcode() {
	$key        = 'name';                  // Specify the key used to save the data
	$saved_data = get_option( $key ); // Retrieve the saved data
	return $saved_data;             // Return the data
}

// Add submenu page using Settings API
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
	$args   = array(
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
	<?php wp_nonce_field( 'update_plugin_options', 'plugin_options_nonce' ); ?>
		<label for="client_name">Client Name:</label>
		<input type="text" id="client_name" name="client_name" value="<?php echo esc_attr( $client_name ); ?>">
	</p>
	<p>
	<?php wp_nonce_field( 'update_plugin_options', 'plugin_options_nonce' ); ?>
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
	if ( isset( $_POST['plugin_options_nonce'] ) && wp_verify_nonce( $_POST['plugin_options_nonce'], 'update_plugin_options' ) ) {
		update_post_meta( $post_id, 'client_name', sanitize_text_field( $_POST['client_name'] ) );
	}

	// Save project URL
	if ( isset( $_POST['plugin_options_nonce'] ) && wp_verify_nonce( $_POST['plugin_options_nonce'], 'update_plugin_options' ) ) {
		update_post_meta( $post_id, 'project_url', esc_url( $_POST['project_url'] ) );
	}
}
add_action( 'save_post', 'save_portfolio_custom_fields' );

// Modify the columns displayed in the portfolio post type admin table
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

// Display custom data in the columns of the portfolio post type admin table
function display_portfolio_custom_columns( $column, $post_id ) {
	//print_r( $post_id );
	//$data = get_post_meta( $post_id, 'company_name', true );
	//print_r( $data );
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

function custom_widget() {
	//echo 'ok';
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
// Create shortcode for form
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
	<form id="portfolio_submission_form">
		<input type="hidden" name="action" value="portfolio_submission">
		<?php wp_nonce_field( 'portfolio_submission_nonce', 'portfolio_submission_nonce_field' ); ?>
		<label for="name">Name:</label>
		<input type="text" id="name" name="name" autocomplete="name" required/><br><br>
		<label for="company_name">Company Name:</label>
		<input type="text" id="company_name" name="company_name" autocomplete="company_name" /><br><br>
		<label for="email">Email:</label>
		<input type="email" id="email" name="email" autocomplete="email" required/><br><br>
		<label for="phone">Phone:</label>
		<input type="tel" id="phone" name="phone" autocomplete="phone"/><br><br>
		<label for="address">Address:</label>
		<textarea id="address" name="address" autocomplete="address" rows="10" cols="50"></textarea><br><br>
		<input type="button" id="submit_btn" value="Submit">
	</form>
	<div id="response_msg"></div>
	</div>
	<script>
	jQuery(document).ready(function ($) {
		$('#submit_btn').on('click', function () {
			// Validate form fields
			var name = $('#name').val();
			var company = $('#company_name').val();
			var email = $('#email').val();
			var phone = $('#phone').val();
			var address = $('#address').val();

			// Email validation regex
			var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
			// Phone validation regex (accepts digits, spaces, dashes, parentheses)
			var phoneRegex = /^[0-9()-\s]+$/;

			// Check email format
			if (!emailRegex.test(email)) {
				$('#response_msg').html('<span style="color: red;">Please enter a valid email address.</span>');
				return;
			}
			// Check phone format
			if (!phoneRegex.test(phone)) {
				$('#response_msg').html('<span style="color: red;">Please enter a valid phone number.</span>');
				return;
			}
			// Check if any required field is empty
			if (name.trim() === '' || email.trim() === '' || company.trim() === '' || phone.trim() === '' || address.trim() === '') {
				$('#response_msg').html('<span style="color: red;">Please fill out all required fields.</span>');
				return;
			}
			

			var formData = $('#portfolio_submission_form').serialize();
			$.ajax({
				type: 'POST',
				url: '<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>',
				data: formData,
				success: function (response) {
					$('#response_msg').html(response);
					$('#portfolio_submission_form')[0].reset(); // Reset the form
				}
			});
		});
	});
</script>
	<?php
	return ob_get_clean();
}
add_shortcode( 'portfolio_submission_form', 'portfolio_submission_form_shortcode' );
// Process form submission
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
			// Create post object
			$portfolio_data = array(
				'post_title'  => $name,
				'post_type'   => 'portfolio',
				'post_status' => 'publish',
				'meta_input'  => array(
					'client_name' => $name,
					'email'       => $email,
					'phone'       => $phone,
					'address'     => $address,
				),
			);
			// Insert the post into the database
			$post_id = wp_insert_post( $portfolio_data );
			if ( is_wp_error( $post_id ) ) {
				echo 'Error: ' . esc_html( $post_id->get_error_message() );
			} else {
				echo 'Success! Your portfolio has been submitted.';
			}
		}
	}
	die();
}
add_action( 'wp_ajax_portfolio_submission', 'process_portfolio_submission' );
add_action( 'wp_ajax_nopriv_portfolio_submission', 'process_portfolio_submission' );

