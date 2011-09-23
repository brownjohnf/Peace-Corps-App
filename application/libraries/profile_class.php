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
		$names = $this->ci->uri->segment(3);
		$names_array = explode('-', trim($names));
	    $query = array('where' => array('people.lname like' => urldecode($names_array[0]), 'people.fname like' => urldecode($names_array[1])), 'limit' => 1, 'offset' => 0);
		
	    // get profile info
	    if (! $result = $this->ci->people_model->selectUsers($query)) {
			return false;
			die();
		}
	    //print_r($result);
		
	    // assign values to return array
		$return['full_name'] = $result['fname'].'&nbsp;'.$result['lname'];
		$return['group'] = $result['group_name'];
		$return['project'] = $result['project'];
		$return['email'] = $result['email'];
		$return['phone'] = $result['phone'];
		$return['stage_name'] = $result['stage_name'];
		$return['sector_name'] = $result['sector_name'];
		$return['local_name'] = $result['local_name'];
		$return['site_name'] = $result['site_name'];
		$return['blog_name'] = $result['blog_name'];
		$return['blog_address'] = $result['blog_address'];
		$return['blog_description'] = $result['blog_description'];
		$return['id'] = $result['id'];
		
		if (isset($result['fb_id']) && is_numeric($result['fb_id'])) {
			$return['social'][] = anchor('http://facebook.com/profile.php?id='.$result['fb_id'], 'Facebook', array('target' => '_blank'));
			$return['profile_photo'] = 'http://graph.facebook.com/'.$result['fb_id'].'/picture?type=large';
		} elseif (isset($result['fb_id']) && is_string($result['fb_id'])) {
			$return['social'][] = anchor('http://facebook.com/'.$result['fb_id'], 'Facebook', array('target' => '_blank'));
			$return['profile_photo'] = 'http://graph.facebook.com/'.$result['fb_id'].'/picture?type=large';
		} else {
			$return['profile_photo'] = base_url().'img/blank.png';
		}
		
		if ($result['blog_address']) {
			$return['blog_address'] = $result['blog_address'];
			$return['blog_name'] = $result['blog_name'];
		}
		
	    return $return;
	}
	
}
