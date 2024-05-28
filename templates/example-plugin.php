<div class="wrap">
		<h2>My Plugin Settings</h2>
		<!-- Create tabs navigation -->
		<h2 class="nav-tab-wrapper">
	<?php
	// Generate nonce
	$nonce = wp_create_nonce( 'example-plugin-nonce' );
	// Append nonce to the link URL
	$link_url = add_query_arg( '_wpnonce', $nonce, '?page=example-plugin&tab=pluginbasic' );
	?>
	<a href="<?php echo esc_url( $link_url ); ?>" class="nav-tab <?php echo ( isset( $_GET['_wpnonce'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'example-plugin-nonce' ) ) || ! isset( $_GET['tab'] ) ? 'nav-tab-active' : ''; ?>">Plugin Basic</a>
</h2>


	<a href="?page=example-plugin&tab=shortcode" class="nav-tab <?php echo 'shortcode' === ( isset( $_GET['tab'] ) ? $_GET['tab'] : '' ) ? 'nav-tab-active' : ''; ?>">Shortcode</a>
	<!-- Add nonce fields for each form -->
	<?php wp_nonce_field( 'example-plugin-action', 'example-plugin-nonce' ); ?>
	<a href="?page=example-plugin&tab=recentpost" class="nav-tab <?php echo 'recentpost' === ( isset( $_GET['tab'] ) ? $_GET['tab'] : '' ) ? 'nav-tab-active' : ''; ?>">Recent Post</a>
	<a href="?page=example-plugin&tab=fetchdata" class="nav-tab <?php echo 'fetchdata' === ( isset( $_GET['tab'] ) ? $_GET['tab'] : '' ) ? 'nav-tab-active' : ''; ?>">Fetch Data Shortcode</a>
</h2>
<!-- Display tab content -->
<div class="tab-content">
	<?php
	$active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'pluginbasic';
	// Verify nonce
	if ( isset( $_GET['_wpnonce'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'example-plugin-nonce' ) ) {
		echo 'nonce verification done';
	} else {
		echo '';
		// Nonce is invalid or missing, handle accordingly (e.g., show an error message)
	}



	switch ( $active_tab ) {
		case 'pluginbasic':
			echo '<h3>Plugin Information</h3>';
			echo '<p>Plugin Name :  Customkm Menu</p>';
			echo '<p>Author :  Krishna</p>';
			echo '<p>Description : Customkm Plugin for your site.</p>';
			echo '<P>Version: 6.5.2</P>';
			break;
		case 'shortcode':
			echo '<h3>Shortcode Usage</h3>';
			echo '<p>Use the following shortcode to display dynamic content:</p>';
			echo '<code>[portfolio_submission_form]</code>';
			echo '<h3>Functionality of Shortcode</h3>';
			echo '<p>The <code>[portfolio_submission_form]</code> shortcode displays a simple message. You can customize the functionality by modifying the <code> portfolio_submission_form_shortcode_function </code>function in the plugin file.</p>';
			echo '<form id="portfolio_submission_form1">
					<input type="hidden" name="action" value="portfolio_submission">

					<label for="name">Name:</label>
					<input type="text" id="name" name="name" autocomplete="name" required/><br><br>
					<label for="company_name">Company Name:</label>
					<input type="text" id="company_name" name="company_name" autocomplete="on" /><br><br>
					<label for="email">Email:</label>
					<input type="email" id="email" name="email" autocomplete="email" required/><br><br>
					<label for="phone">Phone:</label>
					<input type="tel" id="phone" name="phone" autocomplete="phone"/><br><br>
					<label for="address">Address:</label>
					<textarea id="address" name="address" autocomplete="address"></textarea><br><br>
					</form>';
			break;
		case 'recentpost':
			echo '<h3>Recent Post</h3>';
			echo '<p>Use the following shortcode to display dynamic content:</p>
					<code>[recent_portfolio_posts]</code>';
			echo 'using this shortcode you display recent posts from the portfolio.';
			break;
		case 'fetchdata':
			echo '<h3>Fetch Data Shortcode</h3>';
			echo '<p>Use the following shortcode to display dynamic content:</p>
					<code>[fetch_data]</code>';
			echo 'using this shortcode you display name of the field.';
			break;
		default:
			// Fallback if invalid tab is accessed
			echo '<h3>Invalid Tab</h3>';
			break;
	}
	?>
		</div>
	</div>