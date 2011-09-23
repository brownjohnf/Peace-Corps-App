<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

<div id="photo_form" class="content">
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
        <?php echo anchor('feed', img(base_url().'img/cancel_icon_black.png'), array('class' => 'cancel')); ?>
    </div>
</h1>

<?php echo form_open_multipart('photo/upload');?>

<label>File*</label>
<input type="file" name="userfile" size="20" />

<br /><br />

<input type="submit" value="upload" />

</form>
</div>