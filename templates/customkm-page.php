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