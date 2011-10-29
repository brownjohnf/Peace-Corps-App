<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

class Document_model extends CI_Model {

	public function __construct() {
		
		parent::__construct();
		
	}
	
	public function create($data)
	{
	    if ($this->db->insert('documents', $data))
	    {
			return $this->db->insert_id();
	    }
	}
	
	public function read($data = array('where' => array()))
	{
		$default = array('fields' => '*', 'where' => array('id like' => '%', 'delete' => false), 'order_by' => array('column' => 'title', 'order' => 'asc'), 'offset' => 0);
		$data['where'] = array_merge($default['where'], $data['where']);
		$data = array_merge($default, $data);
		//echo '<pre>'; print_r($data); echo '</pre>';
		$this->db->select($data['fields']);
		$this->db->where($data['where']);
		if (isset($data['limit'])) {
			$this->db->limit($data['limit'], $data['offset']);
		}
		$this->db->order_by($data['order_by']['column'], $data['order_by']['order']);
		$query = $this->db->get('documents');

		if (isset($data['limit']) && $data['limit'] == 1)
		{
			return $query->row_array();
		}	
		else
		{
			return $query->result_array();
		}
	}
	
	function update($data)
	{
		$this->db->where('id', $data['id']);
		if ($this->db->update('documents', $data)) {
			return true;
		}
	}
	
	function delete($id)
	{
		$this->db->where('id', $id);
		return $this->db->update('documents', array('delete' => true));
	}
}