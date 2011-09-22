<?php
class Food_security extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->defaultview_tags['navpath'][] = anchor('public/what_we_do','What We Do');
		$this->defaultview_tags['navpath'][] = anchor('public/what_we_do/initiative','Initiatives');
		$this->defaultview_tags['navpath'][] = anchor('public/food_security','Food Security');
		$this->defaultview_tags['leftmenu'] = array(
			anchor('public/food_security', 'Food Security') => array(
				anchor('public/food_security/update', 'Progress Update'),
				anchor('public/food_security/master_farmer', 'Master Farmer'),
				anchor('public/food_security/garden', 'Gardens'),
				anchor('public/food_security/market', 'Markets'),
				anchor('public/food_security/nutrition', 'Nutrition')
				),
			anchor('public/water_sanitation','Water &amp; Sanitation') => array(),
			anchor('public/apptech','Appropriate Technologies') => array(),
			anchor('public/senegal/region','Malaria') => array()
			);
	}

	public function index()
	{
		$this->headview_tags['page_title'] = 'Food Security';
		
		$this->_print();
	}

	public function update()
	{
		$this->defaultview_tags['navpath'][] = anchor('public/food_security/update','Weekly Update');
		
		if (! $this->uri->segment(4, null))
		{
			$content = 'Current update displayed.';
		}
		else
		{
			$content = null;
		}
		
		$this->_print($content);
	}

	public function master_farmer()
	{
		$this->defaultview_tags['navpath'][] = anchor('public/food_security/master_farmer','Master Farmer Program');
		
		$this->_print();
	}

	public function garden()
	{
		$this->defaultview_tags['navpath'][] = anchor('public/food_security/garden','Gardens');
		
		$this->_print();
	}

	public function market()
	{
		$this->defaultview_tags['navpath'][] = anchor('public/food_security/market','Markets');
		
		$this->_print();
	}

	public function nutrition()
	{
		$this->defaultview_tags['navpath'][] = anchor('public/food_security/nutrition','Nutrition');
		
		$this->_print();
	}
}