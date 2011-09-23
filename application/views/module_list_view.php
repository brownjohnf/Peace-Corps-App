<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

<div id="module_list_view" class="content">
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

	<h1>Available Modules</h1>
	<p>The following modules are currently online:</p>
	
	<?php foreach ($tiers as $tier => $modules): ?>
	<h2><?=$tier?></h2>
	<ul>
		<?php foreach ($modules as $link => $module): if (is_numeric($link)): $link = 'module'; endif; ?>
		<li><?php echo anchor($link, $module); ?></li>
		<?php endforeach; ?>
	</ul>
	<?php endforeach; ?>
	
	
</div>