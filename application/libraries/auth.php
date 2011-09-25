<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth
{
	public function __construct() {
		
		$this->ci =& get_instance();
		
		$this->ci->load->model('people_model');
		$this->ci->load->model('logs_model');
		
	}
	
	public function is_user()
	{
		if ($result = $this->ci->people_model->selectUsers(array('where' => array('email' => $this->ci->fb_data['me']['email']))))
		{
			//print_r($result);
			if (count($result) > 0)
			{
				$this->ci->userdata = array('group' => array('id' => $result[0]['group_id'], 'name' => $result[0]['group_name']), 'fname' => $result[0]['fname'], 'lname' => $result[0]['lname'], 'flname' => $result[0]['fname'].' '.$result[0]['lname'], 'lfname' => $result[0]['lname'].', '.$result[0]['fname'], 'id' => $result[0]['id'], 'url' => url_title($result[0]['lname'].'-'.$result[0]['fname'], 'dash', true));
				//print_r($this->ci->userdata);
				return true;
			}
			else
			{
				$this->ci->userdata = array('group' => array('id' => 0, 'name' => 'Guest'), 'fname' => 'Guest', 'lname' => 'Guest', 'flname' => 'Guest', 'lfname' => 'Guest', 'id' => 0);
				return false;
			}
		}
		else
		{
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
