<div class="wrap">
		<h1><?php esc_html_e( 'Email Settings', 'portfolio' ); ?></h1>
		<p><?php esc_html_e( 'Please Select Email notification send notification enable Or disable', 'portfolio' ); ?></p>	
		<form method="post" action="">
			<?php wp_nonce_field( 'settings_action', 'settings_nonce' ); ?>
			<table class="form-table">
				<tr>
					<th scope="row"><?php esc_html_e( 'Email Notifications', 'portfolio' ); ?></th>
					<td>
						<label>
							<input type="checkbox" name="email_notifications" <?php checked( $email_notifications, 'on' ); ?> />
							<?php esc_html_e( 'Enable email notifications', 'portfolio' ); ?>
						</label>
					</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Notification Frequency', 'portfolio' ); ?></th>
					<td>
						<select name="notification_frequency">
						    <option value="daily" <?php selected( $notification_frequency, 'daily' ); ?>><?php esc_html_e( 'Daily', 'portfolio' ); ?></option>
							<option value="weekly" <?php selected( $notification_frequency, 'weekly' ); ?>><?php esc_html_e( 'Weekly', 'portfolio' ); ?></option>
							<option value="monthly" <?php selected( $notification_frequency, 'monthly' ); ?>><?php esc_html_e( 'Monthly', 'portfolio' ); ?></option>
						</select>
				,</td>
				</tr>
			</table>

			<input type="hidden" name="submit" value="on" />
			<?php submit_button( esc_html__( 'Save Settings', 'portfolio' ), 'primary', 'submit', false ); ?>
		</form>
</div>