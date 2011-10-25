<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

class Photo extends MY_Controller {
	
	function __construct() {
	    parent::__construct();
		$this->load->library('photo_class');
	    $this->load->helper('form');
	    $this->load->helper('url');
	}
	
	public function add()
	{
		if (! $this->auth->is_user())
		{
			$this->session->set_flashdata('error', 'You do not have appropriate permissions for this action. [upload photo]');
			redirect('photo/gallery');
		}
		$data['form_title'] = 'Upload Photo';
		$data['user_id'] = $this->userdata['id'];
		
		$this->load->view('head', array('page_title' => 'Upload Photo', 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('basic.js', 'jquery.url.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('right_column');
		$this->load->view('photo_form', $data);
		$this->load->view('main_close');
		$this->load->view('footer', array('footer' => 'Footer Here'));
	}
	
	public function upload()
	{
		if (! $this->auth->is_user())
		{
			$this->session->set_flashdata('error', 'You do not have appropriate permissions for this action. [upload photo]');
			redirect('photo/gallery');
		}
		ini_set("memory_limit","128M");
		$this->load->config('photo');
		$this->load->library('upload');

		if ( ! $this->upload->do_upload())
		{
			$this->session->set_flashdata('error', $this->upload->display_errors());
			redirect('photo/add');
		}
		else
		{
			$this->load->library('image_lib');
			
			// set an array of sizes to be created
			$photos = array(
							array('width' => 50, 'height' => 50, 'name' => '_thumb'),
							array('width' => 180, 'height' => 180, 'name' => '_sm'),
							array('width' => 180, 'height' => null, 'name' => '_180w'),
							array('width' => null, 'height' => 180, 'name' => '_180h'),
							array('width' => 658, 'height' => 390, 'name' => '_splash'),
							array('width' => 980, 'height' => null, 'name' => '_lrg')
							);
			
			// process each photo
			foreach ($photos as $photo)
			{
				$success = $this->photo_class->create($this->upload->data(), $photo);
			}
				
			$this->session->set_flashdata('success', print_r($success, true));
			redirect('photo/add');
		}
	}
	
	public function gallery()
	{
		$this->load->model('photo_model');
		$results = $this->photo_model->read(array('where' => array('height' => 180), 'order_by' => array('column' => 'width', 'order' => 'desc')));
		foreach ($results as $result)
		{
			if ($result['width'] != 180)
			{
				$count = round(980 / $result['width']);
				$margin = (980 - $result['width'] * $count) / $count / 2;
				$data['photos'][] = array('src' => base_url().'uploads/'.$result['filename'].$result['extension'], 'height' => '180px', 'width' => $result['width'], 'style' => 'margin:'.$margin.'px;');
			}
		}
		
		$data['title'] = 'Photo Gallery';
		
		if ($this->userdata['group']['name'] = 'Admin')
		{
			$data['controls'] = anchor('photo/add/', img('img/upload_icon_black.png'), array('class' => 'upload'));
		}
		else
		{
			$data['controls'] = null;
		}
		$this->load->view('head', array('page_title' => 'Photo Gallery', 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('basic.js', 'jquery.url.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		//$this->load->view('left_column');
		//$this->load->view('right_column');
		$this->load->view('gallery_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer', array('footer' => 'Footer Here'));
	}
	
	// this is like the gallery function, but displays all photos, at 180px height
	public function show_all()
	{
		$this->load->model('photo_model');
		$results = $this->photo_model->read();
		foreach ($results as $result)
		{
			$data['photos'][] = array('src' => base_url().'uploads/'.$result['filename'].$result['extension'], 'height' => '180px');
		}
		
		$data['title'] = 'Photo Gallery';
		
		if ($this->userdata['group']['name'] = 'Admin')
		{
			$data['controls'] = anchor('photo/add/', img('img/upload_icon_black.png'), array('class' => 'upload'));
		}
		else
		{
			$data['controls'] = null;
		}
		$this->load->view('head', array('page_title' => 'Photo Gallery', 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('basic.js', 'jquery.url.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		//$this->load->view('left_column');
		//$this->load->view('right_column');
		$this->load->view('gallery_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer', array('footer' => 'Footer Here'));
	}
	
	// for use in profile photo selection modal, is a basic gallery, no header, footer, etc.
	public function select_profile_photo()
	{
		$this->load->model('photo_model');
		
		$results = $this->photo_model->read(array('where' => array('width' => 180, 'height' => 180)));
		foreach ($results as $result)
		{
			$count = round(980 / $result['width']);
			$margin = (980 - $result['width'] * $count) / $count / 2;
			$data['photos'][] = array('src' => base_url().'uploads/'.$result['filename'].$result['extension'], 'height' => '180px', 'width' => '180px', 'id' => $result['filename'].$result['extension'], 'class' => 'gallery_photo', 'onClick' => "profile_photo('".$result['imagename']."');", 'style' => 'margin:'.$margin.'px;');
		}
		
		$data['controls'] = null;
		$data['title'] = 'Select a Photo';
		
		$this->load->view('gallery_view', $data);
	}
	
	// for use in the embedded photo modal, is a basic gallery, no header, footer, etc.
	public function select_embedded_photo()
	{
		$this->load->model('photo_model');
		
		$results = $this->photo_model->read(array('where' => array('height' => 180), 'order_by' => array('column' => 'width', 'order' => 'desc')));
		foreach ($results as $result)
		{
			if ($result['width'] != 180)
			{
				if ($result['width'] > 180) {
					$tail = '_180h';
				} else {
					$tail = '_180w';
				}
				$count = round(980 / $result['width']);
				$margin = (980 - $result['width'] * $count) / $count / 2;
				$data['photos'][] = array('src' => base_url().'uploads/'.$result['filename'].$result['extension'], 'height' => $result['height'], 'width' => $result['width'], 'id' => $result['filename'].$result['extension'], 'class' => 'gallery_photo', 'onClick' => "embed_photo('".base_url().'uploads/'.$result['imagename'].$tail.$result['extension']."');", 'style' => 'margin:'.$margin.'px;');
			}
		}
		
		$data['controls'] = null;
		$data['title'] = 'Select a Photo';
		
		$this->load->view('gallery_view', $data);
	}
	
	// for ajax requests using the page edit photo select tool
	function ajax_image()
	{
		$imagename = $this->input->post('img');
		$this->load->model('photo_model');
		$result = $this->photo_model->read(array('where' => array('imagename' => $imagename), 'limit' => 1, 'width' => 180, 'height' => 180));
		$this->output->set_output(base_url().'uploads/'.$result['filename'].$result['extension']);
	}
}