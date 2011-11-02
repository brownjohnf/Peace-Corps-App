<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

class Link extends MY_Controller {
	
	function __construct() {
	    parent::__construct();
		
		if ($this->userdata['group']['name'] != 'admin')
		{
			$this->session->set_flashdata('error', 'You do not have appropriate permissions for this action.');
			redirect('feed/page');
		}
	}
	
	public function view()
	{
		$this->load->model('link_model');
		
		if ($this->uri->segment(4))
		{
			$data['table'] = $this->link_model->read(array('where' => array($this->uri->segment(3) => $this->uri->segment(4))));
		}
		else
		{
			$data['table'] = $this->link_model->read();
		}
		
		//print_r($data);
		
		$data['title'] = 'Links';
		$data['backtrack'] = array('resource' => 'Resources', 'link/view' => 'Links', 'link/view' => 'View');
		
		
	    // print the page
		$this->output->set_header("Cache-Control: max-age=300, public, must-revalidate");
		
		$this->load->view('head', array('page_title' => $data['title'], 'stylesheets' => array('demo_table.css', 'layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('jquery.dataTables.min.js', 'link.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('link_list_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer');
	}
	
	public function create()
	{
	    $this->load->helper(array('form', 'url'));
	    $this->load->library(array('form_validation', 'link_class'));
		$this->load->model('link_model');
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	    
	    $this->form_validation->set_rules('url', 'URL', 'required');
	    $this->form_validation->set_rules('title', 'Title', 'required');
	    
		if ($this->form_validation->run() == false)
		{
			$data = $this->link_class->blank_form();
			$data['target'] = 'create';
			
			$data['form_title'] = 'Create New Link';
			
			$data['controls'] = anchor('link/view', img(base_url().'img/cancel_icon.png'), array('class' => 'cancel'));
			
			$this->load->view('head', array('page_title' => $data['form_title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css')));
			$this->load->view('header');
			$this->load->view('main_open');
			$this->load->view('left_column');
			$this->load->view('link_form', $data);
			$this->load->view('main_close');
			$this->load->view('footer', array('footer' => 'Footer Here'));
		}
		else
		{
		    if ($id = $this->link_class->create($this->input->post()))
		    {
				$this->session->set_flashdata('message', 'Link successfully created.');
		        redirect('link/view/id/'.$id);
		    }
		    else
		    {
				die("we've hit a serious database error trying to create a link. ask Jack. [010]");
		    }
		}
	}
	
	public function edit()
	{
	    if ($this->uri->segment(3, null) == null && $this->input->post('id') == null)
	    {
			$this->session->set_flashdata('error', 'You must specify a user to edit, or simply create a new one here. [007]');
			redirect('link/create');
	    }
	    
	    $this->load->helper(array('form', 'url'));
	    $this->load->library(array('form_validation', 'link_class'));
		$this->load->model('link_model');
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	    
	    $this->form_validation->set_rules('url', 'URL', 'required');
	    $this->form_validation->set_rules('title', 'Title', 'required');
	    
		if ($this->form_validation->run() == false)
		{
			$data = $this->link_class->full_form($this->uri->segment(3));
			
	        $data['target'] = 'edit';
			$data['form_title'] = 'Edit Link Info';
			$data['controls'] = anchor('link/view/id/'.$this->uri->segment(3), img(base_url().'img/cancel_icon.png'), array('class' => 'cancel'));
			
			$this->load->view('head', array('page_title' => $data['form_title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css')));
			$this->load->view('header');
			$this->load->view('main_open');
			$this->load->view('left_column');
			$this->load->view('link_form', $data);
			$this->load->view('main_close');
			$this->load->view('footer');
		}
		else
		{
		    if ($id = $this->link_class->edit($this->input->post()))
		    {
			    $this->session->set_flashdata('success', 'Link successfully edited.');
			    redirect('link/view/id/'.$id);
			}
		    else
		    {
		        die("we've hit a serious database error trying to update the link. ask Jack. [010]");
	        }
	    }
	}
	
	public function delete()
	{
		if (! $this->link_model->delete($this->uri->segment(3, null)))
		{
			$error = "Couldn't delete link.";
		}
		if (isset($error)) {
			$this->session->set_flashdata('error', $error);
		}
		redirect('link/view');
	}
}