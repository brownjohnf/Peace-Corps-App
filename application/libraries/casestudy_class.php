<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Casestudy_class
{
	public function __construct() {
		$this->ci =& get_instance();
		$this->ci->load->model(array('page_model', 'tag_model', 'permission_model', 'photo_model'));
		$this->ci->load->library(array('permission_class', 'common_class', 'tag_class'));
		$this->ci->load->helper(array('markdown', 'text'));
	}
	public function feed($id = '%')
	{
	    $fields = 'id, updated, title, description, content, url, tags, profile_photo';

	    // get content results
	    $results = $this->ci->page_model->read(array('fields' => $fields, 'where' => array('id like' => $id, 'case_study' => 1), 'limit' => 10));
	    foreach ($results as $result)
	    {
			if (str_word_count($result['content']) > 50)
			{
				$message = $this->ci->tag_class->tags_to_links(word_limiter(strip_tags(Markdown($result['content'], '<b><i><u><em>')), 50));
			    $item['message'] = $message['text'];
			    $item['message_truncated'] = 'yes';
			}
			else
			{
				$message = $this->ci->tag_class->tags_to_links(strip_tags(Markdown($result['content']), '<b><i><u><em>'));
			    $item['message'] = $message['text'];
			    $item['message_truncated'] = 'no';
			}

			$item['subject'] = '<span style="color:green;font-size:120%;">Case Study!</span> '.$result['description'];
			$item['edit_path'] = 'page/edit/'.$result['id'];
			$item['delete_path'] = 'page/delete/'.$result['id'];


			if ($result['profile_photo'] != '')
			{
				$photo_data = $this->ci->photo_model->read(array('where' => array('imagename' => $result['profile_photo'], 'width' => 50, 'height' => 50), 'limit' => 1));
				$item['profile_photo'] = base_url().'uploads/'.$photo_data['filename'].$photo_data['extension'];
			}
			else
			{
				$item['profile_photo'] = base_url().'img/blank.png';
			}


			$item['full_url'] = 'page/view/'.$result['url'];
			$item['author'] = $result['title'];

			if ($tags = $this->ci->tag_model->read(array('fields' => 'tag', 'where' => array('source' => 'page', 'source_id' => $result['id']))))
			{
				foreach ($tags as $tag)
				{
					$item['tags'][] = $tag['tag'];
				}
			}
			else
			{
				$item['tags'] = null;
			}

			$item['elapsed'] = $this->ci->common_class->elapsed_time($result['updated']).' ago';
			if ($this->ci->userdata['group']['name'] == 'admin' || $this->ci->permission_class->is_actor(array('page_id' => $result['id'], 'user_id' => $this->ci->userdata['id'])))
			{
				$item['controls'] = anchor('page/edit/'.$result['id'], img('img/edit_icon_black.png'), array('class' => 'edit'));
			}
			else
			{
				$item['controls'] = null;
			}

			$return[$result['updated']] = $item;
	    }
	    return $return;
	}
}
