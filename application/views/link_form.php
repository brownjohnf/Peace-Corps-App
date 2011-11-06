<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

<div id="link_form" class="content">
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
<?php echo form_open('link/'.$target); ?>

<label>Title</label><?php echo form_input('title', set_value('title', $title)); ?><br />
<label>URL</label><?php echo form_input('url', set_value('url', $url)); ?>
<label>Tags</label><?php echo form_input('tags', set_value('tags', $tags)); ?>

<?php echo form_hidden('id', set_value('id', $id)); ?>
<label>If you're sure...</label>
<?php echo form_submit('submit', 'Save Link!'); ?>

<?php echo form_close(); ?>
</div>