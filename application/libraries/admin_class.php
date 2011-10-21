<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_class
{
	public function __construct() {
		$this->ci =& get_instance();
		$this->ci->load->model(array('admin_model'));
		//$this->ci->load->library(array('permission_class', 'common_class', 'tag_class'));
		//$this->ci->load->helper(array('markdown', 'text'));
	}
	
	public function edit_site_messages($data)
	{
		$input['site_message_error'] = $data['error'];
		$input['site_message_message'] = $data['message'];
		$input['site_message_notice'] = $data['notice'];
		$input['site_message_success'] = $data['success'];
		$input['id'] = $data['id'];
		
		// update the page entry, or die
		if (! $this->ci->admin_model->update_site_settings($input)) {
			die('Failed to update site_settings table. Check your data and try again. [102]');
		}
		
		return $input['id'];
	}
	public function read_site_messages($id = '%')
	{
	    // fetch the message data
	    $results = $this->ci->admin_model->read_site_settings(array('fields' => 'id, site_message_success, site_message_notice, site_message_error, site_message_message', 'limit' => 1));
	    
		$return[] = array('type' => 'success', 'content' => $results['site_message_success'], 'id' => $results['id']);
		$return[] = array('type' => 'notice', 'content' => $results['site_message_notice'], 'id' => $results['id']);
		$return[] = array('type' => 'error', 'content' => $results['site_message_error'], 'id' => $results['id']);
		$return[] = array('type' => 'message', 'content' => $results['site_message_message'], 'id' => $results['id']);
		
	    return $return;
	}
}
