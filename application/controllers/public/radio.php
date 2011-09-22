<?php
class Radio extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->defaultview_tags['navpath'][] = anchor('public/what_we_do','What We Do');
		$this->defaultview_tags['navpath'][] = anchor('public/radio','Radio Production');
		$this->defaultview_tags['leftmenu'] = array(
			anchor('public/radio/sample','Sample Shows') => array(),
			anchor('public/radio/station', 'Stations') => array(),
			anchor('public/radio/tool','Tools') => array(
				anchor('public/radio/script', 'Scripts'),
				anchor('public/radio/tool/writing', 'Writing Guide'),
				anchor('public/radio/audacity', 'Adaucity Recording Manual')
				)
			);
	}

	public function index()
	{
		$this->defaultview_tags['leftmenu'] = array(
			anchor('public/what_we_do/initiative','Initiatives') => array(),
			anchor('public/what_we_do/sector', 'Sectors') => array(),
			anchor('public/radio','Radio') => array(
				anchor('public/radio/sample', 'Sample Shows'),
				anchor('public/radio/station', 'Stations'),
				anchor('public/radio/tool', 'Tools')
			),
			anchor('public/event','Events') => array(),
			'<a href="http://senegad.pcsenegal.org">SeneGAD</a>' => array()
			);
		
		$this->_print();
	}

	public function sample()
	{
		$this->defaultview_tags['navpath'][] = anchor('public/radio/sample','Sample Shows');
		
		$this->_print();
	}

	public function station()
	{
		$this->defaultview_tags['navpath'][] = anchor('public/radio/station','Stations');
		
		$this->_print();
	}

	public function tool()
	{
		$this->defaultview_tags['navpath'][] = anchor('public/radio/tool','Tools');
		
		$this->_print();
	}

	public function script()
	{
		$this->defaultview_tags['navpath'][] = anchor('public/radio/tool','Tools');
		$this->defaultview_tags['navpath'][] = anchor('public/radio/script','Scripts');
		
		$this->_print();
	}

	public function audacity()
	{
		$this->defaultview_tags['navpath'][] = anchor('public/radio/tool','Tools');
		$this->defaultview_tags['navpath'][] = anchor('public/radio/audacity','Audacity Recording Manual');
		
		$this->_print();
	}

}