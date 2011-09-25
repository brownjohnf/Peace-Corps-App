<?php
class MY_Controller extends CI_Controller
{
    function __construct()
	{
        parent::__construct();
		
		$this->load->database();
		$this->load->helper(array('url', 'file', 'array', 'html'));
		$this->load->library(array('auth', 'form_validation', 'menu_class', 'common_class'));
		$this->load->model('facebook_model');
		
		//print_r($this->session->userdata('fb_data'));
		
		$this->fb_data = $this->session->userdata('fb_data'); // this array contains all the user FB info
		//print_r($this->fb_data);
		
				
		// check to see if the user is logged in through facebook
		if ((! $this->fb_data['uid']) or (! $this->fb_data['me']))
		{
			$this->userdata = array('group' => array('id' => -1, 'name' => 'Unknown'), 'fname' => 'Unknown', 'lname' => 'Unknown', 'flname' => 'Unknown', 'lfname' => 'Unknown', 'id' => 0);
			$this->user_menu[] = anchor($this->fb_data['loginUrl'].'&scope=email', 'Facebook Login');
		}
		else
		{
			if ($this->auth->is_user())
			{
				$this->session->unset_userdata('notice');
				if ($this->userdata['group']['name'] == 'Admin')
				{
					//$this->user_menu[] = anchor('feed', 'Admin Panel');
				}
			}
			else
			{
				$this->session->set_userdata('notice', "You are signed in, but not currently registered with us. Consider registering to receive our latest Facebook notices and updates.");
				$this->userdata = array('group' => array('id' => 0, 'name' => 'Guest'), 'fname' => 'Guest', 'lname' => 'Guest', 'flname' => 'Guest', 'lfname' => 'Guest', 'id' => 0);
			}
			$this->user_menu[] = anchor('', img('https://graph.facebook.com/'.$this->fb_data['uid'].'/picture'), array('id' => 'user_image'));
			$this->user_menu[] = anchor('', $this->fb_data['me']['name'].', '.$this->userdata['group']['name']);
		}
		//echo '<pre>'; print_r($this->fb_data); echo '</pre>';
		
		/* alert tests 
		$this->session->set_flashdata('alert', 'This is a test-generated alert.');
		$this->session->set_userdata('message', 'This is a test-generated message.');
		$this->session->set_flashdata('error', 'This is a test-generated error.');
		$this->session->set_flashdata('success', 'This is a test-generated success.');
		$this->session->unset_userdata('message');*/
		
    }
}