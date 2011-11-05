<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

<div id="module_view" class="content">
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

	<h1><?=$title?></h1>
	<h2 class="lesson_plan resource_header">Lesson Plan</h2>
	<div class="lesson_plan">
		<?=$lesson_plan?>
	</div>

	<?php if (isset($resources['resources'])): ?>
	<h2 class="resources resource_header">Resources</h2>
	<div class="resources">
		<p>The following resources are currently online as part of this module (click to expand):</p>
		<?php echo ul($resources['resources']); ?>
	</div>
	<?php endif; ?>

	<?php if (isset($resources['people']) || isset($resources['resources']['Social Networking'])): ?>
	<h2 class="network resource_header">Keep the conversation going</h2>
	<div class="network">
		<?php if (isset($resources['people'])): ?>
		<p>The following people are available for more information:</p>
		<?php echo ul($resources['people']); ?>
		<?php endif; ?>

		<?php if (isset($resources['resources']['Social Networking'])): ?>
		<p>Join the discussion on one of these social networks:</p>
		<?php echo ul($resources['resources']['Social Networking']); ?>
		<?php endif; ?>
	</div>
	<?php endif; ?>
</div>