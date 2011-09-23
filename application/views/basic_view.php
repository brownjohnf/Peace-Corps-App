<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

<div id="blank_view" class="content">
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
	<?php if (isset($backtrack)): ?>
	<div id="backtrack">
	<?php foreach ($backtrack as $key => $value): ?>
		<?php echo anchor($key, $value); ?>&nbsp;>&nbsp;
	<? endforeach; ?>
	</div>
	<?php endif; ?>

	<?=$data?>
</div>