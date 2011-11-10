<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resource_class
{
	public function __construct() {
		$this->ci =& get_instance();
		$this->ci->load->model(array('resource_model'));
	}
	
	public function type_view()
	{
		if ($result = $this->ci->resource_model->read_type())
		{
			foreach ($result as $row)
			{
				$return[] = array('Edit' => anchor('resource/type_edit/'.$row['id'], 'Edit'), 'Resource Type' => $row['name'], 'Description' => $row['description'], 'Delete' => anchor('resource/type_delete', 'Delete'));
			}
			return $return;
		}
	}
	
	public function menu()
	{
		if ($result = $this->ci->module_model->read())
		{
			foreach ($result as $module)
			{
				$all_modules[anchor('module/index/'.$module['tier_id'], $module['tier_name'])][] = anchor('module/view/'.$module['category_name'].'/'.$module['course_number'], strtoupper($module['category_name']).'/'.$module['course_number'].'&nbsp;'.$module['title']);
			}
			$return[anchor('module', 'Modules')] = $all_modules;
			//print_r($return);
			return ul($return, array('id' => 'module_menu', 'class' => 'leftmenu'));
		}
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
					$person = $this->ci->people_model->selectUsers(array('where' => array('id' => $row['res_id']), 'limit' => '1'));
					$return['people'][$row['type_name']][] = anchor('profile/view/'.url_title($person['lname'].'-'.$person['fname'], 'dash', true), $person['fname'].' '.$person['lname']);
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
					$document = $this->ci->document_model->read(array('fields' => 'title, file_pointer', 'where' => array('id' => $row['res_id']), 'limit' => '1'));
					$return['resources'][$row['type_name']][] = anchor('', $document['title']);
				}
			}
			return $return;
		}
	}
}
