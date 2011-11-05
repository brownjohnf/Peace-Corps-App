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
		<p>alias <?=$local_name?>
		<p>
			<?=$group?><br>
			<?=$sector_name?><br>
			<?=$focus?><br>
			<?=$project?>
		</p>
		<p>
			<?=$stage_name?>&nbsp;Stage<br>
			COS: <?=$cos?></p>
	</div>

	<div>
		<h3>Contact Info</h3>
		<p>
		<?php if ($this->userdata['is_user']): if(! is_null($phone1) || ! is_null($email1)): ?>
		<?=$site_name?>, <?=$region_name?><br>
		<?=$phone1?><br>
		<?php if (isset($phone2)): echo $phone2.'<br>'; endif; ?>
		<?=$email1?>
		<?php if (isset($email2)): echo '<br>'.$email2; endif; ?>
		<?php else: echo $fname; ?>
		 has no contact info on record.
		<?php if ($this->userdata['is_admin']): echo anchor('user/edit/'.$id, 'Add info'); endif; endif; else: ?>
		You must be a member of Peace Corps Senegal and logged in to access this information.
		<?php endif; ?>
		</p>
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