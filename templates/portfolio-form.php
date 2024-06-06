<?php
/**
 * HTML form for portfolio submission.
 *
 * This file represents an HTML form for submitting portfolio information.
 * It includes fields for name, company name, email, phone, and address.
 * It also includes a nonce field for security.
 *
 * @since      1.0.0
 *
 * @package    Customkm Menu
 * @subpackage customkm-menu/templates
 */
?>
<div class="my">
	<h2 style="font-weight: bold;"><?php echo esc_html( $atts['title'] ); ?></h2>
<form id="portfolio_submission_form">
		<input type="hidden" name="action" value="portfolio_submission">
		<?php wp_nonce_field( 'portfolio_submission_nonce', 'portfolio_submission_nonce_field' ); ?>
		<label for="name"><?php echo esc_html__( 'Name:', 'customkm-menu' ); ?></label>
		<input type="text" id="name" name="name" autocomplete="name" required/><br><br>
		<label for="company_name"><?php echo esc_html__( 'Company Name:', 'customkm-menu' ); ?></label>
		<input type="text" id="company_name" name="company_name" autocomplete="company_name" /><br><br>
		<label for="email"><?php echo esc_html__( 'Email:', 'customkm-menu' ); ?></label>
		<input type="email" id="email" name="email" autocomplete="email" required/><br><br>
		<label for="phone"><?php echo esc_html__( 'Phone:', 'customkm-menu' ); ?></label>
		<input type="tel" id="phone" name="phone" autocomplete="phone"/><br><br>
		<label for="address"><?php echo esc_html__( 'Address:', 'customkm-menu' ); ?></label>
		<textarea id="address" name="address" autocomplete="address" rows="10" cols="50"></textarea><br><br>
		<input type="button" id="submit_btn" value="Submit">
	</form>
	<div id="response_msg"></div>
	</div>
	