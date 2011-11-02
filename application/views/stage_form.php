<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

<div id="stage_form" class="content wide_form">
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
<?php echo form_open('stage/'.$target); ?>

<label>Stage Name*</label><?php echo form_input('name', set_value('name', $name)); ?><br />
<label>Stage COS</label><?php echo form_input('cos', set_value('cos', $cos)); ?><br />
<label>Arrival Date</label><?php echo form_input('arrival_date', set_value('arrival_date', $arrival_date)); ?><br />
<label>Sectors</label><?php echo form_input('sectors', set_value('sectors', $sectors)); ?><br />

<?php echo form_hidden('id', set_value('id', $id)); ?>
<label>If you're sure...</label>
<?php echo form_submit('submit', 'Submit Stage!'); ?>

<?php echo form_close(); ?>
</div>