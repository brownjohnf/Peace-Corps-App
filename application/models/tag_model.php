<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

class Tag_model extends CI_Model {

	public function __construct() {
		
		parent::__construct();
		
	}
	
	public function read($data)
	{
		$default = array('fields' => '*', 'limit' => '50', 'where' => array('id like' => '%'), 'order_by' => array('column' => 'updated', 'order' => 'desc'), 'offset' => 0, 'distinct' => false);
		$data = array_merge($default, $data);
		//echo '<pre>'; print_r($data); echo '</pre>';
		$this->db->select($data['fields']);
		$this->db->where($data['where']);
		$this->db->limit($data['limit'], $data['offset']);
		$this->db->order_by($data['order_by']['column'], $data['order_by']['order']);
		if ($data['distinct']) {
			$this->db->distinct();
		}
		$query = $this->db->get('tags');

		if ($data['limit'] == 1)
		{
			return $query->row_array();
		}	
		else
		{
			return $query->result_array();
		}
	}
	public function delete($data = null)
	{
		if (! $data) {
				die('source and source_id required for tag_model->delete');
		}
		
		$this->db->where($data);
		
		if (! $this->db->delete('tags')) {
				die('failed to delete from the tags table');
		} else {
				return true;
		}
	}
	
	public function create($batch)
	{
		if (! $this->db->insert_batch('tags', $batch)) {
				die('failed to batch insert tags');
		}
	}
}