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

	// generates a feed of recently modified tags
	public function feed($tag = null)
	{
		// set search criteria, if any
		if ($tag) {
			$where = array('tag' => strtolower($tag));
		} else {
			$where = array('tag like' => '%');
		}

		// retrieve tags
		$results = $this->ci->tag_model->read(array('fields' => 'id, blurb, source, source_id, updated', 'limit' => 40, 'where' => $where, 'order_by' => array('column' => 'updated', 'order' => 'desc')));

		$return = array();
		// for each tag found that matches the search query (each one either in a diff page, or diff places on the same page)
		foreach ($results as $result)
		{
			if ($result['source'] == 'page')
			{
				// generate a set of page feed data for the given page, in which this tag occurs, and for each one:
				foreach ($this->ci->page_class->feed($result['source_id']) as $key => $value)
				{
					// process the tags found in the blurb
					$message = $this->ci->tag_class->tags_to_links($result['blurb']);
					// set the message equal to this processed blurb
					$value['message'] = $message['text'];
					// add this tag blurb to the return array
					$return[$key] = $value;
					//print_r($message);
				}
			}
			elseif ($result['source'] == 'case_study')
			{
				// generate a set of page feed data for the given page, in which this tag occurs, and for each one:
				foreach ($this->ci->casestudy_class->feed($result['source_id']) as $key => $value)
				{
					// process the tags found in the blurb
					$message = $this->ci->tag_class->tags_to_links($result['blurb']);
					// set the message equal to this processed blurb
					$value['message'] = $message['text'];
					// add this tag blurb to the return array
					$return[$key] = $value;
					//print_r($message);
				}
			}
			elseif ($result['source'] == 'documents')
			{
				foreach ($this->ci->document_class->feed($result['source_id']) as $key => $value)
				{
					$return[$key] = $value;
				}
			}
			elseif ($result['source'] == 'links')
			{
				foreach ($this->ci->link_class->feed($result['source_id']) as $key => $value)
				{
					$return[$key] = $value;
				}
			}
			elseif ($result['source'] == 'videos')
			{
				foreach ($this->ci->video_class->feed($result['source_id']) as $key => $value)
				{
					$return[$key] = $value;
				}
			}
		}
		//print_r($return);
		krsort($return);

		return $return;
	}

	// extracts tags from text and inserts them into the database
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
		if (! $this->ci->tag_model->delete(array('source' => $tag_info['source'], 'source_id' => $tag_info['source_id'])))
		{
			die('tag_model->delete returned false');
		}

		// process batch of tags
		if (! $this->ci->tag_model->create($batch))
		{
			die("uh oh, couldn't add the new tags!");
		}
		return true;
	}

	// experimental function for generating a tag cloud
	public function cloud($data = array())
	{
		$default = array('source' => '%', 'limit' => 50, 'order' => 'date');
		$data = array_merge($default, $data);

		switch ($data['order'])
		{
			case 'date':
				$order = array('column' => 'updated', 'order' => 'desc');
				break;
			default:
				$order = array('column' => 'updated', 'order' => 'desc');
		}

		// retrieve tags
		if (! $results = $this->ci->tag_model->read(array('fields' => 'tag, updated', 'limit' => $data['limit'], 'where' => array('source like' => $data['source']), 'distinct' => true)))
		{
			return false;
			die();
		}
		foreach ($results as $result)
		{
			$return[] = $result['tag'];
		}
		return array_unique($return);
	}

	// converts embedded hash tags to links
	public function tags_to_links($string)
	{

		$regexes[] = "/#!([^#]+)#/";
		$regexes[] = '/#([a-zA-Z]+[a-zA-Z0-9]*)/';

		$return['text'] = preg_replace_callback(
			$regexes,
			create_function(
				'$matches',
				'return "<span class=\"hash\">#</span>".anchor("feed/tag/".strtolower($matches[1]), $matches[1]);'
				),
			$string
			);

		foreach ($regexes as $regex)
		{
			if (preg_match_all($regex, $string, $matches, PREG_OFFSET_CAPTURE))
			{
				foreach ($matches[1] as $match)
				{
					$tag = strtolower($match[0]);

					$return['array'][] = $tag;
				}
				$return['string'] = implode('#', $return['array']);
			}
			else
			{
				$return['string'] = $string;
				$return['array'] = null;
			}
		}
		return $return;
	}

	// extracts tags from text, and returns them in array, blurb, and string form
	public function parse_tags($raw_string)
	{
		// set the total number of CHARACTERS (excluding the tag itself) you'd like stored per tag
		$count = 300;
		$string = $raw_string;
		$regexes[] = '/#!([^#]+)#/';
		$regexes[] = '/#([^\.,\/\s!<>#]+)/';

		foreach ($regexes as $regex)
		{
			if (preg_match_all($regex, $string, $matches, PREG_OFFSET_CAPTURE))
			{
				foreach ($matches[1] as $match)
				{
					$tag = strtolower($match[0]);

					$string_length = strlen($string);
					$match_length = strlen($match[1]);

					// if the string is longer than the needed blurb length
					if ($string_length > $count + $match_length) {
						// if the tag isn't too close to the begining of the string
						if ($match[1]-$count/2 > 0) {
							$blurb = '&#8230;'.substr($string, $match[1]-$count/2, $match_length+$count).'&#8230;';
						// if the tag is too close to the end of the string
						} elseif ($match[1]+$count/2 > $string_length) {
							$blurb = substr($string, -$count-$match[1]);
						// if the tag
						} else {
							$blurb = substr($string, 0, $match_length+$count).'&#8230;';
						}
					} elseif ($string_length < $count + $match_length) {
						$blurb = $string;
					} else {
						$blurb = 'test_blurb';
					}

					$return['array'][] = array('tag' => $tag, 'blurb' => trim($blurb));
					$for_string[] = $tag;
				}
				$return['string'] = implode('#', $for_string);
			}
		}
		//echo '<pre>'; print_r($return); echo '</pre>';
		if (isset($return)) {
			return $return;
		}
		else {
			return false;
		}
	}

	// extracts tags from tag-only input box. doesn't use ! check

	// extracts tags from text, and returns them in array and string form
	// returns return['array'], ['string']
	public function tag_input($raw_string)
	{
		$string = $raw_string;
		$regexes[] = '/#([^#]+)/';
		//$regexes[] = '/#([^\.,\/\s!<>#]+)/';

		foreach ($regexes as $regex)
		{
			if (preg_match_all($regex, $string, $matches, PREG_OFFSET_CAPTURE))
			{
				foreach ($matches[1] as $match)
				{
					$tag = strtolower(trim($match[0]));

					$return['array'][] = $tag;
					$for_string[] = $tag;
				}
				$return['string'] = '#'.implode('#', $for_string);
			}
		}
		//echo '<pre>'; print_r($return); echo '</pre>';
		if (isset($return)) {
			return $return;
		}
		else {
			return null;
		}
	}

	// validation callback function for checking tags
	function check_tag_input($tags)
	{
		if ($tags == '' || preg_match('/#.+/i', $tags))
		{
			return false;
		}
		else
		{
			return array('tag_check', 'The %s field must be blank or contain valid tags. (hash separated: #tag1 #tag2#tag3 etc.)');
		}
	}
}
