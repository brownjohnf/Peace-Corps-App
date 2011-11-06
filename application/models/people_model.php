<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

class People_model extends CI_Model {

	public function __construct() {

		parent::__construct();

	}

	public function read($data = array())
	{
		$default = array('fields' => '*', 'limit' => '5000', 'where' => array('id like' => '%'), 'order_by' => array('column' => 'lname', 'order' => 'asc'), 'offset' => 0);
		$data = array_merge($default, $data);
		//echo '<pre>'; print_r($data); echo '</pre>';
		$this->db->select($data['fields']);
		$this->db->where($data['where']);
		$this->db->limit($data['limit'], $data['offset']);
		$this->db->order_by($data['order_by']['column'], $data['order_by']['order']);
		$query = $this->db->get('people');

		if ($data['limit'] == 1)
		{
			return $query->row_array();
		}
		else
		{
			return $query->result_array();
		}
	}

	public function read_stages($data)
	{
		$default = array('fields' => '*', 'limit' => '5000', 'where' => array('id like' => '%'), 'order_by' => array('column' => 'arrival_date', 'order' => 'desc'), 'offset' => 0);
		$data = array_merge($default, $data);
		//echo '<pre>'; print_r($data); echo '</pre>';
		$this->db->select($data['fields']);
		$this->db->where($data['where']);
		$this->db->limit($data['limit'], $data['offset']);
		$this->db->order_by($data['order_by']['column'], $data['order_by']['order']);
		$query = $this->db->get('stages');

		if ($data['limit'] == 1)
		{
			return $query->row_array();
		}
		else
		{
			return $query->result_array();
		}
	}

	public function read_sectors($data)
	{
		$default = array('fields' => '*', 'limit' => '5000', 'where' => array('id like' => '%'), 'order_by' => array('column' => 'name', 'order' => 'asc'), 'offset' => 0);
		$data = array_merge($default, $data);
		//echo '<pre>'; print_r($data); echo '</pre>';
		$this->db->select($data['fields']);
		$this->db->where($data['where']);
		$this->db->limit($data['limit'], $data['offset']);
		$this->db->order_by($data['order_by']['column'], $data['order_by']['order']);
		$query = $this->db->get('sectors');

		if ($data['limit'] == 1)
		{
			return $query->row_array();
		}
		else
		{
			return $query->result_array();
		}
	}

	function selectUsers($data = array())
	{
		$default = array('fields' => 'people.*', 'where' => array('people.id like' => '%'), 'order_by' => array('column' => 'people.lname', 'order' => 'asc'), 'offset' => 0);
		$data = array_merge($default, $data);

		$this->db->select($data['fields'].', volunteers.sector_id, volunteers.stage_id, volunteers.site_id, volunteers.focus, volunteers.cos, volunteers.local_name, volunteers.pc_id as pc_id, groups.name as group_name, groups.label as group_label, stages.name as stage_name, sectors.name as sector_name, sectors.short as sector_short, sites.name as site_name, political_regions.name as region_name');
		$this->db->where($data['where']);
		if (isset($data['limit'])) {
			$this->db->limit($data['limit'], $data['offset']);
		}
		$this->db->from('people');
		$this->db->join('volunteers', 'volunteers.user_id = people.id', 'left');
		$this->db->join('groups', 'groups.id = people.group_id', 'left');
		$this->db->join('stages', 'stages.id = volunteers.stage_id', 'left');
		$this->db->join('sectors', 'sectors.id = volunteers.sector_id', 'left');
		$this->db->join('sites', 'sites.id = volunteers.site_id', 'left');
		$this->db->join('political_regions', 'political_regions.id = sites.parent_id', 'left');
		$this->db->order_by($data['order_by']['column'], $data['order_by']['order']);
    	$query = $this->db->get();
		//print_r($query->row_array());
		//print $this->db->last_query();

		if (isset($data['limit']) && $data['limit'] == 1) {
			return $query->row_array();
		} else {
			return $query->result_array();
		}

	}

	function countUsers()
	{
		$count = $this->db->count_all('people');
		return $count;
	}

    function getGroup($email)
	{
		$this->db->where('email1', $email);
		$this->db->join('groups', 'groups.id = people.group_id');
		$query = $this->db->get('people');
		$result = $query->row_array();
 		return $result['name'];
	}

	function checkUser($field, $value)
	{
		$this->db->where($field, $value);
		$query = $this->db->get('people');
		if ($query->num_rows() !== 0)
		{
 			return true;
		}
		else
		{
			return false;
		}
	}

	function getUser($col = 'id', $value = '%')
	{
		$this->db->where($col, $value);
		$query = $this->db->get('people');

		$result = $query->row_array();

		return $result;
	}

	function delete($data = array())
	{
		if (! is_array($data))
		{
			$data = array('id' => $data['id']);
		}
		$this->db->where($data);
		$this->db->delete('people');
		return true;
	}

	function addUser($data)
	{
		$input = array(
						'id' => $data['id'],
						'group_id' => 2,
						'fname' => $data['fname'],
						'lname' => $data['lname'],
						'project' => $data['project'],
						'email1' => $data['email1'],
						'created_on' => time()
						);
		if ($this->checkUser('id', $input['id']))
		{
			$this->db->where('id', $input['id']);
			$this->db->update('people', $input);
		}
		else
		{
			$this->db->insert('people', $input);
		}
	}

	function addOneUser($data)
	{
		$this->db->insert('people', $data);

		return true;
	}

	public function update($data, $column = 'id')
	{
	    $data['edited'] = time();
	    $data['altered_id'] = $this->userdata['id'];

	    $this->db->where($column, $data[$column]);
		//echo 'column: '.$column.'. query data '; print_r($data);
	    if ($this->db->update('people', $data))
	    {
			return $data[$column];
	    }
	    else
	    {
			//echo $this->db->last_query();
			return false;
	    }
	}

	function updateActivity($email)
	{
		$this->db->where('email1', $email);
		$this->db->update('people', array('last_activity' => time()));

		return true;
	}

	function checkEditor($user_id = null, $page_id = null)
	{
		if ($user_id && $page_id)
		{
			$this->db->where('user_id', $user_id);
			$this->db->where('page_id', $page_id);
			$query = $this->db->get('editors');
			if ($query->num_rows() == 1)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	public function create($data)
	{
		$data['altered_id'] = $this->userdata['id'];
		$data['created'] = time();
		$data['edited'] = $data['created'];

	    if ($this->db->insert('people', $data))
	    {
			return $this->db->insert_id();
	    }
		else
	    {
			return false;
	    }
	}
}