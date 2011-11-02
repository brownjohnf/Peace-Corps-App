<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

class Region_model extends CI_Model {

	public function __construct() {
		
		parent::__construct();
		
	}
	
	public function create($data)
	{
		$data['altered_id'] = $this->userdata['id'];
		$data['created'] = time();
	    if ($this->db->insert('political_regions', $data))
	    {
			return $this->db->insert_id();
	    }
		else
	    {
			return false;
	    }
	}
	
	public function read($data = array('where' => array()))
	{
		if (! array_key_exists('where', $data))
		{
			$data['where'] = array();
		}
		$default = array('fields' => '*', 'where' => array('id like' => '%', 'delete' => false), 'order_by' => array('column' => 'name', 'order' => 'asc'), 'offset' => 0);
		$data['where'] = array_merge($default['where'], $data['where']);
		$data = array_merge($default, $data);
		//echo '<pre>'; print_r($data); echo '</pre>';
		$this->db->select($data['fields']);
		$this->db->where($data['where']);
		if (isset($data['limit'])) {
			$this->db->limit($data['limit'], $data['offset']);
		}
		$this->db->order_by($data['order_by']['column'], $data['order_by']['order']);
		$query = $this->db->get('political_regions');

		if (isset($data['limit']) && $data['limit'] == 1)
		{
			return $query->row_array();
		}	
		else
		{
			return $query->result_array();
		}
	}
	
	// takes array, returns ID
	public function update($data)
	{
	    $data['edited'] = time();
		$id = $data['id'];
		unset($data['id']);
	    $this->db->where('id', $id);
	    if ($this->db->update('political_regions', $data))
	    {
			return $id;
	    }
	    else
	    {
			return false;
	    }
	}
	
	function delete($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('political_regions');
	}
}