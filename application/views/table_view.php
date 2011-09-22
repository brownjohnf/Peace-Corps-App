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
	
	<table>
		<head>
		<?php foreach ($table[0] as $key => $value): ?>
			<th><?=$key?></th>
		<?php endforeach; ?>
		</head>
	<?php foreach ($table as $row): ?>
		<tr>
		<?php foreach ($row as $header => $column): ?>
			<td class="<?=$header?>"><?=$column?></td>
		<?php endforeach; ?>
		</tr>
	<?php endforeach; ?>
	</table>
	
</div>