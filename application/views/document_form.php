<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

<div id="document_form" class="content">
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

<h1><?=$form_title?><div class="controls"><?=$controls?></div></h1>
<?php echo form_open_multipart('document/'.$target); ?>

<?php if ($target == 'do_upload'): ?>
<label>File* ( .pdf | .txt )</label>
<?php echo form_upload('userfile'); ?>
<?php endif; ?>

<label>Title*</label><?php echo form_input('title', set_value('title', $title)); ?><br />
<label>Tags*</label><?php echo form_input('tags', set_value('tags', $tags)); ?>

<?php if ($target != 'do_upload'): ?>
<br />
<label>Filename</label><?php echo form_input('name', set_value('name', $name), 'disabled'); ?><br />
<label>Extension</label><?php echo form_input('ext', set_value('ext', $ext), 'disabled'); ?><br />
<label>Filetype</label><?php echo form_input('type', set_value('type', $type), 'disabled'); ?>
<?php endif; ?>

<?php echo form_hidden('id', set_value('id', $id)); ?>
<label>If you're sure...</label>
<?php echo form_submit('submit', 'Upload/Save Doc Data!'); ?>

<?php echo form_close(); ?>
</div>