<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tag_class
{
	public function __construct() {
		$this->ci =& get_instance();
		$this->ci->load->model('tag_model');
		$this->ci->load->library('page_class');
	}
	
	public function feed($tag = null)
	{
		// set fields to retrieve
		$fields = 'id, blurb, source, source_id, updated';
		
		// set search criteria, if any
		if ($tag) {
			$where = array('tag' => strtolower($tag));
		} else {
			$where = array('tag like' => '%');
		}
		
		// retrieve tags
		$results = $this->ci->tag_model->read(array('fields' => $fields, 'limit' => 15, 'where' => $where));
		
		$return = array();
		// for each tag found that matches the search query (each one either in a diff page, or diff places on the same page)
		foreach ($results as $result)
		{
			// generate a set of page feed data for the given page, in which this tag occurs, and for each one:
			foreach ($this->ci->page_class->feed($result['source_id']) as $key => $value)
			{
				// process the tags found in the blurb
				$message = $this->ci->common_class->tags_to_links($result['blurb']);
				// set the message equal to this processed blurb
				$value['message'] = $message['text'];
				// add this tag blurb to the return array
				$return[] = $value;
				//print_r($message);
			}
		}
		//print_r($results);
		return $return;
	}
	
	
	public function tag($tag_info = array('source' => null, 'source_id' => null, 'to_add' => array(array('blurb' => null, 'tag' => null))))
	{
		// make sure that there're a source and id set
		if (! $tag_info['source'] || ! $tag_info['source_id']) {
			die('you must specify a source table / source_id for the tag.');
		}
		
		// for each tag
		foreach ($tag_info['to_add'] as $to_add)
		{
			// if there's no tag or source id, die
			if (! $to_add['tag']) {
				die('you must specify a tag.');
			}
			
			//set connections
			$input['blurb'] = $to_add['blurb'];
			$input['tag'] = strtolower($to_add['tag']);
			$input['source'] = $tag_info['source'];
			$input['source_id'] = $tag_info['source_id'];
			$input['updated'] = time();
			
			// add this tag row to batch insert
			$batch[] = $input;
		}
		
		// delete all tags currently registered to this source
		if (! $this->ci->tag_model->delete(array('source' => $tag_info['source'], 'source_id' => $tag_info['source_id']))) {
			die('tag_model->delete returned false');
		}
		
		// process batch of tags
		$this->ci->tag_model->create($batch);
		return true;
	}
}
