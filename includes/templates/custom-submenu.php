<?php
/**
 * Submenu settings page.
 *
 * This file represents the submenu settings page for the WordPress plugin. It allows users to configure
 * settings related to the version package for the application.
 *
 * @since      1.0.0
 *
 * @package    Customkm Menu
 * @subpackage customkm-menu/templates
 */

// Wrap the content in a div with the class 'wrap' to style it appropriately.
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
