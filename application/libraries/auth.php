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
				$this->ci->userdata = array('group' => array('id' => $result[0]['group_id'], 'name' => $result[0]['group_name']), 'fname' => $result[0]['fname'], 'lname' => $result[0]['lname'], 'flname' => $result[0]['fname'].' '.$result[0]['lname'], 'lfname' => $result[0]['lname'].', '.$result[0]['fname'], 'id' => $result[0]['id']);
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
	/*
	public function is_actor($content_id = null) {
		
		if ($this->is_user())
		{
			if ($this->is_admin($))
			$data = $this->ci->people_model->getGroup($this->getClientEmail());
			if ($group == 'Admin')
			{
				return true;
			}
			elseif (($group != 'Other') && ($group != 'None'))
			{
				if ($this->ci->people_model->checkEditor($this->getUserId(), $content_id))
				{
					return true;
				}
			}
		}
		else
		{
			return false;
		}
	}
	
	public function is_volunteer() {
		
		
		if ($this->is_user())
		{
			$group = $this->ci->people_model->getGroup($this->getClientEmail());
			if ($group == 'Volunteer')
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
	
	public function is_staff() {
		
		
		if ($this->is_user())
		{
			$group = $this->ci->people_model->getGroup($this->getClientEmail());
			if ($group == 'Staff')
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
	
	public function is_other() {
		
		
		if ($this->is_user())
		{
			$group = $this->ci->people_model->getGroup($this->getClientEmail());
			if ($group == 'Other')
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
	
	public function getUserId() {
		$user = $this->ci->people_model->getUser('email', $this->getClientEmail());
		return $user['id'];
	}*/
}
