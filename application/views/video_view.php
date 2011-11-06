<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

<div id="video_view" class="content standard_view">
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
<p><?=$description?></p>
</div>
<br>

<div>
<?=$embed?>
</div>

<div>
<p>Last updated <?=$edited?>. View on <?=$link?>.</p>
</div>


</div>