<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

<div id="video_list_view" class="content standard_list_view">

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

	<table id="datatable">
		<thead>
			<tr>
				<th>View</th>
				<th>Description</th>
				<th>Tags</th>
				<th>Go To</th>
				<th>Updated</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($table as $row): ?>
			<tr>
				<td><?php echo anchor('video/view/'.$row['id'].'/'.url_title($row['title'], 'underscore'), $row['title']); ?></td>
				<td class=""><?=$row['description']?></td>
				<td class=""><?=$row['tags']?></td>
				<td class=""><?php echo anchor_popup($row['link'], 'External'); ?></td>
				<td><?=$row['edited']?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

</div>
<!-- This clearing element should immediately follow the #content div in order to force the #main_inner div to contain all child floats -->
		<br class="clearfloat" />