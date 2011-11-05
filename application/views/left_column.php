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

			<?php if ($this->userdata['is_admin']): ?>
			<h2>Admin</h2>
			<div>
			    <ul class="leftmenu">

					<li><?=anchor('photo/gallery/me', 'My Photos')?>
						<ul>
							<li><?=anchor('photo/add', 'Upload Photo')?></li>
						</ul>
					</li>
					<li><?=anchor('user/view', 'Users')?>
						<ul>
							<li><?=anchor('user/create', 'New User')?></li>
							<li><?=anchor('stage/view', 'Stages')?></li>
							<li><?=anchor('user/upload', 'Upload Batch')?></li>
						</ul>
					</li>
					<li><?=anchor('resource/type_view', 'Resource Types')?>
						<ul>
							<li><?=anchor('module', 'Modules')?>
								<ul>
									<li><?=anchor('module/edit', 'New Module')?></li>
								</ul>
							</li>
							<li><?=anchor('link/view', 'Links')?>
								<ul>
									<li><?=anchor('link/create', 'New Link')?></li>
								</ul>
							</li>
							<li><?=anchor('document/view', 'Documents')?>
								<ul>
									<li><?=anchor('document/add', 'Upload Document')?></li>
								</ul>
							</li>
						</ul>
					</li>
					<li><?=anchor('page/tree', 'All Pages')?>
						<ul>
							<li><?=anchor('page/create', 'New Page')?></li>
						</ul>
					</li>
					<li><?=anchor('admin/site/messages/edit', 'Edit Site Messages')?></li>
			    </ul>
			</div>
			<?php endif; ?>

			<div>
				<?php echo anchor('page/view/donate', img(array('src' => base_url().'img/donate_w170.png', 'width' => '190px'))); ?>
			</div>
			<div>
				<a href="#google_search" id="google_anchor"><?php echo img(array('src' => base_url().'img/google_search.png', 'width' => '190px')); ?></a>
			</div>
		</div><!-- END leftbar -->