<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

class User extends MY_Controller {

	function __construct() {
	    parent::__construct();

		if (! $this->userdata['is_admin'])
		{
			$this->session->set_flashdata('error', 'You do not have appropriate permissions for this action.');
			redirect('feed/page');
		}
	}

	public function view()
	{
		$this->load->model('people_model');

		if ($this->uri->segment(4))
		{
			$data['table'] = $this->people_model->selectUsers(array('fields' => 'people.id, people.fname, people.lname, people.gender, people.email1, people.email2, people.phone1, people.phone2, people.address, people.blog_address, people.blog_name, people.blog_description, people.is_user, people.is_admin, people.is_moderator, people.created, people.edited, people.last_activity', 'where' => array($this->uri->segment(3) => $this->uri->segment(4))));
		}
		else
		{
			$data['table'] = $this->people_model->selectUsers(array('fields' => 'people.id, people.fname, people.lname, people.gender, people.email1, people.email2, people.phone1, people.phone2, people.address, people.blog_address, people.blog_name, people.blog_description, people.is_user, people.is_admin, people.is_moderator, people.created, people.edited, people.last_activity'));
		}

		//print_r($data);

		$data['title'] = 'All Users';
		$data['backtrack'] = array('admin' => 'Admin Panel', 'user/view' => 'Users', 'user/view/' => 'All');
		$data['edit_target'] = 'user/edit/';
		$data['extra_targets'][] = array('path' => 'user/delete/', 'column' => 'id', 'text' => 'Delete');
		$data['extra_targets'][] = array('path' => 'profile/view/', 'column' => 'id', 'text' => 'Profile');


	    // print the page
		$this->output->set_header("Cache-Control: max-age=300, public, must-revalidate");

		$this->load->view('head', array('page_title' => $data['title'], 'stylesheets' => array('demo_table.css', 'layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('jquery.dataTables.min.js', 'user.js')));
		$this->load->view('header');
		//$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('table_view', $data);
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
	    $this->form_validation->set_rules('group_id', 'Group', 'required|numeric');
	    $this->form_validation->set_rules('stage_id', 'Stage', 'required|numeric');
	    $this->form_validation->set_rules('sector_id', 'Sector', 'required|numeric');
	    $this->form_validation->set_rules('email1', 'Email1', 'required|valid_email');
	    $this->form_validation->set_rules('email2', 'Email2', 'valid_email');
	    $this->form_validation->set_rules('phone1', 'Phone1', 'numeric');
	    $this->form_validation->set_rules('phone2', 'Phone2', 'numeric');
	    $this->form_validation->set_rules('gender', 'Gender', 'numeric');
	    $this->form_validation->set_rules('is_user', 'is_user', 'is_natural');
	    $this->form_validation->set_rules('is_moderator', 'is_moderator', 'is_natural');
	    $this->form_validation->set_rules('is_admin', 'is_moderator', 'is_natural');

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
			$data['backtrack'] = array('admin' => 'Admin Panel', 'user/view' => 'Users', 'user/view/create' => 'New');
			$data['controls'] = anchor('user/view', img(base_url().'img/cancel_icon.png'), array('class' => 'cancel'));

			$this->load->view('head', array('page_title' => $data['form_title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css')));
			$this->load->view('header');
			$this->load->view('main_open');
			$this->load->view('left_column');
			//$this->load->view('right_column');
			$this->load->view('user_form', $data);
			$this->load->view('main_close');
			$this->load->view('footer');
		}
		else
		{
		    if ($id = $this->user_class->create($this->input->post()))
		    {
			$this->session->set_flashdata('message', 'User successfully created.');
		        redirect('user/view/user_id/'.$id);
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
	    $this->form_validation->set_rules('group_id', 'Group', 'required|numeric');
	    $this->form_validation->set_rules('stage_id', 'Stage', 'required|numeric');
	    $this->form_validation->set_rules('sector_id', 'Sector', 'required|numeric');
	    $this->form_validation->set_rules('email1', 'Email1', 'required|valid_email');
	    $this->form_validation->set_rules('email2', 'Email2', 'valid_email');
	    $this->form_validation->set_rules('phone1', 'Phone1', 'numeric');
	    $this->form_validation->set_rules('phone2', 'Phone2', 'numeric');
	    $this->form_validation->set_rules('gender', 'Gender', 'numeric');
	    $this->form_validation->set_rules('is_user', 'is_user', 'is_natural');
	    $this->form_validation->set_rules('is_moderator', 'is_moderator', 'is_natural');
	    $this->form_validation->set_rules('is_admin', 'is_moderator', 'is_natural');

		if ($this->form_validation->run() == false)
		{
			$data = $this->user_class->full_form($this->uri->segment(3));

	        $data['target'] = 'edit/'.$this->uri->segment(3);
			$data['form_title'] = 'Edit User Info';
			$data['controls'] = anchor('user/view/user_id/'.$this->uri->segment(3), img(base_url().'img/cancel_icon.png'), array('class' => 'cancel'));
			$data['backtrack'] = array('admin' => 'Admin Panel', 'user/view' => 'Users', 'user/edit/'.$this->uri->segment(3) => 'Edit');

			$this->load->view('head', array('page_title' => $data['form_title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css')));
			$this->load->view('header');
			$this->load->view('main_open');
			$this->load->view('left_column');
			//$this->load->view('right_column');
			$this->load->view('user_form', $data);
			$this->load->view('main_close');
			$this->load->view('footer');
		}
		else
		{
		    if ($id = $this->user_class->edit($this->input->post()))
		    {
			    $this->session->set_flashdata('success', 'User successfully edited.');
			    redirect('user/view/user_id/'.$id);
			}
		    else
		    {
		        die("we've hit a serious database error trying to update the user. ask Jack. [010]");
	        }
	    }
	}

	public function delete()
	{
		if (! $this->people_model->delete(array('id' => $this->uri->segment(3))))
		{
			$error[] = "Couldn't delete user.";
		}
		if (! $this->permission_model->purge_by_user(array('id' => $this->uri->segment(3, null))))
		{
			$error[] = "Couldn't purge user references.";
		}
		if (isset($error)) {
			$this->session->set_flashdata('error', implode(' ', $error));
		}
		redirect('user/view');
	}

	public function upload()
	{
		$data['form_title'] = 'Upload Users';
		$data['backtrack'] = array('admin' => 'Admin Panel', 'user/view' => 'Users', 'user/upload' => 'Upload Bath');

		$this->load->view('head', array('page_title' => 'Upload Photo', 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('user_upload_form', $data);
		$this->load->view('main_close');
		$this->load->view('footer', array('footer' => 'Footer Here'));
	}

	public function do_upload()
	{
		ini_set("memory_limit","128M");
		$this->config->load('upload_users', true);
		$config = $this->config->item('upload_users');
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$this->session->set_flashdata('error', $this->upload->display_errors());
			redirect('user/upload');
		}
		else
		{
			$this->load->library('user_class');
			$this->load->model(array('user_model', 'site_model', 'sector_model', 'region_model', 'stage_model', 'group_model', 'volunteer_model', 'people_model'));
			if (! $this->user_class->upload($this->upload->data()))
			{
				//$this->session->set_flashdata('error', 'Your data could not be saved. Please try again.');
				redirect('user/upload');
			}
			else
			{
				$this->session->set_flashdata('success', 'Your users were successfully added.');
				redirect('user/view');
			}
		}
	}
}