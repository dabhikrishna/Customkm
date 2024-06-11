<?php
/**
 * Plugin settings page for custom AJAX plugin.
 *
 * @since      1.0.0
 *
 * @package    Customkm Menu
 * @subpackage customkm-menu/templates
 */

// Wrap the content in a div with the class 'wrap'.
?>
<div class="wrap">
<<<<<<< HEAD
	<h2><?php echo esc_html__( 'Custom AJAX Plugin Settings', 'customkm-menu' ); ?></h2>
	<form id="store-name-form">
<<<<<<<< HEAD:templates/custom-ajax.php
	<?php wp_nonce_field( 'custom_ajax_plugin_ajax_nonce', 'plugin_options_nonce' ); ?>
========
		<?php wp_nonce_field( 'custom_ajax_plugin_ajax_nonce', 'plugin_options_nonce' ); ?>
>>>>>>>> a6719ac514c5ab92aa59c39115dbb0e99ff6b942:includes/templates/custom-ajax.php
		<label for="store-name"><?php echo esc_html__( 'Store Name', 'customkm-menu' ); ?></label>
			<input type="text" id="store-name" name="store_name" value="<?php echo esc_attr( get_option( 'store_name' ) ); ?>">
			<input type="submit" value="Save">
	</form>
	<div id="store-name-result"></div>
</div>
<<<<<<<< HEAD:templates/custom-ajax.php
	
========
>>>>>>>> a6719ac514c5ab92aa59c39115dbb0e99ff6b942:includes/templates/custom-ajax.php
=======
		<h2><?php echo esc_html__( 'Custom AJAX Plugin Settings', 'customkm-menu' ); ?></h2>
		<form id="store-name-form">
		<?php wp_nonce_field( 'custom_ajax_plugin_ajax_nonce', 'plugin_options_nonce' ); ?>
		<label for="store-name"><?php echo esc_html__( 'Store Name', 'customkm-menu' ); ?></label>
			<input type="text" id="store-name" name="store_name" value="<?php echo esc_attr( get_option( 'store_name' ) ); ?>">
			<input type="submit" value="Save">
		</form>
		<div id="store-name-result"></div>
	</div>
	
>>>>>>> a6719ac514c5ab92aa59c39115dbb0e99ff6b942
