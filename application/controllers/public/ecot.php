<?php
class Ecot extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->defaultview_tags['navpath'][] = anchor('public/what_we_do','What We Do');
		$this->defaultview_tags['navpath'][] = anchor('public/sector','Sectors');
		$this->defaultview_tags['navpath'][] = anchor('public/business','Business');
		$this->defaultview_tags['navpath'][] = anchor('public/business','Ecotourism');
		$this->defaultview_tags['leftmenu'] = array(
			anchor('public/what_we_do/sector/agfo', 'Agroforestry') => array(),
			anchor('public/business', 'Business') => array(
				anchor('public/ecot','Ecotourism'),
				anchor('public/business/agribusiness', 'Agribusiness'),
				anchor('public/business/waste_management','Waste Management'),
				anchor('public/business/entrepreneurship','Entrepreneurship'),
				anchor('public/artisan','Artisan Network')
				),
			anchor('public/what_we_do/sector/ee', 'Environmental Ed') => array(),
			anchor('public/what_we_do/sector/he', 'Health') => array(),
			anchor('public/what_we_do/sector/susag', 'Sustainable Ag') => array(),
			anchor('public/what_we_do/sector/uag', 'Urban Ag') => array()
			);
	}

	public function index()
	{
		$this->_print();
	}
}