<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

<div id="user_form" class="content">
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
<?php echo form_open('user/'.$target); ?>

<label>Peace Corps ID</label><?php echo form_input('pc_id', set_value('pc_id', $pc_id)); ?><br />
<label>Facebook ID</label><?php echo form_input('fb_id', set_value('fb_id', $fb_id)); ?><br />
<label>First Name*</label><?php echo form_input('fname', set_value('fname', $fname)); ?><br />
<label>Last Name*</label><?php echo form_input('lname', set_value('lname', $lname)); ?><br />
<label>Gender</label><?php echo form_dropdown('gender', array(0 => 'unknown', 1 => 'male', 2 => 'female'), set_value('gender', $gender)); ?><br />
<label>Project</label><?php echo form_input('project', set_value('project', $project)); ?><br />
<label>Primary Email (required to log in, must be the same as used w/Facebook)</label><?php echo form_input('email1', set_value('email1', $email1)); ?><br />
<label>Secondary Email</label><?php echo form_input('email2', set_value('email2', $email2)); ?><br />
<label>Primary Phone</label><?php echo form_input('phone1', set_value('phone1', $phone1)); ?><br />
<label>Secondary Phone</label><?php echo form_input('phone2', set_value('phone2', $phone2)); ?><br />
<label>Address</label><?php echo form_textarea('address', set_value('address', $address)); ?><br />
<label>COS Date</label><?php echo form_input('cos', set_value('cos', $cos)); ?><br />
<label>Local Name</label><?php echo form_input('local_name', set_value('local_name', $local_name)); ?><br />
<label>Blog Name</label><?php echo form_input('blog_name', set_value('blog_name', $blog_name)); ?><br />
<label>Blog Description</label><?php echo form_textarea('blog_description', set_value('blog_description', $blog_description)); ?><br />
<label>Blog Address</label><?php echo form_input('blog_address', set_value('blog_address', $blog_address)); ?><br />

<label>Focus</label><?php echo form_input('focus', set_value('focus', $focus)); ?><br />

<h2>Sharing</h2>
<label>Administrator</label><?php echo form_checkbox('is_admin', '1', set_checkbox('is_admin', '1', false)); ?><br />
<label>Volunteer</label><?php echo form_checkbox('is_user', '1', set_checkbox('is_user', '1', false)); ?><br />
<label>Staff</label><?php echo form_checkbox('is_moderator', '1', set_checkbox('is_moderator', '1', false)); ?><br />

<label>Group*</label>
<?php echo form_dropdown('group_id', $groups, set_value('group_id', $group_id)); ?><br />
<label>Stage*</label>
<?php echo form_dropdown('stage_id', $stages, set_value('stage_id', $stage_id)); ?><br />
<label>Sector*</label>
<?php echo form_dropdown('sector_id', $sectors, set_value('sector_id', $sector_id)); ?><br />
<label>Site</label>
<?php echo form_dropdown('site_id', $sites, set_value('site_id', $site_id)); ?><br />



<?php echo form_hidden('id', set_value('id', $id)); ?>
<label>If you're sure...</label>
<?php echo form_submit('submit', 'Submit Content!'); ?>

<?php echo form_close(); ?>
</div>