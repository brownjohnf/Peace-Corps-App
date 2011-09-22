<?php
class Resources extends MY_Controller {

	public function index()
	{	
		$this->headview_tags['page_title'] = 'Resources';
		
		$this->defaultview_tags['leftmenu'] = array(
													'Resources' => array(
																		  anchor('public/events','Events'), 
																		  anchor('public/resaurces/documents','Documents'), 
																		  anchor('public/radio','Radio'), 
																		  anchor('public/resources/video','Video'), 
																		  anchor('public/photos','Photos')
																		  )
													);
		$this->defaultview_tags['rightmenu'] = array(
													 'Quick Links' =>array(
																		   anchor('public/foodsec/update','Food Security Update'), 
																		   anchor('public/case_study','Case Studies')
																		   )
													 );
		
		$this->_print();
	}

}