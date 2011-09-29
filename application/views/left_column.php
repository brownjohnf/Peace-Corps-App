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
				<ul>
					<li><?=anchor('feed', 'All', array('class' => 'menu_anchor top'))?></li>
					<li><?=anchor('feed/page', 'Content', array('class' => 'menu_anchor top'))?></li>
					<li><?=anchor('feed/blog', 'Blogs', array('class' => 'menu_anchor top'))?></li>
					<li><?=anchor('feed/tag', 'Recent Tags', array('class' => 'menu_anchor top'))?></li>
				</ul>
			</div>
			<?php endif; ?>
			
			
			<?php if ($this->uri->segment(1, null) == 'resource' || $this->uri->segment(1, null) == 'module'): ?>
			<h2>Resources</h2>
			<div>
				<ul>
					<li><?=anchor('resource', 'Overview', array('class' => 'menu_anchor top'))?></li>
				</ul>
				<?php echo $this->module_class->menu(); ?>
			</div>
			<?php endif; ?>
			
			<h2>Browse</h2>
			<div class="left_menu">
			    <?php if (isset($menu)): echo $menu; else: echo $this->menu_class->menu(1, 0); endif;?>
			</div>
			
			<?php if ($this->userdata['group']['name'] == 'Admin'): ?>
			<h2>Admin</h2>
			<div>
			    <ul>
					<li><?=anchor('page/create', 'New Page', array('class' => 'menu_anchor top'))?></li>
					<li><?=anchor('photo/add', 'Add Photo', array('class' => 'menu_anchor top'))?></li>
					<li><?=anchor('user/view', 'User Admin', array('class' => 'menu_anchor top'))?></li>
					<li><?=anchor('resource/type_view', 'Resource Types', array('class' => 'menu_anchor top'))?></li>
			    </ul>
			</div>
			<?php endif; ?>
			
			<div>
				<?php echo anchor('page/view/donate', img(array('src' => base_url().'img/donate_w170.png', 'width' => '190px'))); ?>
			</div>
		</div><!-- END leftbar -->