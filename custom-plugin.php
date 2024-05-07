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
  name   <input type="text" name="name" value="<?php echo get_option('name');?>"/>
  <input type="submit" name="submit" value="submit"/>
</form>
</div>

<?php
}

add_action( 'init', 'data_save_table' );
function data_save_table( )
{
    if(isset($_POST['submit']))
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
        
            <label for="my_plugin_option">My Option:</label>
            <input type="text"  name="my_plugin_option" value="<?php echo esc_attr(get_option('my_plugin_option')); ?>">
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
        $data_to_store1 = $_POST['my_plugin_option'];
        $keys = 'my_plugin_option';
      
        update_option( $keys, $data_to_store1 );
      

    }
}
add_shortcode('fetch_data_value', 'fetch_data_value_shortcode');
function fetch_data_value_shortcode() {
    $key = 'my_plugin_option'; // Specify the key used to save the data
    $saved_data = get_option($key); // Retrieve the saved data
    return $saved_data; // Return the data
}

/*function custom_settings_menu() {
    add_options_page( 'Custom Settings', 'Custom Settings', 'manage_options', 'custom-settings', 'custom_settings_page' );
}
add_action( 'admin_menu', 'custom_settings_menu' );

// Callback function to render the settings page
function custom_settings_page() {
    ?>
    <div class="wrap">
        <h2>Custom Settings</h2>
        <form method="post" action="options.php">
            <?php
            // Output security fields for the registered setting "custom_settings_group"
            settings_fields( 'custom_settings_group' );
            // Output settings sections and their fields
            do_settings_sections( 'custom-settings' );
            // Output save settings button
            submit_button();
            ?>
        </form>
    </div>
    <?php
}
function custom_settings_init() {
    // Register a new setting for "custom-settings" page
    register_setting( 'custom_settings_group', 'custom_setting_name' );

    // Add a section to the settings page
    add_settings_section( 'custom_settings_section', 'Custom Settings Section', 'custom_settings_section_callback', 'custom-settings' );

    // Add a field to the settings section
    add_settings_field( 'custom_setting_field', 'Custom Setting Field', 'custom_setting_field_callback', 'custom-settings', 'custom_settings_section' );
}
add_action( 'admin_init', 'custom_settings_init' );

// Callback functions to render settings section and fields
function custom_settings_section_callback() {
    echo 'This is a section description.';
}

function custom_setting_field_callback() {
    $setting = get_option( 'custom_setting_name' );
    echo "<input type='text' name='custom_setting_name' value='$setting' />";
}
add_action( 'init', 'data_save_table1' );
function data_save_table1( )
{
    if(isset($_POST['submit']))
    {
        $data_to_store = $_POST['custom_setting_name'];
        $key = 'name';
      
        update_option( $key, $data_to_store );
      

    }
}*/