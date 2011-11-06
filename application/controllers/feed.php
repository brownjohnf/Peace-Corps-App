<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

class Feed extends MY_Controller {

	function __construct() {
	    parent::__construct();
		$this->load->library(array('page_class', 'common_class', 'tag_class', 'casestudy_class', 'blog_class', 'document_class', 'link_class', 'video_class'));
	}

	public function index()
	{
		//redirect('feed/page');

	    $pages = $this->page_class->feed();
		$blogs = $this->blog_class->feed();
		$cs = $this->casestudy_class->feed();
		$docs = $this->document_class->feed();
		$links = $this->link_class->feed();
		$vids = $this->video_class->feed();
	    //echo '<pre>'; echo print_r($feed['data']); echo '</pre>';

		$feed = $pages + $blogs + $cs + $docs + $links + $vids;
		//print_r($data['feed']);
		krsort($feed);
		//print_r($data['feed']);
		$chunks = array_chunk($feed, 10, true);
		$data['feed'] = $chunks[0];

		// retrieve tags w/o optional sorting/filter
		$tags['tags'] = $this->tag_class->cloud();

		$data['backtrack'] = array('feed' => 'Feed');

		$this->load->view('head', array('page_title' => 'Updates', 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('right_column', $tags);
		$this->load->view('feed_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer');
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

	public function document()
	{
		$docs = $this->document_class->feed();
	    //echo '<pre>'; echo print_r($feed['data']); echo '</pre>';

		krsort($docs);
		$chunks = array_chunk($docs, 10, true);

		$data['feed'] = $chunks[0];

		// retrieve tags w/o optional sorting/filter
		$tags['tags'] = $this->tag_class->cloud();

		$data['backtrack'] = array('feed' => 'Feed', 'feed/document' => 'Documents');

		$this->load->view('head', array('page_title' => 'Recently Updated Documents', 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('right_column', $tags);
		$this->load->view('feed_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer');
	}

	public function link()
	{
		$feed = $this->link_class->feed();
	    //echo '<pre>'; echo print_r($feed['data']); echo '</pre>';

		krsort($feed);
		$chunks = array_chunk($feed, 10, true);

		$data['feed'] = $chunks[0];

		// retrieve tags w/o optional sorting/filter
		$tags['tags'] = $this->tag_class->cloud();

		$data['backtrack'] = array('feed' => 'Feed', 'feed/link' => 'Links');

		$this->load->view('head', array('page_title' => 'Recently Updated Documents', 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('right_column', $tags);
		$this->load->view('feed_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer');
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
		$this->load->view('footer');
	}

	public function casestudy()
	{
	    $data['feed'] = $this->casestudy_class->feed();
	    //echo '<pre>'; echo print_r($feed['data']); echo '</pre>';

		// retrieve tags w/o optional sorting/filter
		$tags['tags'] = $this->tag_class->cloud();

		$data['backtrack'] = array('feed' => 'Feed', 'feed/casestudy' => 'Case Studies');

		$this->load->view('head', array('page_title' => 'Case Study Updates', 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('basic.js', 'jquery.url.js')));
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
		$this->load->view('footer');
	}

	public function tag()
	{
	    $data['feed'] = $this->tag_class->feed(urldecode($this->uri->segment(3)));
	    //echo '<pre>'; echo print_r($data); echo '</pre>';

		// retrieve tags w/o optional sorting/filter
		$tags['tags'] = $this->tag_class->cloud();

		$data['backtrack'] = array('feed' => 'Feed', 'feed/tag' => 'Tags');

		$this->load->view('head', array('page_title' => 'Tag Updates', 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('right_column', $tags);
		$this->load->view('feed_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer');
	}

	public function video()
	{
	    $data['feed'] = $this->video_class->feed();
	    //echo '<pre>'; echo print_r($feed['data']); echo '</pre>';

		// retrieve tags w/o optional sorting/filter
		$tags['tags'] = $this->tag_class->cloud();

		$data['backtrack'] = array('feed' => 'Feed', 'feed/video' => 'Videos');

		$this->load->view('head', array('page_title' => 'Case Study Updates', 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('right_column', $tags);
		$this->load->view('feed_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer');
	}
}