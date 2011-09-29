<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

class Resource_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}
	
	function read_type($data = array())
	{
		$default = array('fields' => '*', 'where' => array('id like' => '%'), 'order_by' => array('column' => 'name', 'order' => 'asc'), 'offset' => 0);
		$data = array_merge($default, $data);
		
		$this->db->select($data['fields']);
		$this->db->where($data['where']);
		if (isset($data['limit'])) {
			$this->db->limit($data['limit'], $data['offset']);
		}
		$this->db->from('res_types');
		$this->db->order_by($data['order_by']['column'], $data['order_by']['order']);
    	$query = $this->db->get();
		
		if (isset($data['limit']) && $data['limit'] == 1) {
			return $query->row_array();
		} else {
			return $query->result_array();
		}
    	
	}
	
	function read_categories($data = array())
	{
		$default = array('where' => array('id like' => '%'), 'order_by' => array('column' => 'name', 'order' => 'asc'), 'offset' => 0);
		$data = array_merge($default, $data);
		
		$this->db->select('*');
		$this->db->where($data['where']);
		if (isset($data['limit'])) {
			$this->db->limit($data['limit'], $data['offset']);
		}
		$this->db->from('mod_categories');
		$this->db->order_by($data['order_by']['column'], $data['order_by']['order']);
    	$query = $this->db->get();
		//print_r($query->result_array());
		
		if (isset($data['limit']) && $data['limit'] == 1) {
			return $query->row_array();
		} else {
			return $query->result_array();
		}
	}
	
	function read_resources($data = array())
	{
		$default = array('fields' => 'mod_resources.*', 'where' => array('mod_resources.id like' => '%'), 'order_by' => array('column' => 'mod_resources.id', 'order' => 'asc'), 'offset' => 0);
		$data = array_merge($default, $data);
		
		$this->db->select($data['fields'].', res_types.name as type_name');
		$this->db->where($data['where']);
		if (isset($data['limit'])) {
			$this->db->limit($data['limit'], $data['offset']);
		}
		$this->db->from('mod_resources');
		$this->db->join('res_types', 'res_types.id = mod_resources.type_id', 'left');
		$this->db->order_by($data['order_by']['column'], $data['order_by']['order']);
    	$query = $this->db->get();
		
		if (isset($data['limit']) && $data['limit'] == 1) {
			return $query->row_array();
		} else {
			return $query->result_array();
		}
	}
	
}