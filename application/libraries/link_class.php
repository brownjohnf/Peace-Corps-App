<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Link_class
{
	public function __construct() {
		$this->ci =& get_instance();
	}
	public function create($data)
	{
	    $input['url'] = $data['url'];
	    $input['title'] = $data['title'];
	    $input['created'] = time();
		
		if (! $id = $this->ci->link_model->create($input))
		{
			$this->ci->session->set_flashdata('error', 'Failed to add record to links table. [005]');
			return false;
		}
		
		return $id;
	}
	
	public function edit($data)
	{
		$input['id'] = $data['id'];
	    $input['title'] = $data['title'];
		$input['url'] = $data['url'];
		
		// update the page entry, or die
		if (! $this->ci->link_model->update($input)) {
			die('Failed to update links table. Check your data and try again. [002]');
		}
		return $input['id'];
	}
	public function blank_form()
	{
	    $data['title'] = null;
	    $data['url'] = null;
		$data['id'] = null;
	    
	    return $data;
	}
	public function full_form($id)
	{
	    // fetch the link data
	    $data = $this->ci->link_model->read(array('where' => array('id' => $id), 'limit' => 1));

	    return $data;
	}
}
