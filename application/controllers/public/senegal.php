<?php
class Senegal extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->defaultview_tags['navpath'][] = anchor('public/senegal','About Senegal');
		
		$this->defaultview_tags['leftmenu'] = array(
			anchor('public/senegal', 'About Senegal') => array(
				anchor('public/senegal/region', 'Regions'),
				anchor('public/senegal/language', 'Language'),
				anchor('public/senegal/religion', 'Religion'),
				anchor('public/senegal/food', 'Food'),
				anchor('public/senegal/culture', 'Culture')
				),
			anchor('public/what_we_do','What We Do') => array(),
			anchor('public/partner','Partners') => array(),
			anchor('public/senegal/region','Where We Work') => array(),
			anchor('public/case_study','Case Studies') => array()
			);
	}

	public function index()
	{
		$this->_print();
	}
	
	public function region()
	{
		$this->defaultview_tags['navpath'][] = anchor('public/senegal/region','Regions');
		$this->defaultview_tags['leftmenu'] = array(
			anchor('public/senegal/region', 'Regions') => array(
				anchor('public/senegal/region/dakar', 'Dakar'),
				anchor('public/senegal/region/fatick', 'Fatick'),
				anchor('public/senegal/region/kaffrine', 'Kaffrine'),
				anchor('public/senegal/region/kaolack', 'Kaolack'),
				anchor('public/senegal/region/kedougou', 'Kedougou'),
				anchor('public/senegal/region/kolda', 'Kolda'),
				anchor('public/senegal/region/louga', 'Louga'),
				anchor('public/senegal/region/northern_senegal', 'Northern Senegal'),
				anchor('public/senegal/region/tambacounda', 'Tambacounda'),
				anchor('public/senegal/region/thies', 'Thies')
				),
			anchor('public/senegal/language','Language') => array(),
			anchor('public/senegal/religion','Religion') => array(),
			anchor('public/senegal/food','Food') => array(),
			anchor('public/senegal/culture','Culture') => array()
			);
		
		$this->_print();
	}
	
	public function language()
	{
		$this->defaultview_tags['navpath'][] = anchor('public/senegal/language','Language');
		$this->defaultview_tags['leftmenu'] = array(
			anchor('public/senegal/region', 'Regions') => array(),
			anchor('public/senegal/language','Language') => array(
				anchor('public/senegal/language/wolof', 'Wolof'),
				anchor('public/senegal/language/sereer', 'Sereer'),
				anchor('public/senegal/language/pulaar', 'Pulaar'),
				anchor('public/senegal/language/mandinka', 'Mandinka')
				),
			anchor('public/senegal/religion','Religion') => array(),
			anchor('public/senegal/food','Food') => array(),
			anchor('public/senegal/culture','Culture') => array()
			);
		
		$this->_print();
	}
	
	public function religion()
	{
		$this->defaultview_tags['navpath'][] = anchor('public/senegal/religion','Religion');
		$this->defaultview_tags['leftmenu'] = array(
			anchor('public/senegal/region', 'Regions') => array(),
			anchor('public/senegal/language','Language') => array(),
			anchor('public/senegal/religion','Religion') => array(
				anchor('public/senegal/religion/islam', 'Islam'),
				anchor('public/senegal/religion/catholicism', 'Catholicism'),
				anchor('public/senegal/religion/animism', 'Animism')
				),
			anchor('public/senegal/food','Food') => array(),
			anchor('public/senegal/culture','Culture') => array()
			);
		
		$this->_print();
	}
	
	public function food()
	{
		$this->defaultview_tags['navpath'][] = anchor('public/senegal/food','Food');
		$this->defaultview_tags['leftmenu'] = array(
			anchor('public/senegal/region', 'Regions') => array(),
			anchor('public/senegal/language','Language') => array(),
			anchor('public/senegal/religion','Religion') => array(),
			anchor('public/senegal/food','Food') => array(),
			anchor('public/senegal/culture','Culture') => array()
			);
		
		$this->_print();
	}
	
	public function culture()
	{
		$this->defaultview_tags['navpath'][] = anchor('public/senegal/culture','Culture');
		$this->defaultview_tags['leftmenu'] = array(
			anchor('public/senegal/region', 'Regions') => array(),
			anchor('public/senegal/language','Language') => array(),
			anchor('public/senegal/religion','Religion') => array(),
			anchor('public/senegal/food','Food') => array(),
			anchor('public/senegal/culture','Culture') => array()
			);
		
		$this->_print();
	}
}