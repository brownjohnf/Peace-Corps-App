<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_class
{
	public function __construct() {
		$this->ci =& get_instance();
		$this->ci->load->model(array('page_model', 'tag_model'));
		$this->ci->load->library(array('permission_class', 'common_class'));
	}
	public function create($data)
	{
		$input['title'] = $data['title'];
	    $input['url'] = url_title($data['title'], 'dash', true);
	    $input['group_id'] = $data['group_id'];
	    $input['parent_id'] = $data['parent_id'];
	    $input['description'] = $data['description'];
	    $input['content'] = $data['content'];
	    $input['profile_photo'] = $data['profile_photo'];
		
		
	    $input['updated'] = time();
	    $input['created'] = time();
		
		if (! $page_id = $this->ci->page_model->create($input))
		{
			$this->ci->session->set_flashdata('error', 'Failed to add record to content table. [005]');
			return false;
		}
		
		if ($tags = $this->ci->common_class->parse_tags($data['content']))
		{
			$input['tags'] = $tags['string'];
			// set data to be sent to the tag function
			$tag_input = array('source' => 'page', 'source_id' => $page_id, 'to_add' => $tags['array']);
			
			$this->ci->load->library('tag_class');
			//print_r($tag_input);
			// add the tags to the tag table
			if (! $this->ci->tag_class->tag($tag_input)) {
				die('tag_class->tag returned false.');
			}
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
		
		
		return $input['url'];
	}
	
	public function edit($data)
	{
		$input['id'] = $data['id'];
		$input['title'] = $data['title'];
		$input['url'] = url_title($data['title'], 'dash', true);
		$input['group_id'] = $data['group_id'];
		$input['parent_id'] = $data['parent_id'];
		$input['description'] = $data['description'];
		$input['content'] = $data['content'];
		$input['profile_photo'] = $data['profile_photo'];
		
		if ($tags = $this->ci->common_class->parse_tags($data['content']))
		{
			$input['tags'] = $tags['string'];
			// set data to be sent to the tag function
			$tag_input = array('source' => 'page', 'source_id' => $data['id'], 'to_add' => $tags['array']);
			
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
		if ($data['updated'] == 'yes') {
			$input['updated'] = time();
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
		$data['profile_photo'] = null;
		$data['group_id'] = null;
		
		
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
		
		$data['parents'][0] = 'No Parent';
	    foreach ($parents as $parent) {
			$data['parents'][$parent['id']] = $parent['title'];
	    }
	    
	    return $data;
	}
	public function full_form($id)
	{
		$this->ci->load->model('photo_model');
		
	    // fetch the page data
	    $page = $this->ci->page_model->read(array('fields' => 'id, parent_id, title, content, description, group_id, profile_photo, url', 'where' => array('id' => $id), 'limit' => 1));
	    // fetch empty data and list populations
	    $blank_data = $this->blank_form();
	    // merge the two, to create a populated set of data, with list options
	    $data = array_merge($blank_data, $page);
			
		$photo_data = $this->ci->photo_model->read(array('where' => array('imagename' => $data['profile_photo'], 'height' => 75, 'width' => 75), 'limit' => 1));
			
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
	    
	    return $data;
	}
	public function feed($id = '%')
	{
	    $this->ci->load->library('common_class');
		$this->ci->load->model('photo_model');
	    $this->ci->load->helper('text');
	    $fields = 'id, updated, title, description, content, url, tags, profile_photo';
	    
	    // get content results
	    $results = $this->ci->page_model->read(array('fields' => $fields, 'where' => array('id like' => $id)));
	    foreach ($results as $result)
	    {
			if (str_word_count($result['content']) > 50)
			{
				$message = $this->ci->common_class->tags_to_links(word_limiter(strip_tags($result['content']), 50));
			    $item['message'] = $message['text'];
			    $item['message_truncated'] = 'yes';
			}
			else
			{
				$message = $this->ci->common_class->tags_to_links(strip_tags($result['content']));
			    $item['message'] = $message['text'];
			    $item['message_truncated'] = 'no';
			}
			
			$item['subject'] = $result['description'];
			$item['edit_path'] = 'page/edit/'.$result['id'];
			$item['delete_path'] = 'page/delete/'.$result['id'];
			
			
			if ($result['profile_photo'] != '')
			{
				$photo_data = $this->ci->photo_model->read(array('where' => array('imagename' => $result['profile_photo'], 'width' => 180, 'height' => 180), 'limit' => 1));
				$item['profile_photo'] = base_url().'uploads/'.$photo_data['filename'].$photo_data['extension'];
			}
			else
			{
				$item['profile_photo'] = base_url().'img/blank.png';
			}
			
			
			$item['full_url'] = 'page/view/'.$result['url'];
			$item['author'] = $result['title'];
			$item['tags'] = explode('#', trim($result['tags'], '#'));
			//print_r($item['tags']);
			$item['elapsed'] = $this->ci->common_class->elapsed_time($result['updated']).' ago';
			if ($this->ci->userdata['group']['name'] == 'Admin' || $this->ci->permission_class->is_actor(array('page_id' => $result['id'], 'user_id' => $this->ci->userdata['id'])))
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
	    $this->ci->load->library('permission_class');
		$this->ci->load->model('photo_model');
	    $fields = 'id, title, content, parent_id, tags, profile_photo';
	    
	    $query = array('fields' => $fields, 'where' => array('url' => $url), 'limit' => 1);
	    // get content results
	    $result = $this->ci->page_model->read($query);
	    
	    // assign values to return array
	    $return['id'] = $result['id'];
	    $return['title'] = $result['title'];
		$message = $this->ci->common_class->tags_to_links($result['content']);
	    $return['content'] = $message['text'];
	    $return['tags'] =  explode('#', trim($result['tags'], '#'));
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
		
		if ($this->ci->userdata['group']['name'] == 'Admin' || $this->ci->permission_class->is_actor(array('page_id' => $result['id'], 'user_id' => $this->ci->userdata['id'])))
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
		
	    return $return;
	}
	
}