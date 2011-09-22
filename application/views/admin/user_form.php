<h1>Edit/Add User</h1>
<?php $this->load->helper('form'); ?>
 
<?php echo form_open($target, '', array('id' => $id)); ?>

	<h3>Group</h3>
 	<p><?php echo form_dropdown('group_id', $dropdown['options'], $dropdown['selected']); ?></p>
 	
	<h3>First</h3>
 	<p><?php echo form_input('fname', $fname); ?></p>
	
	<h3>Last Name</h3>
    <p><?php echo form_input('lname', $lname); ?></p>
	
	<h3>Email</h3>
    <p><?php echo form_input('email', $email); ?></p>
	
	<h3>Project</h3>
    <p><?php echo form_input('project', $project); ?></p>
 
    <p><?php echo form_submit('submit', 'Submit'); ?></p>
 
<?php echo form_close(); ?>