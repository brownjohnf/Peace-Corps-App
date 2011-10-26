<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

		<div id="leftbar">
			<img id="logo" src="<?php echo base_url(); ?>img/pc_logo.png">
			
			<?php if ($this->uri->segment(1, null) == 'feed'): ?>
			<h2>Updates</h2>
			<div>
				<ul class="leftmenu">
					<li><?=anchor('feed', 'All')?></li>
					<li><?=anchor('feed/page', 'Content')?></li>
					<li><?=anchor('feed/blog', 'Blogs')?></li>
					<li><?=anchor('feed/tag', 'Recent Tags')?></li>
				</ul>
			</div>
			<?php endif; ?>
			
			
			<?php if ($this->uri->segment(1, null) == 'resource' || $this->uri->segment(1, null) == 'module'): ?>
			<h2>Resources</h2>
			<div>
				<ul class="leftmenu">
					<li><?=anchor('resource', 'Overview')?></li>
				</ul>
				<?php echo $this->module_class->menu(); ?>
			</div>
			<?php endif; ?>
			
			<h2>Browse</h2>
			<div class="left_menu">
			    <?php echo $this->page_class->menu(); ?>
			</div>
			
			<?php if ($this->userdata['group']['name'] == 'Admin'): ?>
			<h2>Admin</h2>
			<div>
			    <ul class="leftmenu">
					<li><?=anchor('page/create', 'New Page')?></li>
					<li><?=anchor('photo/add', 'Upload Photo')?></li>
					<li><?=anchor('photo/gallery/me', 'My Photos')?></li>
					<li><?=anchor('user/view', 'User Admin')?></li>
					<li><?=anchor('resource/type_view', 'Resource Types')?></li>
					<li><?=anchor('page/tree', 'Page Tree')?></li>
					<li><?=anchor('admin/site/messages/edit', 'Edit Site Messages')?></li>
			    </ul>
			</div>
			<?php endif; ?>
			
			<div>
				<?php echo anchor('page/view/donate', img(array('src' => base_url().'img/donate_w170.png', 'width' => '190px'))); ?>
			</div>
		</div><!-- END leftbar -->