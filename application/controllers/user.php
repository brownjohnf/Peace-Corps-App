<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

class User extends MY_Controller {
	
	function __construct() {
	    parent::__construct();
	}
	
	public function view()
	{
		$this->load->model('people_model');
		
		if ($this->uri->segment(4, false))
		{
			$data['table'] = $this->people_model->selectUsers(array('where' => array('people.'.$this->uri->segment(3) => $this->uri->segment(4))));
		}
		else
		{
			$data['table'] = $this->people_model->selectUsers();
		}
		
		//print_r($data);
		
		$data['title'] = 'All Users';
		$data['backtrack'] = array('admin' => 'Admin Panel', 'user/view' => 'Users', 'user/view/' => 'All');
		
		
	    // print the page
		$this->output->set_header("Cache-Control: max-age=300, public, must-revalidate");
		
		$this->load->view('head', array('page_title' => $data['title'], 'stylesheets' => array('demo_table.css', 'layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('jquery.dataTables.min.js', 'user.js', 'basic.js', 'jquery.url.js')));
		$this->load->view('header');
		//$this->load->view('main_open');
		//$this->load->view('left_column');
		$this->load->view('user_list_view', $data);
		//$this->load->view('main_close');
		$this->load->view('footer', array('footer' => 'Footer Here'));
	}
	
	public function create()
	{
	    $this->load->helper(array('form', 'url'));
	    $this->load->library(array('form_validation', 'user_class'));
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	    
	    $this->form_validation->set_rules('fname', 'First Name', 'required');
	    $this->form_validation->set_rules('lname', 'Last Name', 'required');
	    $this->form_validation->set_rules('group_id', 'Group', 'required');
	    $this->form_validation->set_rules('stage_id', 'Stage', 'required');
	    $this->form_validation->set_rules('sector_id', 'Sector', 'required');
	    $this->form_validation->set_rules('email', 'Email', 'required');
	    
		if ($this->form_validation->run() == false)
		{
			$data = $this->user_class->blank_form();
			$data['target'] = 'create';
			
			if ($this->input->post('sectors')) {
				$data['set_sectors'] = $this->input->post('sectors');
			}
			if ($this->input->post('groups')) {
				$data['set_groups'] = $this->input->post('groups');
			}
			
			
			$data['form_title'] = 'Create New User';
			
			$data['controls'] = anchor('user/view', img(base_url().'img/cancel_icon.png'), array('class' => 'cancel'));
			
			$this->load->view('head', array('page_title' => $data['form_title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('basic.js','jquery.url.js')));
			$this->load->view('header');
			$this->load->view('main_open');
			$this->load->view('left_column');
			$this->load->view('right_column');
			$this->load->view('user_form', $data);
			$this->load->view('main_close');
			$this->load->view('footer', array('footer' => 'Footer Here'));
		}
		else
		{
		    if ($id = $this->user_class->create($this->input->post()))
		    {
			$this->session->set_flashdata('message', 'User successfully created.');
		        redirect('user/view/id/'.$id);
		    }
		    else
		    {
			die("we've hit a serious database error trying to create a user. ask Jack. [010]");
		    }
		}
	}
	
	public function edit()
	{
	    if ($this->uri->segment(3, null) == null && $this->input->post('id') == null)
	    {
			$this->session->set_flashdata('error', 'You must specify a user to edit, or simply create a new one here. [007]');
			redirect('user/create');
	    }
	    
	    $this->load->helper(array('form', 'url'));
	    $this->load->library(array('form_validation', 'user_class'));
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	    
	    $this->form_validation->set_rules('fname', 'First Name', 'required');
	    $this->form_validation->set_rules('lname', 'Last Name', 'required');
	    $this->form_validation->set_rules('group_id', 'Group', 'required');
	    $this->form_validation->set_rules('stage_id', 'Stage', 'required');
	    $this->form_validation->set_rules('sector_id', 'Sector', 'required');
	    $this->form_validation->set_rules('email', 'Email', 'required');
	    
		if ($this->form_validation->run() == false)
		{
			$data = $this->user_class->full_form($this->uri->segment(3));
			
	        $data['target'] = 'edit';
			$data['form_title'] = 'Edit User Info';
			$data['controls'] = anchor('user/view/id/'.$this->uri->segment(3), img(base_url().'img/cancel_icon.png'), array('class' => 'cancel'));
			
			$this->load->view('head', array('page_title' => $data['form_title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('basic.js', 'jquery.url.js')));
			$this->load->view('header');
			$this->load->view('main_open');
			$this->load->view('left_column');
			$this->load->view('right_column');
			$this->load->view('user_form', $data);
			$this->load->view('main_close');
			$this->load->view('footer', array('footer' => 'Footer Here'));
		}
		else
		{
		    if ($id = $this->user_class->edit($this->input->post()))
		    {
			    $this->session->set_flashdata('success', 'User successfully edited.');
			    redirect('user/view/id/'.$id);
			}
		    else
		    {
		        die("we've hit a serious database error trying to update the user. ask Jack. [010]");
	        }
	    }
	}
	
	public function delete()
	{
		if (! $this->people_model->delete($this->uri->segment(3, null)))
		{
			$error = "Couldn't delete page.";
		}
		if (! $this->permission_model->purge_by_user($this->uri->segment(3, null)))
		{
			$error = "Couldn't purge page references.";
		}
		if (isset($error)) {
			$this->session->set_flashdata('error', $error);
		}
		redirect('user/view');
	}
}