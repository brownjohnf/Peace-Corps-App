<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_class
{
	public function __construct()
	{
		$this->ci =& get_instance();
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