<?php
class User extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->load->library('auth');
		if (! $this->auth->is_user())
		{
			redirect('error/permission/not_user');
		}
	}

	public function index()
	{
		$this->_print();
	}
}