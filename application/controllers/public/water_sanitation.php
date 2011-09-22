<?php
class Water_sanitation extends MY_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		$this->defaultview_tags['navpath'][] = anchor('public/what_we_do','What We Do');
		$this->defaultview_tags['navpath'][] = anchor('public/what_we_do/initiative','Initiatives');
		$this->defaultview_tags['navpath'][] = anchor('public/what_we_do/water_sanitation','Water &amp; Sanitation');
		$this->defaultview_tags['leftmenu'] = array(
			anchor('public/food_security', 'Food Security') => array(),
			anchor('public/water_sanitation','Water &amp; Sanitation') => array(
				anchor('public/water_sanitation/map', 'Project Map')
				),
			anchor('public/appropriate_technology','Appropriate Technologies') => array(),
			anchor('public/malaria','Malaria') => array()
			);
	}

	public function index()
	{
		$this->headview_tags['page_title'] = 'Water &amp; Sanitation';
		
		$this->_print();
	}

	public function map()
	{
		$this->_google_earth();
		
		$this->headview_tags['slideshow'] = $this->load->view('google_earth', array('height'=> 400), true);
		
		$this->defaultview_tags['navpath'][] = anchor('what_we_do/water_sanitation/map','Project Map');
		
		$this->_print();
	}
}