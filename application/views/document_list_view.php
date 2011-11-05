<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

<div id="document_list_view" class="content">

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
				<th>Title</th>
				<th>Tags</th>
				<th>Extension</th>
				<th>Edited</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($table as $row): ?>
			<tr>
				<td><?php echo anchor($row['url'], $row['title']); ?></td>
				<td class=""><?=$row['tags']?></td>
				<td class=""><?=$row['ext']?></td>
				<td class=""><?=$row['edited']?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

</div>
<!-- This clearing element should immediately follow the #content div in order to force the #main_inner div to contain all child floats -->
		<br class="clearfloat" />

		<div id="bottom_of_page">