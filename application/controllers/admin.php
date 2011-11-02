<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

class Admin extends MY_Controller {
	
	function __construct() {
	    parent::__construct();
		
		if ($this->userdata['group']['name'] != 'admin')
		{
			$this->session->set_flashdata('error', 'You are not a site Admin, and therefore do not have access to this portion of the site.');
			redirect('feed/page');
		}
	    $this->load->library('admin_class');
	}
	
	public function index()
	{
		redirect('feed/page');
	}
	
	public function edit_site_messages()
	{
	    $this->load->helper('form');
	    $this->load->helper('url');
	    $this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	    
	    $this->form_validation->set_rules('error', 'Error', 'callback_pass');
	    $this->form_validation->set_rules('message', 'Message', 'callback_pass');
	    $this->form_validation->set_rules('success', 'Success', 'callback_pass');
	    $this->form_validation->set_rules('alert', 'Alert', 'callback_pass');
		
		if ($this->form_validation->run() == false)
		{
			$results = $this->admin_class->read_site_messages();
			foreach ($results as $result)
			{
				$data[$result['type']] = $result['content'];
				$data['id'] = $result['id'];
			}
			
			$data['form_title'] = 'Edit Site Messages';
			$data['controls'] = anchor('admin', img(base_url().'img/cancel_icon.png'), array('class' => 'cancel'));
			$data['backtrack'] = array('' => 'Home', 'admin' => 'Admin Control Panel', 'admin/site/messages/edit' => 'Edit Site Messages');
			
			$this->load->view('head', array('page_title' => 'Edit Site Messages', 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('basic.js', 'jquery.url.js')));
			$this->load->view('header');
			$this->load->view('main_open');
			$this->load->view('left_column');
			$this->load->view('site_messages_form', $data);
			$this->load->view('main_close');
			$this->load->view('footer');
		}
		else
		{
		    if ($edit = $this->admin_class->edit_site_messages($this->input->post()))
		    {
			    $this->session->set_flashdata('success', 'Site messages set successfully. It will take one page transition for them to appear.');
			    redirect('feed/page');
			}
			else
			{
				die("we've hit a serious database error trying to edit site messages. [110]");
			}
	    }
	}
	
	function pass($a)
	{
		return true;
	}
}