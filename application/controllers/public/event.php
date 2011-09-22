<?php
class Event extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->defaultview_tags['navpath'][] = anchor('public/what_we_do','What We Do');
		$this->defaultview_tags['navpath'][] = anchor('public/event','Events');
		$this->defaultview_tags['leftmenu'] = array(
			anchor('public/what_we_do/initiative', 'Initiatives') => array(),
			anchor('public/what_we_do/sector', 'Sectors') => array(),
			anchor('public/radio','Radio') => array(),
			anchor('public/what_we_do/event','Events') => array(
				anchor('public/what_we_do/event', 'Kolda Agricultural Fair 2011'),
				anchor('public/what_we_do/event', 'Networking Conference 2011')
				),
			'<a href="http://senegad.pcsenegal.org">SeneGAD</a>' => array()
			);
	}

	public function index()
	{
		$this->headview_tags['page_title'] = 'What We Do > Events';
		
		$this->_print();
	}
}