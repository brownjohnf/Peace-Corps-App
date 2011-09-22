<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permission_class
{
	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->model('permission_model');
	}
	
	public function authors($page_id)
	{
	    if ($raw_auth = $this->ci->permission_model->read_authors($page_id))
	    {
		    foreach ($raw_auth as $auth)
		    {
				$authors[$auth['id']]['name'] = $auth['fname'].'&nbsp;'.$auth['lname'];
				$authors[$auth['id']]['url'] = url_title($auth['lname'].'-'.$auth['fname'], 'dash', true);
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
	    if ($raw_act = $this->ci->permission_model->read_actors($page_id))
	    {
		    foreach ($raw_act as $act)
		    {
			$actors[$act['id']]['name'] = $act['fname'].'&nbsp;'.$act['lname'];
			$actors[$act['id']]['url'] = url_title($act['lname'].'-'.$act['fname'], 'dash', true);
		    }
		    return $actors;
		
	    }
	    else
	    {
		return false;
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
