<?php
namespace CustomkmMenu\Includes;

/**
 * Class Email_Details
 * Handles functionality related to displaying sent email details.
 *
 * @package CustomkmMenu\Includes
 * @since 1.0.0
 */
class Email_Details {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_shortcode( 'customkm_sent_emails', array( $this, 'customkm_display_sent_emails' ) );
	}

	/**
	 * Retrieves sent emails and outputs them in a list.
	 *
	 * @return string Output HTML for displaying sent email details.
	 */
	public function customkm_display_sent_emails() {
		$sent_emails = get_posts(
			array(
				'post_type'      => 'portfolio',
				'meta_key'       => 'email',
				'posts_per_page' => -1,
			)
		);

		// Display sent emails
		$output = '';
		if ( $sent_emails ) {
			$output .= '<ul>';
			foreach ( $sent_emails as $email ) {
				$email_address = get_post_meta( $email->ID, 'email', true );
				$sent_time     = get_post_meta( $email->ID, 'mail', true );
				$output .= '<li>Email: ' . $email_address . ' - Sent Time: ' . $sent_time . '</li>';
			}
			$output .= '</ul>';
		} else {
			$output = esc_html__( 'No emails have been sent yet.', 'customkm-menu' );
		}

		return $output;
	}
}
