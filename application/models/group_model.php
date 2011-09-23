<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

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