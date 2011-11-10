<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

<div id="profile_form" class="content wide_form">
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


<div id="backtrack">
<?php foreach ($backtrack as $key => $value): ?>
	<?php echo anchor($key, $value).'&nbsp;&gt; '; ?>
<? endforeach; ?>
</div>

<h1><?=$form_title?><div class="controls"><?=$controls?></div></h1>
<?php echo form_open('profile/'.$target); ?>

<label>First Name*</label><?php echo form_input('fname', set_value('fname', $fname)); ?><br />
<label>Last Name*</label><?php echo form_input('lname', set_value('lname', $lname)); ?><br />
<label>Gender</label><?php echo form_dropdown('gender', array(0 => 'unknown', 1 => 'male', 2 => 'female'), set_value('gender', $gender)); ?><br />
<label>Focus (Where are you focused, as a Volunteer? An agfo might say 'Fruit Trees')</label><?php echo form_input('focus', set_value('focus', $focus)); ?><br />
<label>Project (What are you up to? The same agfo might say 'A mango orchard')</label><?php echo form_input('project', set_value('project', $project)); ?><br />
<label>Primary Email (required to log in, must be the same as used w/Facebook)</label><?php echo form_input('email1', set_value('email1', $email1)); ?><br />
<label>Secondary Email</label><?php echo form_input('email2', set_value('email2', $email2)); ?><br />
<label>Primary Phone</label><?php echo form_input('phone1', set_value('phone1', $phone1)); ?><br />
<label>Secondary Phone</label><?php echo form_input('phone2', set_value('phone2', $phone2)); ?><br />
<label>Address</label><?php echo form_textarea('address', set_value('address', $address)); ?><br />
<label>Local Name</label><?php echo form_input('local_name', set_value('local_name', $local_name)); ?><br />
<label>Blog Name</label><?php echo form_input('blog_name', set_value('blog_name', $blog_name)); ?><br />
<label>Blog Description</label><?php echo form_textarea('blog_description', set_value('blog_description', $blog_description)); ?><br />
<label>Blog Address</label><?php echo form_input('blog_address', set_value('blog_address', $blog_address)); ?><br />


<?php echo form_hidden('id', set_value('id', $id)); ?>
<label>If you're sure...</label>
<?php echo form_submit('submit', 'Save Profile'); ?>

<?php echo form_close(); ?>
</div>