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
	    $input['email1'] = $data['email1'];

		if ($data['fb_id'] != '') {
			$input['fb_id'] = $data['fb_id'];
		}

	    $input['pc_id'] = $data['pc_id'];
	    $input['site_id'] = $data['site_id'];
	    $input['fname'] = $data['fname'];
	    $input['lname'] = $data['lname'];
	    $input['address'] = $data['address'];
	    $input['phone1'] = $data['phone1'];
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
			$this->ci->session->set_flashdata('error', 'Your file is not of the text/csv mime type, and is therefore unacceptable. '.$this->ci->upload->data());
			return false;
			die();
		}
		$handle = fopen($data['full_path'], 'r');
		$csv = fgetcsv($handle, 0, ',', '"');

		if (false)//! $found = array_search('pc_id', $csv))// && ! array_search('id', $csv) && count(array_intersect(array('fname', 'lname'), $csv)) != 2)
		{
			$this->ci->session->set_flashdata('error', "You are missing both a PC_ID, and all neccessary fields for creating a new entry. This means that this app has no idea what to do, and is therefore aborting. You must be either a) updating an existing entry by ID, b) updating an existing entry by PC_ID, or c) creating a new entry. If the latter, the following fields are required to be present and populated: fname, lname. Currently, there are the following fields in your file: '".implode("', '", $csv)."'");
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
			if (array_key_exists('is_user', $prep) && $prep['is_user'] == 1)
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
								if (! $region['id'] = $this->ci->region_model->create(array('name' => ucfirst(strtolower($prep['region'])))))
								{
									die('could not create a region for an existing site');
								}
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
					if (array_key_exists('region', $prep))
					{
						unset($prep['region']);
					}
				}

				// if their sector is set, either by full or abbreviated name
				if (array_key_exists('sector', $prep))
				{
					// set default data for new sector
					$default_sector = array('name' => $prep['sector'], 'short' => word_limiter($prep['sector'], 1));

					// set whether or not we're dealing with abbreviations or full names
					if (strlen($prep['sector']) < 6)
					{
						$field = 'short';
					}
					else
					{
						$field = 'name';
					}

					// try to look up the sector, if the sector doesn't exist
					if (! $sector = $this->ci->sector_model->read(array('fields' => 'id', 'where' => array($field.' like' => $prep['sector']), 'limit' => 1)))
					{
						// create new sector from default data
						if ($sector['id'] = $this->ci->sector_model->create(array_merge($default_sector, array($field => $prep['sector']))))
						{
							die('could not create new sector.');
						}
					}
					$prep['sector_id'] = $sector['id'];
					unset($prep['sector']);
				}

				// if their stage is set in any way
				if (array_key_exists('stage', $prep))
				{
					$default_stage = array('name' => $prep['stage']);

					// if there is no stage for this name
					if (! $stage = $this->ci->stage_model->read(array('fields' => 'id', 'where' => array('name like' => $prep['stage']), 'limit' => 1)))
					{
						// create a new stage
						if (! $stage['id'] = $this->ci->stage_model->create($default_stage))
						{
							die('could not create a new stage.');
						}
					}
					$prep['stage_id'] = $stage['id'];
					unset($prep['stage']);
				}

				// get the volunteer group_id from the database
				if (! $group = $this->ci->group_model->read(array('where' => array('name' => 'user'), 'limit' => 1)))
				{
					die('could not read groups for volunteer');
				}
				$prep['group_id'] = $group['id'];

				// insert the volunteer-specific data into the volunteers table
				/* determine whether to use the actual id, or the pc_id to check for extant data
				if (array_key_exists('id', $prep))
				{
					$id_col = 'user_id';
					$id_to_use = $prep['id'];
					$prep['user_id'] = $prep['id'];
				}
				elseif (array_key_exists('pc_id', $prep))
				{
					$id_col = 'pc_id';
					$id_to_use = $prep['pc_id'];
				}
				else
				{
					die('there is neither an id or pc_id column present for inserting the volunteer. FAIL.');
				}*/

				// set default volunteer input data
				$input = array_intersect_key($prep, array_flip(array('user_id', 'pc_id', 'focus', 'stage_id', 'cos', 'local_name', 'site_id', 'sector_id')));
				//print_r($input);

				// if there is an extant entry
				if ($vol = $this->ci->volunteer_model->read(array('fields' => 'id, user_id', 'where' => array('pc_id' => $prep['pc_id']), 'limit' => 1)))
				{
					if (count($input > 1))
					{
						if (! $this->ci->volunteer_model->update($input, 'pc_id'))
						{
							die('failed to update volunteer entry');
						}
					}
					if ($vol['user_id'] > 0)
					{
						$prep['id'] = $vol['user_id'];
					}
					else
					{
						$prep['vol_id'] = $vol['id'];
					}
				}
				// if no current entries exist, create a new one
				elseif (! $prep['vol_id'] = $this->ci->volunteer_model->create($input))
				{
					die('something went very wrong, and locating or creating volunteer entries failed. '.$this->ci->db->last_query());
				}
			}

			// if the person is a staff member
			if (array_key_exists('is_staff', $prep))
			{

			}

			// insert the person into the people table

			// clean the phone/email fields
			foreach (array('phone1', 'phone2') as $key)
			{
				if (array_key_exists($key, $prep))
				{
					$prep[$key] = str_replace(array(' ', '-', '.', '(', ')'), '', $prep[$key]);
				}
			}

			// set default values
			$input = array_intersect_key($prep, array_flip(array('fb_id', 'group_id', 'fname', 'lname', 'email1', 'email2', 'phone1', 'phone2', 'address', 'blog_address', 'blog_description', 'blog_name', 'is_user')));
			//print_r($input);

			// if an id is set, and therefore we assume they already exist
			if ((array_key_exists('id', $prep) && $user = $this->ci->people_model->read(array('fields' => 'id', 'where' => array('id' => $prep['id']), 'limit' => 1))))
			{
				$input['id'] = $user['id'];
				if (! $this->ci->people_model->update($input))
				{
					die('failed to update volunteer entry');
				}
			}
			elseif ($user['id'] = $this->ci->people_model->create($input))
			{
				if (! $this->ci->volunteer_model->update(array('user_id' => $user['id'], 'id' => $prep['vol_id'])))
				{
					die('failed to add user_id to previously created volunteer profile');
				}
			}
			else
			{
				die('failed to find or create a new volunteer entry');
			}


			$output[] = $prep;
			unset($prep);
		}

		//echo '<pre>'; print_r($output); echo '</pre>';

		fclose($handle);
		return true;
	}

	public function edit($data)
	{
		$this->ci->load->model(array('user_model', 'volunteer_model', 'people_model'));

		$input['id'] = $data['id'];
		$input['fb_id'] = $data['fb_id'];
	    $input['group_id'] = $data['group_id'];
	    $input['fname'] = $data['fname'];
	    $input['lname'] = $data['lname'];
	    $input['gender'] = $data['gender'];
	    $input['project'] = $data['project'];
	    $input['email1'] = $data['email1'];
	    $input['email2'] = $data['email2'];
	    $input['phone1'] = $data['phone1'];
	    $input['phone2'] = $data['phone2'];
	    $input['address'] = $data['address'];
	    $input['blog_address'] = $data['blog_address'];
	    $input['blog_name'] = $data['blog_name'];
	    $input['blog_description'] = $data['blog_description'];

		// clean out any empty values
	    foreach ($input as $key => $value)
	    {
	    	if ($value == '')
	    	{
	    		unset($input[$key]);
	    	}
	    }

	    foreach (array('is_user', 'is_admin', 'is_moderator') as $is)
	    {
	    	$input[$is] = (array_key_exists($is, $data) ? 1 : 0);
	    }

		// update the people entry, or die
		if (! $this->ci->people_model->update($input)) {
			die('Failed to update people table. Check your data and try again. [002]');
		}

	    unset($input);

	    $input['user_id'] = $data['id'];
	    $input['focus'] = $data['focus'];
	    $input['stage_id'] = $data['stage_id'];
	    $input['cos'] = $data['cos'];
	    $input['local_name'] = $data['local_name'];
	    $input['site_id'] = $data['site_id'];
	    $input['sector_id'] = $data['sector_id'];

		// clean out any empty values
	    foreach ($input as $key => $value)
	    {
	    	if ($value == '')
	    	{
	    		unset($input[$key]);
	    	}
	    }

		// update the volunteers entry, or die
		if (! $success = $this->ci->volunteer_model->update($input, 'user_id')) {
			die('Failed to update volunteers table. Check your data and try again. [002]');
		}

		return $data['id'];
	}
	public function blank_form()
	{
		$this->ci->load->model(array(
									 'permission_model',
									 'people_model',
									 'site_model',
									 'sector_model',
									 'stage_model',
									 'group_model'
									 ));

		$data['id'] = null;
	    $data['fb_id'] = null;
		$data['group_id'] = null;
	    $data['fname'] = null;
	    $data['lname'] = null;
	    $data['gender'] = null;
	    $data['project'] = null;
	    $data['email1'] = null;
	    $data['email2'] = null;
		$data['phone1'] = null;
	    $data['phone2'] = null;
		$data['address'] = null;
		$data['blog_address'] = null;
		$data['blog_name'] = null;
		$data['blog_description'] = null;
	    $data['is_user'] = null;
	    $data['is_admin'] = null;
	    $data['is_moderator'] = null;


	    $data['pc_id'] = null;
	    $data['focus'] = null;
		$data['stage_id'] = null;
		$data['cos'] = null;
		$data['local_name'] = null;
		$data['site_id'] = null;
		$data['sector_id'] = null;

	    $groups = $this->ci->group_model->read(array('fields' => 'id, name'));
	    $stages = $this->ci->stage_model->read(array('fields' => 'id, name'));
	    $sectors = $this->ci->sector_model->read(array('fields' => 'id, name'));
	    $sites = $this->ci->site_model->read(array('fields' => 'id, name'));

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
	    $page = $this->ci->people_model->selectUsers(array('where' => array('people.id' => $id), 'limit' => 1));

	    // fetch empty dataset
	    $blank_data = $this->blank_form();

	    // merge the two, to create a populated set of data, with list options
	    $data = array_merge($blank_data, $page);

	    foreach (array('is_user', 'is_admin', 'is_moderator') as $key)
	    {
	    	if ($data[$key] == 1)
	    	{
	    		$data[$key] = true;
	    	}
	    }

	    //print_r($data);
	    return $data;
	}
}
