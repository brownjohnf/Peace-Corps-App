<?php
class Get_involved extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->defaultview_tags['navpath'][] = anchor('public/get_involved','Get Involved');
		$this->defaultview_tags['leftmenu'] = array(
			anchor('public/get_involved/donate', 'Donate') => array(
				anchor('public/get_involved/donate/country_fund', 'Country Fund'),
				anchor('public/get_involved/donate/partnership', 'Peace Corps Partnership')
				),
			anchor('public/get_involved/library','Libraries') => array(),
			anchor('public/get_involved/fellow','PC Fellows') => array()
			);
	}

	public function index()
	{
		$this->_print();
	}

	public function donate()
	{
		$this->defaultview_tags['navpath'][] = anchor('public/get_involved/donate','Donate');
		
		$this->_print();
	}

	public function library()
	{
		$this->defaultview_tags['navpath'][] = anchor('public/get_involved/library','Libraries');
		
		$this->_print();
	}

	public function fellow()
	{
		$this->defaultview_tags['navpath'][] = anchor('public/get_involved/fellow','Peace Corps Senegal Fellowship');
		
		$this->_print();
	}
}