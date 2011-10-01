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
		$config['upload_path'] = 'uploads';
		//print $config['upload_path'];
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '0';
		$config['max_width']  = '0';
		$config['max_height']  = '0';
		$config['file_name'] = md5($this->session->userdata('session_id').rand());
		//print $this->session->userdata('session_id').'-'.rand().'<br>';
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$this->session->set_flashdata('error', $this->upload->display_errors());
			redirect('photo/add');
		}
		else
		{
			$upload_info = $this->upload->data();
			$original = $upload_info['full_path'];
			$imagename = md5($this->session->userdata('session_id').rand());
			
			$this->load->library('image_lib');
			
			// crop the original down to a square
			if (! $square_info = $this->photo_class->crop($upload_info))
			{
				$this->session->set_flashdata('error', 'Photo was successfully uploaded, but could not be cropped. Please correct the problem, and try again.'.print_r($this->upload->data(), true));
				redirect('photo/add');
			}
			//print $square;
			// reduce the square image to 180
			if (! $this->photo_class->resize($square_info, 180, 180, true, $imagename))
			{
				$this->session->set_flashdata('error', 'Photo was successfully uploaded and cropped, but the cropped image could not be resized to 180. Please correct the problem, and try again.'.print_r($this->upload->data(), true));
				redirect('photo/add');
			}
			// reduce the square image to 75, without copying
			if (! $this->photo_class->resize($square_info, 75, 75, false, $imagename))
			{
				$this->session->set_flashdata('error', 'Photo was successfully uploaded and cropped, but the cropped image could not be resized to 75. Please correct the problem, and try again.'.print_r($this->upload->data(), true));
				redirect('photo/add');
			}
			//print $original;
			$upload_info['full_path'] = $original;
			// reduce the original upload to 250
			if (! $this->photo_class->resize($upload_info, 250, 250, true, $imagename))
			{
				$this->session->set_flashdata('error', 'Photo was successfully uploaded, cropped and resized, but the original image could not be resized to 980. Please correct the problem, and try again.'.print_r($this->upload->data(), true));
				redirect('photo/add');
			}
			// reduce the original upload to 180, not copying
			if (! $this->photo_class->resize($upload_info, 180, 180, true, $imagename))
			{
				$this->session->set_flashdata('error', 'Photo was successfully uploaded, cropped and resized, but the original image could not be resized to 980. Please correct the problem, and try again.'.print_r($this->upload->data(), true));
				redirect('photo/add');
			}
			// reduce the original upload to 980
			if (! $this->photo_class->resize($upload_info, 980, 900, false, $imagename))
			{
				$this->session->set_flashdata('error', 'Photo was successfully uploaded, cropped and resized, but the original image could not be resized to 980. Please correct the problem, and try again.'.print_r($this->upload->data(), true));
				redirect('photo/add');
			}
				
			$this->session->set_flashdata('success', 'You have successfully uploaded your photo. Its unique identifier is '.$imagename.'.');
			redirect('photo/add');
			
		}
	}
	
	public function gallery()
	{
		$this->load->model('photo_model');
		$results = $this->photo_model->read(array('where' => array('width' => 180, 'height' => 180)));
		foreach ($results as $result)
		{
			$data['photos'][] = array('src' => base_url().'uploads/'.$result['filename'].$result['extension'], 'height' => '180px', 'width' => '180px');
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
	
	public function select_photo()
	{
		$this->load->model('photo_model');
		$results = $this->photo_model->read(array('where' => array('width' => 180, 'height' => 180)));
		foreach ($results as $result)
		{
			$data['photos'][] = array('src' => base_url().'uploads/'.$result['filename'].$result['extension'], 'height' => '180px', 'width' => '180px', 'id' => $result['filename'].$result['extension'], 'class' => 'gallery_photo', 'onClick' => "pick_photo('".$result['imagename']."');");
		}
		
		$data['controls'] = null;
		$data['title'] = 'Select a Photo';
		
		$this->load->view('gallery_view', $data);
	}
	
	function ajax_image()
	{
		$imagename = $this->input->post('img');
		$this->load->model('photo_model');
		$result = $this->photo_model->read(array('where' => array('imagename' => $imagename), 'limit' => 1, 'width' => 180, 'height' => 180));
		$this->output->set_output(base_url().'uploads/'.$result['filename'].$result['extension']);
	}
}