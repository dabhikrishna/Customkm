<?php
/**
 * Table row for displaying portfolio information.
 *
 * This file represents an HTML table row for displaying portfolio information.
 * It includes columns for title, client name, address, email, phone, company, date, and a delete button.
 * The delete button includes data attributes for post ID and nonce for security.
 *
 * @since      1.0.0
 *
 * @package    Customkm Menu
 * @subpackage customkm-menu/templates
 */
?>
<tr style="background-color: #ddd;">
	<td><?php echo esc_html( get_the_title( $post_id ) ); ?></td>
	<td><?php echo esc_html( $client_name ); ?></td>
	<td><?php echo esc_html( $address ); ?></td>
	<td><?php echo esc_html( $email ); ?></td>
	<td><?php echo esc_html( $phone ); ?></td>
	<td><?php echo esc_html( $company ); ?></td>
	<td><?php echo esc_html( get_the_date() ); ?></td>
	<td><button class="delete-post-button" data-post-id="<?php echo esc_html( $post_id ); ?>" data-nonce="<?php echo esc_attr( wp_create_nonce( 'delete_post_nonce' ) ); ?>">Delete Post</button></td>
</tr></br>
