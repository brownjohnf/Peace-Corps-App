<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

class Stage extends MY_Controller {
	
	function __construct() {
	    parent::__construct();
		
		if (! $this->userdata['is_admin'])
		{
			$this->session->set_flashdata('error', 'You do not have appropriate permissions for this action.');
			redirect('feed/page');
		}
		$this->load->model('stage_model');
	}
	
	public function view()
	{
		
		if ($this->uri->segment(4))
		{
			$data['table'] = $this->stage_model->read(array('fields' => '*', 'where' => array($this->uri->segment(3) => $this->uri->segment(4))));
		}
		else
		{
			$data['table'] = $this->stage_model->read(array('fields' => '*'));
		}
		
		
		$data['title'] = 'Stages';
		$data['backtrack'] = array('admin' => 'Admin Panel', 'user/view' => 'Users', 'stage/view' => 'Stages');
		$data['edit_target'] = 'stage/edit/';
		$data['extra_targets'][] = array('path' => 'user/view/stage_id/', 'column' => 'id', 'text' => 'View Members');
		$data['extra_targets'][] = array('path' => 'stage/delete/', 'column' => 'id', 'text' => 'Delete');
		
		
		
	    // print the page
		$this->output->set_header("Cache-Control: max-age=300, public, must-revalidate");
		
		$this->load->view('head', array('page_title' => $data['title'], 'stylesheets' => array('demo_table.css', 'layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('jquery.dataTables.min.js', 'user.js')));
		$this->load->view('header');
		//$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('table_view', $data);
		//$this->load->view('main_close');
		$this->load->view('footer');
	}
	
	public function create()
	{
	    $this->load->helper(array('form', 'url'));
	    $this->load->library(array('form_validation', 'stage_class'));
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	    
	    $this->form_validation->set_rules('name', 'Stage name', 'required');
	    $this->form_validation->set_rules('cos', 'COS date', 'numeric');
	    $this->form_validation->set_rules('arrival_date', 'Arrival date', 'numeric');
	    $this->form_validation->set_rules('sectors', 'Sectors', 'alpha');
	    
		if ($this->form_validation->run() == false)
		{
			$data = $this->stage_class->blank_form();
			$data['target'] = 'create';
			
			
			$data['form_title'] = 'Create New Stage';
			$data['backtrack'] = array('admin' => 'Admin Panel', 'user/view' => 'Users', 'stage/view' => 'Stages', 'stage/edit' => 'Create');
			
			$data['controls'] = anchor('stage/view', img(base_url().'img/cancel_icon.png'), array('class' => 'cancel'));
			
			$this->load->view('head', array('page_title' => $data['form_title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css')));
			$this->load->view('header');
			$this->load->view('main_open');
			$this->load->view('left_column');
			//$this->load->view('right_column');
			$this->load->view('stage_form', $data);
			$this->load->view('main_close');
			$this->load->view('footer');
		}
		else
		{
		    if ($id = $this->stage_class->create($this->input->post()))
		    {
			$this->session->set_flashdata('message', 'Stage successfully created.');
		        redirect('stage/view/id/'.$id);
		    }
		    else
		    {
			die("we've hit a serious database error trying to create a stage. ask Jack. [010]");
		    }
		}
	}
	
	public function edit()
	{
	    if ($this->uri->segment(3, null) == null && $this->input->post('id') == null)
	    {
			$this->session->set_flashdata('error', 'You must specify a stage to edit, or simply create a new one here. [007]');
			redirect('stage/create');
	    }
	    
	    $this->load->helper(array('form', 'url'));
	    $this->load->library(array('form_validation', 'stage_class'));
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	    
	    $this->form_validation->set_rules('name', 'Stage name', 'required');
	    $this->form_validation->set_rules('cos', 'COS date', 'numeric');
	    $this->form_validation->set_rules('arrival_date', 'Arrival date', 'numeric');
	    $this->form_validation->set_rules('sectors', 'Sectors', 'alpha');
	    
		if ($this->form_validation->run() == false)
		{
			$data = $this->stage_class->full_form($this->uri->segment(3));
			
	        $data['target'] = 'edit/'.$this->uri->segment(3);
			$data['form_title'] = 'Edit Stage Info';
			$data['controls'] = anchor('stage/view/id/'.$this->uri->segment(3), img(base_url().'img/cancel_icon.png'), array('class' => 'cancel'));
			$data['backtrack'] = array('admin' => 'Admin Panel', 'user/view' => 'Users', 'stage/view' => 'Stages', 'stage/edit' => 'Edit');
			
			$this->load->view('head', array('page_title' => $data['form_title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css')));
			$this->load->view('header');
			$this->load->view('main_open');
			$this->load->view('left_column');
			//$this->load->view('right_column');
			$this->load->view('stage_form', $data);
			$this->load->view('main_close');
			$this->load->view('footer');
		}
		else
		{
		    if ($id = $this->stage_class->edit($this->input->post()))
		    {
			    $this->session->set_flashdata('success', 'Stage successfully edited.');
			    redirect('stage/view/id/'.$id);
			}
		    else
		    {
		        die("we've hit a serious database error trying to update the stage. ask Jack. [010]");
	        }
	    }
	}
	
	public function delete()
	{
		if (! $this->volunteer_model->update(array('stage_id' => 1), array('stage_id' => $this->uri->segment(3, null))))
		{
			$error[] = "Couldn't reset stage users.";
		}
		if (! $this->stage_model->delete(array('id' => $this->uri->segment(3))))
		{
			$error[] = "Couldn't delete stage.";
		}
		if (isset($error)) {
			$this->session->set_flashdata('error', implode(' ', $error));
		}
		redirect('stage/view');
	}
}