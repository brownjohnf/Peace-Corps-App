<?php

class Permission_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}
	// finds authors, if any, for given page id
	public function read_authors($page_id)
	{
	    $this->db->select('user_id, fname, lname, people.id');
	    $this->db->from('authors');
	    $this->db->where('page_id', $page_id);
	    $this->db->join('people', 'people.id = authors.user_id');
	    $query = $this->db->get();
	    $result = $query->result_array();
	    if (! empty($result)) {
		return $result;
	    } else {
		return false;
	    }
	}
	
	// finds actors, if any, for given page id
	public function read_actors($page_id)
	{
	    $this->db->select('user_id, fname, lname, people.id');
	    $this->db->from('actors');
	    $this->db->where('page_id', $page_id);
	    $this->db->join('people', 'people.id = actors.user_id');
	    $query = $this->db->get();
	    $result = $query->result_array();
	    if (! empty($result)) {
		return $result;
	    } else {
		return false;
	    }
	}
	public function read_groups($data)
	{
		$default = array('fields' => '*', 'limit' => '50', 'where' => array('id like' => '%'), 'order_by' => array('column' => 'name', 'order' => 'asc'), 'offset' => 0);
		$data = array_merge($default, $data);
		//echo '<pre>'; print_r($data); echo '</pre>';
		$this->db->select($data['fields']);
		$this->db->where($data['where']);
		$this->db->limit($data['limit'], $data['offset']);
		$this->db->order_by($data['order_by']['column'], $data['order_by']['order']);
		$query = $this->db->get('groups');

		if ($data['limit'] == 1)
		{
			return $query->row_array();
		}	
		else
		{
			return $query->result_array();
		}
	}
	public function create_actor($data)
	{
	    return $this->db->insert('actors', $data);
	}
	public function create_author($data)
	{
	    return $this->db->insert('authors', $data);
	}
	public function delete_author($data)
	{
	    $this->db->where('page_id', $data['page_id']);
	    $this->db->where('user_id', $data['user_id']);
	    return $this->db->delete('authors');
	}
	public function delete_actor($data)
	{
	    $this->db->where('page_id', $data['page_id']);
	    $this->db->where('user_id', $data['user_id']);
	    return $this->db->delete('actors');
	}
	public function purge_by_page($page_id)
	{
		$this->db->where('page_id', $page_id);
	    $this->db->delete('actors');
		$this->db->where('page_id', $page_id);
	    $this->db->delete('authors');
		return true;
	}
}