<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

class Admin_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}
	
	function read_site_settings($data = array())
	{
		$default = array('fields' => '*', 'where' => array('id like' => '%'), 'order_by' => array('column' => 'id', 'order' => 'desc'), 'offset' => 0);
		$data = array_merge($default, $data);
		
		$this->db->select($data['fields']);
		$this->db->where($data['where']);
		if (isset($data['limit'])) {
			$this->db->limit($data['limit'], $data['offset']);
		}
		$this->db->from('site_settings');
		$this->db->order_by($data['order_by']['column'], $data['order_by']['order']);
    	$query = $this->db->get();
		
		if (isset($data['limit']) && $data['limit'] == 1) {
			return $query->row_array();
		} else {
			return $query->result_array();
		}
	}
	
	// takes array, returns ID
	public function update_site_settings($data)
	{
	    $this->db->where('id', $data['id']);
	    if ($this->db->update('site_settings', $data))
	    {
			return $data['id'];
	    }
	}
}