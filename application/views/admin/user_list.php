<table id="datatable">
	<thead>
		<tr>
			<th>Group</th>
			<th>First</th>
			<th>Last</th>
			<th>Action</th>
	</thead>
	<tbody>
<?php if (isset($users)): foreach ($users as $user): ?>
		<tr>
			<td><?php echo $user['name']; ?></td>
			<td><?php echo $user['fname']; ?></td>
			<td><?php echo $user['lname']; ?></td>
			<td><?php echo anchor('admin/page/add_editor/'.$page_id.'/'.$user['id'], 'Add as Editor'); ?></td>
		</tr>
<?php endforeach; else: ?>

    <h2>No Users found</h2>
 
<?php endif; ?>
	</tbody>
</table>