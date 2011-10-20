<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

class Page_model extends CI_Model {

	public function __construct() {
		
		parent::__construct();
		
	}
	
	function delete($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('pages');
	}
	
	public function read($data)
	{
		$default = array('fields' => '*', 'limit' => '50', 'where' => array('id like' => '%'), 'order_by' => array('column' => 'updated', 'order' => 'desc'), 'offset' => 0);
		$data = array_merge($default, $data);
		//echo '<pre>'; print_r($data); echo '</pre>';
		$this->db->select($data['fields']);
		$this->db->where($data['where']);
		$this->db->limit($data['limit'], $data['offset']);
		$this->db->order_by($data['order_by']['column'], $data['order_by']['order']);
		$query = $this->db->get('pages');

		if ($data['limit'] == 1)
		{
			return $query->row_array();
		}	
		else
		{
			return $query->result_array();
		}
	}
	
	public function create($data)
	{
	    if ($this->db->insert('pages', $data))
	    {
				return $this->db->insert_id();
	    }
		else
	    {
				return false;
	    }
	}
	// takes array, returns ID
	public function update($data)
	{
	    $data['edited'] = time();
	    $this->db->where('id', $data['id']);
	    if ($this->db->update('pages', $data))
	    {
		return $data['id'];
	    }
	    else
	    {
		return false;
	    }
	}
	public function reset_parent($parent_id)
	{
		$this->db->where('parent_id', $parent_id);
		if ($this->db->update('pages', array('parent_id' => 0)))
		{
				return true;
		}
		else
		{
				return false;
		}
	}
	
	public function create_page_link($data = array())
	{
	    return $this->db->insert('page_links', $data);
	}
	
	public function read_page_links($data = array())
	{
		$default = array('fields' => 'page_links.*', 'where' => array('page_links.id like' => '%'), 'order_by' => array('column' => 'page_links.id', 'order' => 'asc'), 'offset' => 0);
		$data = array_merge($default, $data);
		
		$this->db->select($data['fields'].', pages.url as link_url, pages.title as link_title');
		$this->db->where($data['where']);
		if (isset($data['limit'])) {
			$this->db->limit($data['limit'], $data['offset']);
		}
		$this->db->from('page_links');
		$this->db->join('pages', 'pages.id = page_links.link_id', 'left');
		$this->db->order_by($data['order_by']['column'], $data['order_by']['order']);
    	$query = $this->db->get();
		
		if (isset($data['limit']) && $data['limit'] == 1) {
			return $query->row_array();
		} else {
			return $query->result_array();
		}
	}
	
	public function delete_page_link($where = array())
	{
	    $this->db->where($where);
	    return $this->db->delete('page_links');
	}
}