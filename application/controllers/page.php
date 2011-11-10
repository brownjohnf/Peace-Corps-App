<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

class Page extends MY_Controller {

	function __construct() {
	    parent::__construct();
		$this->load->model('page_model');
		$this->load->library(array('common_class', 'page_class'));
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
	    $data['backtrack'] = array('' => 'Home', 'feed/page' => 'Pages');
	    $data['backtrack'] = $data['backtrack'] + $this->common_class->backtrack($data['parent_id'], 'pages');
	    $data['backtrack']['page/view/'.$url] = $data['title'];
	    
	    $switch = ($data['case_study'] == true ? 'page' : 'case_study');
	    
	    // find relevant case studies by tag
	    $res = null;
	    //print_r($data['tags']);
	    if (is_array($data['tags']))
	    {
	    	$res = $this->tag_class->resource_list_by_tag($data['tags'], array($switch));
	    	//print_r($res);
		}
		
	    // print the page
		$this->output->set_header("Cache-Control: max-age=300, public, must-revalidate");

		$this->load->view('head', array('page_title' => $data['title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('basic.js', 'jquery.url.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('right_column', array('authors' => $data['authors'], 'tags' => $data['tags'], 'profile_photo' => $data['profile_photo'], 'links' => $data['links'], 'resource_list' => $res));
		$this->load->view('page_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer', array('footer' => 'Footer Here'));
	}

	public function create()
	{
		if ($this->userdata['group']['name'] != 'admin' && (! $this->permission_class->is_actor(array('page_id' => $this->uri->segment(3, 0), 'user_id' => $this->userdata['id']))))
		{
			$this->session->set_flashdata('error', 'You do not have appropriate permissions for this action. [create]');
			redirect('feed/page');
		}
		$locked = ($this->userdata['is_admin'] ? null : 'disabled');

	    $this->load->helper('form');
	    $this->load->helper('url');
	    $this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

	    $this->form_validation->set_rules('title', 'Page Title', 'required');
	    $this->form_validation->set_rules('description', 'Description', 'required');
	    $this->form_validation->set_rules('content', 'Content', 'required');
	    $this->form_validation->set_rules('updated', 'Updated', 'is_natural');
	    $this->form_validation->set_rules('auto_child_link', 'Auto-link to children', 'is_natural');
	    $this->form_validation->set_rules('auto_sibling_link', 'Auto-link to siblings', 'is_natural');
	    $this->form_validation->set_rules('auto_parent_link', 'Auto-link to parents', 'is_natural');
	    $this->form_validation->set_rules('visibility', 'visibility', 'required');
	    $this->form_validation->set_rules('group_id', 'Group', 'required');
	    $this->form_validation->set_rules('parent_id', 'Parent', 'required');
	    $this->form_validation->set_rules('profile_photo', 'Profile Photo', 'required');

		if ($this->form_validation->run() == false)
		{
			$data = $this->page_class->blank_form();
			if (($actor_for = $this->permission_class->page_by_actor($this->userdata['id'])) && $this->userdata['group']['name'] != 'admin')
			{
				$data['parents'] = array_intersect_key($data['parents'], $actor_for);
			}
			$data['parent_id'] = $this->uri->segment(3, 0);
			$data['target'] = 'create/'.$data['parent_id'];
			if ($this->input->post('actors')) {
				$data['set_actors'] = $this->input->post('actors');
			}
			if ($this->input->post('authors')) {
				$data['set_authors'] = $this->input->post('authors');
			}
			if ($this->input->post('links')) {
				$data['set_links'] = $this->input->post('links');
			}
			$data['locked'] = $locked;


			$data['form_title'] = 'Create New Page';
			$data['backtrack'] = array('' => 'Home', 'feed/page' => 'Page', 'page/create' => 'Create');

			if (isset($history['page']['view'])) {
				$data['controls'] = anchor('page/view/'.$history['page']['view'], img(base_url().'img/cancel_icon.png'), array('class' => 'cancel'));
			} else {
				$data['controls'] = anchor('feed/page', img(base_url().'img/cancel_icon.png'), array('class' => 'cancel'));
			}

			$this->output->set_header("Cache-Control: max-age=3000, public, must-revalidate");

			$this->load->view('head', array('page_title' => 'Create New Page', 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css', 'nyroModal.css'), 'scripts' => array('jquery.nyroModal.js', 'jquery.nyroModal.filters.link.js', 'page_edit.js', 'basic.js','jquery.url.js')));
			$this->load->view('header');
			$this->load->view('main_open');
			$this->load->view('left_column');
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

		if ($this->userdata['group']['name'] != 'admin' && (! $this->permission_class->is_actor(array('page_id' => $this->uri->segment(3), 'user_id' => $this->userdata['id']))))
		{
			$this->session->set_flashdata('error', 'You do not have appropriate permissions for this action. [edit]');
			redirect('feed/page');
		}
		$locked = ($this->userdata['is_admin'] ? null : 'readonly');

	    $this->load->helper('form');
	    $this->load->helper('url');
	    $this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

	    $this->form_validation->set_rules('title', 'Page Title', 'required');
	    $this->form_validation->set_rules('description', 'Description', 'required');
	    $this->form_validation->set_rules('content', 'Content', 'required');
	    $this->form_validation->set_rules('updated', 'Updated', 'is_natural');
	    $this->form_validation->set_rules('auto_link_child', 'Auto-link to children', 'is_natural');
	    $this->form_validation->set_rules('auto_link_sibling', 'Auto-link to siblings', 'is_natural');
	    $this->form_validation->set_rules('auto_link_parent', 'Auto-link to parents', 'is_natural');
	    $this->form_validation->set_rules('visibility', 'Visibility', 'required');
	    $this->form_validation->set_rules('group_id', 'Group', 'required');
	    $this->form_validation->set_rules('parent_id', 'Parent', 'required');
	    $this->form_validation->set_rules('profile_photo', 'Profile Photo', 'required');
	    $this->form_validation->set_rules('id', 'ID', 'required');

		if ($this->form_validation->run() == false)
		{
			if (! $data = $this->page_class->full_form($this->uri->segment(3)))
			{
				$this->session->set_flashdata('error', 'The page you are trying to edit does not exist.');
				redirect('page/create');
			}
			//if (($actor_for = $this->permission_class->page_by_actor($this->userdata['id'])) && $this->userdata['group']['name'] != 'admin')
			//{
			//	$data['parents'] = array_intersect_key($data['parents'], $actor_for);
			//}
			$data['locked'] = $locked;
	        $data['target'] = 'edit/'.$this->uri->segment(3);
			$data['form_title'] = 'Edit Page';
			if ($this->input->post('actors')) {
			    $data['set_actors'] = $this->input->post('actors');
			}
			if ($this->input->post('authors')) {
			    $data['set_authors'] = $this->input->post('authors');
			}
			if ($this->input->post('links')) {
			    $data['set_links'] = $this->input->post('links');
			}


			$data['controls'] = anchor('page/view/'.$data['url'], img(base_url().'img/cancel_icon.png'), array('class' => 'cancel'));
			$data['backtrack'] = array('' => 'Home', 'feed/page' => 'Pages', 'page/view/'.$data['url'] => $data['title'], 'page/edit/'.$this->uri->segment(3) => 'Edit');

			$this->load->view('head', array('page_title' => 'Edit Page', 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css', 'nyroModal.css'), 'scripts' => array('jquery.nyroModal.js', 'jquery.nyroModal.filters.link.js', 'page_edit.js')));
			$this->load->view('header');
			$this->load->view('main_open');
			$this->load->view('left_column');
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
		if (! $this->userdata['is_admin'])
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
		if (! $this->page_model->delete_page_link(array('page_id' => $this->uri->segment(3))))
		{
			$error[] = 'Could not remove page links. Please look into the problem.';
		}

		if (isset($error)) {
			$this->session->set_flashdata('error', implode(' ', $error));
		} else {
			$this->session->set_flashdata('success', 'Page successfully deleted.');
		}

		redirect('feed/page');
	}

	public function tree()
	{
		if (! $this->userdata['is_admin'])
		{
			$this->session->set_flashdata('error', 'You do not have appropriate permissions for this action.');
			redirect('feed/page');
		}
		$data['data'] = $this->page_class->menu();
		$data['title'] = 'Page Tree';
		$data['backtrack'] = array('' => 'Home', 'feed/page' => 'Pages', 'page/tree' => 'Page Tree');

		$this->load->view('head', array('page_title' => $data['title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('basic.js', 'jquery.url.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('right_column');
		$this->load->view('basic_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer', array('footer' => 'Footer Here'));
	}
}