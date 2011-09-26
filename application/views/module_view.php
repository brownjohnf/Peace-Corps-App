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
	
	<h2 class="resources">Resources</h2>
	<div class="resources">
		<p>The following resources are currently online as part of this module (click to expand):</p>
		<ul class="module_resources">
			<?php if (isset($resources)): foreach ($resources as $key => $resource): ?>
			<li><span class="resource_header">
				<?php if (is_array($resource)): echo $key; ?>
				</span>
				<ul>
				<? foreach ($resource as $link => $value): ?>
				<li><?php if($key == 'How-to Videos'): echo '<h3>'.$link.'</h3>'.$value; else: echo anchor($link, $value); endif; ?></li>
				<?php endforeach; ?>
				</ul>
				<?php else: ?>
				<?php echo $resource; ?></span>
				<?php endif; ?>
			</li>
			<?php endforeach; endif; ?>
		</ul>
	</div>
	
	<h2 class="network">Network</h2>
	<div class="network">
		<p>Connect with people around you who have significant experience with these practices.</p>
		
		<h3>Volunteers &amp; Staff</h3>
		<ul>
			<?php if (isset($people)): foreach ($people as $link => $person): ?>
			<li><?php echo anchor($link, $person); ?></li>
			<?php endforeach; endif; ?>
		</ul>
		
		<?php if (isset($experts)): foreach ($experts as $expert): ?>
		<h3>Local, field-based experts</h3>
			<p>
			<?php echo $expert['name']; ?><br>
			<?php echo $expert['description']; ?><br><br>
			<?php echo $expert['address']; ?><br>
			<?php echo $expert['phone']; ?><br>
			<?php echo $expert['email']; ?>
			</p>
			<?php endforeach; endif; ?>
		
		<?php if (isset($social)): ?>
		<h3>Keep the conversation going</h3>
		<ul>
			<?php foreach ($social as $link => $group): ?>
			<li><?php echo anchor($link, $group, array('target' => '_blank')); ?></li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
	</div>
</div>