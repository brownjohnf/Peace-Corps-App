<?php
class MY_Controller extends CI_Controller
{
    function __construct()
	{
        parent::__construct();
		
		$this->load->helper(array('url', 'file', 'array', 'html'));
		
		$this->load->library(array('auth', 'form_validation', 'menu_class', 'common_class'));
		
		$this->load->database();
		
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
				if ($this->userdata['group']['name'] == 'Admin')
				{
					//$this->user_menu[] = anchor('feed', 'Admin Panel');
				}
			}
			else
			{
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
    
    function _print($body = null)
    {
    	if (! isset($body) && ($this->uri->segment(1) != 'private') && ($this->uri->segment(1) != 'admin'))
    	{
    		$content = $this->content->loadContent();
    		$body = '<h1 id="content_title">'.$content['title'].'</h1>'.$content['content'];
    		$this->headview_tags['title'] = $content['title'];
    		
			if ($this->auth->is_editor($content['id']))
			{
				$this->defaultview_tags['editbox'] = $this->load->view('editorbox_view', $content['editbox'], true);
			}
			//$this->defaultview_tags['navpath'][] = anchor($content['path'], $content['title']);
    	}
    	elseif (! isset($body) && (($this->uri->segment(1) == 'private') || ($this->uri->segment(1) == 'admin')))
    	{
    		$body = 'This is a restricted section. You must specify content manually.';
    	}
		$this->defaultview_tags['content'] = $body;
		
		$this->load->view('headview',$this->headview_tags);
		$this->load->view('defaultview',$this->defaultview_tags);
		$this->load->view('footview',$this->footview_tags);
	}

	function _slideshow()
	{
		$this->_jquery();
		
		$this->headview_tags['stylesheets'][] = base_url().'css/s3Slider.css';
		$this->headview_tags['scripts'][] = base_url().'js/s3Slider.js';
		$this->headview_tags['scripts'][] = base_url().'js/my_s3Slider.js';
	}
	
	function _google_earth()
	{
		
		$this->headview_tags['scripts'][] = 'https://www.google.com/jsapi?key=ABQIAAAA929mveu8aplh94mIvhgO1xQ5cXbFHwLTcKbGZruc_Xls9QQN9RQ8wyFCSCzL1WvI5DzqCklT1r-cFg';
		$this->headview_tags['scripts'][] = base_url().'js/google_earth.js';
	}
	
	function _jquery()
	{
		$this->headview_tags['scripts'][] = 'http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js';
	}
}