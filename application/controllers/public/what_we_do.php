<?php
class What_we_do extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->defaultview_tags['navpath'][] = anchor('public/what_we_do','What We Do');
		$this->defaultview_tags['leftmenu'] = array(
			anchor('public/what_we_do/initiative','Initiatives') => array(
				anchor('public/food_security', 'Food Security'),
				anchor('public/water_sanitation', 'Water &amp; Sanitation'),
				anchor('public/appropriate_technology', 'Appropriate Technologies'),
				anchor('public/malaria', 'Malaria')
			),
			anchor('public/what_we_do/sector', 'Sectors') => array(),
			anchor('public/radio','Radio') => array(),
			anchor('public/event','Events') => array(),
			'<a href="http://senegad.pcsenegal.org">SeneGAD</a>' => array()
			);
	}

	public function index()
	{	
		$this->headview_tags['page_title'] = 'What We Do';
		
		$this->defaultview_tags['leftmenu'] = array(
			anchor('public/senegal', 'About Senegal') => array(),
			anchor('public/what_we_do','What We Do') => array(
				anchor('public/what_we_do/initiative', 'Initiatives'),
				anchor('public/what_we_do/sector', 'Sectors'),
				anchor('public/radio', 'Radio'),
				anchor('public/event', 'Events'),
				'<a href="http://senegad.pcsenegal.org">SeneGAD</a>'
				),
			anchor('public/partner','Partners') => array(),
			anchor('public/senegal/region','Where We Work') => array(),
			anchor('public/case_study','Case Studies') => array()
			);
		
		$this->_print();
	}

	public function sector()
	{
		$this->headview_tags['page_title'] = 'What We Do > Sectors';
		
		$this->defaultview_tags['navpath'][] = anchor('public/what_we_do/sector','Sectors');
		$this->defaultview_tags['leftmenu'] = array(
			anchor('public/what_we_do/initiative','Initiatives') => array(),
			anchor('public/what_we_do/sector', 'Sectors') => array(
				anchor('public/what_we_do/sector/agfo', 'Agroforestry'),
				anchor('public/business', 'Business'),
				anchor('public/what_we_do/sector/ee', 'Environmental Ed'),
				anchor('public/what_we_do/sector/he', 'Health'),
				anchor('public/what_we_do/sector/susag', 'Sustainable Ag'),
				anchor('public/what_we_do/sector/uag', 'Urban Ag')
				),
			anchor('public/radio','Radio') => array(),
			anchor('public/event','Events') => array(),
			'<a href="http://senegad.pcsenegal.org">SeneGAD</a>' => array()
			);
		
		$this->_print();
	}

	public function event()
	{
		$this->headview_tags['page_title'] = 'What We Do > Events';
		
		$this->defaultview_tags['navpath'][] = anchor('public/what_we_do/event','Events');
		$this->defaultview_tags['leftmenu'] = array(
			anchor('public/what_we_do/sector', 'Sectors') => array(),
			anchor('public/what_we_do/event','Events') => array(
				anchor('public/what_we_do/event', 'Kolda Agricultural Fair 2011'),
				anchor('public/what_we_do/event', 'Networking Conference 2011')
				),
			anchor('public/case_study','Case Studies') => array(),
			'<a href="http://senegad.pcsenegal.org">SeneGAD</a>' => array()
			);
		
		$this->_print();
	}
	
	public function initiative()
	{
		$this->headview_tags['page_title'] = 'Initiatives';
		
		$this->defaultview_tags['navpath'][] = anchor('public/what_we_do/initiative','Initiatives');
		
		$this->_print();
	}
}