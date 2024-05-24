<form id="portfolio_submission_form">
		<input type="hidden" name="action" value="portfolio_submission">
		<?php wp_nonce_field( 'portfolio_submission_nonce', 'portfolio_submission_nonce_field' ); ?>
		<label for="name">Name:</label>
		<input type="text" id="name" name="name" autocomplete="name" required/><br><br>
		<label for="company_name">Company Name:</label>
		<input type="text" id="company_name" name="company_name" autocomplete="company_name" /><br><br>
		<label for="email">Email:</label>
		<input type="email" id="email" name="email" autocomplete="email" required/><br><br>
		<label for="phone">Phone:</label>
		<input type="tel" id="phone" name="phone" autocomplete="phone"/><br><br>
		<label for="address">Address:</label>
		<textarea id="address" name="address" autocomplete="address" rows="10" cols="50"></textarea><br><br>
		<input type="button" id="submit_btn" value="Submit">
	</form>