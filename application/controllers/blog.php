<?php
class Blog extends MY_Controller {
	
	function __construct()
	{
	    parent::__construct();
		$this->load->library('blog_class');
	}
	
	public function index()
	{
		// retrieve all volunteer blogs
		$data['feed'] = $this->blog_class->feed();
		
		$data['title'] = 'Blogs';
		$data['backtrack'] = array('blog' => 'Blogs');
		
	    // print the list of blogs
		$this->load->view('head', array('page_title' => $data['title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('basic.js', 'jquery.url.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('right_column');
		$this->load->view('feed_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer', array('footer' => 'Footer Here'));
	}
	
	public function view()
	{
		if (! $names = $this->uri->segment(3, false))
		{
			$data = 'You must specify a user.';
			die($data);
		}
		
		$data = $this->blog_class->view($names);
		$data['title'] = $data['fname'].'&nbsp;'.$data['lname']."'s Recent Blog Posts";
		$data['backtrack'] = array('feed/blog' => 'Blogs', 'profile/view/'.url_title($data['lname'].'-'.$data['fname'], 'dash', true) => $data['fname'].'&nbsp;'.$data['lname']);
		$data['controls'] = null;
		
		$data2['profile_photo'] = $data['profile_photo'];
		$data2['user_info'] = 'yes';
		$data2['blog_url'] = $data['blog_address'];
		$data2['name'] = $data['fname'].'&nbsp;'.$data['lname'];
		//print_r($data);
		
	    // print the blog posts
		$this->output->set_header("Cache-Control: max-age=300, public, must-revalidate");
		
		$this->load->view('head', array('page_title' => $data['title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('basic.js', 'jquery.url.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('right_column', $data2);
		$this->load->view('blog_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer', array('footer' => 'Footer Here'));
	}
}