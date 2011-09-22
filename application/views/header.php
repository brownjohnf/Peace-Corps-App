<?php
	$topmenu = array(anchor('','Home', array('name' => 'home')), anchor('feed','Updates', array('name' => 'feed')), anchor('resource','Resources', array('name' => 'resource')), anchor('photo/gallery','Photos', array('name' => 'photo')), anchor('feed/video','Videos', array('name' => 'video')), anchor('feed/blog', 'Blogs'), array('name' => 'blog'));
?>
<body>
	<div id="outer_container">
		<div id="header_outer">
			<div id="header_inner">
				<a id="site_title" href="<?php echo base_url(); ?>"><span id="pc">Peace Corps</span>&nbsp;<span id="title_separator">|</span>&nbsp;<span id="country">Senegal</span></a>
				<ul class="hmenu" id="main_menu">
					<?php foreach ($topmenu as $item): ?>
					<li><?php echo $item; ?></li>
					<?php endforeach; ?>
				</ul>
				<ul class="hmenu" id="user_menu">
					<?php foreach ($this->user_menu as $item): ?>
					<li><?php echo $item; ?></li>
					<?php endforeach; ?>
				</ul>
				<br class="clearfloat" />
			</div><!-- end #header_inner -->
			<br class="clearfloat" />
		</div><!-- END #header_outer -->
		
		<?php
if ($this->session->flashdata('alert'))
{
    $this->load->view('alert');
}
if ($this->session->flashdata('message'))
{
    $this->load->view('message');
}
?>