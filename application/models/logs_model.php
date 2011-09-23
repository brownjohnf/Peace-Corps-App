<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

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