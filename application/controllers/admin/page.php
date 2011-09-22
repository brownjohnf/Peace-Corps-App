<?php

class Page extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->library('content');
		
		$this->headview_tags['page_title'] = 'Page Administration';
	}
	
	function index()
	{
		if (! $this->auth->is_admin())
		{
			redirect('public/home/error/permission/not_admin');
		}
		$this->_print('Welcome to the page administration section.');
	}
	
	function create()
	{
		if (! $this->auth->is_admin())
		{
			redirect('public/home/error/permission/not_admin');
		}
		if ($this->input->post('submit'))
		{
			$data = $this->input->post();
			
			// strip out internal info that shouldn't go into the db
			unset($data['submit']);
			unset($data['path']);
			// strip out update info, which isn't needed for a create
			unset($data['update']);
			
			// add creation / update timestamps
			$data['created'] = time();
			$data['updated'] = time();
 
            // Add the page
           	$this->content->addPage($data);
			
			redirect($this->input->post('path'));
		}
		elseif ($this->input->post('cancel'))
		{
			redirect($this->input->post('path'));
		}
		else
		{
			
			$path = $this->uri->segment_array();
			array_shift($path);
			array_shift($path);
			array_shift($path);
			$path_array = $this->content->nameURI($path);
			
			// get a list of users for the dropdown authors list
			$users = $this->people_model->selectUsers();
			foreach ($users as $user)
			{
				$dropdown[$user['id']] = $user['lname'].', '.$user['fname'];
			}
			
			// set blank info for populating create page
			$data = array('path' => $path_array, 'title' => '', 'description' => '', 'content' => '', 'target' => 'admin/page/create', 'path_string' => implode('/', $path_array), 'users' => $dropdown, 'author_id' => null);
			$this->_print($this->load->view('admin/page_form', $data, true));
		}
	}
	
	function update()
	{
		$id = $this->uri->segment(4, 0);
		if (! $this->auth->is_editor($id))
		{
			redirect('public/home/error/permission/not_admin');
		}
		if ($this->input->post('submit'))
		{
			// collect the data from the post array
			$data = $this->input->post();
			$data['id'] = $id;
			
			// strip out internal info that shouldn't go into the db
			unset($data['submit']);
			unset($data['path']);
			
			// add edit timestamp
			$data['edited'] = time();
			
			// if requested, set the update timestamp
			if (isset($data['update']) && $data['update'] == 'yes') {
				$data['updated'] = time();
			}
			unset($data['update']);
 
            // update the page
           	$this->content_model->updateContent($data);
			
			redirect($this->input->post('path'));
		}
		elseif ($this->input->post('cancel'))
		{
			redirect($this->input->post('path'));
		}
		elseif ($id == 0)
		{
			$this->_print('You must specify a page to edit.');
		}
		else
		{
			$return = $this->content_model->findContent(array('id' => $id));
			$data = $return[0];
			$paths = array('domain','controller','function','page','aux0');
			$path_array = array_filter(array_intersect_key($data, array_flip($paths)));
			
			
			$users = $this->people_model->selectUsers();
			foreach ($users as $user)
			{
				$dropdown[$user['id']] = $user['lname'].' '.$user['fname'];
			}
			$data['users'] = $dropdown;
			$data['path_string'] = implode('/', $path_array);
			$data['path'] = $path_array;
			$data['target'] = 'admin/page/update/'.$id;
			
			$this->_print($this->load->view('admin/page_form', $data, true));
		}
	}
	
	function delete()
	{
		if (! $this->auth->is_admin())
		{
			redirect('public/home/error/permission/not_admin');
		}
		$id = $this->uri->segment(4, 0);
		if ($id == 0)
		{
			$this->_print('Please specify a page to delete.');
		}
		else
		{
			$this->content->deletePage($id);
			$this->_print('Page deleted.');
		}
	}
	
	function delete_editor()
	{
		if (! $this->auth->is_admin())
		{
			redirect('public/home/error/permission/not_admin');
		}
		$user_id = $this->uri->segment(5, 0);
		$page_id = $this->uri->segment(4, 0);
		if ($page_id ==0)
		{
			$this->_print('Please specify a user and page combo to be removed, in that order: user_id/page_id.');
		}
		else
		{
			$this->content_model->deleteContentEditor($user_id, $page_id);
			$this->_print('You have successfully removed an editor.');
		}
	}
	
	function add_editor()
	{
		if (! $this->auth->is_admin())
		{
			redirect('home/error/permission/not_admin');
		}
		$user_id = $this->uri->segment(5, 0);
		$page_id = $this->uri->segment(4, 0);
		
		if ($user_id != 0 && $page_id != 0)
		{
			$this->content_model->insertContentEditor($user_id, $page_id);
			$this->_print('Editor successfully added.');
		}
		elseif ($page_id != 0 && $user_id == 0)
		{
			$data = array();
			$data['page_id'] = $this->uri->segment(4);
		
			$this->headview_tags['scripts'][] = 'http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js';
			$this->headview_tags['scripts'][] = base_url().'js/jquery.dataTables.min.js';
			$this->headview_tags['scripts'][] = base_url().'js/datatable_initiate.js';
		
			$this->headview_tags['stylesheets'][] = base_url().'css/demo_table.css';
		
			$data['users'] = $this->people_model->selectUsers();
				
			$this->_print($this->load->view('admin/user_list', $data, TRUE));
		}
		else
		{
			$this->_print('Please either specify a valid editor/page combo to be added, or a page ID to select a user.');
		}
	}
}