<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

class Feed extends MY_Controller {
	
	function __construct() {
	    parent::__construct();
		$this->load->library(array('page_class', 'common_class', 'tag_class'));
	}

	public function index()
	{
		redirect('feed/page');
		$this->load->library('blog_class');
		
	    $pages = $this->page_class->feed();
		$blogs = $this->blog_class->feed();
	    //echo '<pre>'; echo print_r($feed['data']); echo '</pre>';
		
		krsort($blogs);
		$blogs_chunks = array_chunk($blogs, 10, true);
		$pages_chunks = array_chunk($pages, 10, true);
		
		$data['feed'] = $pages_chunks[0] + $blogs_chunks[0];
		//print_r($data['feed']);
		krsort($data['feed']);
		//print_r($data['feed']);
	    
		$data['backtrack'] = array('feed' => 'Feed');
		
		$this->load->view('head', array('page_title' => 'Updates', 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('basic.js', 'jquery.url.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('right_column');
		$this->load->view('feed_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer', array('footer' => 'Footer Here'));
	}

	public function blog()
	{
		$this->load->library('blog_class');
		
		$blogs = $this->blog_class->feed();
	    //echo '<pre>'; echo print_r($feed['data']); echo '</pre>';
		
		krsort($blogs);
		$blogs_chunks = array_chunk($blogs, 10, true);
		
		$data['feed'] = $blogs_chunks[0];
		
		// retrieve tags w/o optional sorting/filter
		$tags['tags'] = $this->tag_class->cloud();
	    
		$data['backtrack'] = array('feed' => 'Feed', 'feed/blog' => 'Blogs');
		
		$this->load->view('head', array('page_title' => 'Recently Updated Blogs', 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('basic.js', 'jquery.url.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('right_column', $tags);
		$this->load->view('feed_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer', array('footer' => 'Footer Here'));
	}

	public function page()
	{
	    $data['feed'] = $this->page_class->feed();
	    //echo '<pre>'; echo print_r($feed['data']); echo '</pre>';
	    
		// retrieve tags w/o optional sorting/filter
		$tags['tags'] = $this->tag_class->cloud();
	    
		$data['backtrack'] = array('feed' => 'Feed', 'feed/page' => 'Pages');
		
		$this->load->view('head', array('page_title' => 'Page Updates', 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('basic.js', 'jquery.url.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('right_column', $tags);
		$this->load->view('feed_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer', array('footer' => 'Footer Here'));
	}
	
	public function profile()
	{
	    $data['feed'] = $this->page_class->feed();
	    //echo '<pre>'; echo print_r($feed['data']); echo '</pre>';
	    
		// retrieve tags w/o optional sorting/filter
		$tags['tags'] = $this->tag_class->cloud();
	    
		$data['backtrack'] = array('feed' => 'Feed', 'feed/page' => 'Pages');
		
		$this->load->view('head', array('page_title' => 'Page Updates', 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('basic.js', 'jquery.url.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('right_column', $tags);
		$this->load->view('feed_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer', array('footer' => 'Footer Here'));
	}

	public function tag()
	{
		$this->load->library('tag_class');
		
	    $data['feed'] = $this->tag_class->feed(urldecode($this->uri->segment(3, null)));
	    //echo '<pre>'; echo print_r($data); echo '</pre>';
	    
		// retrieve tags w/o optional sorting/filter
		$tags['tags'] = $this->tag_class->cloud();
		
		$data['backtrack'] = array('feed' => 'Feed', 'feed/tag' => 'Tags');
		
		$this->load->view('head', array('page_title' => 'Tag Updates', 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('basic.js', 'jquery.url.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('right_column', $tags);
		$this->load->view('feed_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer', array('footer' => 'Footer Here'));
	}
	
	public function video() {
		
		$data['backtrack'] = array('feed' => 'Feed', 'feed/video' => 'Videos');
		$data['data'] = "<h1>Coming Soon: Video Updates</h1><p>Sorry, but we haven't quite finished this part yet! Come back soon to check out the latest videos from the production houses of Peace Corps Senegal.</p>";
		
		$this->load->view('head', array('page_title' => 'Coming Soon: Video Updates', 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('basic.js', 'jquery.url.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('right_column');
		$this->load->view('basic_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer', array('footer' => 'Footer Here'));
	}
}