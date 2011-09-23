<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Photo_class
{
	public function __construct() {
		$this->ci =& get_instance();
		$this->ci->load->model('photo_model');
	}
	
	public function add_to_album($array) {
		$input['filename'] = $array['raw_name'];
		$input['mime'] = $array['file_type'];
		$input['extension'] = $array['file_ext'];
		$input['size'] = $array['file_size'];
		$input['width'] = $array['image_width'];
		$input['height'] = $array['image_height'];
		$input['imagename'] = $array['imagename'];
		$input['owner_id'] = $this->ci->userdata['id'];
		$input['added'] = time();
		
		return $this->ci->photo_model->create($input);
	}
	
	public function crop($upload_info)
	{
		$new_name = md5($this->ci->session->userdata('session_id').rand());
		//print $this->ci->session->userdata('session_id').'-'.rand();
		//print $new_name;
		$config['image_library'] = 'gd2';
		$config['source_image']	= $upload_info['full_path'];
		//print $config['source_image'];
		$config['maintain_ratio'] = false;
		$config['new_image'] = $upload_info['file_path'].$new_name.$upload_info['file_ext'];
		
		// if landscape
		if ($upload_info['image_width'] > $upload_info['image_height'])
		{
			$slice = ($upload_info['image_width'] - $upload_info['image_height']) / 2;
			$config['x_axis'] = $slice;
			$config['y_axis'] = 0;
			$config['height'] = $upload_info['image_height'];
			$config['width'] = $upload_info['image_width'] - $slice;
			
			$this->ci->image_lib->clear();
			$this->ci->image_lib->initialize($config);
			if ( ! $this->ci->image_lib->crop())
			{
				echo $this->ci->image_lib->display_errors();
			}
			
			$config['x_axis'] = -$slice;
			$config['width'] = $upload_info['image_height'];
			$config['source_image'] = $config['new_image'];
			unset($config['new_image']);
			
			$this->ci->image_lib->clear();
			$this->ci->image_lib->initialize($config);
			if ( ! $this->ci->image_lib->crop())
			{
				echo $this->ci->image_lib->display_errors();
			}
			$upload_info['image_width'] = $upload_info['image_height'];
		}
		// if portrait
		elseif ($upload_info['image_width'] < $upload_info['image_height'])
		{
			$slice = ($upload_info['image_height'] - $upload_info['image_width']) / 2;
			$config['x_axis'] = 0;
			$config['y_axis'] = $slice;
			$config['height'] = $upload_info['image_height'] - $slice;
			$config['width'] = $upload_info['image_width'];
			
			$this->ci->image_lib->clear();
			$this->ci->image_lib->initialize($config);
			if ( ! $this->ci->image_lib->crop())
			{
				echo $this->ci->image_lib->display_errors();
			}
			
			$config['y_axis'] = -$slice;
			$config['height'] = $upload_info['image_width'];
			$config['source_image'] = $config['new_image'];
			unset($config['new_image']);
			
			$this->ci->image_lib->clear();
			$this->ci->image_lib->initialize($config);
			if ( ! $this->ci->image_lib->crop())
			{
				die($this->ci->image_lib->display_errors());
			}
			$upload_info['image_height'] = $upload_info['image_width'];
		}
		$upload_info['full_path'] = $config['source_image'];
		$upload_info['raw_name'] = $new_name;
		return $upload_info;
	}
	
	public function resize($upload_info = array(), $w, $h, $copy, $imagename = false)
	{
		if (! $imagename) {
			$imagename = md5($this->ci->session->userdata('session_id').rand());
		}
		$new_name = md5($this->ci->session->userdata('session_id').rand());
		$config['image_library'] = 'gd2';
		$config['source_image']	= $upload_info['full_path'];
		$config['maintain_ratio'] = true;
		$config['create_thumb'] = false;
		$config['width'] = $w;
		$config['height'] = $h;
		
		if ($copy) {
			$config['new_image'] = $upload_info['file_path'].$new_name.$upload_info['file_ext'];
			$final_image = $config['new_image'];
			$upload_info['raw_name'] = $new_name;
		} else {
			$final_image = $config['source_image'];
		}
		
		$this->ci->image_lib->clear();
		$this->ci->image_lib->initialize($config);
		
		if ( ! $this->ci->image_lib->resize())
		{
			die($this->ci->image_lib->display_errors());
		}
		$meta = getimagesize($final_image);
		$upload_info['file_size'] = filesize($final_image) * .0009765625;
		
		$upload_info['image_width'] = $meta[0];
		$upload_info['image_height'] = $meta[1];
		$upload_info['imagename'] = $imagename;
		if (! $this->ci->photo_class->add_to_album($upload_info))
		{
			$this->ci->session->set_flashdata('error', 'Photo was successfully uploaded, cropped and resized, but database was not updated. They are now out of sync. Please delete the photo, correct the problem, and try again.'.print_r($this->ci->upload->data(), true));
			redirect('photo/add');
		}
		return $upload_info;
	}
}
