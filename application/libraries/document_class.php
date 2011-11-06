<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Document_class
{
	public function __construct() {
		$this->ci =& get_instance();
		$this->ci->load->model('document_model');
	}
	public function create($data)
	{
	    $input['title'] = $data['title'];
		$input['name'] = $data['name'];
		$input['ext'] = $data['ext'];
		$input['type'] = $data['type'];
		$input['size'] = $data['size'];
		$input['user_id'] = $data['user_id'];

		if ($tags = $this->ci->tag_class->tag_input($data['tags']))
		{
			$input['tags'] = $tags['string'];
			foreach ($tags['array'] as $tag)
			{
				$tag_input[] = array('tag' => $tag, 'blurb' => null);
			}
		}

		if (! $id = $this->ci->document_model->create($input))
		{
			$this->ci->session->set_flashdata('error', 'Failed to add record to documents table. [005]');
			return false;
		}

		if (isset($tag_input) && ! $this->ci->tag_class->tag(array('source' => 'documents', 'source_id' => $id, 'to_add' => $tag_input)))
		{
			die('tag_class->tag returned false.');
		}

		return $id;
	}

	public function view()
	{
		if (! $results = $this->ci->document_model->read(array('fields' => 'id, title, tags, ext, edited, size', 'order_by' => array('column' => 'edited', 'order' => 'desc'))))
		{
			die('failed to read documents table');
		}

		foreach ($results as $doc)
		{
			if ($doc['tags'] != '')
			{
				$tags = explode('#', trim($doc['tags'], '#'));
				foreach ($tags as $tag)
				{
					$tag_ret[] = '<span class="hash">#</span>'.anchor('tag/feed/'.urlencode($tag), $tag);
				}
				$row['tags'] = implode(' ', $tag_ret);
			}
			else
			{
				$row['tags'] = null;
			}

			$row['title'] = $doc['title'];
			$row['url'] = base_url().'document/download/'.$doc['id'].'/'.url_title(str_replace('.', '', $doc['title']), 'underscore');
			$row['edited'] = date('d M Y', $doc['edited']);
			$row['ext'] = $doc['ext'];
			$row['size'] = $doc['size'].' kb';

			unset($tag_ret);
			$return[] = $row;
		}

		return $return;
	}

	public function edit($data)
	{
	    $input['title'] = $data['title'];
		$input['id'] = $data['id'];

		if ($tags = $this->ci->tag_class->tag_input($data['tags']))
		{
			$input['tags'] = $tags['string'];
			foreach ($tags['array'] as $tag)
			{
				$tag_input[] = array('tag' => $tag, 'blurb' => null);
			}
			if (! $this->ci->tag_class->tag(array('source' => 'documents', 'source_id' => $data['id'], 'to_add' => $tag_input)))
			{
				die('tag_class->tag returned false.');
			}
		}
		else
		{
			$input['tags'] = null;
			// need to delete any tags that were attached to this page

			// delete all tags currently registered to this source
			if (! $this->ci->tag_model->delete(array('source' => 'documents', 'source_id' => $data['id']))) {
				die('tag_model->delete returned false');
			}
		}

		// update the document entry, or die
		if (! $this->ci->document_model->update($input)) {
			die('Failed to update document table. Check your data and try again. [002]');
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

	public function feed($id ='%')
	{
		// grab all documents
		$results = $this->ci->document_model->read(array('fields' => 'id, title, tags, ext, edited', 'where' => array('id like' => $id), 'order_by' => array('column' => 'edited', 'order' => 'desc'), 'limit' => 10));

		// populate the standard feed harness
		foreach ($results as $result)
		{
			if ($result['tags'])
			{
				$tags = $this->ci->tag_class->tags_to_links($result['tags']);
			}
			else
			{
				$tags = array('string' => 'Not currently tagged.', 'array' => null);
			}

			$item['message'] = null;
			$item['message_truncated'] = 'no';
			$item['subject'] = '<span style="color:blue;font-size:120%;">Document</span> '.$result['ext'];
			$item['full_url'] = base_url().'document/download/'.$result['id'].'/'.url_title($result['title'], 'underscore');
			$item['author'] = $result['title'];
			$item['tags'] = $tags['array'];


			// eventually needs to point to icons for diff kinds of documents
			if (false) {
				$item['profile_photo'] = 'http://graph.facebook.com/'.$result['fb_id'].'/picture';
			} else {
				$item['profile_photo'] = base_url().'img/blank.png';
			}

			$item['elapsed'] = $this->ci->common_class->elapsed_time($result['edited']).' ago';


			if ($this->ci->userdata['is_admin'])
			{
				$item['controls'] = anchor('document/edit/'.$result['id'], img('img/edit_icon_black.png'), array('class' => 'edit'));
			}
			else
			{
				$item['controls'] = null;
			}
			$item['comments'] = null;
			$item['info'] = null;

			$return[$result['edited']] = $item;
		}

		return $return;
	}
}
