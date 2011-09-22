<?php
class Case_study extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->defaultview_tags['navpath'][] = anchor('public/case_study','Case Studies');
		$this->defaultview_tags['leftmenu'] = array(
			anchor('public/senegal', 'About Senegal') => array(),
			anchor('public/what_we_do', 'What We Do') => array(),
			anchor('public/partner','Partners') => array(),
			anchor('public/senegal/region','Where We Work') => array(),
			anchor('public/case_study','Case Studies') => array(
				anchor('public/case_study/show/feature', 'Featured'),
				anchor('public/case_study/show/recent', 'Most Recent'),
				anchor('public/case_study/show', 'All')
				)
			);
	}

	public function index()
	{
		$this->headview_tags['page_title'] = 'Case Studies';
		
		$this->_slideshow();
		$this->slideshow['slides'] = array(
			array(
				'img' => 'segou_w559.png',
				'path' => base_url().'public/case_study/view/21',
				'title' => 'A Case Study',
				'caption' => 'Read all about case studies!',
				'position' => 'top'
			),
			array(
				'img' => 'segou_w559.png',
				'path' => base_url().'public/case_study/view/21',
				'title' => 'Yet Another Case Study',
				'caption' => 'Read all about case studies!',
				'position' => 'right'
			),
		);
		
		$this->headview_tags['slideshow'] = $this->load->view('slideshow_view', $this->slideshow, true);
		
		$this->_print();
	}
	
	public function show()
	{
		$this->_print('This page will list '.$this->uri->segment(4, 'all').' case studies.');
	}
	
	public function view()
	{
		$this->_print('View a specific case study');
	}
}