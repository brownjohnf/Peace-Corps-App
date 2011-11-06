<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

class Video extends MY_Controller {

	function __construct() {
	    parent::__construct();

		$this->load->library('video_class');
	}

	public function search()
	{
		if ($this->uri->segment(4))
		{
			$data['table'] = $this->video_model->read(array('where' => array($this->uri->segment(3) => $this->uri->segment(4))));
		}
		else
		{
			$data['table'] = $this->video_model->read();
		}

		//print_r($data);

		$data['title'] = 'Videos';
		$data['backtrack'] = array('resource' => 'Resources', 'video' => 'Videos', 'video/' => 'View');


	    // print the page
		$this->output->set_header("Cache-Control: max-age=300, public, must-revalidate");

		$this->load->view('head', array('page_title' => $data['title'], 'stylesheets' => array('demo_table.css', 'layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('jquery.dataTables.min.js', 'video.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('video_list_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer');
	}

	public function admin()
	{
		if (! $this->userdata['is_admin'])
		{
			$this->session->set_userdata('error', 'You do not have appropriate permissions to administer videos.');
			redirect('video');
		}

		if ($this->uri->segment(4))
		{
			$data['table'] = $this->video_model->read(array('where' => array($this->uri->segment(3) => $this->uri->segment(4))));
		}
		else
		{
			$data['table'] = $this->video_model->read();
		}

		//print_r($data);

		$data['title'] = 'Videos';
		$data['backtrack'] = array('resource' => 'Resources', 'video' => 'Videos', 'link/admin' => 'Admin');


	    // print the page
		$this->output->set_header("Cache-Control: max-age=300, public, must-revalidate");

		$this->load->view('head', array('page_title' => $data['title'], 'stylesheets' => array('demo_table.css', 'layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('jquery.dataTables.min.js', 'datatable_initiate.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('table_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer');
	}

	public function view()
	{
		if ($this->uri->segment(3) && is_numeric($this->uri->segment(3)))
		{
			if (! $data = $this->video_class->view($this->uri->segment(3)))
			{
				redirect('video');
			}
		}
		else
		{
			$this->session->set_flashdata('error', 'You must specifiy a video to view, using its unique ID number.');
			redirect('video');
		}


		$data['backtrack'] = array('resource' => 'Resources', 'video' => 'Videos', 'video/view/'.$data['id'] => $data['title']);
		$tags['tags'] = $data['tags'];

		$this->load->view('head', array('page_title' => $data['title'], 'stylesheets' => array('demo_table.css', 'layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('jquery.dataTables.min.js', 'datatable_initiate.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('right_column', $tags);
		$this->load->view('video_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer');
	}

	public function create()
	{
		if (! $this->userdata['is_admin'])
		{
			$this->session->set_userdata('error', 'You do not have appropriate permissions to administer videos.');
			redirect('video');
		}

	    $this->load->helper(array('form', 'url'));
	    $this->load->library(array('form_validation', 'tag_class'));

		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

	    $this->form_validation->set_rules('title', 'Title', 'required');
	    $this->form_validation->set_rules('description', 'Description', 'required');
	    $this->form_validation->set_rules('embed', 'Embed code', 'required');
	    $this->form_validation->set_rules('link', 'Link', 'required');
	    $this->form_validation->set_rules('tags', 'Tags', 'callback_tag_check');
	    $this->form_validation->set_rules('video_type', 'Video Type', 'required');

		if ($this->form_validation->run() == false)
		{
			$data = $this->video_class->blank_form();
			$data['target'] = 'create';

			$data['form_title'] = 'Log New Video';
			$data['backtrack'] = array('resource' => 'Resources', 'video/admin' => 'Manage Videos', 'video/create' => 'New');
			$data['controls'] = anchor('video', img(base_url().'img/cancel_icon.png'), array('class' => 'cancel'));

			$this->load->view('head', array('page_title' => $data['form_title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css')));
			$this->load->view('header');
			$this->load->view('main_open');
			$this->load->view('left_column');
			$this->load->view('video_form', $data);
			$this->load->view('main_close');
			$this->load->view('footer');
		}
		else
		{
		    if ($id = $this->video_class->create($this->input->post()))
		    {
				$this->session->set_flashdata('message', 'Video successfully created.');
		        redirect('video/view/'.$id.'/'.url_title($this->input->post('title'), 'underscore'));
		    }
		    else
		    {
				die("we've hit a serious database error trying to log a video. ask Jack. [010]");
		    }
		}
	}

	public function edit()
	{
		if (! $this->userdata['is_admin'])
		{
			$this->session->set_userdata('error', 'You do not have appropriate permissions to administer videos.');
			redirect('video');
		}

	    if ($this->uri->segment(3, null) == null && $this->input->post('id') == null)
	    {
			$this->session->set_flashdata('error', 'You must specify a user to edit, or simply create a new one here. [007]');
			redirect('video/create');
	    }

	    $this->load->helper(array('form', 'url'));
	    $this->load->library(array('form_validation', 'tag_class'));

		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

	    $this->form_validation->set_rules('title', 'Title', 'required');
	    $this->form_validation->set_rules('description', 'Description', 'required');
	    $this->form_validation->set_rules('embed', 'Embed code', 'required');
	    $this->form_validation->set_rules('link', 'Link', 'required');
	    $this->form_validation->set_rules('tags', 'Tags', 'callback_tag_check');
	    $this->form_validation->set_rules('video_type', 'Video Type', 'required');

		if ($this->form_validation->run() == false)
		{
			$data = $this->video_class->full_form($this->uri->segment(3));

	        $data['target'] = 'edit/'.$this->uri->segment(3);
			$data['form_title'] = 'Edit Video Info';
			$data['controls'] = anchor('video/view/'.$this->uri->segment(3), img(base_url().'img/cancel_icon.png'), array('class' => 'cancel'));
			$data['backtrack'] = array('resource' => 'Resources', 'video' => 'Videos', 'video/admin' => 'Admin', 'video/edit/'.$this->uri->segment(3) => 'Edit');

			$this->load->view('head', array('page_title' => $data['form_title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css')));
			$this->load->view('header');
			$this->load->view('main_open');
			$this->load->view('left_column');
			$this->load->view('video_form', $data);
			$this->load->view('main_close');
			$this->load->view('footer');
		}
		else
		{
		    if ($id = $this->video_class->edit($this->input->post()))
		    {
			    $this->session->set_flashdata('success', 'Video successfully edited.');
		        redirect('video/view/'.$id.'/'.url_title($this->input->post('title'), 'underscore'));
			}
		    else
		    {
		        die("we've hit a serious database error trying to update the link. ask Jack. [010]");
	        }
	    }
	}

	public function delete()
	{
		if (! $this->userdata['is_admin'])
		{
			$this->session->set_userdata('error', 'You do not have appropriate permissions to administer videos.');
			redirect('video');
		}

		if (! $this->video_model->delete($this->uri->segment(3)))
		{
			$error = "Couldn't delete video.";
		}
		if (isset($error)) {
			$this->session->set_flashdata('error', $error);
		}
		redirect('video/admin');
	}

	// validation callback function for checking tags
	function tag_check($tags)
	{
		if ($fail = $this->tag_class->check_tag_input($tags))
		{
			$this->form_validation->set_message($fail[0], $fail[1]);
			return false;
		}
		else
		{
			return true;
		}
	}
}