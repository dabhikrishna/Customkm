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