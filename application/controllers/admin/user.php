<?php

class User extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->defaultview_tags['navpath'][] = anchor('admin','Administer');
		
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('people_model');
		/*$this->load->library('auth');
		if (! $this->auth->is_admin())
		{
			redirect('home/error/permission/not_admin');
		}*/
	}
	

	function index()
	{
		$this->headview_tags['page_title'] = 'Admin > Users';
		
		$this->_print();
		
	}
	
	function show()
	{
		$this->headview_tags['scripts'][] = 'http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js';
		$this->headview_tags['scripts'][] = base_url().'js/jquery.dataTables.min.js';
		$this->headview_tags['scripts'][] = base_url().'js/datatable_initiate.js';
		
		$this->headview_tags['stylesheets'][] = base_url().'css/demo_table.css';
		
		$data = array();
		$data['users'] = $this->people_model->selectUsers();
				
		$this->load->view('admin/user_show', $data);
	}

	function upload_user()
	{
		$config['upload_path'] = 'temp/';
		$config['allowed_types'] = 'csv';
		$config['max_size']	= '100';
		$config['overwrite']  = true;
		$config['file_name']  = 'new_users.csv';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());

			$this->load->view('admin/user_upload_view', $error, true);
		}
		else
		{
			$file = array('upload_data' => $this->upload->data());
			
			if (($handle = fopen('temp/'.$file['upload_data']['file_name'], 'r')) !== false)
			{
				$columns = fgetcsv($handle, 0, ',');
				$column_keys = array_keys($columns);
				while (($data = fgetcsv($handle, 0, ',')) !== false)
				{
					$input = null;
					foreach ($data as $key => $value)
					{
						$input[$columns[$key]] = $value;
					}
					$this->people_model->addUser($input);
				}
			}
			fclose($handle);
			redirect('admin/user/show');
		}
	}
	
	function update()
	{
		$this->load->model('group_model');
		$id = $this->uri->segment(4, 0);
 		if ($this->input->post('submit'))
 		{
   			$data['fname'] = $this->security->xss_clean($this->input->post('fname'));
   			$data['lname'] = $this->security->xss_clean($this->input->post('lname'));
        	$data['email'] = $this->security->xss_clean($this->input->post('email'));
        	$data['project'] = $this->security->xss_clean($this->input->post('project'));
        	$data['group_id'] = $this->input->post('group_id');
        	$data['edited'] = time();
        	$data['id'] = $this->input->post('id');
 
        	$this->people_model->updateUser($data);
			
			// display
			$this->view();
					
    	}
    	elseif ($id == 0)
    	{
			$this->_print('Please specify someone to update.');
		}
		else
		{
			$data = $this->people_model->getUser('id', $id);
        	$data['target'] = 'admin/user/update/'.$id;
        	$groups = $this->group_model->getUniqueGroups();
        	foreach ($groups as $group)
        	{
        		$data['dropdown']['options'][$group['id']] = $group['name'];
        	}
        	$data['dropdown']['selected'] = $data['group_id'];
        	
			$this->_print($this->load->view('admin/user_form', $data, TRUE));
    	}
	}
	
	function delete()
	{
    	$id = $this->uri->segment(4, 0);
		if ($id == 0) {
			$this->_print('Please specify someone to delete.');
		} else {
	    	$this->people_model->deleteUser($id);
			$this->show();
		}
		
	}
	
	function add()
	{
		$this->load->model('group_model');
 		if ($this->input->post('submit'))
 		{
   			$data['fname'] = $this->security->xss_clean($this->input->post('fname'));
   			$data['lname'] = $this->security->xss_clean($this->input->post('lname'));
        	$data['email'] = $this->security->xss_clean($this->input->post('email'));
        	$data['project'] = $this->security->xss_clean($this->input->post('project'));
        	$data['group_id'] = $this->input->post('group_id');
        	$data['created_on'] = time();
 
        	$this->people_model->addOneUser($data);
			
			// display
			$this->view();
					
    	}
		else
		{
        	$groups = $this->group_model->getUniqueGroups();
        	$data['target'] = 'admin/user/add';
        	foreach ($groups as $group)
        	{
        		$data['dropdown']['options'][$group['id']] = $group['name'];
        	}
        	$data['dropdown']['selected'] = 5;
        	$data['fname'] = '';
        	$data['lname'] = '';
        	$data['email'] = '';
        	$data['project'] = '';
        	$data['id'] = null;
        	
			$this->_print($this->load->view('admin/user_form', $data, TRUE));
    	}
		
	}
}