<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

class Home extends MY_Controller {
	
	function __construct() {
	    parent::__construct();
		
	}

	public function index()
	{
		redirect(base_url());
	}

	public function splash()
	{
		$this->load->library(array('common_class'));
		if ($this->input->get('state')) {
			if ($this->auth->is_user())
			{
				$this->session->set_flashdata('success', 'You have successfully logged in.');
				redirect(base_url().'profile/view/'.$this->userdata['url']);
			}
			else
			{
				redirect('welcome');
			}
		}
		
$data['splash'] = array(
					array(
						'visual' => img(array('src' => base_url().'uploads/1ca600fea348193c11d5880ce48fd278_splash.jpg', 'width' => '658px', 'height' => '390px')),
						'width' => '658px',
						'title' => "We've got a new look!",
						'text' => "We're pleased to announce the launch of our new Peace Corps Senegal website. The address may be the same, but it's full of new features and content, making it more powerful and full-featured than ever.",
						'link' => anchor('page/view/about-us', '<i>Bismillah!</i>')
						),
					array(
						  'visual' => '<iframe width="658" height="390" src="http://www.youtube.com/embed/0ad-aaaVZ-E?rel=0&wmode=Opaque" frameborder="0" allowfullscreen></iframe>',
						  'width' => '658px',
						  'title' => 'Kolda Ag Fair A Success!',
						  'text' => "Peace Corps Senegal organized and executed an agricultural fair in the southern regional capital of Kolda. Combining elements of a farmers market with a food transformation expo, it attracted many local agricultural producers and buyers.",
						  'link' => anchor('http://youtube.com/user/pcsenegaladmin', 'Visit our YouTube Channel', array('target' => '_blank'))
						  ),
					array(
						  'visual' => '<iframe width="658" height="390" src="http://www.youtube.com/embed/gt4VYGd178I?rel=0&wmode=Opaque" frameborder="0" allowfullscreen></iframe>',
						  'width' => '658px',
						  'title' => 'Welcome Aggies!',
						  'text' => "Peace Corps Senegal welcomes its newest agriculture stage! Over the next nine weeks, they'll learn a local language, learn about Senegalese culture, and acquire all the skills they'll need to be an effective Volunteer for the next two years.",
						  'link' => anchor('http://youtube.com/user/pcsenegaladmin', 'Visit our YouTube Channel', array('target' => '_blank'))
						  ),
					array(
						'visual' => img(array('src' => base_url().'uploads/1ca600fea348193c11d5880ce48fd278_splash.jpg', 'width' => '658px', 'height' => '390px')),
						'width' => '658px',
						'title' => "We've got a new look!",
						'text' => "We're pleased to announce the launch of our new Peace Corps Senegal website. The address may be the same, but it's full of new features and content, making it more powerful and full-featured than ever.",
						'link' => anchor('page/view/about-us', '<i>Bismillah!</i>')
						),
					array(
						'visual' => img(array('src' => base_url().'uploads/d42c981bac33c044a217eaf43949237b_splash.JPG', 'width' => '658px', 'height' => '390px')),
						'width' => '658px',
						'title' => 'Photo Contest 2012',
						'text' => "Last year's Peace Corps West Africa photo contest winners were beautiful, and ranged from poignant to funny; we're expecting even better this year. If you're a PCV with a camera, wipe off the dust and snap some shots. Details coming soon.",
						'link' => ''//anchor('', '')
						),
					array(
						'visual' => img(array('src' => base_url().'uploads/00d7e66150430aff782c894883944e84_splash.jpg', 'width' => '658px', 'height' => '390px')),
						'width' => '658px',
						'title' => 'Stomping Out Malaria',
						'text' => "Peace Corps/Senegal is proud of its continued efforts to combat malaria. We have inspired a new partnership between the President's Malaria Initiative and Peace Corps programs across Africa, who are now teamed up to eradicate malaria across the continent. For more information on the Stomping Out Malaria in Africa initiative, and to see what else we're doing to fight malaria here in Senegal, check out our page.",
						'link' => anchor('page/view/malaria', 'Fighting Malaria')
						),
					array(
						'visual' => img(array('src' => base_url().'uploads/d42c981bac33c044a217eaf43949237b_splash.JPG', 'width' => '658px', 'height' => '390px')),
						'width' => '658px',
						'title' => 'Celebrating 50 Years',
						'text' => "It's hard to believe, but Peace Corps is now 50 years old. We'll be looking back over the years as we near our 50th birthday here at Peace Corps Senegal, coming up in 2013. Stay tuned.",
						'link' => anchor('page/view/50th-anniversary', 'Celebrate with us')
						),
					array(
						'visual' => img(array('src' => base_url().'uploads/1ca600fea348193c11d5880ce48fd278_splash.jpg', 'width' => '658px', 'height' => '390px')),
						'width' => '658px',
						'title' => "We've got a new look!",
						'text' => "We're pleased to announce the launch of our new Peace Corps Senegal website. The address may be the same, but it's full of new features and content, making it more powerful and full-featured than ever.",
						'link' => anchor('page/view/about-us', '<i>Bismillah!</i>')
						),
					array(
						'visual' => img(array('src' => base_url().'uploads/ad8f43cf48574073b9bbf386789e9bd1_splash.JPG', 'width' => '658px', 'height' => '390px')),
						'width' => '658px',
						'title' => 'Food Security',
						'text' => "Peace Corps Senegal Volunteers work with local farmers, food transformation cooperatives, and resellers to enhance Senegal's food security. Learn about our partnership with USAID, the Master Farmer program, and the many other ways we're working sustainably and locally to ensure greater food security for generations to come.",
						'link' => anchor('page/view/food-security', 'PC Senegal &amp; Food Security')
						)
					);
		
		$this->output->set_header("Cache-Control: max-age=300, public, must-revalidate");
		
		$this->load->view('head', array('page_title' => 'Home', 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css', 'anythingslider.css', 'splash.css'), 'scripts' => array('jquery.easing.1.2.js', 'jquery.anythingslider.min.js', 'my_anything_slider.js')));
		$this->load->view('header');
		$this->load->view('splash_view', $data);
		//$this->load->view('footer');
	}
	
	public function welcome()
	{
		$data['title'] = 'Welcome!';
		$data['data'] = "<h1>Thanks for signing in!</h1><p>We're glad you decided to sign in, and would like to encourage you to join the Peace Corps Senegal community. You're not currently registered as a Volunteer, Staff, or Administrator. If you believe this is an error, contact the site administrator.</p><h2>What Now?</h2><p>We encourage you to join our email list, or sign up for Facebook updates from us. We value privacy, and we'll only send you information if you explicitly request it. If you're already signed up and would like to unregister, you can do so here.</p><p>Stay tuned for more ways to get involved.</p><h3>Friends &amp; Family</h3><p>Is your son or daughter, best friend or college buddy, mother or father currently serving with us? See if they have a blog, take a look at their profile, or donate to their project.</p><h3>Development Agencies</h3><p>Are you a member of another Peace Corps post, Peace Corps Washington, a stateside NGO, or abroad here in the field? Take a look at how we collaborate with development agencies of all kinds at home and abroad, and see about working with us. Already working with us? Want a little oversight? We're committed to transparency, and you can view what we're up to in the fields of malaria prevention and food security development.</p><h3>Developers</h3><p>Have a little web savvy? Have a lot? Consider the joining the team keeping this platform alive and kicking. Read more about it on its homepage.</p>";
		$data['backtrack'] = array('' => 'Home', 'home/welcome' => 'Welcome');
		
		// print the error
		$this->load->view('head', array('page_title' => $data['title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('basic.js', 'jquery.url.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('right_column');
		$this->load->view('basic_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer', array('footer' => 'Footer Here'));
	}
	
	public function disclaimer()
	{
		$data['title'] = 'Disclaimer';
		$data['data'] = '<h1>Disclaimer</h1><p>The contents of this web site do not reflect in any way the positions of the U.S. Government or the United States Peace Corps. This web site is managed and supported by Peace Corps Senegal Volunteers and our supporters. It is not a U.S. Government web site.</p>';
		
	    // print the page
		$this->output->set_header("Cache-Control: max-age=300, public, must-revalidate");
		
		$this->load->view('head', array('page_title' => $data['title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('basic.js', 'jquery.url.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('right_column');
		$this->load->view('blank_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer');
	}
	
	public function privacy()
	{
		$data['title'] = 'Privacy Policy';
		$data['data'] = "<h1>Privacy Policy</h1><p>Peace Corps Senegal will never give, sell, or in any way communicate any personal information to anyone, save with the owner of said information's express permission.</p>";
		
	    // print the page
		$this->output->set_header("Cache-Control: max-age=300, public, must-revalidate");
		
		$this->load->view('head', array('page_title' => $data['title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('basic.js', 'jquery.url.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('right_column');
		$this->load->view('blank_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer');
	}
	
	public function support()
	{
		$data['title'] = 'Support Us';
		$data['data'] = '<h1>Support Us</h1><p>This site is powered by the open source Peace Corps App Project. If you would like to contribute funds, time, or energy to the effort, please contact us through github, at <a href="https://github.com/brownjohnf/Peace-Corps-App" target="_blank">https://github.com/brownjohnf/Peace-Corps-App</a>.</p>';
		
	    // print the page
		$this->output->set_header("Cache-Control: max-age=300, public, must-revalidate");
		
		$this->load->view('head', array('page_title' => $data['title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('basic.js', 'jquery.url.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('right_column');
		$this->load->view('blank_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer');
	}
	
	public function security()
	{
		$data['title'] = 'Security';
		$data['data'] = '<h1>Security</h1><p>All content hosted through this application is safe and secure. For more information please view our '.anchor('privacy', 'Privacy Policy').'.</p>';
		
	    // print the page
		$this->output->set_header("Cache-Control: max-age=300, public, must-revalidate");
		
		$this->load->view('head', array('page_title' => $data['title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('basic.js', 'jquery.url.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('right_column');
		$this->load->view('blank_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer');
	}
	
	public function about()
	{
		$data['title'] = 'About';
		$data['data'] = '<h1>About</h1><p>This website is running the open source Peace Corps App, currently in pre-alpha release.</p><h2>License</h2><p>PC Web App is copyright John F. Brown, 2011, and files herein are licensed under the Affero General Public License version 3, the text of which can be found in GNU-AGPL-3.0, or any later version of the AGPL, unless otherwise noted.  Components of PC Web App, including CodeIgniter, PHP Markdown and JQuery, are licensed separately. All unmodified files from these and other sources retain their original copyright and license notices: see the relevant individual files.</p><h2>Authors</h2><ul><li>'.anchor('https://diasp.org/u/brownjohnf', 'John F. Brown').'</li></ul>';
		
	    // print the page
		$this->output->set_header("Cache-Control: max-age=300, public, must-revalidate");
		
		$this->load->view('head', array('page_title' => $data['title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('basic.js', 'jquery.url.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('right_column');
		$this->load->view('blank_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer');
	}
}