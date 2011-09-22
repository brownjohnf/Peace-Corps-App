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