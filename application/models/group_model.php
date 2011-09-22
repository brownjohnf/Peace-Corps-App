<?php

class Group_model extends CI_Model {

	public function __construct() {
		
		parent::__construct();
		
	}
	
	function getUniqueGroups()
	{
		$this->db->distinct();
    	$query = $this->db->get('groups');
 
    	$results = $query->result_array();
 
    	return $results;
	}
}