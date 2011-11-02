<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Document_class
{
	public function __construct() {
		$this->ci =& get_instance();
	}
	public function create($data)
	{
		$tags = $this->ci->tag_class->tag_input($data['tags']);
	    $input['tags'] = $tags['string'];
	    $input['title'] = $data['title'];
		$input['name'] = $data['name'];
		$input['ext'] = $data['ext'];
		$input['type'] = $data['type'];
		$input['user_id'] = $data['user_id'];
		
		
		if (! $id = $this->ci->document_model->create($input))
		{
			$this->ci->session->set_flashdata('error', 'Failed to add record to links table. [005]');
			return false;
		}
		
		foreach ($tags['array'] as $tag)
		{
			$tag_input[] = array('tag' => $tag, 'source' => 'documents', 'source_id' => $id, 'updated' => time());
		}
		
		if (! $this->ci->tag_model->create($tag_input))
		{
			die('failed to add tags to tag table');
		}
		return $id;
	}
	
	public function edit($data)
	{
		$tags = $this->ci->tag_class->tag_input($data['tags']);
	    $input['tags'] = $tags['string'];
	    $input['title'] = $data['title'];
		$input['id'] = $data['id'];
		
		// update the document entry, or die
		if (! $this->ci->document_model->update($input)) {
			die('Failed to update document table. Check your data and try again. [002]');
		}
		
		foreach ($tags['array'] as $tag)
		{
			$tag_input[] = array('tag' => $tag, 'source' => 'documents', 'source_id' => $input['id'], 'updated' => time());
		}
		
		if (! $this->ci->tag_model->create($tag_input))
		{
			die('failed to add tags to tag table');
		}
		return $input['id'];
	}
	public function blank_form()
	{
		$data['id'] = null;
	    $data['tags'] = null;
	    $data['title'] = null;
		$data['name'] = null;
		$data['ext'] = null;
		$data['type'] = null;
	    
	    return $data;
	}
	public function full_form($id)
	{
	    // fetch the document data
	    $data = $this->ci->document_model->read(array('where' => array('id' => $id), 'limit' => 1));
		//$blank = $this->blank_form();
		//$data = array_merge($blank, $data);
	    return $data;
	}
}
