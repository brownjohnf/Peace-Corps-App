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
		<?php echo anchor($key, $value); ?>&nbsp;>&nbsp;
	<? endforeach; ?>
	</div>

	<h1><?=$title?></h1>
	<h2 class="lesson_plan">Lesson Plan</h2>
	<div class="lesson_plan">
		<?=$lesson_plan?>
	</div>
	
	<?php if (isset($resources)): ?>
	<h2 class="resources">Resources</h2>
	<div class="resources">
		<p>The following resources are currently online as part of this module (click to expand):</p>
		<?php echo ul($resources); ?>
	</div>
	<?php endif; ?>
	
	<?php if (isset($people)): ?>
	<h2 class="network">Network</h2>
	<div class="network">
		<p>The following people are available for more information:</p>
		<?php echo ul($people); ?>
	</div>
	<?php endif; ?>
		
	<?php if (isset($social)): ?>
	<h2>Keep the conversation going</h2>
	<div>
		<?php echo ul($social); ?>
	</div>
	<?php endif; ?>
</div>