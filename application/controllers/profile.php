<?php
class Profile extends MY_Controller {
	
	function __construct()
	{
	    parent::__construct();
		$this->load->library('profile_class');
	}
	
	public function view()
	{
		// retrieve profile
		if ($data = $this->profile_class->view($this->uri->segment(3)))
		{
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