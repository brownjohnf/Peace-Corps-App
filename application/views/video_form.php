<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

<div id="video_form" class="content wide_form">
    <?php echo validation_errors(); ?>
    <?
        if ($this->session->flashdata('error'))
        {
            $this->load->view('error');
        }
        if ($this->session->flashdata('success'))
        {
            $this->load->view('success');
        }
        $history = $this->session->userdata('history');
    ?>

<?php if (isset($backtrack)): ?>
<div id="backtrack">
<?php foreach ($backtrack as $key => $value): ?>
	<?php echo anchor($key, $value).'&nbsp;&gt; '; ?>
<? endforeach; ?>
</div>
<?php endif; ?>

<h1><?=$form_title?><div class="controls"><?=$controls?></div></h1>
<?php echo form_open('video/'.$target); ?>

<label>Title*</label><?php echo form_input('title', set_value('title', $title)); ?><br />
<label>Description*</label><?php echo form_input('description', set_value('description', $description)); ?><br />
<label>Tags</label><?php echo form_input('tags', set_value('tags', $tags)); ?><br />
<label>Link*</label><?php echo form_input('link', set_value('link', $link)); ?><br />
<label>Embed (YouTube and Google videos should be submitted as the unique identifier. All others require full code.)</label><?php echo form_input('embed', set_value('embed', $embed)); ?><br />
<?php echo form_radio('video_type', 'none', set_radio('video_type', 'none', $none)); ?>&nbsp;None&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo form_radio('video_type', 'youtube', set_radio('video_type', 'youtube', $youtube)); ?>&nbsp;YouTube&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo form_radio('video_type', 'google', set_radio('video_type', 'google', $google)); ?>&nbsp;Google Video

<?php echo form_hidden('id', set_value('id', $id)); ?>
<label>If you're sure...</label>
<?php echo form_submit('submit', 'Save Video!'); ?>

<?php echo form_close(); ?>
</div>