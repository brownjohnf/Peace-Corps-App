<?php

class Page_model extends CI_Model {

	public function __construct() {
		
		parent::__construct();
		
	}
	
	function delete($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('pages');
	}
	
	public function read($data)
	{
		$default = array('fields' => '*', 'limit' => '50', 'where' => array('id like' => '%'), 'order_by' => array('column' => 'updated', 'order' => 'desc'), 'offset' => 0);
		$data = array_merge($default, $data);
		//echo '<pre>'; print_r($data); echo '</pre>';
		$this->db->select($data['fields']);
		$this->db->where($data['where']);
		$this->db->limit($data['limit'], $data['offset']);
		$this->db->order_by($data['order_by']['column'], $data['order_by']['order']);
		$query = $this->db->get('pages');

		if ($data['limit'] == 1)
		{
			return $query->row_array();
		}	
		else
		{
			return $query->result_array();
		}
	}
	
	public function create($data)
	{
	    if ($this->db->insert('pages', $data))
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
	    if ($this->db->update('pages', $data))
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