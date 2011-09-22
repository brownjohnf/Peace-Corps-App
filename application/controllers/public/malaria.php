<?php
class Malaria extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->defaultview_tags['navpath'][] = anchor('public/what_we_do','What We Do');
		$this->defaultview_tags['navpath'][] = anchor('public/what_we_do/initiative','Initiatives');
		$this->defaultview_tags['navpath'][] = anchor('public/malaria','Malaria');
		$this->defaultview_tags['leftmenu'] = array(
			anchor('public/food_security', 'Food Security') => array(),
			anchor('public/water_sanitation','Water &amp; Sanitation') => array(),
			anchor('public/appropriate_technology','Appropriate Technologies') => array(),
			anchor('public/malaria','Malaria') => array(
				anchor('public/appropriate_technology/rope_pump', 'Rope Pump'),
				anchor('public/appropriate_technology/briquette_press', 'Briquette Press'),
				anchor('public/appropriate_technology/fruit_drier', 'Fruit Drier'),
				anchor('public/appropriate_technology/improved_stoves', 'Improved Stoves'),
				anchor('public/appropriate_technology/uns', 'Universal Nut Sheller')
				)
			);
	}

	public function index()
	{
		$this->headview_tags['page_title'] = 'Malaria';
		
		$this->_print();
	}
}