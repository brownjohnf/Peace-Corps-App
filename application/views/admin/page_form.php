<h1>Add New Page</h1>
<?php $this->load->helper('form'); ?>
 
<?php echo form_open($target, '', array('path' => $path_string)); ?>
	
	<h3>Path</h3>
    <p>
    	<?php foreach ($path as $key => $value): ?>
    	<?php echo form_input($key, $value); ?>/
    	<?php endforeach; ?>
    </p>

	<h3>Title</h3>
 	<p><?php echo form_input('title', $title); ?></p>
	
	<h3>Description</h3>
    <p>Optional unless a case study. Recommended.<br /><?php echo form_textarea(array('name' => 'description', 'value' => $description, 'style' => 'height: 100px;')); ?></p>
    
	<h3>Author</h3>
	<p><?php echo form_dropdown('author_id', $users, $author_id); ?></p>
	
	<h3>Content</h3>
    <p><?php echo form_textarea(array('name' => 'content',  'value' => $content, 'style' => 'height: 300px;')); ?></p>
 
    <p><?php echo form_submit('submit', 'Submit').'&nbsp;'; echo form_submit('cancel', 'Cancel'); ?>&nbsp;<?php echo form_checkbox('update', 'yes'); ?><-Mark this page as updated</p>
 
<?php echo form_close(); ?>