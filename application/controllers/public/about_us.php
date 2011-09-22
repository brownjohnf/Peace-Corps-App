<?php
class About_us extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->defaultview_tags['navpath'][] = anchor('public/about_us','About Us');
		$this->defaultview_tags['leftmenu'] = array(
			anchor('public/about_us/staff', 'Staff') => array(
				anchor('public/user/hedrick_chris', 'Country Director'),
				anchor('public/about_us/staff/apcd', 'Program Directors'),
				anchor('public/about_us/staff/finance', 'Finance'),
				anchor('public/about_us/staff/tech', 'Technical Trainers'),
				anchor('public/about_us/staff/general_service', 'General Services'),
				anchor('public/about_us/staff/lcf', 'LCFs'),
				anchor('public/about_us/staff/thies', 'Thies Training Center')
				),
			anchor('public/about_us/volunteer','Volunteers') => array(),
			anchor('public/about_us/pcresponse','Peace Corps Response') => array(),
			anchor('public/about_us/intern','Interns') => array(),
			anchor('public/about_us/contact','Contact Us') => array()
			);
	}

	public function index()
	{
		$this->_print();
	}

	public function staff()
	{
		$this->defaultview_tags['navpath'][] = anchor('public/about_us/staff','Staff');
		
		$this->_print();
	}

	public function volunteer()
	{
		$this->defaultview_tags['navpath'][] = anchor('public/about_us/volunteer','Volunteers');
		
		$this->_print();
	}

	public function pcresponse()
	{
		$this->defaultview_tags['navpath'][] = anchor('public/about_us/pcresponse','Peace Corps Response');
		
		$this->_print();
	}

	public function intern()
	{
		$this->defaultview_tags['navpath'][] = anchor('public/about_us/intern','Interns');
		
		$this->_print();
	}

	public function contact()
	{
		$this->defaultview_tags['navpath'][] = anchor('public/about_us/contact','Contact Us');
		
		$this->_print();
	}
}