<?php
/**
 * HTML form for updating plugin options.
 *
 * This file represents an HTML form for updating plugin options, such as client name and project URL.
 * It includes fields for client name and project URL, and it also includes a nonce field for security.
 *
 * @since      1.0.0
 *
 * @package    Customkm Menu
 * @subpackage customkm-menu/templates
 */
?>
<form method="post">
	<?php wp_nonce_field( 'update_plugin_options', 'plugin_options_nonce' ); ?>
	<label for="client_name"><?php echo esc_html__( 'Client Name:', 'customkm-menu' ); ?></label>
	<input type="text" name="client_name" id="client_name" value="" />
	<label for="project_url"><?php echo esc_html__( 'Project URL:', 'customkm-menu' ); ?></label>
	<input type="url" name="project_url" id="project_url" value="" />
</form>
