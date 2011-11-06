<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

class Casestudy extends MY_Controller {

	function __construct()
	{
	    parent::__construct();
		$this->load->library(array('permission_class', 'profile_class'));
	}

	public function index()
	{
		$this->load->model(array('page_model'));

		if (! $results = $this->page_model->read(array('fields' => 'id, title, url, description, tags, updated', 'where' => array('case_study' => 1))))
		{
			$this->session->set_flashdata('error', 'No case studies were found. Sorry.');
			redirect('feed/page');
		}

		foreach ($results as $result)
		{
			$table['edit'] = anchor('page/edit/'.$result['id'], 'Edit');
			$table['title'] = anchor('page/view/'.$result['url'], $result['title']);
			$table['description'] = $result['description'];
			$table['tags'] = $result['tags'];
			$table['updated'] = date('m D Y', $result['updated']);

			$data['table'][] = $table;
		}

		$data['title'] = 'Case Studies';
		$data['backtrack'] = array('' => 'Home', 'feed/page' => 'Pages', 'casestudy' => 'Case Studies');


	    // print the page
		$this->output->set_header("Cache-Control: max-age=300, public, must-revalidate");

		$this->load->view('head', array('page_title' => $data['title'], 'stylesheets' => array('demo_table.css', 'layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('jquery.dataTables.min.js', 'profile_list.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('casestudy_list_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer', array('footer' => 'Footer Here'));
	}
}