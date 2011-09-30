<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

<div id="table_view" class="content">

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
		<?php foreach ($table[0] as $key => $value): ?>
			<th><?=$key?></th>
		<?php endforeach; ?>
		</thead>
	<?php foreach ($table as $row): ?>
		<tr>
		<?php foreach ($row as $header => $column): ?>
			<td class="<?=$header?>"><?=$column?></td>
		<?php endforeach; ?>
		</tr>
	<?php endforeach; ?>
	</table>
	
</div>