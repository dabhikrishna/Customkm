<form method="post">
	<?php wp_nonce_field( 'update_plugin_options', 'plugin_options_nonce' ); ?>
	<label for="client_name">Client Name:</label>
	<input type="text" name="client_name" id="client_name" value="" />
	<label for="project_url">Project URL:</label>
	<input type="url" name="project_url" id="project_url" value="" />
</form>