<?php
/**
 * Plugin settings page.
 *
 * This file represents the settings page for the plugin. It allows users to configure
 * plugin settings such as the name using the WordPress Options API.
 *
 * @since      1.0.0
 *
 * @package    Customkm Menu
 * @subpackage customkm-menu/templates
 */

// Wrap the content in a div with the class 'logo-container' to display the plugin logo.
?>
<div class="logo-container">
		<img src="<?php echo esc_url( plugins_url( 'images/custom-logo.png', __FILE__ ) ); ?>" alt="Plugin Logo">
	</div>
	<div class="wrap">
		<form action="" method="post">
			<?php wp_nonce_field( 'update_plugin_options', 'plugin_options_nonce' ); ?>
			<?php echo esc_html__( 'Name', 'customkm-menu' ); ?> <input type="text" name="name" value="<?php echo esc_attr( get_option( 'name' ) ); ?>"/>
			<input type="submit" name="submit" value="Submit"/>
		</form>
	</div>