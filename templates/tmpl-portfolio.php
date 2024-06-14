<div id="page-content"></div>
<script type="text/html" id="tmpl-portfolio">
	<# if (data.length > 0) { #>
		<style>
			th {
				border: 1px solid #ddd;
				padding: 8px;
				text-align: left;
				background-color: #f2f2f2;
			}
		</style>
		<table>
			<thead>
				<tr>
				<th><?php echo esc_html__( 'ID', 'customkm-menu' ); ?></th>
				<th><?php echo esc_html__( 'Title', 'customkm-menu' ); ?></th>
				<th><?php echo esc_html__( 'Address', 'customkm-menu' ); ?></th>
				<th><?php echo esc_html__( 'Phone', 'customkm-menu' ); ?></th>
				<th><?php echo esc_html__( 'Email', 'customkm-menu' ); ?></th>
				<th><?php echo esc_html__( 'Company Name', 'customkm-menu' ); ?></th>
				<th><?php echo esc_html__( 'Sent Mail', 'customkm-menu' ); ?></th>
				<th><?php echo esc_html__( 'Delete', 'customkm-menu' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<# _.each(data, function(item) { #>
					<tr style="background-color: #ddd;">
						<td>{{ item.id }}</td>
						<td>{{ item.title }}</td>
						<td>{{ item.address }}</td>
						<td>{{ item.phone }}</td>
						<td>{{ item.email }}</td>
						<td>{{ item.company_name }}</td>
						<td>{{ item.mail }}</td>
						<td>
							<button data-post-id="{{ item.id }}" class="delete-post">Delete Post</button>
						</td>
					</tr>
				<# }); #>
			</tbody>
		</table>
	<# } else { #>
		<p>No portfolio posts found.</p>
	<# } #>
</script>
