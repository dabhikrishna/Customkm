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
<<<<<<< HEAD
<<<<<<<< HEAD:templates/custom-submenu.php
	<h2><?php echo esc_html__( 'My Submenu Page', 'customkm-menu' ); ?></h2>
========
	<h2>My Submenu Page</h2>
>>>>>>>> a6719ac514c5ab92aa59c39115dbb0e99ff6b942:includes/templates/custom-submenu.php
	<form method="post" action="options.php">
		<?php
		// Display settings fields
		settings_fields( 'my-custom-settings-group' );
		do_settings_sections( 'my-custom-settings-group' );
		?>
		<input type="submit" class="button-primary" value="Save Changes">
	</form>
</div>
<<<<<<<< HEAD:templates/custom-submenu.php
	
========
>>>>>>>> a6719ac514c5ab92aa59c39115dbb0e99ff6b942:includes/templates/custom-submenu.php
=======
		<h2><?php echo esc_html__( 'My Submenu Page', 'customkm-menu' ); ?></h2>
		<form method="post" action="options.php">
			<?php
			// Display settings fields
			settings_fields( 'my-custom-settings-group' );
			do_settings_sections( 'my-custom-settings-group' );
			?>
			<input type="submit" class="button-primary" value="Save Changes">
		</form>
	</div>
	
>>>>>>> a6719ac514c5ab92aa59c39115dbb0e99ff6b942