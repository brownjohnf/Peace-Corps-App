<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

<div id="profile_view" class="content">
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

	<h1>
		<?=$full_name?>
		<div class="controls">
			<?php if (isset($controls)): echo $controls; endif; ?>
		</div>
	</h1>
	
	<div>
		<p>a.k.a <?=$local_name?>
		<p><?=$group?> | <?=$sector_name?> | <?=$project?></p>
		<p><?=$stage_name?>&nbsp;Stage<br><?=$site_name?><br>COS: <?=$cos?></p>
	</div>
	
	<div>
		<h3>Contact Info</h3>
		<?php if ($this->auth->is_user()): ?>
		<p><?=$phone1?><br><?=$email1?>
		<?php else: ?>
		<p>You must be a member of Peace Corps Senegal and logged in to access this information.</p>
		<?php endif; ?>
	</div>
	
	<div>
		<h3>Social Contacts</h3>
		<p>
			<?php if (isset($social)): ?>
			<?php foreach ($social as $social_contact): ?>
				<?=$social_contact?>&nbsp;<br>
			<?php endforeach; ?>
			<?php endif; ?>
			
			<?php if ($blog_address): ?>
			<?php echo anchor('blog/view/'.$url_name, $blog_name); ?>&nbsp;[blog]
			<?php endif; ?>
		</p>
	</div>
	
	<?php if (isset($author_for)): ?>
	<div>
		<h3>Authorship</h3>
		<p>
			<?=$full_name?> is an author of the following pages:
		</p>
		<ul>
			<?php foreach ($author_for as $page): ?>
			<li><?php echo anchor('page/view/'.$page['url'], $page['title']); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php endif; ?>
	
	<?php if (($this->userdata['group']['name'] == 'admin' || $this->userdata['id'] == $id) && isset($actor_for)): ?>
	<div>
		<h3>Acting Privileges</h3>
		<p>
			<?=$full_name?> is an actor for the following pages:
		</p>
		<ul>
			<?php foreach ($actor_for as $page): ?>
			<li><?php echo anchor('page/view/'.$page['url'], $page['title']).'&nbsp;'.anchor('page/edit/'.$page['id'], 'Edit'); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php endif; ?>
	
	<?php if ($this->userdata['group']['name'] == 'admin'): ?>
	<div>
		<h3>Admin</h3>
		<p>
			<?php echo anchor('user/edit/'.$id, 'Edit User'); ?>
		</p>
	</div>
	<?php endif; ?>

</div>