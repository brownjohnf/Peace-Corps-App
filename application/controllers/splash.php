<?php
class Splash extends MY_Controller {
	
	function __construct() {
	    parent::__construct();
		
	}

	public function index()
	{
		$this->load->library('menu_class');
		
		$data['col1'] = '<h2>Browse</h2>'.$this->menu_class->menu(1, 0);
		$data['col2'] = '<h2>Contact Us</h2><p>Peace Corps Senegal<br>Almadies Lot N/1 TF 23231<br>BP 2534<br>Dakar Yoff<br>Senegal, West Africa</p><p>admin@pcsenegal.org<br>Phone: +221 33 859 7575<br>Fax: +221 33 859 7580</p>';
		$data['col3'] = '<h2>Legal</h2><p>All content and design protected under Creative Commons Copyright. &copy;2011 Peace Corps Senegal.<p/><p>The contents of this web site do not reflect in any way the positions of the U.S. Government or the United States Peace Corps. This web site is managed and supported by Peace Corps Senegal Volunteers and our supporters. It is not a U.S. Government web site.</p>';
		
		$this->output->set_header("Cache-Control: max-age=300, public, must-revalidate");
		
		$this->load->view('head', array('page_title' => 'Peace Corps Senegal | Welcome', 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css', 'anythingslider.css'), 'scripts' => array('jquery.easing.1.2.js', 'jquery.anythingslider.min.js', 'my_anything_slider.js')));
		$this->load->view('header');
		$this->load->view('splash_view', $data);
	}
}