<?php

class Menu extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('Menu_model');
		
		$this->headview_tags['page_title'] = 'Menus';
		$this->defaultview_tags['content'] = 'Welcome to the Case Study Management Centre.';
		$this->defaultview_tags['navpath'][] = anchor('admin','Administer');
		
		$this->load->database();
		$this->load->helper('url');
		
		$this->defaultview_tags['leftmenu'] = array(
													'User Administration' => array(
																				anchor('admin/user/show','Show'),
																				anchor('admin/user/add','Add User'),
																				anchor('admin/user/search','Search')
																				),
													'Case Studies' => array(
																		  anchor('admin/case_study/show','Show'),
																		  anchor('admin/case_study/add','Add'),
																		  anchor('admin/case_study/search','Search')
																		  ), 
													'Resources' => array(
																		   anchor('admin/resources/show', 'Show'),
																		   anchor('admin/resources/add','Add'),
																		   anchor('admin/resources/search','Search')
																		   ), 
													'Deep Management' => array(
																		   anchor('admin/region', 'Regions'),
																		   anchor('admin/work_zone','Work Zones'),
																		   anchor('admin/language','Languages'),
																		   anchor('admin/sector','Sectors'),
																		   anchor('admin/tag/system','System Tags'),
																		   anchor('admin/tag/user','User Tags')
																		   )
													);
		
		$this->defaultview_tags['rightmenu'] = array(
													 'Quick Links' => array(
																		   anchor('public/food_security/update','Food Security Update'), 
																		   anchor('public/case_study','Case Studies')
																		   )
													 );$this->load->library('auth');
		/*if (! $this->auth->is_admin())
		{
			redirect('error/permission/not_admin');
		}*/
	}
	
	function index() {
		
		$this->_print();
	}
			
	function create() {
        // Check if form is submitted
   		if ($this->input->post('submit')) {
			$data = array(
						  'title' => $this->security->xss_clean($this->input->post('title')),
						  'description' => $this->security->xss_clean($this->input->post('description')),
						  'content' => $this->security->xss_clean($this->input->post('content'))
						  );
 
            // Add the post
           	$this->Case_study_model->addStudy($data);
			
			// display
			$this->view();
       	} else {
			$this->headview_tags['page_title'] = 'Add Case Study';
			$form_settings = array('target' => 'admin/case_study/add', 'title' => '', 'description' => '', 'content' => '');
				
			$this->_print($this->load->view('admin/menu_form', '',TRUE));
		}
	}
	
	function view() {
		$id = $this->uri->segment(4, 'all');
		
		$data = $this->Case_study_model->getStudy($id);
				
		$this->_print($this->load->view('admin/case_study_view', $data, TRUE));
	}
	
	function show() {
		$this->load->library('pagination');
		$offset = $this->uri->segment(4, 'all');
		
		$config['base_url'] = site_url('admin/case_study/show');
		$config['per_page'] = 3;
		$config['total_rows'] = $this->Case_study_model->countStudies();
		$config['uri_segment'] = 4;
		
		$data = array();
		$data['studies'] = $this->Case_study_model->selectStudies($config['per_page'], $offset);
		
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
				
		$this->_print($this->load->view('admin/case_study_show', $data, TRUE));
	}
	
	function update() {
		$id = $this->uri->segment(4, 0);
 		if ($this->input->post('submit')) {
   			$title = $this->security->xss_clean($this->input->post('title'));
   			$description = $this->security->xss_clean($this->input->post('description'));
        	$content = $this->security->xss_clean($this->input->post('content'));
 
        	$this->Case_study_model->updateStudy($id, $description, $title, $content);
			
			// display
			$this->view();
					
    	} elseif ($id == 0) {
			$this->_print('Please specify a case study to update.');
		} else {
			$data = $this->Case_study_model->getStudy($id);
        	$data['target'] = 'admin/case_study/update/'.$id;
			print_r($data);
			$this->_print($this->load->view('admin/case_study_form', $data, TRUE));
    	}
	}
	
	function delete() {
    	$id = $this->uri->segment(4, 0);
		if ($id == 0) {
			$this->_print('Please specify a case study to delete.');
		} else {
	    	$this->Case_study_model->deleteStudy($id);
			$this->show();
		}
	}

}