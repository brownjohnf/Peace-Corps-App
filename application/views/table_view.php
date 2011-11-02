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
		<?php echo anchor($key, $value).'&nbsp;&gt; '; ?>
	<? endforeach; ?>
	</div>
	
	<?php if (isset($table)): ?>
	<table id="datatable">
		<thead>
		<?php if (isset($edit_target)): ?>
			<th>Edit</th>
		<?php endif; foreach ($table[0] as $key => $value): ?>
			<th><?php echo ucfirst($key) ?></th>
		<?php endforeach; if (isset($extra_targets)): foreach ($extra_targets as $target_info): ?>
			<th><?=$target_info['text']?></th>
		<?php endforeach; endif; ?>
		</thead>
	<?php foreach ($table as $row): ?>
		<tr>
		<?php if (isset($edit_target)): ?>
			<td class="control"><?php echo anchor($edit_target.$row['id'], 'Edit'); ?></td>
		<?php endif; foreach ($row as $header => $column): ?>
			<td class="<?=$header?>"><?php if (($header == 'created' || $header == 'edited') && ! is_null($column)): echo date('d-M-Y H:i:s', $column); else: echo $column; endif; ?></td>
		<?php endforeach; if (isset($extra_targets)): foreach ($extra_targets as $target_info): ?>
			<td class="control"><?php echo anchor($target_info['path'].$row[$target_info['column']], $target_info['text']); ?></td>
		<?php endforeach; endif; ?>
		</tr>
	<?php endforeach; ?>
	</table>
	<?php else: ?>
	<p>There appear to be no results matching your query.</p>
	<?php endif; ?>
	
</div>
<br class="clearfloat" />