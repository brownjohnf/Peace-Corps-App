<?php
class Facebook_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		
		$config = array(
						'appId' => $this->config->item('fb_api'),
						'secret' => $this->config->item('fb_secret'),
						'fileupload' => true
						);
		
		$this->load->library('facebook', $config);
		
		// We may or may not have this data based on whether the user is logged in.
		$user = $this->facebook->getUser();
		
        // If we have a $user id here, it means we know the user is logged into
        // Facebook, but we don't know if the access token is valid. An access
        // token is invalid if the user logged out of Facebook.
		$profile = null;
		if ($user)
		{
			try {
				// proceed knowing you have a logged in user who's authenticated.
				$profile = $this->facebook->api('/me?fields=id,name,link,email');
			} catch (FacebookApiException $e) {
				error_log($e);
				$user = null;
			}
		}
		
		$fb_data = array(
						 'me' => $profile,
						 'uid' => $user,
						 'loginUrl' => $this->facebook->getLoginUrl(),
						 'logoutUrl' => $this->facebook->getLogoutUrl()
						 );
		
		$this->session->set_userdata('fb_data', $fb_data);
	}
}