<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module_class
{
	public function __construct() {
		$this->ci =& get_instance();
		$this->ci->load->model(array('module_model', 'tag_model'));
		$this->ci->load->library(array('permission_class', 'common_class'));
		$this->ci->load->helper('markdown');
	}

	public function show()
	{
		if ($result = $this->ci->module_model->read())
		{
			foreach ($result as $module)
			{
				$return[$module['tier_name']][$module['category_name']][$module['course_number']] = $module;
			}
			//print_r($return);
			return $return;
		}
	}

	public function menu()
	{
		if ($result = $this->ci->module_model->read())
		{
			foreach ($result as $module)
			{
				$all_modules[anchor('module/index/'.$module['tier_id'], $module['tier_name'])][] = anchor('module/view/'.$module['category_name'].'/'.$module['course_number'], strtoupper($module['category_name']).'-'.$module['course_number'].'&nbsp;'.$module['title']);
			}
			$return[anchor('module', 'Modules')] = $all_modules;
			//print_r($return);
			return ul($return, array('id' => 'module_menu', 'class' => 'leftmenu'));
		}
	}

	public function create($data)
	{
	}

	public function edit($data)
	{
	}

	public function blank_form()
	{
	}

	public function full_form($id)
	{
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
				$photo_data = $this->ci->photo_model->read(array('where' => array('imagename' => $result['profile_photo'], 'width' => 180, 'height' => 180), 'limit' => 1));
				$item['profile_photo'] = base_url().'uploads/'.$photo_data['filename'].$photo_data['extension'];
			}
			else
			{
				$item['profile_photo'] = base_url().'img/blank.png';
			}


			$item['full_url'] = 'page/view/'.$result['url'];
			$item['author'] = $result['title'];

			if ($tags = $this->ci->tag_model->read(array('fields' => 'tag', 'where' => array('source' => 'module', 'source_id' => $result['id']))))
			{
				foreach ($tags as $tag)
				{
					$item['tags'][] = $tag['tag'];
				}
			}
			else
			{
				$tags = null;
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

	public function view($data)
	{
		/* convert the category name to id
		if (! $cat_id = $this->ci->module_model->read_categories(array('fields' => 'id', 'where' => array('name like' => $data['category']), 'limit' => '1')))
		{
			return false;
		}*/

		// pull module
		if (! $result = $this->ci->module_model->read(array('where' => array('mod_categories.name' => $data['category'], 'modules.course_number' => $data['number']), 'limit' => '1')))
		{
			return false;
		}

	    // assign values to return array
	    $return['id'] = $result['id'];
	    $return['title'] = $result['title'];
		$lesson_plan = $this->ci->tag_class->tags_to_links($result['lesson_plan']);
	    $return['lesson_plan'] = Markdown($lesson_plan['string']);

		/*
		if ($result['profile_photo'] != '')
		{
			$photo_data = $this->ci->photo_model->read(array('where' => array('imagename' => $result['profile_photo'], 'width' => 180, 'height' => 180), 'limit' => 1));
			$return['profile_photo'] = base_url().'uploads/'.$photo_data['filename'].$photo_data['extension'];
		}
		else
		{
			$return['profile_photo'] = base_url().'img/blank.png';
		}
		*/

		if ($this->ci->userdata['is_admin'] || $this->ci->permission_class->is_actor(array('page_id' => $result['id'], 'user_id' => $this->ci->userdata['id'])))
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

	public function resource_by_module($mod_id)
	{
		$this->ci->load->model(array('module_model', 'people_model', 'page_model', 'link_model', 'video_model', 'document_model'));
		if ($result = $this->ci->module_model->read_resources(array('where' => array('mod_id' => $mod_id))))
		{
			foreach ($result as $row)
			{
				$tables[$row['table']][] = $row;
			}
			if (array_key_exists('people', $tables))
			{
				foreach ($tables['people'] as $row)
				{
					$person = $this->ci->people_model->selectUsers(array('where' => array('people.id' => $row['res_id']), 'limit' => '1'));
					$return['people'][$row['type_name']][] = anchor('profile/view/'.url_title($person['lname'].'-'.$person['fname'], 'underscore', true), $person['fname'].' '.$person['lname']);
				}
			}
			if (array_key_exists('pages', $tables))
			{
				foreach ($tables['pages'] as $row)
				{
					$page = $this->ci->page_model->read(array('fields' => 'url, title', 'where' => array('id' => $row['res_id']), 'limit' => '1'));
					$return['resources'][$row['type_name']][] = anchor('page/view/'.$page['url'], $page['title']);
				}
			}
			if (array_key_exists('links', $tables))
			{
				foreach ($tables['links'] as $row)
				{
					$link = $this->ci->link_model->read(array('fields' => 'url, title', 'where' => array('id' => $row['res_id']), 'limit' => '1'));
					$return['resources'][$row['type_name']][] = anchor($link['url'], $link['title']);
				}
			}
			if (array_key_exists('videos', $tables))
			{
				foreach ($tables['videos'] as $row)
				{
					$video = $this->ci->video_model->read(array('fields' => 'title, link', 'where' => array('id' => $row['res_id']), 'limit' => '1'));
					$return['resources'][$row['type_name']][] = anchor($video['link'].'?rel=0&wmode=Opaque', $video['title']);
				}
			}
			if (array_key_exists('documents', $tables))
			{
				foreach ($tables['documents'] as $row)
				{
					if ($document = $this->ci->document_model->read(array('fields' => 'title, name', 'where' => array('id' => $row['res_id']), 'limit' => '1')))
					{
						$return['resources'][$row['type_name']][] = anchor($document['name'], $document['title']);
					}
					else
					{
						$errors[] = 'A document ['.$row['res_id'].'] was missing.';
					}
				}
			}
			if (isset($errors))
			{
				$this->ci->session->set_flashdata('error', implode('<br>', $errors));
			}
			return $return;
		}
	}
}
