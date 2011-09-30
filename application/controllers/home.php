<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

class Home extends MY_Controller {
	
	function __construct() {
	    parent::__construct();
		
	}

	public function index()
	{
		redirect(base_url());
	}

	public function splash()
	{
		$this->load->library(array('common_class'));
		
		$data['col1'] = '<h2>Browse</h2>'.$this->page_class->menu(1, 0);
		$data['col2'] = '<h2>Contact Us</h2><p>Peace Corps Senegal<br>Almadies Lot N/1 TF 23231<br>BP 2534<br>Dakar Yoff<br>Senegal, West Africa</p><p>admin@pcsenegal.org<br>Phone: +221 33 859 7575<br>Fax: +221 33 859 7580</p>';
		$data['col3'] = '<h2>Legal</h2><p>All content and design protected under Creative Commons Copyright. &copy;2011 Peace Corps Senegal.<p/><p>The contents of this web site do not reflect in any way the positions of the U.S. Government or the United States Peace Corps. This web site is managed and supported by Peace Corps Senegal Volunteers and our supporters. It is not a U.S. Government web site.</p>';
		
		$this->output->set_header("Cache-Control: max-age=300, public, must-revalidate");
		
		$this->load->view('head', array('page_title' => 'Peace Corps Senegal | Welcome', 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css', 'anythingslider.css'), 'scripts' => array('jquery.easing.1.2.js', 'jquery.anythingslider.min.js', 'my_anything_slider.js')));
		$this->load->view('header');
		$this->load->view('splash_view', $data);
	}
	
	public function login_redirect()
	{
		if ($this->auth->is_user())
		{
			$this->session->set_flashdata('success', 'You have successfully logged in.');
			redirect(base_url().'profile/view/'.$this->userdata['url']);
		}
		else
		{
			redirect(base_url().'home/welcome');
		}
	}
	
	public function welcome()
	{
		$data['title'] = 'Welcome!';
		$data['data'] = "<h1>Thanks for signing in!</h1><p>We're glad you decided to sign in, and would like to encourage you to join the Peace Corps Senegal community. You're not currently registered as a Volunteer, Staff, or Administrator. If you believe this is an error, contact the site administrator.</p><h2>What Now?</h2><p>We encourage you to join our email list, or sign up for Facebook updates from us. We value privacy, and although you've already registered with us by signing in through Facebook, we'll only send you information if you explicitly request it. If you're already signed up and would like to unregister, you can do so here.</p><p>Stay tuned for more ways to get involved.</p><h3>Friends &amp; Family</h3><p>Is your son or daughter, best friend or college buddy, mother or father currently serving with us? See if they have a blog, take a look at their profile, or donate to their project.</p><h3>Development Agencies</h3><p>Are you a member of another Peace Corps post, Peace Corps Washington, a stateside NGO, or abroad here in the field? Take a look at how we collaborate with development agencies of all kinds at home and abroad, and see about working with us. Already working with us? Want a little oversight? We're committed to transparency, and you can view what we're up to in the fields of malaria prevention and food security development.</p><h3>Developers</h3><p>Have a little web savvy? Have a lot? Consider the joining the team keeping this platform alive and kicking. Read more about it on its homepage.</p>";
		$data['backtrack'] = array('' => 'Home', 'home/welcome' => 'Welcome');
		
		// print the error
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