<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_class
{
	public function __construct()
	{
		$this->ci =& get_instance();
	}
	
	public function parse_tags($raw_string)
	{
		// set the total number of CHARACTERS (excluding the tag itself) you'd like stored per tag
		$count = 300;
		$string = strip_tags($raw_string, '<b><i><a>');
		$regexes[] = '/#!([^#]+)#/';
		$regexes[] = '/#([^\.,\/\s!<>]+)/';
		
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
			}
		}
		return $return;
	}
	
	public function elapsed_time($time1, $time2 = false)
	{
	    // if only one argument is passed, assume that it should be compared to the current time
	    if (! $time2)
	    {
			$time2 = time();
	    }
	    // make sure that time2 is larger
	    if ($time1 > $time2)
	    {
			$ttime = $time1;
			$time1 = $time2;
			$time2 = $ttime;
	    }
	    // set intervals to be used
	    // php 'knows' them
	    $intervals = array('year', 'month', 'day', 'hour', 'minute', 'second');
	    $diffs =array();
	    
	    // loop through all intervals
	    foreach ($intervals as $interval)
		{
			// set default diff to 0
			$diffs[$interval] = 0;
		
			// create temp time
			$ttime = strtotime('+1 '.$interval, $time1);
		
			// loop until temp time is smaller than time2
			while ($time2 >= $ttime)
			{
			    $time1 = $ttime;
			    $diffs[$interval]++;
			    
			    // create new temp time from time1 and interval
			    $ttime = strtotime('+1 '.$interval, $time1);
			}
	    }
	    $count = 0;
	    $times = array();
	    
	    // loop through all diffs
	    foreach ($diffs as $interval => $value)
	    {
			// add value and interval
			// if value is bigger than 0
			if ($value > 0)
			{
			    // add s if value is not 1
			    if ($value != 1)
			    {
					$interval .= 's';
			    }
		    
			    // add value and interval to times array
			    $times[] = $value.' '.$interval;
			    $count++;
			}
	    }
		if (isset($times[0])) {
		    return $times[0];
		} else {
			return null;
		}
	}
	// given a parent id and table name, calculates the path down from the top-level parent item
	public function backtrack($parent_id, $table)
	{
	    $data = null;
	    $fields = 'parent_id, title, url';
	    while ($parent_id != 0)
	    {
			$response = $this->ci->page_model->read(array('where' => array('id' => $parent_id), 'fields' => $fields, 'limit' => 1));
			$data[$response['url']] = $response['title'];
			$parent_id = $response['parent_id'];
	    }
		if (is_array($data))
	    {
			return array_reverse($data);
	    }
	    else
	    {
			return $data;
	    }
	}
	
	//flattens a multi-dimensional array (recursive implode)
    public function r_implode($glue, $pieces)
    {
	foreach($pieces as $r_pieces)
	{
    		if(is_array($r_pieces))
    		{
      			$retVal[] = '<ul>'.$this->r_implode($glue, $r_pieces).'</ul>';
    		}
    		else	
    		{
      			$retVal[] = '<li>'.$r_pieces.'';
    		}
  	}
	    return '</li>'.implode($glue, $retVal);
	
    }
}