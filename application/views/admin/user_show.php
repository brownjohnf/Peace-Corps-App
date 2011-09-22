<table id="datatable">
	<thead>
		<tr>
			<th>ID</th>
			<th>Group</th>
			<th>First</th>
			<th>Last</th>
			<th>Email</th>
			<th>Created</th>
			<th>Last Activity</th>
			<th>Admin</th>
	</thead>
	<tbody>
<?php if (isset($users)): foreach ($users as $user): ?>
		<tr>
			<td><?php echo anchor('admin/user/view/'.$user['id'], $user['id']); ?></td>
			<td><?php echo $user['name']; ?></td>
			<td><?php echo $user['fname']; ?></td>
			<td><?php echo $user['lname']; ?></td>
			<td><?php if (! is_null($user['email']) && $user['email'] !== '') {echo anchor('admin/user/update/'.$user['id'], $user['email']);} else {echo anchor('admin/user/update/'.$user['id'], 'No email');} ?></td>
			<td><?php echo date('dMY', $user['created_on']); ?></td>
			<td><?php echo date('H\:i\:s dMY', $user['last_activity']); ?></td>
			<td><?php echo anchor('admin/user/delete/'.$user['id'], 'Delete'); ?></td>
		</tr>
<?php endforeach; else: ?>

    <h2>No posts found</h2>
 
<?php endif; ?>
	</tbody>
</table>