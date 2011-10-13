<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

<div id="blog_view" class="content">
<?php
	$this->load->helper('html');
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



<?php foreach ($blog_data as $item): ?>

<div class="blog_block">
	<div class="blog_body">
		<div>
			<div class="controls"><?=$item['controls']?></div>
			<div>
				<h3 class="blog_title"><?=$item['title']?></h3>
				<span class="feed_elapsed"><?=$item['elapsed']?>
			</div>
		</div>
		<div class="blog_subject"><?=$item['subject']?></div>
		<div class="blog_content">
			<?=$item['content']?>
		</div>
		<div class="feed_info">INFO</div>
		<div class="feed_tags">
			<?php if ($item['tags']): foreach ($item['tags'] as $tag): ?>
			<span class="hash">#</span><?php echo anchor('feed/tag/'.$tag, $tag, array('class' => 'tag')); ?></span>
			<?php endforeach; endif; ?>
		</div>
		<div class="feed_comments">COMMENTS</div>
	</div>
</div>
<?php endforeach; ?>

</div>