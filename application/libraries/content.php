<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content
{
	public function __construct() {
		
		$this->ci =& get_instance();
		
		$this->ci->load->model('content_model');
		
	}
	
	public function loadContent()
	{
		$input = $this->nameURI(array_values($this->ci->uri->segment_array()), true);
		$content = $this->ci->content_model->findContent($input);
		$path = implode('/', array_filter($input));
		if ($content['count'] == 1)
		{
			$output = $content[0];
			if ($editors = $this->ci->content->pageEditors($output['id']))
			{
				foreach ($editors as $editor)
				{
					$tag = $editor['name'];
					if ($this->ci->auth->is_admin())
					{
						$tag .= anchor('admin/page/delete_editor/'.$output['id'].'/'.$editor['id'], '<-Remove');
					}
					$output['editbox']['editors'][] = $tag;
				}
			}
			else
			{
				$output['editbox']['editors'][] = 'No editors.';
			}
			$output['editbox']['options'][] = anchor('admin/page/update/'.$output['id'], 'Edit Page');
			if ($this->ci->auth->is_admin())
			{
				$output['editbox']['options'][] = anchor('admin/page/delete/'.$output['id'], 'Delete Page');
				$output['editbox']['options'][] = anchor('admin/page/add_editor/'.$output['id'], 'Add Editor');
			}
		}
		elseif ($content['count'] > 1)
		{
			$output['id'] = null;
			$output['title'] = 'Multiple Hits';
			$output['content'] = '<p>Multiple content pages were found for '.$path.'. Please provide only one set of content, or take otherwise appropriate steps to correct the problem.</p>';
			$output['editbox']['error'] = 'Multiple listings.';
		}
		else
		{
			$output['id'] = null;
			$output['title'] = 'No Database Content';
			$output['content'] = '<p>No database content was found for '.$path.'. Please edit the page, or take appropriate steps to correct the problem.</p>';
			$output['editbox']['editors'][] = 'No editors. No existing page.';
			if ($this->ci->auth->is_admin())
			{
				$output['editbox']['options'][] = anchor('admin/page/create/'.$path, 'Create Page');
			}
		}
		$output['path'] = $path;
		return $output;
	}
	
	// returns an array of the path segments, either padded with NULLs for queries, or only the present elements.
	public function nameURI($segments, $padding = false)
	{
		$sections = array('domain', 'controller', 'function', 'page', 'aux0');
		// false for just the specified path
		if ($padding == false)
		{
			foreach ($segments as $key => $value)
			{
				$output[$sections[$key]] = $value;
			}
		}
		// true for a padded, database matched list
		elseif ($padding == true)
		{
			foreach ($sections as $key => $value)
			{
				if (array_key_exists($key, $segments))
				{
					$output[$value] = $segments[$key];
				}
				else
				{
					$output[$value] = null;
				}
			}
		}
		return $output;
	}
	
	function pageEditors($page_id)
	{
		$output = $this->ci->content_model->getEditors($page_id);
		return $output;
	}
	
	public function addPage($data)
	{
		$this->ci->content_model->addContent($data);
	}
	
	public function deletePage($id)
	{
		
		$this->ci->content_model->deleteContent($id);
		$this->ci->content_model->deleteContentEditors($id);
	}
}
