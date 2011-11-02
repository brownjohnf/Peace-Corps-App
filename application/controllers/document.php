<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

class Document extends MY_Controller {
	
	function __construct() {
	    parent::__construct();
		$this->load->library('document_class');
	    $this->load->helper(array('form', 'url'));
		$this->load->model('document_model');
	}
	
	public function view()
	{
		$this->load->model('document_model');
		
		if (is_numeric($this->uri->segment(3)))
		{
			$data['table'] = $this->document_model->read(array('where' => array('id' => $this->uri->segment(3))));
		}
		elseif (! is_numeric($this->uri->segment(3)) && $this->uri->segment(4))
		{
			$data['table'] = $this->document_model->read(array('where' => array($this->uri->segment(3) => $this->uri->segment(4))));
		}
		else
		{
			$data['table'] = $this->document_model->read();
		}
		
		$data['title'] = 'Documents';
		$data['backtrack'] = array('resource' => 'Resources', 'document/view' => 'Documents', 'document/view' => 'View');
		
		
	    // print the page
		$this->output->set_header("Cache-Control: max-age=300, public, must-revalidate");
		
		$this->load->view('head', array('page_title' => $data['title'], 'stylesheets' => array('demo_table.css', 'layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('jquery.dataTables.min.js', 'document.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('document_list_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer');
	}
	
	public function add()
	{
		if (! $this->auth->is_user())
		{
			$this->session->set_flashdata('error', 'You do not have appropriate permissions for this action. [upload photo]');
			redirect('resource');
		}
		$data = $this->document_class->blank_form();
		
		$data['form_title'] = 'Upload Document';
		$data['target'] = 'do_upload';
		
		$this->load->view('head', array('page_title' => $data['form_title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('document_form', $data);
		$this->load->view('main_close');
		$this->load->view('footer');
	}
	
	function do_upload()
	{
		if (! $this->auth->is_user())
		{
			$this->session->set_flashdata('error', 'You do not have appropriate permissions for this action. [upload photo]');
			redirect('resource');
		}
		ini_set("memory_limit","128M");
		$this->config->load('file', true);
		$config = $this->config->item('file');
		$this->load->library('upload', $config);
	
		if ($this->upload->do_upload())
		{
			$data['tags'] = $this->input->post('tags');
			if ($this->input->post('title'))
			{
				$data['title'] = $this->input->post('title');
			}
			else
			{
				$data['title'] = $this->input->post('userfile');
			}
			$upload_data = $this->upload->data();
			$data['name'] = $upload_data['raw_name'];
			$data['ext'] = $upload_data['file_ext'];
			$data['type'] = $upload_data['file_type'];
			$data['user_id'] = $this->userdata['id'];
			
			if ($id = $this->document_class->create($data))
			{
				$this->session->set_flashdata('success', 'You have successfully uploaded your document. Please edit its metadata, if you have not already done so.');
				redirect('document/edit/'.$id);
			}
			else
			{
				$this->session->set_flashdata('error', 'could not add process document.');
				redirect('document/add');
			}
		}
		else
		{
			$this->session->set_flashdata('error', $this->upload->display_errors());
			
			redirect('document/add');
		}
	}
	
	public function edit()
	{
	    if ($this->uri->segment(3, null) == null && $this->input->post('id') == null)
	    {
			$this->session->set_flashdata('error', 'You must specify a document to edit, or simply create a new one here. [007]');
			redirect('document/create');
	    }
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	    
	    $this->form_validation->set_rules('title', 'Title', 'required');
	    $this->form_validation->set_rules('tags', 'Tags', 'callback_tag_check');
	    
		if ($this->form_validation->run() == false)
		{
			$data = $this->document_class->full_form($this->uri->segment(3));
			
	        $data['target'] = 'edit/'.$data['id'];
			$data['form_title'] = 'Edit Document Info';
			$data['controls'] = anchor('document/view/'.$this->uri->segment(3), img(base_url().'img/cancel_icon.png'), array('class' => 'cancel'));
			
			$this->load->view('head', array('page_title' => $data['form_title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css')));
			$this->load->view('header');
			$this->load->view('main_open');
			$this->load->view('left_column');
			$this->load->view('document_form', $data);
			$this->load->view('main_close');
			$this->load->view('footer');
		}
		else
		{
		    if ($id = $this->document_class->edit($this->input->post()))
		    {
			    $this->session->set_flashdata('success', 'Document data successfully edited.');
			    redirect('document/view/'.$id);
			}
		    else
		    {
		        die("we've hit a serious database error trying to update the document data. ask Jack. [010]");
	        }
	    }
	}
	
	public function delete()
	{
		if (! $this->document_model->delete($this->uri->segment(3)))
		{
			$error = "Couldn't delete document from database.";
		}
		if (isset($error)) {
			$this->session->set_flashdata('error', $error);
		}
		redirect('document/view');
	}
	
	// validation callback function for checking tags
	function tag_check($tags)
	{
		if ($fail = $this->tag_class->check_tag_input($tags))
		{
			$this->form_validation->set_message($fail[0], $fail[1]);
			return false;
		}
		else
		{
			return true;
		}
	}
}