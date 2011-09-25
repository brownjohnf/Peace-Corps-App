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
}