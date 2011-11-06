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

	public function index()
	{
		$data['table'] = $this->document_class->view();

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

	public function admin()
	{
		if (! $this->userdata['is_admin'])
		{
			$this->session->set_flashdata('error', 'You do not have appropriate permissions for this action. [upload photo]');
			redirect('document');
		}
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
		$data['edit_target'] = 'document/edit/';
		$data['extra_targets'][] = array('path' => 'document/delete/', 'column' => 'id', 'text' => 'Delete');


	    // print the page
		$this->output->set_header("Cache-Control: max-age=300, public, must-revalidate");

		$this->load->view('head', array('page_title' => $data['title'], 'stylesheets' => array('demo_table.css', 'layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('jquery.dataTables.min.js', 'document.js')));
		$this->load->view('header');
		//$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('table_view', $data);
		//$this->load->view('main_close');
		$this->load->view('footer');
	}

	public function download()
	{
		$data = $this->document_model->read(array('fields' => 'title, name, ext, type', 'where' => array('id' => $this->uri->segment(3)), 'limit' => 1));
		$full_path = base_url().'uploads/docs/'.$data['name'].$data['ext'];

		header('Content-disposition: attachment; filename: '.$data['title']);
		header('Content-type: '.$data['type']);
		readfile($full_path);
	}

	public function add()
	{
		if (! $this->userdata['is_admin'])
		{
			$this->session->set_flashdata('error', 'You do not have appropriate permissions for this action. [upload document]');
			redirect('document');
		}
		$data = $this->document_class->blank_form();

		$data['form_title'] = 'Upload Document';
		$data['target'] = 'do_upload';
		$data['backtrack'] = array('resource' => 'Resources', 'document' => 'Documents', 'document/add' => 'Upload');

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
		if (! $this->userdata['is_admin'])
		{
			$this->session->set_flashdata('error', 'You do not have appropriate permissions for this action. [upload document]');
			redirect('admin');
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
			$data['size'] = $upload_data['file_size'];
			$data['user_id'] = $this->userdata['id'];

			if ($id = $this->document_class->create($data))
			{
				$this->session->set_flashdata('success', 'You have successfully uploaded your document. Please edit its metadata, if you have not already done so. This is optional; the data you see below is already saved.');
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
		if (! $this->userdata['is_admin'])
		{
			$this->session->set_flashdata('error', 'You do not have appropriate permissions for this action. [upload document]');
			redirect('document');
		}
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
			$data['backtrack'] = array('resource' => 'Resources', 'document' => 'Documents', 'document/edit/'.$this->uri->segment(3) => 'Edit');

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
			    redirect('document/admin/'.$id);
			}
		    else
		    {
		        die("we've hit a serious database error trying to update the document data. ask Jack. [010]");
	        }
	    }
	}

	public function delete()
	{
		if (! $this->userdata['is_admin'])
		{
			$this->session->set_flashdata('error', 'You do not have appropriate permissions for this action. [upload photo]');
			redirect('document');
		}
		$this->load->model('resource_model');
		if (! $this->document_model->delete(array('id' => $this->uri->segment(3))))
		{
			$error[] = "Couldn't delete document from database.";
		}
		if (! $this->tag_model->delete(array('source' => 'documents', 'source_id' => $this->uri->segment(3))))
		{
			$error[] = "Couldn't delete document from database.";
		}
		if (! $this->resource_model->delete_resources(array('table' => 'documents', 'res_id' => $this->uri->segment(3))))
		{
			$error[] = "Couldn't delete document from mod_resources table.";
		}
		if (isset($error)) {
			$this->session->set_flashdata('error', implode(' ', $error));
		}
		redirect('document/admin');
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