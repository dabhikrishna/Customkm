<div id="page-content"></div>
<script type="text/html" id="tmpl-portfolio">
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
				<th>ID</th>
				<th>Title</th>
				<th>Address</th>
				<th>Phone</th>
				<th>Email</th>
				<th>Company Name</th>
				<th>Sent Mail</th>
				<th>Delete</th>
			</tr>
			
		</thead>
		<tbody>
			
			<# _.each( data, function ( item ) { #>
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
			<# } ) #>
		</tbody>
	</table>
</script>

