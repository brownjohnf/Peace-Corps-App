<h1>Add New Case Study</h1>
<?php $this->load->helper('form'); ?>
 
<?php echo form_open($target); ?>

	<h3>Title</h3>
 	<p><?php echo form_input('title', $title); ?></p>
	
	<h3>Description</h3>
    <p><?php echo form_textarea('description', $description); ?></p>
	
	<h3>Content</h3>
    <p><?php echo form_textarea('content', $content); ?></p>
 
    <p><?php echo form_submit('submit', 'Submit'); ?></p>
 
<?php echo form_close(); ?>