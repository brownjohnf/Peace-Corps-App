<?php
class Partner extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->defaultview_tags['navpath'][] = anchor('public/partner','Partners');
		
		$this->defaultview_tags['leftmenu'] = array(
			anchor('public/senegal', 'About Senegal') => array(),
			anchor('public/what_we_do','What We Do') => array(),
			anchor('public/partner','Partners') => array(),
			anchor('public/senegal/region','Where We Work') => array(),
			anchor('public/case_study','Case Studies') => array()
			);
	}

	public function index()
	{
		$this->headview_tags['page_title'] = 'What We Do > Events';
		
		$this->_print();
	}
}