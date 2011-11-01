<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_class
{
	public function __construct() {
		$this->ci =& get_instance();
	}
	public function create($data)
	{
		$this->ci->load->model('user_model');
		
	    $input['group_id'] = $data['group_id'];
	    $input['stage_id'] = $data['stage_id'];
	    $input['sector_id'] = $data['sector_id'];
	    $input['email'] = $data['email'];
		
		if ($data['fb_id'] != '') {
			$input['fb_id'] = $data['fb_id'];
		}
		
	    $input['pc_id'] = $data['pc_id'];
	    $input['site_id'] = $data['site_id'];
	    $input['fname'] = $data['fname'];
	    $input['lname'] = $data['lname'];
	    $input['address'] = $data['address'];
	    $input['phone'] = $data['phone'];
	    $input['blog_address'] = $data['blog_address'];
	    $input['blog_name'] = $data['blog_name'];
	    $input['blog_description'] = $data['blog_description'];
	    $input['project'] = $data['project'];
	    $input['cos'] = $data['cos'];
	    $input['local_name'] = $data['local_name'];
	    $input['created_on'] = time();
		
		if (! $user_id = $this->ci->user_model->create($input))
		{
			$this->ci->session->set_flashdata('error', 'Failed to add record to people table. [005]');
			return false;
		}
		
		return $user_id;
	}
	
	public function upload($data)
	{
		if ($data['file_type'] != 'text/csv') {
			$this->ci->session->set_flashdata('error', 'Your file is not of the text/csv mime type, and is therefore unacceptable.');
			return false;
			die();
		}
		$handle = fopen($data['full_path'], 'r');
		$csv = fgetcsv($handle, 0, ',', '"');
		
		if (! array_search('pc_id', $csv) && ! array_search('id', $csv) && count(array_intersect(array('fname', 'lname'), $csv)) != 2)
		{
			$this->ci->session->set_flashdata('error', 'You are missing both an ID, PC_ID, and all neccessary fields for creating a new entry. This means that this app has no idea what to do, and is therefore aborting. You must be either a) updating an existing entry by ID, b) updating an existing entry by PC_ID, or c) creating a new entry. If the latter, the following fields are required to be present and populated: fname, lname.');
			return false;
			die;
		}
		$keys = array_flip($csv);
		
		while(($row = fgetcsv($handle, 0, ',', '"')) != false)
		{
			// trim crap off the end of all fields
			foreach ($csv as $key => $value)
			{
				$prep[$value] = trim($row[$key], "(),'\t\n\r\0\x0B -_=/\\][");
				if ($prep[$value] == '')
				{
					unset($prep[$value]);
				}
			}
			// if this user is a volunteer
			if (array_key_exists('is_volunteer', $prep) && $prep['is_volunteer'] == 1)
			{
				// if their cos date is set
				if (array_key_exists('cos', $prep))
				{
					$prep['cos'] = strtotime($prep['cos']);
				}
				// if their site is set by name
				if (array_key_exists('site', $prep))
				{
					// set a blank set of site data to use in lieu of anything they might be missing
					$default_site = array('name' => null, 'parent_id' => 0, 'lat' => null, 'lng' => null);
					
					// if the site already exists, based on a search by name
					if ($site = $this->ci->site_model->read(array('fields' => 'id, parent_id', 'where' => array('name like' => $prep['site']), 'limit' => 1)))
					{
						$prep['site_id'] = $site['id'];
						
						// if the site has no parent, and the region is set in csv
						if ($site['parent_id'] == 0 && array_key_exists('region', $prep))
						{
							// if there is no region of that name
							if (! $region = $this->ci->region_model->read(array('fields' => 'id', 'where' => array('name like' => $prep['region']), 'limit' => 1)))
							{
								// create a new region
								$region['id'] = $this->ci->region_model->create(array('name' => ucfirst(strtolower($prep['region']))));
							}
							
							// set the site parent to the new region_id
							if (! $this->ci->site_model->update(array('id' => $prep['site_id'], 'parent_id' => $region['id'])))
							{
								die('could not add region to existing site.');
							}
						}
					}
					// if the site does not exist, and there's a region set, confirm/create the region then the site
					elseif (array_key_exists('region', $prep))
					{
						// if there is no region of that name
						if (! $region = $this->ci->region_model->read(array('fields' => 'id', 'where' => array('name like' => $prep['region']), 'limit' => 1)))
						{
							// create a new region
							if (! $region['id'] = $this->ci->region_model->create(array('name' => ucfirst(strtolower($prep['region'])))))
							{
								die('could not create new region of name '.$prep['region']);
							}
						}
						
						// create the site, including the region in the definition
						if (! $site['id'] = $this->ci->site_model->create(array_merge($default_site, array('name' => $prep['site'], 'parent_id' => $region['id']))))
						{
							die('could not create new site with a parent_id of '.$region['id']);
						}
						
						$prep['site_id'] = $site['id'];
						$prep['region_id'] = $region['id'];
					}
					// if the site does not exist, and there is no region set, create it
					elseif ($site = $this->ci->site_model->create(array_merge($default_site, array('name' => $prep['site']))))
					{
						$prep['site_id'] = $site['id'];
					}
					else
					{
						die('serious problem: could not find or create site.');
					}
					unset($prep['site']);
				}
				if (array_key_exists('sector', $prep))
				{
					$default_sector = array('name' => $prep['sector'], 'short' => word_limiter($prep['sector'], 1));
					if (strlen($prep['sector']) < 6)
					{
						$field = 'short';
					}
					else
					{
						$field = 'name';
					}
					if ($sector_id = $this->ci->sector_model->read(array('fields' => 'id', 'where' => array($field.' like' => $prep['sector']), 'limit' => 1)))
					{
						$prep['sector_id'] = $sector_id['id'];
					}
					elseif ($site_id = $this->ci->sector_model->create(array_merge($default_sector, array($field => $prep['sector']))))
					{
						$prep['sector_id'] = $sector_id['id'];
					}
					else
					{
						die('serious problem: could not find or create sector.');
					}
					unset($prep['sector']);
				}
			}
			elseif (array_key_exists('is_staff', $prep))
			{
				
			}
			$output[] = $prep;
		}
		
		echo '<pre>'; print_r($output); echo '</pre>';
		
		fclose($handle);
	}
	
	public function edit($data)
	{
		$this->ci->load->model('user_model');
		
		$input['id'] = $data['id'];
	    $input['group_id'] = $data['group_id'];
	    $input['stage_id'] = $data['stage_id'];
	    $input['sector_id'] = $data['sector_id'];
	    $input['email'] = $data['email'];
		
		if ($data['fb_id'] != '') {
			$input['fb_id'] = $data['fb_id'];
		}
		
	    $input['pc_id'] = $data['pc_id'];
	    $input['site_id'] = $data['site_id'];
	    $input['fname'] = $data['fname'];
	    $input['lname'] = $data['lname'];
	    $input['address'] = $data['address'];
	    $input['phone'] = $data['phone'];
	    $input['blog_address'] = $data['blog_address'];
	    $input['blog_name'] = $data['blog_name'];
	    $input['blog_description'] = $data['blog_description'];
	    $input['project'] = $data['project'];
	    $input['cos'] = $data['cos'];
	    $input['local_name'] = $data['local_name'];
		
		// update the page entry, or die
		if (! $this->ci->user_model->update($input)) {
			die('Failed to update content table. Check your data and try again. [002]');
		}
		
		return $input['id'];
	}
	public function blank_form()
	{
		$this->ci->load->model(array('permission_model', 'people_model', 'site_model'));
		
	    $data['fb_id'] = null;
	    $data['pc_id'] = null;
	    $data['fname'] = null;
	    $data['lname'] = null;
	    $data['project'] = null;
	    $data['email'] = null;
		$data['phone'] = null;
		$data['address'] = null;
		$data['cos'] = null;
		$data['local_name'] = null;
		$data['blog_name'] = null;
		$data['blog_description'] = null;
		$data['blog_address'] = null;
		$data['stage_id'] = null;
		$data['sector_id'] = null;
		$data['site_id'] = null;
		$data['group_id'] = null;
		$data['id'] = null;
	    
	    $groups = $this->ci->permission_model->read_groups(array('fields' => 'id, name'));
	    $stages = $this->ci->people_model->read_stages(array('fields' => 'id, name'));
	    $sectors = $this->ci->people_model->read_sectors(array('fields' => 'id, name'));
	    $sites = $this->ci->site_model->read_sites(array('fields' => 'id, name'));
	    
	    foreach ($stages as $stage) {
			$data['stages'][$stage['id']] = $stage['name'];
	    }
	    
		foreach ($groups as $group) {
			$data['groups'][$group['id']] = $group['name'];
	    }
		foreach ($sectors as $sector) {
			$data['sectors'][$sector['id']] = $sector['name'];
	    }
		$data['sites']['NULL'] = 'Unknown';
	    foreach ($sites as $site) {
			$data['sites'][$site['id']] = $site['name'];
	    }
	    
	    return $data;
	}
	public function full_form($id)
	{
	    // fetch the user data
	    $page = $this->ci->people_model->read(array('where' => array('id' => $id), 'limit' => 1));
		
	    // fetch empty dataset
	    $blank_data = $this->blank_form();
		
	    // merge the two, to create a populated set of data, with list options
	    $data = array_merge($blank_data, $page);
	    
	    return $data;
	}
}
