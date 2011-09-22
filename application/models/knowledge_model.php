<?php

class Knowledge_model extends CI_Model {

	public function __construct() {
		
		parent::__construct();
		
	}
	
	// accepts search criteria in the form of key/value pairs in array
	function findContent($data)
	{
		$this->db->where($data);
    	$query = $this->db->get('content');
 
    	$results = $query->result_array();
    	
    	if (empty($results))
    	{
    		return false;
    	}
    	else
    	{
    		$results['count'] = $query->num_rows();
    		return $results;
    	}
	}
	
	function addContent($data)
	{
		$this->db->insert('content', $data);
	}
	
	function updateContent($data)
	{
		$this->db->where('id', $data['id']);
		$this->db->update('content', $data);
	}
	
	function deleteContent($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('content');
	}
	
	function deleteContentEditors($id)
	{
		$this->db->where('page_id', $id);
		$this->db->delete('editors');
	}
	
	function deleteContentEditor($user_id, $page_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('page_id', $page_id);
		$this->db->delete('editors');
	}
	
	function insertContentEditor($user_id, $page_id)
	{
		$this->db->insert('editors', array('user_id' => $user_id, 'page_id' => $page_id));
	}
	
	function getEditors($page_id)
	{
		$this->db->where('page_id', $page_id);
		$this->db->distinct();
		$this->db->join('people', 'people.id = editors.user_id');
		$query = $this->db->get('editors');
		
		if ($query->num_rows() > 0)
		{
			$result = $query->result_array();
			foreach ($result as $row)
			{
				$output[] = array('id' => $row['id'], 'name' => $row['fname'].' '.$row['lname']);
			}
		}
		else
		{
			$output = false;
		}
		return $output;
	}
}