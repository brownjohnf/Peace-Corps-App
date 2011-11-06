<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Link_class
{
	public function __construct() {
		$this->ci =& get_instance();
		$this->ci->load->model('link_model');
	}
	public function create($data)
	{
	    $input['url'] = $data['url'];
	    $input['title'] = $data['title'];

		if ($tags = $this->ci->tag_class->tag_input($data['tags']))
		{
			$input['tags'] = $tags['string'];
			foreach ($tags['array'] as $tag)
			{
				$tag_input[] = array('tag' => $tag, 'blurb' => null);
			}
		}

		// create the link entry, or die
		if (! $id = $this->ci->link_model->create($input)) {
			die('Failed to update links table. Check your data and try again. [002]');
		}

		if (isset($tag_input) && ! $this->ci->tag_class->tag(array('source' => 'links', 'source_id' => $id, 'to_add' => $tag_input)))
		{
			die('tag_class->tag returned false.');
		}

		return $id;
	}

	public function edit($data)
	{
		$input['id'] = $data['id'];
	    $input['title'] = $data['title'];
		$input['url'] = $data['url'];

		if ($tags = $this->ci->tag_class->tag_input($data['tags']))
		{
			$input['tags'] = $tags['string'];
			foreach ($tags['array'] as $tag)
			{
				$tag_input[] = array('tag' => $tag, 'blurb' => null);
			}
			if (! $this->ci->tag_class->tag(array('source' => 'links', 'source_id' => $data['id'], 'to_add' => $tag_input)))
			{
				die('tag_class->tag returned false.');
			}
		}
		else
		{
			$input['tags'] = null;
			// need to delete any tags that were attached to this page

			// delete all tags currently registered to this source
			if (! $this->ci->tag_model->delete(array('source' => 'links', 'source_id' => $data['id']))) {
				die('tag_model->delete returned false');
			}
		}

		// update the page entry, or die
		if (! $this->ci->link_model->update($input)) {
			die('Failed to update links table. Check your data and try again. [002]');
		}

		return $input['id'];
	}

	public function blank_form()
	{
	    $data['title'] = null;
	    $data['url'] = null;
		$data['id'] = null;
		$data['tags'] = null;

	    return $data;
	}

	public function full_form($id)
	{
	    // fetch the link data
	    $data = $this->ci->link_model->read(array('where' => array('id' => $id), 'limit' => 1));

	    return $data;
	}

	public function feed($id ='%')
	{
		// grab all links
		$results = $this->ci->link_model->read(array('fields' => 'id, title, tags, url, updated', 'where' => array('id like' => $id), 'order_by' => array('column' => 'updated', 'order' => 'desc'), 'limit' => 10));

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
			$item['subject'] = '<span style="color:purple;font-size:120%;">Link</span> '.$result['url'];
			$item['full_url'] = $result['url'];
			$item['author'] = $result['title'];
			$item['tags'] = $tags['array'];


			// eventually needs to point to icon for links
			if (false) {
				$item['profile_photo'] = 'http://graph.facebook.com/'.$result['fb_id'].'/picture';
			} else {
				$item['profile_photo'] = base_url().'img/blank.png';
			}

			$item['elapsed'] = $this->ci->common_class->elapsed_time($result['updated']).' ago';


			if ($this->ci->userdata['is_admin'])
			{
				$item['controls'] = anchor('link/edit/'.$result['id'], img('img/edit_icon_black.png'), array('class' => 'edit'));
			}
			else
			{
				$item['controls'] = null;
			}
			$item['comments'] = null;
			$item['info'] = null;

			$return[$result['updated']] = $item;
		}

		return $return;
	}
}
