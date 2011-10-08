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
	
	public function crop($upload_info)
	{
		$config['image_library'] = 'ImageMagick';
		$config['library_path'] = $this->ci->config->item('imagemagick_path');
		$config['source_image']	= $upload_info['full_path'];
		$config['maintain_ratio'] = false;
		
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
				echo $this->ci->image_lib->display_errors().' first landscape crop';
			}
			
			$config['x_axis'] = -$slice;
			$config['width'] = $upload_info['image_height'];
			unset($config['new_image']);
			
			$this->ci->image_lib->clear();
			$this->ci->image_lib->initialize($config);
			if ( ! $this->ci->image_lib->crop())
			{
				echo $this->ci->image_lib->display_errors().' second landscape crop';
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
			
			$this->ci->image_lib->clear();
			$this->ci->image_lib->initialize($config);
			if ( ! $this->ci->image_lib->crop())
			{
				die($this->ci->image_lib->display_errors());
			}
			$upload_info['image_height'] = $upload_info['image_width'];
		}
		$upload_info['full_path'] = $config['source_image'];
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
	
	public function create($data = array(), $new_name = '', $target = array())
	{
		// set the original file and full name for the new file
		$config['source_image']	= $data['full_path'];
		$config['new_image'] = $new_name.$target['name'].$data['file_ext'];
		
		print abs($target['width'] / $target['height'] - $data['image_width'] / $data['image_height']).' '.$target['name'].' <br>';
		
		if (is_null($target['height']) || is_null($target['width'])) // if only the width or height is set, do a soft resize, without a crop
		{
			$config['image_library'] = 'gd2';
			if ($target['width']) {
				$config['width'] = $target['width'];
				print 'width';
			}
			if ($target['height']) {
				$config['height'] = $target['height'];
				print 'height';
			}
		
			$this->ci->image_lib->clear();
			$this->ci->image_lib->initialize($config);
			
			if ( ! $this->ci->image_lib->resize())
			{
				die($this->ci->image_lib->display_errors());
			}
		}
		elseif (abs($target['width'] / $target['height'] - $data['image_width'] / $data['image_height']) > .1) // if the aspect ratio of the photo is not almost exactly what is specified, resize to the small dimension, then crop the photo to the final size
		{
			if ($target['width'] > $target['height'])
			{
				$config['image_library'] = 'gd2';
				$config['height'] = $target['height'];
			
				$this->ci->image_lib->clear();
				$this->ci->image_lib->initialize($config);
				
				if ( ! $this->ci->image_lib->resize())
				{
					die($this->ci->image_lib->display_errors().'<- landscape resize<br>');
				}
				
				$slice = ($upload_info['image_width'] - $target['height']) / 2;
				$config['x_axis'] = $target['width'] + $slice;
				$config['source_image']	= $upload_info['file_path'].$config['new_image'];
				$config['maintain_ratio'] = false;
				unset($config['height']);
				
				$this->ci->image_lib->clear();
				$this->ci->image_lib->initialize($config);
				if ( ! $this->ci->image_lib->crop())
				{
					die($this->ci->image_lib->display_errors().'<- first landscape crop<br>');
				}
				
				$config['x_axis'] = -$target['width'];
				
				$this->ci->image_lib->clear();
				$this->ci->image_lib->initialize($config);
				if ( ! $this->ci->image_lib->crop())
				{
					die($this->ci->image_lib->display_errors().'<- second landscape crop<br>');
				}
			}
			else
			{
				$config['image_library'] = 'gd2';
				$config['width'] = $target['width'];
			
				$this->ci->image_lib->clear();
				$this->ci->image_lib->initialize($config);
				
				if ( ! $this->ci->image_lib->resize())
				{
					die($this->ci->image_lib->display_errors().'<- portrait resize<br>');
				}
				
				$slice = ($data['image_height'] - $target['width']) / 2;
				$config['y_axis'] = $target['height'] + $slice;
				$config['source_image']	= $data['file_path'].$config['new_image'];
				$config['maintain_ratio'] = false;
				unset($config['width']);
				
				$this->ci->image_lib->clear();
				$this->ci->image_lib->initialize($config);
				if ( ! $this->ci->image_lib->crop())
				{
					die($this->ci->image_lib->display_errors().'<- first portrait crop<br>');
				}
				
				$config['y_axis'] = -$target['height'];
				
				$this->ci->image_lib->clear();
				$this->ci->image_lib->initialize($config);
				if ( ! $this->ci->image_lib->crop())
				{
					die($this->ci->image_lib->display_errors().'<- second portrait crop<br>');
				}
			}
		}
		else // otherwise, just do a hard resize
		{
			$config['image_library'] = 'gd2';
			$config['width'] = $target['width'];
			$config['height'] = $target['height'];
			$config['maintain_ratio'] = false;
		
			$this->ci->image_lib->clear();
			$this->ci->image_lib->initialize($config);
			
			if ( ! $this->ci->image_lib->resize())
			{
				die($this->ci->image_lib->display_errors());
			}
		}
		
		$meta = getimagesize($data['file_path'].$config['new_image']);
		$input['filename'] = $new_name.$target['name'];
		$input['mime'] = $data['file_type'];
		$input['extension'] = $data['file_ext'];
		$input['size'] = filesize($data['file_path'].$config['new_image']);
		$input['width'] = $meta[0];
		$input['height'] = $meta[1];
		$input['imagename'] = $config['new_image'];
		$input['owner_id'] = $this->ci->userdata['id'];
		$input['added'] = time();
		
		unset($config);
		
		if (! $this->ci->photo_model->create($input))
		{
			$this->ci->session->set_flashdata('error', 'Photo was successfully uploaded, cropped and resized, but database was not updated. They are now out of sync. Please delete the photo, correct the problem, and try again.'.print_r($input, true).print_r($data, true));
			return false;
			die();
		}
		return $input;
	}
}
