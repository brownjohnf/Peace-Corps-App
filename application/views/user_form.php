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

<label>Peace Corps ID</label><?php echo form_input('pc_id', set_value('title', $pc_id)); ?><br />
<label>Facebook ID</label><?php echo form_input('fb_id', set_value('description', $fb_id)); ?><br />
<label>First Name*</label><?php echo form_input('fname', set_value('content', $fname)); ?><br />
<label>Last Name*</label><?php echo form_input('lname', set_value('content', $lname)); ?><br />
<label>Project</label><?php echo form_input('project', set_value('content', $project)); ?><br />
<label>Email*</label><?php echo form_input('email', set_value('content', $email)); ?><br />
<label>Phone</label><?php echo form_input('phone', set_value('content', $phone)); ?><br />
<label>Address</label><?php echo form_textarea('address', set_value('content', $address)); ?><br />
<label>COS Date</label><?php echo form_input('cos', set_value('content', $cos)); ?><br />
<label>Local Name</label><?php echo form_input('local_name', set_value('content', $local_name)); ?><br />
<label>Blog Name</label><?php echo form_input('blog_name', set_value('content', $blog_name)); ?><br />
<label>Blog Description</label><?php echo form_textarea('blog_description', set_value('content', $blog_description)); ?><br />
<label>Blog Address</label><?php echo form_input('blog_address', set_value('content', $blog_address)); ?><br />



<h2>Sharing</h2>
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