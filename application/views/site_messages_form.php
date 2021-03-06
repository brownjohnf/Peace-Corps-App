<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

<div id="site_messages_form" class="content">
    <?php echo validation_errors(); ?>
    <?
        if ($this->session->flashdata('error')) {
            $this->load->view('error');
        }
        if ($this->session->flashdata('success')) {
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
<?php echo form_open('admin/site/messages/edit'); ?>

<label>Message</label><?php echo form_textarea('message', set_value('message', $message)); ?><br />
<label>Alert</label><?php echo form_textarea('alert', set_value('notice', $alert)); ?><br />
<label>Success</label><?php echo form_textarea('success', set_value('success', $success)); ?><br />
<label>Error</label><?php echo form_textarea('error', set_value('error', $error)); ?><br />

<?php echo form_hidden('id', set_value('id', $id)); ?>
<label>If you're sure...</label>
<?php echo form_submit('submit', 'Submit Content!'); ?>

<?php echo form_close(); ?>
</div>