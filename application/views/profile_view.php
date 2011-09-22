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
		<?php echo anchor('page/view/'.$key, $value); ?>&nbsp;>&nbsp;
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
		<p><?=$group?>, <?=$sector_name?>, <?=$project?></p>
		<p><?=$stage_name?>&nbsp;Stage<br><?=$site_name?></p>
	</div>
	
	<div>
		<h3>Contact Info</h3>
		<?php if ($this->auth->is_user()): ?>
		<p><?=$phone?><br><?=$email?>
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
			<?php echo anchor($blog_address, $blog_name, array('target' => '_blank')); ?>&nbsp;[blog]
			<?php endif; ?>
		</p>
	</div>
	
	<?php if ($this->userdata['group']['name'] == 'Admin'): ?>
	<div>
		<h3>Admin</h3>
		<p>
			<?php echo anchor('user/edit/'.$id, 'Edit User'); ?>
		</p>
	</div>
	<?php endif; ?>

</div>