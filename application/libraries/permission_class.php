<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permission_class
{
	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->model('permission_model');
	}
	
	public function authors($page_id)
	{
	    if ($raw_auth = $this->ci->permission_model->read_authors(array('fields' => 'user_id', 'where' => array('page_id' => $page_id))))
	    {
		    foreach ($raw_auth as $auth)
		    {
				$person = $this->ci->people_model->read(array('fields' => 'fname, lname', 'where' => array('id' => $auth['user_id']), 'limit' => '1'));
				$authors[$auth['user_id']]['name'] = $person['fname'].'&nbsp;'.$person['lname'];
				$authors[$auth['user_id']]['url'] = url_title($person['lname'].'-'.$person['fname'], 'dash', true);
		    }
		    return $authors;
		
	    }
	    else
	    {
			return null;
	    }
	}
	
	public function actors($page_id)
	{
	    if ($raw_act = $this->ci->permission_model->read_actors(array('fields' => 'user_id', 'where' => array('page_id' => $page_id))))
	    {
		    foreach ($raw_act as $act)
		    {
				$person = $this->ci->people_model->read(array('fields' => 'fname, lname', 'where' => array('id' => $act['user_id']), 'limit' => '1'));
				$authors[$act['user_id']]['name'] = $person['fname'].'&nbsp;'.$person['lname'];
				$authors[$act['user_id']]['url'] = url_title($person['lname'].'-'.$person['fname'], 'dash', true);
		    }
		    return $authors;
		
	    }
	    else
	    {
			return null;
	    }
	}
	
	// finds all pages authored by a given user
	public function page_by_author($user_id)
	{
		$this->ci->load->model('page_model');
		if ($result = $this->ci->permission_model->read_authors(array('fields' => 'page_id', 'where' => array('user_id' => $user_id))))
		{
			foreach ($result as $page)
			{
				$page = $this->ci->page_model->read(array('fields' => 'id, title, url, group_id, description, updated', 'limit' => '1', 'where' => array('id' => $page['page_id'])));
				$return[$page['updated']] = $page;
			}
			krsort($return);
			return $return;
		}
	}
	
	// finds all pages for which a given user can act
	public function page_by_actor($user_id)
	{
		$this->ci->load->model('page_model');
		if ($result = $this->ci->permission_model->read_actors(array('fields' => 'page_id', 'where' => array('user_id' => $user_id))))
		{
			foreach ($result as $page)
			{
				$page = $this->ci->page_model->read(array('fields' => 'id, title, url, group_id, description, updated', 'limit' => '1', 'where' => array('id' => $page['page_id'])));
				$return[$page['updated']] = $page;
			}
			krsort($return);
			return $return;
		}
	}
	public function add_actor($page_id, $user_id)
	{
	    return $this->ci->permission_model->create_editor(array('page_id' => $page_id, 'user_id' => $user_id));
	}
	public function add_author($page_id, $user_id)
	{
	    return $this->ci->permission_model->create_author(array('page_id' => $page_id, 'user_id' => $user_id));
	}
	public function delete_author($page_id, $user_id)
	{
	    return $this->ci->permission_model->delete_author(array('page_id' => $page_id, 'user_id' => $user_id));
	}
	public function delete_actor($page_id, $user_id)
	{
	    return $this->ci->permission_model->delete_actor(array('page_id' => $page_id, 'user_id' => $user_id));
	}
	
	public function is_actor($array)
	{
		if ($results = $this->actors($array['page_id'])) {
			if (array_key_exists($array['user_id'], $results))
			{
				return true;
			}
		}
		return false;
	}
}
