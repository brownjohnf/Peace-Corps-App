<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stage_class
{
	public function __construct() {
		$this->ci =& get_instance();
	}
	public function create($data)
	{
	    $input['name'] = $data['name'];
	    $input['cos'] = $data['cos'];
	    $input['arrival_date'] = $data['arrival_date'];
	    $input['sectors'] = $data['sectors'];
		
		if (! $stage_id = $this->ci->user_model->create($input))
		{
			$this->ci->session->set_flashdata('error', 'Failed to add record to stages table. [005]');
			return false;
		}
		
		return $stage_id;
	}
	
	public function edit($data)
	{
		$input['id'] = $data['id'];
	    $input['name'] = $data['name'];
	    $input['cos'] = $data['cos'];
	    $input['arrival_date'] = $data['arrival_date'];
	    $input['sectors'] = $data['sectors'];
	    
		// update the stage entry, or die trying
		if (! $success = $this->ci->stage_model->update($input)) {
			die('Failed to update stages table. Check your data and try again. [002]');
		}
		
		return $data['id'];
	}
	public function blank_form()
	{
		$data['id'] = null;
		$data['name'] = null;
	    $data['cos'] = null;
		$data['arrival_date'] = null;
	    $data['sectors'] = null;
	    
	    return $data;
	}
	public function full_form($id)
	{
	    // fetch the user data
	    $page = $this->ci->stage_model->read(array('where' => array('id' => $id), 'limit' => 1));
		
	    // fetch empty dataset
	    $blank_data = $this->blank_form();
		
	    // merge the two, to create a populated set of data, with list options
	    $data = array_merge($blank_data, $page);
	    
	    //print_r($data);
	    return $data;
	}
}
