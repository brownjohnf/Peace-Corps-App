<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth
{
	public function __construct() {
		
		$this->ci =& get_instance();
		
		$this->ci->load->model(array('people_model', 'user_model', 'logs_model'));
		
	}
	
	public function is_user()
	{
		if ($result = $this->ci->people_model->selectUsers(array('where' => array('email' => $this->ci->fb_data['me']['email']), 'limit' => 1)))
		{
			$this->ci->userdata = array('group' => array('id' => $result['group_id'], 'name' => $result['group_name']), 'fname' => $result['fname'], 'lname' => $result['lname'], 'flname' => $result['fname'].' '.$result['lname'], 'lfname' => $result['lname'].', '.$result['fname'], 'id' => $result['id'], 'url' => url_title($result['lname'].'-'.$result['fname'], 'dash', true));
			//print_r($this->ci->userdata);
			
			if ($result['fb_id'] != $this->ci->fb_data['uid'])
			{
				if (! $id = $this->ci->user_model->update(array('id' => $result['id'], 'fb_id' => $this->ci->fb_data['uid'])))
				{
					$this->ci->session->set_flashdata('error', 'There was an error editing your Facebook ID in the database. Please contact admin. [auth/29]');
				}
			}
			return true;
		}
		else
		{
			$this->ci->userdata = array('group' => array('id' => 0, 'name' => 'Guest'), 'fname' => 'Guest', 'lname' => 'Guest', 'flname' => 'Guest', 'lfname' => 'Guest', 'id' => 0);
			return false;
		}
	}
	
	public function is_admin()
	{
		if ($result = $this->ci->people_model->selectUsers(array('where' => array('email' => $this->ci->fb_data['me']['email']))))
		{
			//print_r($result);
			if ($result[0]['name'] == 'Admin')
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
}
