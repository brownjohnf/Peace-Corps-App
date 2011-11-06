<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_class
{
	public function __construct() {
		$this->ci =& get_instance();
		$this->ci->load->model(array('page_model', 'tag_model', 'permission_model', 'photo_model'));
		$this->ci->load->library(array('permission_class', 'common_class', 'tag_class'));
		$this->ci->load->helper(array('markdown', 'text'));
	}
	public function create($data)
	{
		if (array_key_exists('case_study', $data))
		{
			$input['case_study'] = 1;
			$input['parent_id'] = 0;
			$source = 'case_study';
		}
		else
		{
	    	$input['parent_id'] = $data['parent_id'];
	    	$source = 'page';
		}
		$input['title'] = $data['title'];
	    $input['url'] = url_title($data['title'], 'dash', true);
	    $input['group_id'] = $data['group_id'];
	    $input['description'] = $data['description'];
	    $input['content'] = $data['content'];
	    $input['profile_photo'] = $data['profile_photo'];
	    $input['visibility'] = $data['visibility'];

		if ($this->ci->userdata['group']['name'] != 'admin')
		{
			$data['actors'][] = $this->ci->userdata['id'];
		}

	    $input['updated'] = time();
	    $input['created'] = time();

		if (! $page_id = $this->ci->page_model->create($input))
		{
			$this->ci->session->set_flashdata('error', 'Failed to add record to content table. [005]');
			return false;
		}

		if ($tags = $this->ci->tag_class->parse_tags(strip_tags(Markdown($data['content']), '<b><i><em><ul><a>')))
		{
			// set data to be sent to the tag function
			$tag_input = array('source' => $source, 'source_id' => $page_id, 'to_add' => $tags['array']);

			$this->ci->load->library('tag_class');
			//print_r($tag_input);
			// add the tags to the tag table
			if (! $this->ci->tag_class->tag($tag_input)) {
				die('tag_class->tag returned false.');
			}
		}

		// if auto-links were requested, apply them
		if (array_key_exists('auto_link_parent', $data) && $data['parent_id'] != 0) {
			$auto_links[] = $data['parent_id'];
		}
		if (array_key_exists('auto_link_sibling', $data)) {
			$query_array[] = "parent_id = $data[parent_id]";
		}
		if (array_key_exists('auto_link_child', $data)) {
			$query_array[] = "parent_id = $data[id]";
		}

		// if auto-links need to be looked up, do so
		if (isset($query_array))
		{
			$query_string = '('.implode(' OR ', $query_array).") AND (id != $page_id OR 'delete' IS FALSE)";
			if ($results = $this->ci->page_model->read(array('fields' => 'id', 'where' => $query_string)))
			{
				foreach ($results as $result)
				{
					$auto_links[] = $result['id'];
				}
			}
		}

		// if there is any auto-data to submit
		if (isset($auto_links) && isset($data['links']))
		{
			$data['links'] = array_merge($data['links'], $auto_links);
		}
		elseif (isset($auto_links))
		{
			$data['links'] = $auto_links;
		}

		if (isset($data['authors']))
		{
			foreach ($data['authors'] as $author)
			{
				if (! $this->ci->permission_model->create_author(array('page_id' => $page_id, 'user_id' => $author)))
				{
					$this->ci->session->set_flashdata('error', 'Failed to add record to authors table while adding content. [001]');
					return false;
				}
			}
		}

		if (isset($data['actors']))
		{
			foreach ($data['actors'] as $actor)
			{
				if (! $this->ci->permission_model->create_actor(array('page_id' => $page_id, 'user_id' => $actor)))
				{
					$this->ci->session->set_flashdata('error', 'Failed to add record to actors table while adding content. [001]');
					return false;
				}
			}
		}

		if (isset($data['links']))
		{
			foreach ($data['links'] as $link)
			{
				if (! $this->ci->page_model->create_page_link(array('page_id' => $page_id, 'link_id' => $link)))
				{
					$this->ci->session->set_flashdata('error', 'Failed to add record to page_links table while adding content. [078]');
					return false;
				}
			}
		}


		return $input['url'];
	}

	public function edit($data)
	{
		if (array_key_exists('case_study', $data))
		{
			$input['case_study'] = 1;
			$input['parent_id'] = 0;
			$source = 'case_study';
		}
		else
		{
			$source = 'page';
			$input['parent_id'] = $data['parent_id'];
		}

		$input['id'] = $data['id'];
		$input['title'] = $data['title'];
		$input['url'] = url_title($data['title'], 'dash', true);
		$input['group_id'] = $data['group_id'];
		$input['description'] = $data['description'];
		$input['content'] = $data['content'];
		$input['profile_photo'] = $data['profile_photo'];
		$input['visibility'] = $data['visibility'];

		if ($tags = $this->ci->tag_class->parse_tags(strip_tags(Markdown($data['content']), '<b><i><em><u><a>')))
		{
			// set data to be sent to the tag function
			$tag_input = array('source' => $source, 'source_id' => $data['id'], 'to_add' => $tags['array']);

			$this->ci->load->library('tag_class');
			//print_r($tag_input);
			// add the tags to the tag table
			if (! $this->ci->tag_class->tag($tag_input)) {
				die('tag_class->tag returned false.');
			}
		}
		else
		{
			// need to delete any tags that were attached to this page

			// delete all tags currently registered to this source
			if (! $this->ci->tag_model->delete(array('source' => 'page', 'source_id' => $data['id']))) {
				die('tag_model->delete returned false');
			}
		}

		// if the page is marked as updated, set the current time
		if (array_key_exists('updated', $data)) {
			$input['updated'] = time();
		}

		// if auto-links were requested, apply them
		if (array_key_exists('auto_link_parent', $data) && $data['parent_id'] != 0) {
			$auto_links[] = $data['parent_id'];
		}
		if (array_key_exists('auto_link_sibling', $data)) {
			$query_array[] = "parent_id = $data[parent_id]";
		}
		if (array_key_exists('auto_link_child', $data)) {
			$query_array[] = "parent_id = $data[id]";
		}

		// if auto-links need to be looked up, do so
		if (isset($query_array))
		{
			$query_string = '('.implode(' OR ', $query_array).") AND (id != $data[id] OR 'delete' IS FALSE)";
			if ($results = $this->ci->page_model->read(array('fields' => 'id', 'where' => $query_string)))
			{
				foreach ($results as $result)
				{
					$auto_links[] = $result['id'];
				}
			}
		}

		// if there is any auto-data to submit
		if (isset($auto_links) && isset($data['links']))
		{
			$data['links'] = array_merge($data['links'], $auto_links);
		}
		elseif (isset($auto_links))
		{
			$data['links'] = $auto_links;
		}

		// update the page entry, or die
		if (! $this->ci->page_model->update($input)) {
			die('Failed to update content table. Check your data and try again. [002]');
		}

		if ($cur_authors = $this->ci->permission_class->authors($data['id'])) {
			foreach ($cur_authors as $key => $value)
			{
				$current_authors[] = $key;
			}
			if (isset($data['authors']))
			{
				$auth_to_add = array_diff($data['authors'], $current_authors);
				$auth_to_del = array_diff($current_authors, $data['authors']);
			}
			else
			{
				$auth_to_del = $current_authors;
			}

			foreach ($auth_to_del as $author) {
				if (! $this->ci->permission_model->delete_author(array('page_id' => $data['id'], 'user_id' => $author)))
				{
					$this->ci->session->set_flashdata('error', 'Failed to remove author while updating content. [004]');
					return false;
				}
			}
		}
		elseif (isset($data['authors']))
		{
			$auth_to_add = $data['authors'];
		}
		if (isset($auth_to_add))
		{
			foreach ($auth_to_add as $author)
			{
				if (! $this->ci->permission_model->create_author(array('page_id' => $data['id'], 'user_id' => $author)))
				{
					$this->ci->session->set_flashdata('error', 'Failed to add author while updating content. [003]');
					return false;
				}
			}
		}

		if ($cur_actors = $this->ci->permission_class->actors($data['id']))
		{
			foreach ($cur_actors as $key => $value)
			{
				$current_actors[] = $key;
			}
			if (isset($data['actors']))
			{
				$act_to_add = array_diff($data['actors'], $current_actors);
				$act_to_del = array_diff($current_actors, $data['actors']);
			}
			else
			{
				$act_to_del = $current_actors;
			}

			foreach ($act_to_del as $actor)
			{
				if (! $this->ci->permission_model->delete_actor(array('page_id' => $data['id'], 'user_id' => $actor)))
				{
					$this->ci->session->set_flashdata('error', 'Failed to remove actor while updating content. [011]');
					return false;
				}
			}
		}
		elseif (isset($data['actors']))
		{
			$act_to_add = $data['actors'];
		}
		if (isset($act_to_add))
		{
			foreach ($act_to_add as $actor)
			{
				if (! $this->ci->permission_model->create_actor(array('page_id' => $data['id'], 'user_id' => $actor)))
				{
					$this->ci->session->set_flashdata('error', 'Failed to add actor while updating content. [012]');
					return false;
				}
			}
		}

		// update/delete/add links to other pages
		if ($cur_links = $this->ci->page_model->read_page_links(array('where' => array('page_id' => $data['id']))))
		{
			foreach ($cur_links as $link)
			{
				$current_links[] = $link['link_id'];
			}
			if (isset($data['links']))
			{
				$links_to_add = array_diff($data['links'], $current_links);
				$links_to_del = array_diff($current_links, $data['links']);
			}
			else
			{
				$links_to_del = $current_links;
			}

			foreach ($links_to_del as $link)
			{
				if (! $this->ci->page_model->delete_page_link(array('page_id' => $data['id'], 'link_id' => $link)))
				{
					$this->ci->session->set_flashdata('error', 'Failed to remove link while updating content. [011]');
					return false;
				}
			}
		}
		elseif (isset($data['links']))
		{
			$links_to_add = $data['links'];
		}
		if (isset($links_to_add))
		{
			foreach ($links_to_add as $link)
			{
				if (! $this->ci->page_model->create_page_link(array('page_id' => $data['id'], 'link_id' => $link)))
				{
					$this->ci->session->set_flashdata('error', 'Failed to add link while updating content. [012]');
					return false;
				}
			}
		}
		// end link edits

		return $input['url'];
	}
	public function blank_form()
	{
	    $data['title'] = null;
	    $data['description'] = null;
	    $data['content'] = null;
	    $data['id'] = null;
	    $data['set_authors'] = null;
	    $data['set_actors'] = null;
		$data['set_links'] = null;
		$data['profile_photo'] = null;
		$data['group_id'] = 6;
		$data['visibility'] = 1;


		$data['profile_photo_info'] = array('src' => base_url().'img/blank.png', 'height' => 75, 'id' => 'profile_photo_preview');

	    $users = $this->ci->people_model->read(array('fields' => 'id, lname, fname'));
	    $groups = $this->ci->permission_model->read_groups(array('fields' => 'id, name'));
	    $parents = $this->ci->page_model->read(array('fields' => 'id, title', 'order_by' => array('column' => 'title', 'order' => 'asc')));

	    foreach ($users as $user) {
			$data['users'][$user['id']] = $user['lname'].', '.$user['fname'];
	    }

		foreach ($groups as $group) {
			$data['groups'][$group['id']] = $group['name'];
	    }

		$data['parents'][0] = 'No Parent / Case Study';
	    foreach ($parents as $parent) {
			$data['parents'][$parent['id']] = $parent['title'];
	    }
		$data['links'] = $data['parents'];
		unset($data['links'][0]);

	    return $data;
	}
	public function full_form($id)
	{
	    // fetch the page data
	    if (! $page = ($this->ci->page_model->read(array('fields' => 'id, parent_id, title, content, description, group_id, profile_photo, url, visibility', 'where' => array('id' => $id), 'limit' => 1))))
	    {
	    	return false;
	    }
	    // fetch empty data and list populations
	    $blank_data = $this->blank_form();
	    // merge the two, to create a populated set of data, with list options
	    $data = array_merge($blank_data, $page);

		$photo_data = $this->ci->photo_model->read(array('where' => array('imagename' => $data['profile_photo'], 'height' => 180, 'width' => 180), 'limit' => 1));

		$data['profile_photo_info'] = array('src' => base_url().'uploads/'.$photo_data['filename'].$photo_data['extension'], 'width' => $photo_data['width'], 'height' => $photo_data['height'], 'id' => 'profile_photo_preview');

	    // grab page authors
	    if ($authors = $this->ci->permission_class->authors($data['id']))
	    {
			// add them to the set_authors array
			foreach ($authors as $author_id => $author)
			{
			    $data['set_authors'][] = $author_id;
			}
	    }

	    // grab page actors
	    if ($actors = $this->ci->permission_class->actors($data['id']))
	    {
			// add them to the set_actors array
			foreach ($actors as $actor_id => $actor)
			{
			    $data['set_actors'][] = $actor_id;
			}
	    }

	    // grab page links
	    if ($links = $this->ci->page_model->read_page_links(array('where' => array('page_id' => $data['id']))))
	    {
			// add them to the set_actors array
			foreach ($links as $link)
			{
			    $data['set_links'][] = $link['link_id'];
			}
	    }

	    return $data;
	}
	public function feed($id = '%')
	{
	    $fields = 'id, updated, title, description, content, url, tags, profile_photo';

	    // get content results
	    if (! $results = $this->ci->page_model->read(array('fields' => $fields, 'where' => array('id like' => $id, 'case_study' => 0), 'limit' => 10)))
	    {
	    	die('no page found for the id: ['.$id.']');
	    }
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

			$item['subject'] = $result['description'];
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
	public function view($url)
	{
	    // get content results
	    if (! $result = $this->ci->page_model->read(array('fields' => 'id, title, content, parent_id, tags, profile_photo', 'where' => array('url' => $url), 'limit' => 1)))
	    {
	    	$this->ci->session->set_flashdata('error', 'There is no page with that name. page_class');
	    	redirect('feed/page');
	    	die();
	    }

	    // assign values to return array
	    $return['id'] = $result['id'];
	    $return['title'] = $result['title'];
		$message = $this->ci->tag_class->tags_to_links($result['content']);

	    $return['content'] = Markdown($message['text']);
	    //$return['tags'] = explode('#', trim($result['tags'], '#'));
		$return['tags'] = $message['array'];
	    $return['parent_id'] = $result['parent_id'];

		if ($result['profile_photo'] != '')
		{
			$photo_data = $this->ci->photo_model->read(array('where' => array('imagename' => $result['profile_photo'], 'width' => 180, 'height' => 180), 'limit' => 1));
			$return['profile_photo'] = base_url().'uploads/'.$photo_data['filename'].$photo_data['extension'];
		}
		else
		{
			$return['profile_photo'] = base_url().'img/blank.png';
		}

		if ($this->ci->userdata['group']['name'] == 'admin' || $this->ci->permission_class->is_actor(array('page_id' => $result['id'], 'user_id' => $this->ci->userdata['id'])))
		{
			$return['controls'] = anchor('page/edit/'.$result['id'], img('img/edit_icon_black.png'), array('class' => 'edit')).anchor('page/create/'.$result['id'], img('img/create_icon_black.png'), array('class' => 'create')).anchor('page/delete/'.$result['id'], img('img/delete_icon_black.png'), array('class' => 'delete'));
		}
		else
		{
			$return['controls'] = null;
		}

	    // retrieve authorship info
	    $return['authors'] = $this->ci->permission_class->authors($result['id']);

	    // retrieve actors
	    $return['actors'] = $this->ci->permission_class->actors($result['id']);

		// retrieve page links
		$return['links'] = $this->ci->page_class->links($result['id']);

	    return $return;
	}

	public function links($page_id)
	{
		if ($links = $this->ci->page_model->read_page_links(array('where' => array('page_id' => $page_id))))
		{
			foreach ($links as $link)
			{
				$return[] = anchor('page/view/'.$link['link_url'], $link['link_title']);
			}
			return $return;
		}
		return null;
	}

	private function _menu_r($parent_id, $maxdepth = 0, $curdepth = 0)
	{
		$pages = $this->ci->page_model->read(array('fields' => 'id, title, url, visibility', 'where' => array('parent_id' => $parent_id, 'case_study' => 0), 'order_by' => array('column' => 'title', 'order' => 'asc')));
		foreach ($pages as $page)
		{
			if ($page['visibility'] == 1)
			{
				$class = array('class' => 'visible');
			}
			else
			{
				$class = array('class' => 'invisible');
			}

			if ($this->ci->userdata['group']['name'] == 'admin')
			{
				$controls = '<div class="controls">'.anchor('page/edit/'.$page['id'], img('img/edit_icon_black.png'), array('class' => 'edit')).'</div>';
			}
			else
			{
				$controls = null;
			}

			if ($this->ci->page_model->read(array('fields' => 'id', 'where' => array('parent_id' => $page['id'], 'case_study' => 0))) && $curdepth < $maxdepth)
			{
				$menu[$controls.anchor('page/view/'.$page['url'], $page['title'], $class)] = $this->_menu_r($page['id'], $maxdepth, $curdepth + 1);
			}
			else
			{
				$menu[] = $controls.anchor('page/view/'.$page['url'], $page['title'], $class);
			}
		}
		return $menu;
	}

	public function menu($depth = null, $parent_id = 0)
	{
		if (is_null($depth))
		{
			$depth = 99999;
		}
		// new approach
		$return = $this->_menu_r($parent_id, $depth);
		$return[] = anchor('feed/casestudy', 'Case Studies', array('class' => 'visible'));
	    return ul($return, array('id' => 'page_menu', 'class' => 'leftmenu'));
	}
}
