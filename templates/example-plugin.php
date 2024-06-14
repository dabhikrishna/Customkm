<?php
/**
 * Plugin settings page.
 *
 * This file represents the settings page for the plugin. It allows users to configure
 * plugin settings and provides tabbed navigation for different sections using WordPress
 * nonce fields for security.
 *
 * @since      1.0.0
 *
 * @package    Customkm Menu
 * @subpackage customkm-menu/templates
 */

// Wrap the content in a div with the class 'wrap'.
?>
<div class="wrap">
	<h2><?php echo esc_html__( 'My Plugin Settings', 'customkm-menu' ); ?></h2>
	<!-- Create tabs navigation -->
	<h2 class="nav-tab-wrapper">
	<?php
	// Generate nonce
	$nonce = wp_create_nonce( 'example-plugin-submenu-nonce' );
	// Append nonce to the link URL
	$link_url = add_query_arg( '_wpnonce', $nonce, '?page=example-plugin-submenu&tab=pluginbasic' );
	?>
	<a href="<?php echo esc_url( $link_url ); ?>" class="nav-tab <?php echo ( isset( $_GET['_wpnonce'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'example-plugin-nonce' ) ) || ! isset( $_GET['tab'] ) ? 'nav-tab-active' : ''; ?>"><?php echo esc_html__( 'Plugin Basic', 'customkm-menu' ); ?></a>
	<a href="?page=example-plugin-submenu&tab=shortcode" class="nav-tab <?php echo 'shortcode' === ( isset( $_GET['tab'] ) ? $_GET['tab'] : '' ) ? 'nav-tab-active' : ''; ?>"><?php echo esc_html__( 'Shortcode', 'customkm-menu' ); ?></a>
	<!-- Add nonce fields for each form -->
	<?php wp_nonce_field( 'example-plugin-action', 'example-plugin-nonce' ); ?>
	<a href="?page=example-plugin-submenu&tab=recentpost" class="nav-tab <?php echo 'recentpost' === ( isset( $_GET['tab'] ) ? $_GET['tab'] : '' ) ? 'nav-tab-active' : ''; ?>"><?php echo esc_html__( 'Recent Post', 'customkm-menu' ); ?></a>
	<a href="?page=example-plugin-submenu&tab=fetchdata" class="nav-tab <?php echo 'fetchdata' === ( isset( $_GET['tab'] ) ? $_GET['tab'] : '' ) ? 'nav-tab-active' : ''; ?>"><?php echo esc_html__( 'Fetch Data Shortcode', 'customkm-menu' ); ?></a>
	<a href="?page=example-plugin-submenu&tab=email_settings" class="nav-tab <?php echo 'email_settings' === ( isset( $_GET['tab'] ) ? $_GET['tab'] : '' ) ? 'nav-tab-active' : ''; ?>"><?php echo esc_html__( 'Email Settings', 'customkm-menu' ); ?></a>
</h2>
<!-- Display tab content -->
<div class="tab-content">
	<?php
	$active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'pluginbasic';
	// Verify nonce
	if ( isset( $_GET['_wpnonce'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'example-plugin-nonce' ) ) :
		?>
	<?php else : ?>
		<?php // Nonce is invalid or missing, handle accordingly (e.g., show an error message) ?>
	<?php endif; ?>

	<?php
	switch ( $active_tab ) :
		case 'pluginbasic':
			?>
			<h3><?php echo esc_html__( 'Plugin Information', 'customkm-menu' ); ?></h3>
			<p><?php echo esc_html__( 'Plugin Name : Customkm Menu', 'customkm-menu' ); ?></p>
			<p><?php echo esc_html__( 'Author : Krishna', 'customkm-menu' ); ?></p>
			<p><?php echo esc_html__( 'Description : Customkm Plugin for your site.', 'customkm-menu' ); ?></p>
			<P><?php echo esc_html__( 'Version: 1.0.0', 'customkm-menu' ); ?></P>
			<?php
			break;
		case 'shortcode':
			?>
			<h3><?php echo esc_html__( 'Shortcode Usage', 'customkm-menu' ); ?></h3>
			<p><?php echo esc_html__( 'Use the following shortcode to display dynamic content:', 'customkm-menu' ); ?></p>
			<code><?php echo esc_html__( '[portfolio_submission_form]', 'customkm-menu' ); ?></code>
			<h3><?php echo esc_html__( 'Functionality of Shortcode', 'customkm-menu' ); ?></h3>
			<p><?php echo esc_html__( 'The [portfolio_submission_form] shortcode displays a simple message. You can customize the functionality by modifying the  portfolio_submission_form_shortcode_function function in the plugin file.', 'customkm-menu' ); ?></p>
			<form id="portfolio_submission_form1">
				<input type="hidden" name="action" value="portfolio_submission">

				<label for="name"><?php echo esc_html__( 'Name:', 'customkm-menu' ); ?></label>
				<input type="text" id="name" name="name" autocomplete="name" required/><br><br>
				<label for="company_name"><?php echo esc_html__( 'Company Name:', 'customkm-menu' ); ?></label>
				<input type="text" id="company_name" name="company_name" autocomplete="on" /><br><br>
				<label for="email"><?php echo esc_html__( 'Email:', 'customkm-menu' ); ?></label>
				<input type="email" id="email" name="email" autocomplete="email" required/><br><br>
				<label for="phone"><?php echo esc_html__( 'Phone:', 'customkm-menu' ); ?></label>
				<input type="tel" id="phone" name="phone" autocomplete="phone"/><br><br>
				<label for="address"><?php echo esc_html__( 'Address:', 'customkm-menu' ); ?></label>
				<textarea id="address" name="address" autocomplete="address"></textarea><br><br>
			</form>
			<?php
			break;
		case 'recentpost':
			?>
			<h3><?php echo esc_html__( 'Recent Post', 'customkm-menu' ); ?></h3>
			<p><?php echo esc_html__( 'Use the following shortcode to display dynamic content:', 'customkm-menu' ); ?></p>
			<code><?php echo esc_html__( '[recent_portfolio_posts]', 'customkm-menu' ); ?></code>
			<p><?php echo esc_html__( 'using this shortcode you display recent posts from the portfolio.', 'customkm-menu' ); ?></p>
			<?php
			break;
		case 'fetchdata':
			?>
			<h3><?php echo esc_html__( 'Fetch Data Shortcode', 'customkm-menu' ); ?></h3>
			<p><?php echo esc_html__( 'Use the following shortcode to display dynamic content:', 'customkm-menu' ); ?></p>
			<code><?php echo esc_html__( '[fetch_data]', 'customkm-menu' ); ?></code>
			<p><?php echo esc_html__( 'using this shortcode you display name of the field.', 'customkm-menu' ); ?></p>
			<?php
			break;
		case 'email_settings':
			if ( isset( $_POST['submit'] ) && wp_verify_nonce( $_POST['settings_nonce'], 'settings_action' ) ) {
					// Save settings
					$email_notifications = isset( $_POST['email_notifications'] ) ? 1 : 0;
					update_option( 'email_notifications', $email_notifications );
					$notification_frequency = isset( $_POST['notification_frequency'] ) ? sanitize_text_field( $_POST['notification_frequency'] ) : 'daily';
					update_option( 'notification_frequency', $notification_frequency );
					// Display success message
				?>
					<div class="updated"><p><?php esc_html_e( 'Settings saved successfully.', 'portfolio' ); ?></p></div>
					<?php
			}
				// Retrieve current settings
				$email_notifications = get_option( 'email_notifications', 1 );
				$notification_frequency = get_option( 'notification_frequency', 'daily' );
			// Display the form
			?>
				<h3><?php echo esc_html__( 'Email Settings', 'customkm-menu' ); ?></h3>
				<form method="post" action="">
				<table class="form-table">
					<?php wp_nonce_field( 'settings_action', 'settings_nonce' ); ?>
					<tr>
					<th>
					<label for="email_notifications"><?php echo esc_html__( 'Email Notifications:', 'customkm-menu' ); ?></label>
					</th>
					<td>
					<input type="checkbox" id="email_notifications" name="email_notifications" <?php checked( $email_notifications, 1 ); ?> /><br><br>
					</td>
					</tr>
					<tr>
					<th>
					<label for="notification_frequency"><?php echo esc_html__( 'Notification Frequency:', 'customkm-menu' ); ?></label>
					</th>
					<td>
					<select id="notification_frequency" name="notification_frequency">
						<option value="daily" <?php selected( $notification_frequency, 'daily' ); ?>><?php echo esc_html__( 'Daily', 'customkm-menu' ); ?></option>
						<option value="hourly" <?php selected( $notification_frequency, 'hourly' ); ?>><?php echo esc_html__( 'hourly', 'customkm-menu' ); ?></option>
						<option value="weekly" <?php selected( $notification_frequency, 'weekly' ); ?>><?php echo esc_html__( 'Weekly', 'customkm-menu' ); ?></option>
						<option value="monthly" <?php selected( $notification_frequency, 'monthly' ); ?>><?php echo esc_html__( 'Monthly', 'customkm-menu' ); ?></option>
					</select><br><br>
					</td>
					</tr>
					</table>
					<input type="submit" name="submit" value="<?php echo esc_attr__( 'Save Settings', 'customkm-menu' ); ?>" class="button button-primary" />
				</form>
				<?php
			break;
		default:
			?>
			<h3><?php echo esc_html__( 'Invalid Tab', 'customkm-menu' ); ?></h3>
			<?php
			break;
	endswitch;
	?>
</div>
</div>
