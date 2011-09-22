<?php
class knowledge extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('knowledge_library');
	}
	
	public function index()
	{	
		$this->headview_tags['page_title'] = 'Knowledge Base';
		
		$this->_print($this->knowledge_library->printTree('links'));
	}
	public function results()
	{
		print $this->uri->segment(4);
		$this->defaultview_tags['title'] = $this->uri->segment(5);
		$this->_print($this->knowledge_library->show_resources($this->uri->segment(4)));
	}
}