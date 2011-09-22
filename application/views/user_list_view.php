<div id="user_list_view" class="content">
<?php
if ($this->session->flashdata('error'))
{
    $this->load->view('error');
}
if ($this->session->flashdata('success'))
{
    $this->load->view('success');
}
?>

	<div id="backtrack">
	<?php foreach ($backtrack as $key => $value): ?>
		<?php echo anchor($key, $value); ?>&nbsp;>&nbsp;
	<? endforeach; ?>
	</div>
	
	<table id="datatable">
		<thead>
			<tr>
				<th>Controls</th>
				<th>PC ID</th>
				<th>Facebook ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Group</th>
				<th>Sector</th>
				<th>Email</th>
				<th>Blog Name</th>
				<th>Blog Desc</th>
				<th>Blog Address</th>
				<th>Phone</th>
				<th>Stage</th>
				<th>COS</th>
				<th>Project</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($table as $row): ?>
			<tr>
				<td><?php echo anchor('user/edit/'.$row['id'], 'Edit'); ?></td>
				<td class=""><?=$row['pc_id']?></td>
				<td class=""><?=$row['fb_id']?></td>
				<td class=""><?php echo anchor('profile/view/'.url_title($row['lname'].'-'.$row['fname'], 'dash', true), $row['fname']); ?></td>
				<td class=""><?php echo anchor('profile/view/'.url_title($row['lname'].'-'.$row['fname'], 'dash', true), $row['lname']); ?></td>
				<td class=""><?=$row['group_name']?></td>
				<td class=""><?=$row['sector_name']?></td>
				<td class=""><?=$row['email']?></td>
				<td class=""><?=$row['blog_name']?></td>
				<td class=""><?=$row['blog_description']?></td>
				<td class=""><?=$row['blog_address']?></td>
				<td class=""><?=$row['phone']?></td>
				<td class=""><?=$row['stage_name']?></td>
				<td class=""><?=$row['cos']?></td>
				<td class=""><?=$row['project']?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	
</div>
<!-- This clearing element should immediately follow the #content div in order to force the #main_inner div to contain all child floats -->
		<br class="clearfloat" />
	
		<div id="bottom_of_page">