<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_class
{
	public function __construct() {
		$this->ci =& get_instance();
	}
	public function create($data)
	{
		$this->ci->load->model('user_model');
		
	    $input['group_id'] = $data['group_id'];
	    $input['stage_id'] = $data['stage_id'];
	    $input['sector_id'] = $data['sector_id'];
	    $input['email'] = $data['email'];
		
		if ($data['fb_id'] != '') {
			$input['fb_id'] = $data['fb_id'];
		}
		
	    $input['pc_id'] = $data['pc_id'];
	    $input['site_id'] = $data['site_id'];
	    $input['fname'] = $data['fname'];
	    $input['lname'] = $data['lname'];
	    $input['address'] = $data['address'];
	    $input['phone'] = $data['phone'];
	    $input['blog_address'] = $data['blog_address'];
	    $input['blog_name'] = $data['blog_name'];
	    $input['blog_description'] = $data['blog_description'];
	    $input['project'] = $data['project'];
	    $input['cos'] = $data['cos'];
	    $input['local_name'] = $data['local_name'];
	    $input['created_on'] = time();
		
		if (! $user_id = $this->ci->user_model->create($input))
		{
			$this->ci->session->set_flashdata('error', 'Failed to add record to people table. [005]');
			return false;
		}
		
		return $user_id;
	}
	
	public function edit($data)
	{
		$this->ci->load->model('user_model');
		
		$input['id'] = $data['id'];
	    $input['group_id'] = $data['group_id'];
	    $input['stage_id'] = $data['stage_id'];
	    $input['sector_id'] = $data['sector_id'];
	    $input['email'] = $data['email'];
		
		if ($data['fb_id'] != '') {
			$input['fb_id'] = $data['fb_id'];
		}
		
	    $input['pc_id'] = $data['pc_id'];
	    $input['site_id'] = $data['site_id'];
	    $input['fname'] = $data['fname'];
	    $input['lname'] = $data['lname'];
	    $input['address'] = $data['address'];
	    $input['phone'] = $data['phone'];
	    $input['blog_address'] = $data['blog_address'];
	    $input['blog_name'] = $data['blog_name'];
	    $input['blog_description'] = $data['blog_description'];
	    $input['project'] = $data['project'];
	    $input['cos'] = $data['cos'];
	    $input['local_name'] = $data['local_name'];
		
		// update the page entry, or die
		if (! $this->ci->user_model->update($input)) {
			die('Failed to update content table. Check your data and try again. [002]');
		}
		
		return $input['id'];
	}
	public function blank_form()
	{
		$this->ci->load->model(array('permission_model', 'people_model', 'location_model'));
		
	    $data['fb_id'] = null;
	    $data['pc_id'] = null;
	    $data['fname'] = null;
	    $data['lname'] = null;
	    $data['project'] = null;
	    $data['email'] = null;
		$data['phone'] = null;
		$data['address'] = null;
		$data['cos'] = null;
		$data['local_name'] = null;
		$data['blog_name'] = null;
		$data['blog_description'] = null;
		$data['blog_address'] = null;
		$data['stage_id'] = null;
		$data['sector_id'] = null;
		$data['site_id'] = null;
		$data['group_id'] = null;
		$data['id'] = null;
	    
	    $groups = $this->ci->permission_model->read_groups(array('fields' => 'id, name'));
	    $stages = $this->ci->people_model->read_stages(array('fields' => 'id, name'));
	    $sectors = $this->ci->people_model->read_sectors(array('fields' => 'id, name'));
	    $sites = $this->ci->location_model->read_sites(array('fields' => 'id, name'));
	    
	    foreach ($stages as $stage) {
			$data['stages'][$stage['id']] = $stage['name'];
	    }
	    
		foreach ($groups as $group) {
			$data['groups'][$group['id']] = $group['name'];
	    }
		foreach ($sectors as $sector) {
			$data['sectors'][$sector['id']] = $sector['name'];
	    }
		$data['sites']['NULL'] = 'Unknown';
	    foreach ($sites as $site) {
			$data['sites'][$site['id']] = $site['name'];
	    }
	    
	    return $data;
	}
	public function full_form($id)
	{
	    // fetch the user data
	    $page = $this->ci->people_model->read(array('where' => array('id' => $id), 'limit' => 1));
		
	    // fetch empty dataset
	    $blank_data = $this->blank_form();
		
	    // merge the two, to create a populated set of data, with list options
	    $data = array_merge($blank_data, $page);
	    
	    return $data;
	}
}
