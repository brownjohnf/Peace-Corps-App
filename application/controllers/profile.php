<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

class Profile extends MY_Controller {

	function __construct()
	{
	    parent::__construct();
		$this->load->library(array('permission_class', 'profile_class'));
	}

	public function search()
	{
		$this->load->model(array('people_model', 'sector_model', 'stage_model', 'region_model'));

		if ($this->uri->segment(4))
		{
			$results = $this->people_model->selectUsers(array('fields' => 'people.fname, people.lname, people.email1, people.phone1, people.edited', 'where' => array($this->uri->segment(3) => $this->uri->segment(4))));
		}
		else
		{
			$results = $this->people_model->selectUsers(array('fields' => 'people.fname, people.lname, people.email1, people.phone1, people.edited'));
		}

		if (! $results)
		{
			die('no table data');
		}

		foreach ($results as $result)
		{
			$table['fname'] = anchor('profile/view/'.strtolower($result['lname'].'-'.$result['fname']), $result['fname']);
			$table['lname'] = anchor('profile/view/'.strtolower($result['lname'].'-'.$result['fname']), $result['lname']);
			$table['email1'] = $result['email1'];
			$table['phone1'] = $result['phone1'];
			$table['local_name'] = $result['local_name'];
			$table['stage_name'] = $result['stage_name'];
			$table['sector_short'] = strtoupper($result['sector_short']);
			$table['site_name'] = $result['site_name'];
			$table['region_name'] = $result['region_name'];

			$data['table'][] = $table;
		}

		if (! $results = $this->sector_model->read(array('fields' => 'id, name')))
		{
			die('failed to read sectors');
		}
		foreach ($results as $result)
		{
			$sectors[] = anchor('profile/search/sectors.id/'.$result['id'], $result['name']);
		}

		if (! $results = $this->stage_model->read(array('fields' => 'id, name')))
		{
			die('failed to read stages');
		}
		foreach ($results as $result)
		{
			$stages[] = anchor('profile/search/stages.id/'.$result['id'], $result['name']);
		}

		if (! $results = $this->region_model->read(array('fields' => 'id, name')))
		{
			die('failed to read regions');
		}
		foreach ($results as $result)
		{
			$regions[] = anchor('profile/search/political_regions.id/'.$result['id'], $result['name']);
		}

		$data['sectors'] = array_unique($sectors);
		$data['stages'] = array_unique($stages);
		$data['regions'] = array_unique($regions);

		$data['title'] = 'User Profiles';
		$data['backtrack'] = array('' => 'Home', 'profile' => 'Profiles');


	    // print the page
		$this->output->set_header("Cache-Control: max-age=300, public, must-revalidate");

		$this->load->view('head', array('page_title' => $data['title'], 'stylesheets' => array('demo_table.css', 'layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('jquery.dataTables.min.js', 'profile_list.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('profile_list_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer', array('footer' => 'Footer Here'));
	}

	public function view()
	{
		// retrieve profile
		if ($data = $this->profile_class->view($this->uri->segment(3)))
		{
			if ($authorship = $this->permission_class->page_by_author($data['id']))
			{
				$data['author_for'] = $authorship;
			}
			if ($actorship = $this->permission_class->page_by_actor($data['id']))
			{
				$data['actor_for'] = $actorship;
			}

			$data['title'] = 'Profile';
			$data['backtrack'] = array('feed/profile' => 'Profiles', 'profile/view/'.$this->uri->segment(3) => $data['full_name']);

			$data2['profile_photo'] = $data['profile_photo'];
			$data2['profile_id'] = $data['id'];


			// print the profile
			$this->load->view('head', array('page_title' => $data['title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('basic.js', 'jquery.url.js')));
			$this->load->view('header');
			$this->load->view('main_open');
			$this->load->view('left_column');
			$this->load->view('right_column', $data2);
			$this->load->view('profile_view', $data);
		}
		else
		{
			$data['title'] = 'Profile';
			$data['data'] = "<h1>Missing Profile</h1><p>I'm sorry, but there doesn't appear to be a user with that name.</p>";
			$data['backtrack'] = array('feed/profile' => 'Profiles');

			// print the error
			$this->load->view('head', array('page_title' => $data['title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('basic.js', 'jquery.url.js')));
			$this->load->view('header');
			$this->load->view('main_open');
			$this->load->view('left_column');
			$this->load->view('right_column');
			$this->load->view('basic_view', $data);
		}

		$this->load->view('main_close');
		$this->load->view('footer', array('footer' => 'Footer Here'));
	}

	public function edit()
	{
	    if ($this->uri->segment(3, null) == null && $this->input->post('id') == null)
	    {
			$this->session->set_flashdata('error', 'You must specify a profile to edit.');
			redirect('profile');
	    }
	    elseif ($this->userdata['id'] != $this->uri->segment(3))
	    {
	    	$this->session->set_flashdata('error', 'You are not authorized to edit this profile.');
	    	redirect('profile');
	    }

	    $this->load->helper(array('form', 'url'));
	    $this->load->library(array('form_validation', 'user_class'));

		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

	    $this->form_validation->set_rules('fname', 'First Name', 'required');
	    $this->form_validation->set_rules('lname', 'Last Name', 'required|alpha_numeric');
	    $this->form_validation->set_rules('email1', 'Email1', 'required|valid_email');
	    $this->form_validation->set_rules('email2', 'Email2', 'valid_email');
	    $this->form_validation->set_rules('phone1', 'Phone1', 'numeric');
	    $this->form_validation->set_rules('phone2', 'Phone2', 'numeric');
	    $this->form_validation->set_rules('gender', 'Gender', 'numeric');

		if ($this->form_validation->run() == false)
		{
			$data = $this->profile_class->full_form($this->uri->segment(3));

	        $data['target'] = 'edit/'.$this->uri->segment(3);
			$data['form_title'] = 'Edit Profile';
			$data['controls'] = anchor('profile', img(base_url().'img/cancel_icon.png'), array('class' => 'cancel'));
			$data['backtrack'] = array('profile' => 'Profiles', 'profile/edit/'.$this->uri->segment(3) => 'Edit my profile');

			$this->load->view('head', array('page_title' => $data['form_title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css')));
			$this->load->view('header');
			$this->load->view('main_open');
			$this->load->view('left_column');
			//$this->load->view('right_column');
			$this->load->view('profile_form', $data);
			$this->load->view('main_close');
			$this->load->view('footer');
		}
		else
		{
		    if ($id = $this->profile_class->edit($this->input->post()))
		    {
			    $this->session->set_flashdata('success', 'Profile successfully edited.');
			    redirect('profile/view/'.$id);
			}
		    else
		    {
		        die("we've hit a serious database error trying to update the user. ask Jack. [010]");
	        }
	    }
	}
}