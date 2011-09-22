<?php

class Admin extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->defaultview_tags['navpath'][] = anchor('admin','Administer');
		
		$this->load->database();
		$this->load->helper('url');
		
		$this->defaultview_tags['leftmenu'] = array(
													'User Administration' => array(
																				anchor('admin/user/show','Show Users'),
																				anchor('admin/user/add','Add User'),
																				anchor('admin/user/search','Search')
																				),
													'Case Studies' => array(
																		  anchor('admin/case_study/show','Show'),
																		  anchor('admin/case_study/add','Add'),
																		  anchor('admin/case_study/search','Search')
																		  ), 
													'Resources' => array(
																		   anchor('admin/resources/show', 'Show'),
																		   anchor('admin/resources/add','Add'),
																		   anchor('admin/resources/search','Search')
																		   ), 
													'Deep Management' => array(
																		   anchor('admin/region', 'Regions'),
																		   anchor('admin/work_zone','Work Zones'),
																		   anchor('admin/language','Languages'),
																		   anchor('admin/sector','Sectors'),
																		   anchor('admin/tag/system','System Tags'),
																		   anchor('publictag/user','User Tags')
																		   )
													);
		
		$this->defaultview_tags['rightmenu'] = array(
													 'Quick Links' => array(
																		   anchor('public/food_security/update','Food Security Update'), 
																		   anchor('public/case_study','Case Studies')
																		   )
													 );
		$this->load->library('auth');
		if (! $this->auth->is_admin())
		{
			redirect('public/home/error/permission/not_admin');
		}
	}

	function index()
	{
		$this->headview_tags['page_title'] = 'Admin Home';
		
		$this->defaultview_tags['content'] = 'Admin home.';
			
			
		$this->load->view('headview', $this->headview_tags);
		$this->load->view('defaultview', $this->defaultview_tags);
		$this->load->view('footview', $this->footview_tags);
		
	}
	
	function check_link()
	{
		$this->headview_tags['page_title'] = 'Admin Home';
		
		$this->load->helper('directory');
		$this->load->helper('file');
		
		$structure = get_filenames('html', true);
		
		global $output;
		$output = '<h1>Link Output</h1>';
		
		function walk ($value, $key)
		{
			global $output;
			
			$file_string = read_file($value);
			$output .= '<div><p>'.$value.'</p>';
			$regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
			//$regexp = "<img\s[^>]*src=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/img>";
			if(preg_match_all("/$regexp/siU", $file_string, $matches, PREG_SET_ORDER))
			{
				$output .= '<ul>';
				foreach($matches as $match)
				{
					if (read_file($match[2]))
					{
					 	$output .= '<li style="color: green;">'.$match[2].'</li>';
					}
					else
					{
						$output .= '<li style="color: red;">'.$match[2].'</li>';
					}
				}
				$output .= '</ul>';
			}
			$output .= '</div>';
		}
		array_walk_recursive($structure, 'walk');
		$this->defaultview_tags['content'] = $output;
			
			
		$this->load->view('headview', $this->headview_tags);
		$this->load->view('defaultview', $this->defaultview_tags);
		$this->load->view('footview', $this->footview_tags);
	}
}

