<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

<div id="user_upload_form" class="content wide_form">
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

<h1>
    <?=$form_title?>
    <div class="controls">
        <?php echo anchor('user/view', img(base_url().'img/cancel_icon_black.png'), array('class' => 'cancel')); ?>
    </div>
</h1>

<p>Select a CSV file of users to upload. CSV files must observe the following standards:</p>
<ul>
    <li>.csv filename extension</li>
    <li>comma separated</li>
    <li>double-quotation mark delimited</li>
</ul>
<p>The following fields must be present:</p>
<ul>
    <li>pc_id, PC ID number</li>
    <li>fname, First Name</li>
    <li>lname, Last Name</li>
    <li>email1, Email</li>
    <li>phone1, Phone</li>
    <li>address, Address</li>
    <li>stage, Stage</li>
    <li>cos, COS</li>
    <li>sector, Sector</li>
    <li>site, Site</li>
    <li>local_name, Local Name</li>
    <li>gender, Gender</li>
</ul>
<p>If any of the preceding information, DO NOT upload a file. You'll most likely damage something. Read a tutorial on CSV and come back.</p>

<?php echo form_open_multipart('user/do_upload');?>

<label>File* ( .csv )</label>
<input type="file" name="userfile" size="20" /><br /><br />

<br /><br />

<input type="submit" value="Upload Users" />

</form>
</div>