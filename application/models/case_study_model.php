<?php

class Case_study_model extends CI_Model {
 
    function addStudy($data) {
 
        $this->db->insert('case_study', $data);
    }
	
	function getStudy($id) {
		if ($id !== 'all') {
			$this->db->where('id', $id);
		}
    	$query = $this->db->get('case_study', 1);
    	$studies = $query->row_array();
 /*
    	foreach ($query->result() as $row) {
        	$studies[] = array(
            	'id' => $row->id,
            	'title' => $row->title,
            	'description' => $row->description,
            	'content' => $row->content
        	);
    	}*/
 
    	return $studies;
	}
	
	function selectStudies($num, $offset) {
    	$query = $this->db->get('case_study', $num, $offset);
    	$studies = array();
 
    	foreach ($query->result() as $row) {
        	$studies[] = array(
            	'id' => $row->id,
            	'title' => $row->title,
            	'description' => $row->description,
            	'content' => $row->content
        	);
    	}
 
    	return $studies;
	}
	
	function updateStudy($id, $description, $title, $content) {
    	$data = array(
        	'title' => $title,
			'description' => $description,
        	'content' => $content
    	);
 
    	$this->db->where('id', $id);
    	$this->db->update('case_study', $data);
	}
	
	function deleteStudy($id) {
    	$this->db->where('id', $id);
    	$this->db->delete('case_study');
	}
	
	function countStudies() {
		$count = $this->db->count_all('case_study');
		return $count;
	}
 
}