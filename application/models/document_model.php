<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

class Document_model extends CI_Model {

	public function __construct() {
		
		parent::__construct();
		
	}
	
	public function read($data)
	{
		$default = array('fields' => '*', 'where' => array('id like' => '%'), 'order_by' => array('column' => 'title', 'order' => 'asc'), 'offset' => 0);
		$data = array_merge($default, $data);
		
		$this->db->select($data['fields']);
		$this->db->where($data['where']);
		if (isset($data['limit'])) {
			$this->db->limit($data['limit'], $data['offset']);
		}
		$this->db->order_by($data['order_by']['column'], $data['order_by']['order']);
		$query = $this->db->get('documents');

		if ($data['limit'] == 1)
		{
			return $query->row_array();
		}	
		else
		{
			return $query->result_array();
		}
	}
	
	function delete($id)
	{
		$this->db->where('id', $id);
		if ($this->db->delete('documents')) {
			return true;
		}
	}
	
	function update($data)
	{
		$this->db->where('id', $data['id']);
		if ($this->db->update('documents', $data)) {
			return true;
		}
	}
}