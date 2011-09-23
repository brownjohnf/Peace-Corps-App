<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

<div id="gallery_view" class="content">
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
    <?=$title?>
    <div class="controls">
		<?=$controls?>
	</div>
</h1>

<div id="gallery">
<?php

foreach ($photos as $photo)
{
    echo img($photo);
}

?>

<br class="clearfloat" />
</div>
</div>