<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

class Resource extends MY_Controller {
	
	function __construct()
	{
	    parent::__construct();
		// is needed for all functions, because it's drawn on by the menu generator
		// in the left_column view
		$this->load->library('module_class');
	}
	
	public function index()
	{
		
		$data['title'] = 'Resources';
		$data['backtrack'] = array('resource' => 'Resources');
		
		$data['data'] = '<h1>Learning Resources</h1><p>Welcome to the resource section. The following resources are currently online:</p><h2>Modules</h2><p>'.anchor('module', 'View all modules').'</p><p>Our training modules are organized by tier and sector. The lower the tier, the broader is the knowledge in that module. Tier Zero covers topics that all Volunteers in all posts worldwide will receive; Tier One materials are broad subjects for all Volunteers in Senegal; Tier Two materials cover sector-specific knowlodge; Tier Three materials are of an advanced nature, and taught selectively.</p><h2>Documents</h2><p>List of recently updated docs to go here...</p>';
		
	    // print the page
		$this->output->set_header("Cache-Control: max-age=300, public, must-revalidate");
		
		$this->load->view('head', array('page_title' => $data['title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('basic.js', 'jquery.url.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('right_column');
		$this->load->view('blank_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer', array('footer' => 'Footer Here'));
	}
	
	public function type_view()
	{
		$this->load->library('resource_class');
		
		$data['table'] = $this->resource_class->type_view();
		$data['title'] = 'Resource Types';
		$data['backtrack'] = array('resource' => 'Resources', 'resource/type_view' => 'Types');
		
		
	    // print the page
		$this->output->set_header("Cache-Control: max-age=300, public, must-revalidate");
		
		$this->load->view('head', array('page_title' => $data['title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css', 'demo_table.css'), 'scripts' => array('basic.js', 'jquery.dataTables.min.js', 'datatable_initiate.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('table_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer', array('footer' => 'Footer Here'));
	}
}