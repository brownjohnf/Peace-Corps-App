<?php

class Logs_model extends CI_Model {
	
	function addRequest($email) {
		
		$user = $this->people_model->getUser('email', $email);
		$data = array(
					  'folder' => $this->uri->segment(1, null),
					  'controller' => $this->uri->segment(2, null),
					  'function' => $this->uri->segment(3, null),
					  'page' => $this->uri->segment(4, null),
					  'parameters' => $this->uri->segment(5, null),
					  'timestamp' => time(),
					  'user_id' => $user['id']
					  );
		$this->db->insert('activity_log', $data);
	
	}
}