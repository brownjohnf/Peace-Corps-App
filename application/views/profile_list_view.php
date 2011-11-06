<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

<div id="profile_list_view" class="content">

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
		<?php echo anchor($key, $value).'&nbsp;&gt; '; ?>
	<? endforeach; ?>
	</div>

	<div>
		<h4>View by sector</h4>
		<p><?php foreach ($sectors as $sector): echo $sector.' &nbsp; '; endforeach; ?></p>
		<h4>View by stage</h4>
		<p><?php foreach ($stages as $stage): echo $stage.' &nbsp; '; endforeach; ?></p>
		<h4>View by region</h4>
		<p><?php foreach ($regions as $region): echo $region.' &nbsp; '; endforeach; ?></p>
		<br>
	</div>

	<table id="datatable">
		<thead>
			<tr>
				<th>Last</th>
				<th>First</th>
				<th>Local Name</th>
				<?php if ($this->userdata['is_user']): ?>
				<th>Email</th>
				<th>Phone</th>
				<th>Site</th>
				<?php endif; ?>
				<th>Region</th>
				<th>Stage</th>
				<th>Sector</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($table as $row): ?>
			<tr>
				<td class=""><?=$row['lname']?></td>
				<td class=""><?=$row['fname']?></td>
				<td class=""><?=$row['local_name']?></td>
				<?php if ($this->userdata['is_user']): ?>
				<td class=""><?=$row['email1']?></td>
				<td class=""><?=$row['phone1']?></td>
				<td class=""><?=$row['site_name']?></td>
				<?php endif; ?>
				<td class=""><?=$row['region_name']?></td>
				<td class=""><?=$row['stage_name']?></td>
				<td class=""><?=$row['sector_short']?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

</div>
<!-- This clearing element should immediately follow the #content div in order to force the #main_inner div to contain all child floats -->
		<br class="clearfloat" />

		<div id="bottom_of_page">