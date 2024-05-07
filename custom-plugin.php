<?php
/**
* Plugin Name: Custom Menu

* Description: Test.
* Version: 0.1
* Author: your-name

**/





function custom_menu_page()
{
     add_menu_page('Custom Menu','Custom Menu','manage_options','custom-page-slug','custom_page_content','dashicons-admin-generic',25);
}
add_action('admin_menu','custom_menu_page');

function custom_page_content()
{
    ?>
     <div class="wrap">
    <form action ="" method="post" >
    <?php wp_nonce_field( 'update_plugin_options', 'plugin_options_nonce' ); ?>
  name   <input type="text" name="name" value="<?php echo esc_attr(get_option('name'));?>"/>
  <input type="submit" name="submit" value="submit"/>
</form>
</div>

<?php
}

add_action( 'init', 'data_save_table' );
function data_save_table( )
{
    if ( isset( $_POST['plugin_options_nonce'] ) && wp_verify_nonce( $_POST['plugin_options_nonce'], 'update_plugin_options' ) ) 
        // Nonce is valid, process the form submission
   
    
    {
        $data_to_store = $_POST['name'];
        $key = 'name';
      
        update_option( $key, $data_to_store );
      

    }
}

add_shortcode('fetch_data', 'fetch_data_shortcode');
function fetch_data_shortcode() {
    $key = 'name'; // Specify the key used to save the data
    $saved_data = get_option($key); // Retrieve the saved data
    return $saved_data; // Return the data
}
/*using Option API*/
function my_plugin_submenu_page() {
    add_submenu_page(
        'options-general.php', // Parent menu slug
        'My Plugin Settings', // Page title
        'My Plugin', // Menu title
        'manage_options', // Capability
        'my-plugin-submenu', // Menu slug
        'my_plugin_submenu_settings_page' // Callback function
    );
}
add_action('admin_menu', 'my_plugin_submenu_page');
function my_plugin_submenu_settings_page() {
    ?>
    <div class="wrap">
        <h2>My Plugin Settings</h2>
        <form method="post" action="">
        
           
            Add Data <input type="text"  name="my_data" value="<?php echo esc_attr(get_option('my_data')); ?>"/>
            <input type="submit" name="submit" value="submit">
        </form>
    </div>
    <?php
}


add_action( 'init', 'data_save_table2' );
function data_save_table2( )
{
    if(isset($_POST['submit']))
    {
        $data_to_store1 = $_POST['my_data'];
        $keys = 'my_data';
      
        update_option( $keys, $data_to_store1 );
      

    }
}
add_shortcode('fetch_data_value', 'fetch_data_value_shortcode');
function fetch_data_value_shortcode() {
    $key = 'my_data'; // Specify the key used to save the data
    $saved_data = get_option($key); // Retrieve the saved data
    return $saved_data; // Return the data
}

/*done using Option API*/


/*using Settings API*/
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

/*done using Settings API*/
