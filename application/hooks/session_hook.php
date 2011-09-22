<?php

class Session_hook extends CI_Hooks
{
    public $CI;
    
    function __construct()
    {
	parent::__construct();
		$this->CI = get_instance();
    }
    
    function set_current_page()
    {
		//$this->CI->session->unset_userdata('history');
		$path = $this->CI->uri->segment_array();
		$history = $this->CI->session->userdata('history');
		$history['back_url'] = implode('/', $path);
		if (isset($path[3]))
		{
		    $history[$path[1]][$path[2]] = $path[3];
		    $history[$path[1]]['last_function'] = $path[2];
		    $history['last_controller'] = $path[1];
		}
		elseif (isset($path[2]))
		{
		    $history[$path[1]] = $path[2];
		    $history[$path[1]]['last_function'] = $path[2];
		    $history['last_controller'] = $path[1];
		}
		elseif (isset($path[1]))
		{
		    $history['last_controller'] = $path[1];
		}
		$this->CI->session->set_userdata('history', $history);
    }
}