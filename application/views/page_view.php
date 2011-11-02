<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

<div id="page_view" class="content">
    <?
        if ($this->session->flashdata('error')) {
            $this->load->view('error');
        }
        if ($this->session->flashdata('success')) {
            $this->load->view('success');
        }
    ?>
<div id="backtrack">
<?php foreach ($backtrack as $key => $value): ?>
		<?php echo anchor($key, $value).'&nbsp;&gt; '; ?>
<? endforeach; ?>
</div>

<h1>
    <?=$title?>
    <div class="controls">
		<?=$controls?>
	</div>
</h1>

<div>
<?=$content?>
</div>


<div class="actors">
<?php if ($actors): ?>
    <h3>Editors</h3>
    <p>
        <?php $count = count($actors); foreach ($actors as $actor_id => $actor): ?>
        <?php echo anchor('profile/view/'.$actor['url'], $actor['name']); if ($count > 1) echo '&nbsp;|&nbsp;'; $count--;?>
        <?php endforeach; ?>
    </p>
<?php endif; ?>
</div>

</div>