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
	    	$query = array('where' => array('lname like' => urldecode($names_array[0]), 'fname like' => urldecode($names_array[1])), 'limit' => 1);
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

}
