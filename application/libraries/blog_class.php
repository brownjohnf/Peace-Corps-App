<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog_class
{
	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->model(array('page_model', 'people_model'));
		$this->ci->load->library(array('permission_class', 'common_class'));
	}
	
	public function feed()
	{
		// grab all users with blogs
		$results = $this->ci->people_model->selectUsers(array('where' => array('blog_address !=' => '')));
		
		// populate the standard feed harness
		foreach ($results as $result)
		{
			$tags = $this->ci->common_class->tags_to_links('blog #description here');
			$item['message'] = $tags['text'];
			$item['message_truncated'] = 'no';
			$item['subject'] = anchor('profile/view/'.strtolower($result['lname'].'-'.$result['fname']), $result['fname'].'&nbsp;'.$result['lname']).',&nbsp;'.$result['group_name'];
			$item['full_url'] = prep_url($result['blog_address']);
			$item['author'] = $result['blog_name'];
			$item['tags'] = $tags['array'];
			
			
		
			if (isset($result['fb_id'])) {
				$item['profile_photo'] = 'http://graph.facebook.com/'.$result['fb_id'].'/picture';
			} else {
				$item['profile_photo'] = base_url().'img/blank.png';
			}

			$a = get_headers($item['full_url'], 1);
			
			if (array_key_exists('Last-Modified', $a))
			{
				$item['elapsed'] = $this->ci->common_class->elapsed_time(strtotime($a['Last-Modified']));
			}
			else
			{
				$item['elapsed'] = null;
				$a['Last-Modified'] = date(time());
			}
			
			$item['controls'] = null;
			$item['comments'] = null;
			$item['info'] = null;
			
			$return[strtotime($a['Last-Modified'])] = $item;
		}
		return $return;
	}
	
	public function view($names)
	{
		$names_array = explode('-', trim($names));
	    $query = array('where' => array('people.lname like' => urldecode($names_array[0]), 'people.fname like' => urldecode($names_array[1])), 'limit' => 1, 'offset' => 0);
		
	    // get profile info
	    if (! $result = $this->ci->people_model->selectUsers($query)) {
			return false;
			die();
		}
		
		if (! $result['blog_address']) {
			return false;
			die();
		}
		
		$return = $result;
		
		if (isset($result['fb_id']) && is_numeric($result['fb_id'])) {
			$return['social'][] = anchor('http://facebook.com/profile.php?id='.$result['fb_id'], 'Facebook', array('target' => '_blank'));
			$return['profile_photo'] = 'http://graph.facebook.com/'.$result['fb_id'].'/picture?type=large';
		} elseif (isset($result['fb_id']) && is_string($result['fb_id'])) {
			$return['social'][] = anchor('http://facebook.com/'.$result['fb_id'], 'Facebook', array('target' => '_blank'));
			$return['profile_photo'] = 'http://graph.facebook.com/'.$result['fb_id'].'/picture?type=large';
		} else {
			$return['profile_photo'] = base_url().'img/blank.png';
		}
		
		$address_array = explode('.', $result['blog_address']);
		$blog_type = $address_array[count($address_array) - 2];
		

		$count = 0;
		switch ($blog_type)
		{
			case 'blogspot':
				$return['feed'] = prep_url($result['blog_address'].'/feeds/posts/default');
		
				$rss = simplexml_load_file($return['feed']);
				
				foreach ($rss->entry as $item)
				{
					if ($count > 5) {
						break;
					}
					$data[$count]['content'] = '<p>'.str_replace(array('</div>', '<br>', '<div>'), array('</p>', '', '<p>'), $item->content).'</p>';
					$data[$count]['title'] = strip_tags($item->title);
					$data[$count]['subject'] = null;
					$data[$count]['tags'] = null;
					$data[$count]['elapsed'] = null;
					$count++;
				}
				break;
			case 'wordpress':
				$this->ci->session->set_flashdata('message', "We're sorry, but ".$result['fname'].'&nbsp;'.$result['lname'].'uses a Wordpress blog, which is currently only partially supported. We hope to add greater support for this feature in the future.');
				$return['feed'] = prep_url($result['blog_address'].'/feed');
				$rss = simplexml_load_file($return['feed']);
				foreach ($rss->channel->item as $item)
				{
					if ($count > 5) {
						break;
					}
					$data[$count]['content'] = anchor($item->link, $item->pubDate);
					$data[$count]['title'] = $item->title;
					$data[$count]['subject'] = null;
					$data[$count]['tags'] = null;
					$data[$count]['elapsed'] = $this->ci->common_class->elapsed_time(strtotime($item->pubDate)).'&nbsp;ago';
					$count++;
				}
				break;
			default:
				$data = "Sorry, we don't recognize this type of blog.";
		}
		//print_r($rss);
		$return['blog_data'] = $data;
	    return $return;
	}
	
}
