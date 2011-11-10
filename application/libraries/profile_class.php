<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_class
{
	public function __construct() {
		$this->ci =& get_instance();
		$this->ci->load->model('people_model');
	}

	public function view($url)
	{
		if (is_numeric($url))
		{
			$query = array('where' => array('people.id' => $url), 'limit' => 1);
		}
		elseif ($url != '')
		{
			$names = $this->ci->uri->segment(3);
			$names_array = explode('-', trim($names));
	    	$query = array('where' => array('lname like' => urldecode($names_array[0]), 'fname like' => '%'.urldecode($names_array[1]).'%'), 'limit' => 1);
	    }
	    else
	    {
	    	return false;
	    	die();
	    }

	    // get profile info
	    if (! $result = $this->ci->people_model->selectUsers($query)) {
			return false;
			die();
		}
	    //print_r($result);

	    // assign values to return array
	    $return['fname'] = $result['fname'];
		$return['full_name'] = $result['fname'].'&nbsp;'.$result['lname'];
		$return['url_name'] = url_title($result['lname'].'-'.$result['fname'], 'dash', true);
		$return['group'] = $result['group_label'];
		$return['project'] = $result['project'];
		$return['focus'] = $result['focus'];
		$return['email1'] = $result['email1'];
		$return['phone1'] = $result['phone1'];
		$return['email2'] = $result['email2'];
		$return['phone2'] = $result['phone2'];
		$return['stage_name'] = $result['stage_name'];
		$return['sector_name'] = $result['sector_name'];
		$return['local_name'] = $result['local_name'];
		$return['site_name'] = $result['site_name'];
		$return['region_name'] = $result['region_name'];
		$return['blog_name'] = $result['blog_name'];
		$return['blog_address'] = prep_url($result['blog_address']);
		$return['blog_description'] = $result['blog_description'];
		$return['id'] = $result['id'];
		$return['cos'] = date('d M Y', $result['cos']);

		if (isset($result['fb_id']) && is_numeric($result['fb_id'])) {
			$return['social'][] = anchor('http://facebook.com/profile.php?id='.$result['fb_id'], 'Facebook', array('target' => '_blank'));
			$return['profile_photo'] = 'http://graph.facebook.com/'.$result['fb_id'].'/picture?type=large';
		} elseif (isset($result['fb_id']) && is_string($result['fb_id'])) {
			$return['social'][] = anchor('http://facebook.com/'.$result['fb_id'], 'Facebook', array('target' => '_blank'));
			$return['profile_photo'] = 'http://graph.facebook.com/'.$result['fb_id'].'/picture?type=large';
		} else {
			$return['profile_photo'] = base_url().'img/blank.png';
		}

	    return $return;
	}

	public function edit($data)
	{
		$this->ci->load->model(array('volunteer_model', 'people_model'));

		$input['id'] = $data['id'];
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
	    		$input[$key] = null;
	    	}
	    }

		// update the people entry, or die
		if (! $this->ci->people_model->update($input)) {
			die('Failed to update people table. Check your data and try again. [002]');
		}

	    unset($input);

	    $input['focus'] = $data['focus'];
	    $input['local_name'] = $data['local_name'];
	    $input['user_id'] = $data['id'];

		// clean out any empty values
	    foreach ($input as $key => $value)
	    {
	    	if ($value == '')
	    	{
	    		$input[$key] = null;
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
		$data['id'] = null;
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

	    $data['focus'] = null;
		$data['local_name'] = null;

	    return $data;
	}
	
	public function full_form($id)
	{
	    // fetch the user data
	    $page = $this->ci->people_model->selectUsers(array('fields' => 'people.id, people.fname, people.lname, people.gender, people.project, people.email1, people.email2, people.phone1, people.phone2, people.address, people.blog_address, people.blog_name, people.blog_description, volunteers.focus, volunteers.local_name', 'where' => array('people.id' => $id), 'limit' => 1));

	    // fetch empty dataset
	    $blank_data = $this->blank_form();

	    // merge the two, to create a populated set of data, with list options
	    $data = array_merge($blank_data, $page);

	    //print_r($data);
	    return $data;
	}
}
