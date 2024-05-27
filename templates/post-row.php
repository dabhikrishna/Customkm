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
