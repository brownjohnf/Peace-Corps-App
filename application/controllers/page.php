<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

class Page extends MY_Controller {
	
	function __construct() {
	    parent::__construct();
		$this->load->library('page_class');
		$this->load->library(array('common_class'));
	}
	
	public function index()
	{
		redirect('feed/page');
	}
	
	public function view()
	{
	    // check to make sure that a page has been specified
	    if (! $url = $this->uri->segment(3, false))
	    {
			redirect('feed/page');
	    }
	    
	    // retrieve the page information
	    $data = $this->page_class->view($url);
	    
	    // retrieve the backtrack url for the top of the page. takes the content id and table name
	    // the backtrack function can only be called for content with a 'parent' field, and a valid hierarchical structure
	    $data['backtrack'] = $this->common_class->backtrack($data['parent_id'], 'pages');
	    $data['backtrack'][$url] = $data['title'];
	    
	    // print the page
		$this->output->set_header("Cache-Control: max-age=300, public, must-revalidate");
		
		$this->load->view('head', array('page_title' => $data['title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('basic.js', 'jquery.url.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('right_column', array('authors' => $data['authors'], 'tags' => $data['tags'], 'profile_photo' => $data['profile_photo']));
		$this->load->view('page_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer', array('footer' => 'Footer Here'));
	}
	
	public function create()
	{
		if ($this->userdata['group']['name'] != 'Admin' && (! $this->permission_class->is_actor(array('page_id' => $this->uri->segment(3, 0), 'user_id' => $this->userdata['id']))))
		{
			$this->session->set_flashdata('error', 'You do not have appropriate permissions for this action. [create]');
			redirect('feed/page');
		}
	    $this->load->helper('form');
	    $this->load->helper('url');
	    $this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	    
	    $this->form_validation->set_rules('title', 'Page Title', 'required');
	    $this->form_validation->set_rules('description', 'Description', 'required');
	    $this->form_validation->set_rules('content', 'Content', 'required');
	    $this->form_validation->set_rules('updated', 'Updated', 'required');
	    $this->form_validation->set_rules('group_id', 'Group', 'required');
	    $this->form_validation->set_rules('parent_id', 'Parent', 'required');
	    $this->form_validation->set_rules('profile_photo', 'Profile Photo', 'required');
	    
		if ($this->form_validation->run() == false)
		{
			$data = $this->page_class->blank_form();
			if ($actor_for = $this->permission_class->page_by_actor($this->userdata['id']) && $this->userdata['group']['name'] != 'Admin')
			{
				$data['parents'] = array_intersect_key($data['parents'], array($this->uri->segment(3) => 'test'));
				$data['users'] = array_intersect_key($data['users'], array($this->userdata['id'] => 'test'));
				//print_r($data);
			}
			$data['parent_id'] = $this->uri->segment(3, 0);
			$data['target'] = 'create/'.$data['parent_id'];
			if ($this->input->post('actors')) {
				$data['set_actors'] = $this->input->post('actors');
			}
			if ($this->input->post('authors')) {
				$data['set_authors'] = $this->input->post('authors');
			}
			
			
			$data['form_title'] = 'Create New Page';
			
			if (isset($history['page']['view'])) {
				$data['controls'] = anchor('page/view/'.$history['page']['view'], img(base_url().'img/cancel_icon.png'), array('class' => 'cancel'));
			} else {
				$data['controls'] = anchor('feed/page', img(base_url().'img/cancel_icon.png'), array('class' => 'cancel'));
			}
			
			$this->output->set_header("Cache-Control: max-age=3000, public, must-revalidate");
			
			$this->load->view('head', array('page_title' => 'Create New Page', 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css', 'nyroModal.css'), 'scripts' => array('jquery.nyroModal.js', 'jquery.nyroModal.filters.link.js', 'page_edit.js', 'basic.js','jquery.url.js')));
			$this->load->view('header');
			$this->load->view('main_open');
			$this->load->view('left_column', $left_col);
			$this->load->view('right_column');
			$this->load->view('page_form', $data);
			$this->load->view('main_close');
			$this->load->view('footer', array('footer' => 'Footer Here'));
		}
		else
		{
		    if ($url = $this->page_class->create($this->input->post()))
		    {
			$this->session->set_flashdata('success', 'Page successfully created.');
		        redirect('page/view/'.$url);
		    }
		    else
		    {
			die("we've hit a serious database error trying to create a page. ask Jack. [010]");
		    }
		}
	}
	
	public function edit()
	{
	    if ($this->uri->segment(3, null) == null && $this->input->post('id') == null)
	    {
			$this->session->set_flashdata('error', 'You must specify a page to edit, or simply create a new one here. [007]');
			redirect('page/create');
	    }
		
		if ($this->userdata['group']['name'] != 'Admin' && (! $this->permission_class->is_actor(array('page_id' => $this->uri->segment(3), 'user_id' => $this->userdata['id']))))
		{
			$this->session->set_flashdata('error', 'You do not have appropriate permissions for this action. [edit]');
			redirect('feed/page');
		}
	    
	    $this->load->helper('form');
	    $this->load->helper('url');
	    $this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	    
	    $this->form_validation->set_rules('title', 'Page Title', 'required');
	    $this->form_validation->set_rules('description', 'Description', 'required');
	    $this->form_validation->set_rules('content', 'Content', 'required');
	    $this->form_validation->set_rules('updated', 'Updated', 'required');
	    $this->form_validation->set_rules('group_id', 'Group', 'required');
	    $this->form_validation->set_rules('parent_id', 'Parent', 'required');
	    $this->form_validation->set_rules('profile_photo', 'Profile Photo', 'required');
	    $this->form_validation->set_rules('id', 'ID', 'required');
	    
		if ($this->form_validation->run() == false)
		{
			$data = $this->page_class->full_form($this->uri->segment(3));
	        $data['target'] = 'edit/'.$this->uri->segment(3);
			$data['form_title'] = 'Edit Page';
			if ($this->input->post('actors')) {
			    $data['set_actors'] = $this->input->post('actors');
			}
			if ($this->input->post('authors')) {
			    $data['set_authors'] = $this->input->post('authors');
			}
			
			
			$data['controls'] = anchor('page/view/'.$data['url'], img(base_url().'img/cancel_icon.png'), array('class' => 'cancel'));
			
			$this->load->view('head', array('page_title' => 'Edit Page', 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css', 'nyroModal.css'), 'scripts' => array('jquery.nyroModal.js', 'jquery.nyroModal.filters.link.js', 'page_edit.js', 'basic.js', 'jquery.url.js')));
			$this->load->view('header');
			$this->load->view('main_open');
			$this->load->view('left_column', $left_col);
			$this->load->view('right_column');
			$this->load->view('page_form', $data);
			$this->load->view('main_close');
			$this->load->view('footer', array('footer' => 'Footer Here'));
		}
		else
		{
		    if ($url = $this->page_class->edit($this->input->post()))
		    {
			    $this->session->set_flashdata('success', 'Page successfully edited.');
			    redirect('page/view/'.$url);
			}
			else
			{
				die("we've hit a serious database error trying to create a page. ask Jack. [010]");
			}
	    }
	}
	
	public function delete()
	{
		if ($this->userdata['group']['name'] != 'Admin')
		{
			$this->session->set_flashdata('error', 'You do not have appropriate permissions for this action.');
			redirect('feed/page');
		}
		
		if (! $this->page_model->delete($this->uri->segment(3, null)))
		{
			$error[] = "Couldn't delete page.";
		}
		if (! $this->permission_model->purge_by_page($this->uri->segment(3, null)))
		{
			$error[] = "Couldn't purge page references.";
		}
		if (! $this->page_model->reset_parent($this->uri->segment(3, null)))
		{
			$error[] = 'Failed to reset pages that pointed to this one. You now have orphaned pages.';
		}
		if (! $this->tag_model->delete(array('source' => 'page', 'source_id' => $this->uri->segment(3))))
		{
			$error[] = 'Could not remove tags. Please look into the problem.';
		}
		
		if (isset($error)) {
			$this->session->set_flashdata('error', implode(' ', $error));
		} else {
			$this->session->set_flashdata('success', 'Page successfully deleted.');
		}
		
		redirect('feed/page');
	}
}