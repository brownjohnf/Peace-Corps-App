<?php

class User_model extends CI_Model {

	public function __construct() {
		
		parent::__construct();
		
	}
	
	function delete($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('pages');
	}
	
	public function create($data)
	{
	    if ($this->db->insert('people', $data))
	    {
				return $this->db->insert_id();
	    }
		else
	    {
				return false;
	    }
	}
	// takes array, returns ID
	public function update($data)
	{
	    $data['edited'] = time();
	    $this->db->where('id', $data['id']);
	    if ($this->db->update('people', $data))
	    {
		return $data['id'];
	    }
	    else
	    {
		return false;
	    }
	}
	public function reset_parent($parent_id)
	{
		$this->db->where('parent_id', $parent_id);
		if ($this->db->update('pages', array('parent_id' => 0)))
		{
				return true;
		}
		else
		{
				return false;
		}
	}
	
}