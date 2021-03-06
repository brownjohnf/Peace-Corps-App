<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

<div id="page_form" class="content">
    <?php echo validation_errors(); ?>
    <?
        if ($this->session->flashdata('error')) {
            $this->load->view('error');
        }
        if ($this->session->flashdata('success')) {
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
<?php echo form_open('page/'.$target); ?>
<?php echo form_hidden('id', set_value('id', $id)); ?>

<div class="left">
<label>Title*</label><?php echo form_input('title', set_value('title', $title)); ?><br />
</div>
<div class="right">
<label>Parent Page*</label><?php echo form_dropdown('parent_id', $parents, set_value('parent_id', $parent_id)); ?><br />
</div>

<label>Description*</label><?php echo form_input('description', set_value('description', $description)); ?><br />
<label>Content*</label><br><?php echo form_textarea('content', set_value('content', $content)); ?><br />
<span id="insert_photo" class="button1">Insert Photo</span>

<label>Profile Photo*</label>
<div class="left">
<?php echo form_input('profile_photo', set_value('profile_photo', $profile_photo)); ?><br />
</div>
<div class="right">
<?php echo img($profile_photo_info); ?>
</div>

<h2>Linking</h2>

<div class="left">
<label>Right-column Page Link(s)</label><?php echo form_multiselect('links[]', $links, $set_links); ?><br />
</div>
<div class="right">
<label>Auto-linking (automatically adds pages for 'Suggested Reading')</label>
<?php echo form_checkbox('auto_link_child', '1', set_checkbox('updated', '1', false)); ?>&nbsp;auto-link to children<br />
<?php echo form_checkbox('auto_link_sibling', '1', set_checkbox('updated', '1', false)); ?>&nbsp;auto-link to siblings<br />
<?php echo form_checkbox('auto_link_parent', '1', set_checkbox('updated', '1', false)); ?>&nbsp;auto-link to parents
</div>



<h2>Permissions</h2>

<div class="left">
<label>Visibility* (whether or not the page will be in menu)</label>
<?php echo form_dropdown('visibility', array(1 => 'Show', 0 => 'Hide'), set_value('visibility', $visibility)); ?><br />
<label>Editors (users able to edit the page.)</label>
<?php echo form_multiselect('actors[]', $users, $set_actors, $locked); ?><br />
</div>

<div class="right">
<label>Group* (public allows everyone, user allows only pcvs)</label>
<?php echo form_dropdown('group_id', $groups, set_value('group_id', $group_id)); ?><br />
<label>Author(s)</label>
<?php echo form_multiselect('authors[]', $users, $set_authors); ?><br />
</div>
<br class="clearfloat" /><br />

<label>Mark as updated</label>
<?php echo form_checkbox('updated', '1', set_checkbox('updated', '1', false)); ?>&nbsp;If checked, this page will appear in feeds as updated.<br />
<?php echo form_checkbox('case_study', '1', set_checkbox('case_study', '1', $case_study)); ?>&nbsp;Is this a case study?<br />

<label>If you're sure...</label>
<?php echo form_submit('submit', 'Save Page!'); ?>

<?php echo form_close(); ?>
</div>