<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

		<div id="leftbar">
			<img id="logo" src="<?php echo base_url(); ?>img/pc_logo.png">

			<?php if ($this->uri->segment(1) == 'feed'): ?>
			<h2>Updates</h2>
			<div>
				<ul class="leftmenu">
					<li><?=anchor('feed', 'All')?></li>
					<li><?=anchor('feed/page', 'Pages')?></li>
					<li><?=anchor('feed/casestudy', 'Case Studies')?></li>
					<li><?=anchor('feed/document', 'Documents')?></li>
					<li><?=anchor('feed/link', 'Links')?></li>
					<li><?=anchor('feed/video', 'Videos')?></li>
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
			    <?php echo $this->page_class->menu(array('case_study' => 0, 'group_id' => 6, 'visibility' => 1)); ?>
			    <ul class="leftmenu">
			    	<li><?php echo anchor('feed/casestudy', 'Case Studies'); ?>
			    		<ul>
					    	<li><?php echo anchor('casestudy', 'Search Case Studies'); ?></li>
					    </ul>
					</li>
			    </ul>
			</div>

			<?php if ($this->userdata['is_user']): ?>
			<h2>Volunteer</h2>
			<div>
			    <?php echo $this->page_class->menu(array('case_study' => 0, 'group_id' => 2)); ?>
			    
			    <ul class="leftmenu user_menu">
					<li><?=anchor('profile', 'Profiles')?>
						<ul>
							<li><?=anchor('profile/view/'.$this->userdata['url'], 'My Profile')?></li>
						</ul>
					</li>
					<li><?=anchor('resource', 'Resources')?>
						<ul>
							<li><?=anchor('casestudy', 'Case Studies')?></li>
							<li><?=anchor('module', 'Modules')?></li>
							<li><?=anchor('link', 'Links')?></li>
							<li><?=anchor('document', 'Documents')?></li>
							<li><?=anchor('photo/gallery/me', 'My Photos')?></li>
							<li><?=anchor('video', 'Videos')?></li>
						</ul>
					</li>
			    </ul>
			</div>
			<?php endif; ?>

			<?php if ($this->userdata['is_admin']): ?>
			<h2>Admin</h2>
			<div>
			    <ul class="leftmenu user_menu admin_menu">
					<li><?=anchor('user/view', 'Users')?>
						<ul>
							<li><?=anchor('user/create', 'New User')?></li>
							<li><?=anchor('stage/view', 'Stages')?></li>
							<li><?=anchor('user/upload', 'Upload Batch')?></li>
						</ul>
					</li>
					<li><?=anchor('resource/type_view', 'Resource Types')?>
						<ul>
							<li><?=anchor('page', 'Pages')?>
								<ul>
									<li><?=anchor('page/tree', 'Page Tree')?></li>
									<li><?=anchor('casestudy', 'Case Studies')?></li>
									<li><?=anchor('page/create', 'New Page/Case Study')?></li>
								</ul>
							</li>
							<li><?=anchor('module', 'Modules')?>
								<ul>
									<li><?=anchor('module/edit', 'New Module')?></li>
								</ul>
							</li>
							<li><?=anchor('link', 'Links')?>
								<ul>
									<li><?=anchor('link/admin', 'Manage')?></li>
									<li><?=anchor('link/create', 'New Link')?></li>
								</ul>
							</li>
							<li><?=anchor('document', 'Documents')?>
								<ul>
									<li><?=anchor('document/admin', 'Manage')?></li>
									<li><?=anchor('document/add', 'Upload Doc')?></li>
								</ul>
							</li>
							<li><?=anchor('photo/gallery', 'Photos')?>
								<ul>
									<li><?=anchor('photo/admin', 'Manage')?></li>
									<li><?=anchor('photo/add', 'Upload Photo')?></li>
								</ul>
							</li>
							<li><?=anchor('video', 'Videos')?>
								<ul>
									<li><?=anchor('video/admin', 'Manage')?></li>
									<li><?=anchor('video/create', 'Add Video')?></li>
								</ul>
							</li>
						</ul>
					</li>
					<li><?=anchor('admin/site/messages/edit', 'Site Messages')?></li>
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