<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

<div id="feed_view" class="content">
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



<?php krsort($feed, SORT_NUMERIC); foreach ($feed as $item): ?>

<div class="feed_block">
	<div class="avatar">
		<? echo anchor($item['full_url'], img($item['profile_photo'])); ?>
	</div>
	<div class="feed_body">
		<div>
			<div class="controls"><?=$item['controls']?></div>
			<div>
				<?php echo anchor($item['full_url'], $item['author'], array('class' => 'feed_author')); ?>
				<span class="feed_elapsed"><?=$item['elapsed']?>
			</div>
		</div>
		<div class="feed_subject"><?=$item['subject']?></div>
		<div class="feed_message">
			<?=$item['message']?>
			<?php if ($item['message_truncated'] == 'yes'): ?>
			<span class="feed_read_more"><?php anchor($item['full_url'], 'read more'); ?></span>
			<? endif; ?>
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