<?php
class Resource extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->headview_tags['page_title'] = 'Resources';
		
		$this->defaultview_tags['navpath'][] = anchor('public/resource','Resources');
		$this->defaultview_tags['leftmenu'] = array(
			anchor('public/resource/report', 'Reports') => array(),
			anchor('public/resource/library', 'Library') => array(),
			anchor('public/resource/reference','Reference Pages') => array(
				anchor('', 'Agriculture'),
				anchor('', 'Health &amp; Environment'),
				anchor('', 'Business'),
				anchor('', 'Language')
				),
			anchor('','How-to Videos') => array(),
			anchor('','Radio Shows') => array()
			);
	}

	public function index()
	{
		$this->_print();
	}

}