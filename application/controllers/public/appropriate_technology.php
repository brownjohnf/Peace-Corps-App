<?php
class Appropriate_technology extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->defaultview_tags['navpath'][] = anchor('public/what_we_do/initiative','Initiatives');
		$this->defaultview_tags['navpath'][] = anchor('public/appropriate_technology','Appropriate Technologies');
		$this->defaultview_tags['leftmenu'] = array(
			anchor('public/food_security', 'Food Security') => array(),
			anchor('public/water_sanitation','Water &amp; Sanitation') => array(),
			anchor('public/appropriate_technology','Appropriate Technologies') => array(
				anchor('public/appropriate_technology/rope_pump', 'Rope Pump'),
				anchor('public/appropriate_technology/briquette_press', 'Briquette Press'),
				anchor('public/appropriate_technology/fruit_drier', 'Fruit Drier'),
				anchor('public/appropriate_technology/improved_stoves', 'Improved Stoves'),
				anchor('public/appropriate_technology/uns', 'Universal Nut Sheller')
				),
			anchor('public/malaria','Malaria') => array()
			);
	}

	public function index()
	{
		$this->headview_tags['page_title'] = 'Appropriate Technologies';
		
		$this->_print();
	}

	public function rope_pump()
	{
		$this->defaultview_tags['navpath'][] = anchor('public/appropriate_technology/rope_pump','Rope Pump');
		
		$this->_print();
	}

	public function briquette_press()
	{
		$this->defaultview_tags['navpath'][] = anchor('public/appropriate_technology/briquette_press','Briquette Press');
		
		$this->_print();
	}

	public function fruit_drier()
	{
		$this->defaultview_tags['navpath'][] = anchor('public/appropriate_technology/fruit_drier','Fruit Drier');
		
		$this->_print();
	}

	public function improved_stoves()
	{
		$this->defaultview_tags['navpath'][] = anchor('public/appropriate_technology/improved_stoves','Improved Stoves');
		
		$this->_print();
	}

	public function uns()
	{
		$this->defaultview_tags['navpath'][] = anchor('public/appropriate_technology/uns','Universal Nut Sheller');
		
		$this->_print();
	}
}