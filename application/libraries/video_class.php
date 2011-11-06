<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video_class
{
	public function __construct() {
		$this->ci =& get_instance();
		$this->ci->load->model('video_model');
	}
	public function create($data)
	{
	    $input['description'] = $data['description'];
	    $input['title'] = $data['title'];
	    $input['embed'] = $data['embed'];
	    $input['link'] = $data['link'];
	    $input['type'] = ($data['video_type'] == 'none' ? null : $data['video_type']);

		if ($tags = $this->ci->tag_class->tag_input($data['tags']))
		{
			$input['tags'] = $tags['string'];
			foreach ($tags['array'] as $tag)
			{
				$tag_input[] = array('tag' => $tag, 'blurb' => null);
			}
		}

		// create the video entry, or die
		if (! $id = $this->ci->video_model->create($input)) {
			die('Failed to update videos table. Check your data and try again. [002]');
		}

		// post the tags
		if (isset($tag_input) && ! $this->ci->tag_class->tag(array('source' => 'videos', 'source_id' => $id, 'to_add' => $tag_input)))
		{
			die('tag_class->tag returned false.');
		}

		return $id;
	}

	public function edit($data)
	{
		$input['id'] = $data['id'];
	    $input['description'] = $data['description'];
	    $input['title'] = $data['title'];
	    $input['embed'] = $data['embed'];
	    $input['link'] = $data['link'];
	    $input['type'] = ($data['video_type'] == 'none' ? null : $data['video_type']);

		if ($tags = $this->ci->tag_class->tag_input($data['tags']))
		{
			$input['tags'] = $tags['string'];
			foreach ($tags['array'] as $tag)
			{
				$tag_input[] = array('tag' => $tag, 'blurb' => null);
			}
			if (! $this->ci->tag_class->tag(array('source' => 'videos', 'source_id' => $data['id'], 'to_add' => $tag_input)))
			{
				die('tag_class->tag returned false.');
			}
		}
		else
		{
			$input['tags'] = null;
			// need to delete any tags that were attached to this page

			// delete all tags currently registered to this source
			if (! $this->ci->tag_model->delete(array('source' => 'videos', 'source_id' => $data['id']))) {
				die('tag_model->delete returned false');
			}
		}

		// update the page entry, or die
		if (! $this->ci->video_model->update($input)) {
			die('Failed to update links table. Check your data and try again. [002]');
		}

		return $input['id'];
	}

	public function view($id)
	{
		if (! $result = $this->ci->video_model->read(array('fields' => '', 'where' => array('id' => $id), 'limit' => 1)))
		{
			$this->ci->session->set_flashdata('error', 'The video you have requested does not exist.');
		}

		$return['id'] = $result['id'];
		$return['title'] = $result['title'];
		$return['description'] = $result['description'];
		$return['edited'] = date('m D Y', $result['edited']);
		$return['tags'] = ($result['tags'] != '' ? explode('#', trim($result['tags'], '#')) : null);

		if ($this->ci->userdata['is_admin'])
		{
			$return['controls'] = anchor('video/edit/'.$result['id'], img('img/edit_icon_black.png'), array('class' => 'edit'));
		}
		else
		{
			$return['controls'] = null;
		}

		switch ($result['type'])
		{
			case 'youtube':
				$return['embed'] = '<iframe width="560" height="315" src="http://www.youtube.com/embed/'.$result['embed'].'?rel=0&wmode=Opaque" frameborder="0" allowfullscreen></iframe>';
				$return['link'] = anchor($result['link'], 'YouTube');
				break;
			default:
				$return['embed'] = $result['embed'];
				$return['link'] = anchor($result['link'], 'original medium');
		}

		return $return;
	}

	public function blank_form()
	{
	    $data['id'] = null;
	    $data['link'] = null;
		$data['description'] = null;
		$data['title'] = null;
		$data['embed'] = null;
		$data['tags'] = null;
		$data['none'] = null;
		$data['youtube'] = null;
		$data['google'] = null;

	    return $data;
	}

	public function full_form($id)
	{
	    // fetch the link data
	    $data = $this->ci->video_model->read(array('where' => array('id' => $id), 'limit' => 1));

		foreach (array('none', 'youtube', 'google') as $key)
		{
	    	$data[$key] = ($key == $data['type'] ? true : false);
		}

	    return $data;
	}

	public function feed($id ='%')
	{
		// grab all videos
		$results = $this->ci->video_model->read(array('fields' => 'id, title, description, embed, tags, link, edited', 'where' => array('id like' => $id), 'order_by' => array('column' => 'edited', 'order' => 'desc'), 'limit' => 10));

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

			$item['message'] = $result['description'];
			$item['message_truncated'] = 'no';
			$item['subject'] = '<span style="color:white;font-size:120%;">Video</span> '.anchor($result['link']);
			$item['full_url'] = base_url().'video/view/'.$result['id'].'/'.url_title($result['title'], 'underscore');
			$item['author'] = $result['title'];
			$item['tags'] = $tags['array'];


			// eventually needs to point to icon for links
			if (false) {
				$item['profile_photo'] = 'http://graph.facebook.com/'.$result['fb_id'].'/picture';
			} else {
				$item['profile_photo'] = base_url().'img/blank.png';
			}

			$item['elapsed'] = $this->ci->common_class->elapsed_time($result['edited']).' ago';


			if ($this->ci->userdata['is_admin'])
			{
				$item['controls'] = anchor('video/edit/'.$result['id'], img('img/edit_icon_black.png'), array('class' => 'edit'));
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
