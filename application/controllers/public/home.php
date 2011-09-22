<?php
class Home extends MY_Controller
{	
	public function index()
	{
		$this->_print();
	}

	public function splash()
	{
		$this->_slideshow();
		
		$this->defaultview_tags['rightmenu'] = array();
		$this->defaultview_tags['chunk'] = "<script src=\"http://widgets.twimg.com/j/2/widget.js\"></script>
<script>
new TWTR.Widget({
  version: 2,
  type: 'profile',
  rpp: 2,
  interval: 6000,
  width: 180,
  height: 150,
  theme: {
    shell: {
      background: '#5C4033',
      color: '#ffffff'
    },
    tweets: {
      background: '',
      color: '',
      links: ''
    }
  },
  features: {
    scrollbar: false,
    loop: false,
    live: false,
    hashtags: true,
    timestamp: false,
    avatars: false,
    behavior: 'all'
  }
}).render().setUser('hedrickchris').start();
</script>";

	$this->slideshow['slides'] = array(
		array(
			'img' => 'segou_w559.png',
			'path' => base_url().'public/case_study/view/21',
			'title' => 'Segou Ecolodge',
			'caption' => 'Follow Zach Swank as he works with a community to develop an income-generating, ecologically sound tourist destination.',
			'position' => 'bottom'
		),
		array(
			'img' => '52weeks_w559.png',
			'path' => base_url().'public/case_study/view/16',
			'title' => '52 Pumps, 52 Weeks',
			'caption' => 'Join Garrison and Marcy as they attempt to install 52 locally made pumps in 52 wells, all in one year!',
			'position' => 'left'
		)
	);
	$this->headview_tags['slideshow'] = $this->load->view('slideshow_view', $this->slideshow, true);

		$this->_print();
	}

	public function error()
	{
		switch ($this->uri->segment(4))
		{
			case 'permission':
				$error[0] = 'Permission Error';
				switch ($this->uri->segment(5))
				{
					case 'not_admin':
						$error[1] = 'You have attempted to access a restricted page, but you do not have administrator privileges. Please login or request appropriate credentials.';
						break;
					default:
						$error[1] = 'No further information available.';
				}
				break;
			case 'missing':
				$error[0] = 'Missing Page';
				$error[1] = "We're sorry, but it looks like the page you've requested is missing. Please let Jack know what you're looking for, so he can fix the problem. Meanwhile, maybe try a Google search (to your right), and see if the content's still around somewhere.";
			default:
				$error[0] = 'Unknown Error';
				$error[1] = 'Well, something went wrong. But Jack, <i>ahem</i>, has failed to define this error. Go yell at him.';
		}
		
		$this->headview_tags['page_title'] = $error[0];
		
		$error_string = '<h1>'.$error[0].'</h1><p class="error">'.$error[1].'</p>';
		
		$this->_print($error_string);
	}
	
	public function privacy()
	{
		$this->defaultview_tags['navpath'][] = anchor('public/home/privacy/policy','About Senegal');
		$this->_print();
	}
}