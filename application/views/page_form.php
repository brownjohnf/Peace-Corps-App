<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

<div id="page_form" class="content">
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
<?php echo form_open('page/'.$target); ?>

<label>Title*</label><?php echo form_input('title', set_value('title', $title)); ?><br />
<label>Description*</label><?php echo form_input('description', set_value('description', $description)); ?><br />
<label>Content*</label><?php echo form_textarea('content', set_value('content', $content)); ?><br />
<label>Profile Photo*</label>
<?php echo img($profile_photo_info); ?>
<?php echo form_input('profile_photo', set_value('profile_photo', $profile_photo)); ?><br />

<label>Mark as updated</label>
<?php echo form_checkbox('updated', 'yes', set_checkbox('updated', 'yes', true)); ?>&nbsp;If checked, this page will appear in feeds as updated.


<h2>Sharing</h2>
<label>Parent Page*</label>
<?php echo form_dropdown('parent_id', $parents, set_value('parent_id', $parent_id)); ?><br />

<label>Group*</label>
<?php echo form_dropdown('group_id', $groups, set_value('group_id', $group_id)); ?><br />

<label>Actors (These users will be able to act for the page.)</label>
<?php echo form_multiselect('actors[]', $users, $set_actors); ?><br />

<h2>Credits</h2>
<label>Author(s)*</label><?php echo form_multiselect('authors[]', $users, $set_authors); ?><br />

<?php echo form_hidden('id', set_value('id', $id)); ?>
<label>If you're sure...</label>
<?php echo form_submit('submit', 'Submit Content!'); ?>

<?php echo form_close(); ?>
</div>