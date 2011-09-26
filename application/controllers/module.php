<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

class Module extends MY_Controller {
	
	function __construct()
	{
	    parent::__construct();
		$this->load->library('module_class');
	}
	
	public function index()
	{
		$data['tiers'] = $this->module_class->show();
		
		$data['title'] = 'Modules';
		$data['backtrack'] = array('resource' => 'Resources', 'module' => 'Modules');
		
		/*
		$data['tiers']['Tier Zero'] = array(
							   'SS-001 Safety and Security',
							   'SS-002 Allegations',
							   'MED-001 Food and Water Preparation',
							   'MED-002 Nutrition',
							   'TTC-001 Training Center Orientation',
							   'PST-001 Pre-Service Training Overview',
							   'PST-002 Pre-Service Training Technical Overview',
							   'LANG-001 Intro to Language',
							   'PST-003 The Project Plan',
							   'MED-002 Reducing Risk of HIV/STI Exposure',
							   'SS-003 Emergency Action Plan'
							   );
		$data['tiers']['Tier One'] = array(
							   'module/view/basic-garden-bed-preparation' => 'AG-104 Basic Garden Bed Preparation',
							   'UAG-101 Intro to Urban Agriculture',
							   'AG-102 Composting',
							   'FS-101 Food Security Initiative',
							   'AG-116 Vegetable Pepinieres',
							   'BIKE-001 Bike Training',
							   'CC-101 Cross-Cultural Fair',
							   'TTC-102 Homestay Orientation',
							   'CC-102 Cross-Cultural Training Introduction',
							   'TTC-101 Training Site Logistics',
							   'MED-101 Common Illnesses and Nutrition',
							   'MED-102 Malaria, General Information, Prophylaxes & Policies',
							   "MED-103 Men and Women's Health",
							   'AG-103 Soils and Amendments',
							   'UAG-102 Intro to Garden Crops',
							   'AG-105 Learning Local Environmental Knowledge (LLEK)',
							   'PST-101 PCV Credibility',
							   'PST-102 Swearing-In Criteria',
							   'SUSAG-101 Intro to Field Crops, Part 1',
							   'SUSAG-102 Intro to Field Crops, Part 2',
							   'UAG-103 Agroforestry for Urban Ag Volunteers',
							   'GAD-101 SeneGAD',
							   'AG-106 Permaculture: Design Process',
							   'PST-103 PCV Responsibilities to Host Communities',
							   'PST-104 Intro to Counterpart Workshop',
							   'AG-107 Permaculture: Components of a Living System',
							   'AG-108 Permaculture: Mapping, Part 1',
							   'module/view/live-fencing' => 'AGFO-107 Live Fencing',
							   'PST-105 Volunteer Visit Prep',
							   'DEV-101 Introduction to International Development',
							   'PST-106 APCD, PTA, PCVL Roles & Responsibilities',
							   'PST-107 Counterpart Roles & Responsibilities',
							   'AG-110 Integrated Pest Management (IPM)',
							   'AG-113 Pest and Disease Identification',
							   'AGFO-108 Moringa Preparation',
							   'AG-111 The Ecology of Senegal',
							   'AG-109 Permaculture: Mapping, Part 2',
							   'AG-112 Garden Maintenance',
							   'MED-104 Emotional Health and Yoga',
							   'MED-105 HIV and Sexual Health',
							   'MED-106 Emergencies and First Aid',
							   'PST-108 Administration of Senegal',
							   'AG-114 Open Garden Day',
							   'IT-101 Electronic Resources',
							   'PST-109 Life Between Install and IST',
							   'MED-107 Medical Policies, Procedures and Dental',
							   'LANG-101 Intro to Language Seminars',
							   'AGFO-101 Agfo Tech Training Overview',
							   'AGFO-102 Agfo Project Plan',
							   'AGFO-103 Intro to Agroforestry',
							   'AG-101 Gardening Basics',
							   'AGFO-104 Tree ID Walk, Part 1',
							   'AGFO-105 Tree ID Walk, Part 2',
							   'AGFO-106 Agfo Technologies',
							   'PST-110 Recording and Reporting',
							   'APPTECH-101 Mud Stoves',
							   'AGFO-111 Partner Organizations',
							   'AGFO-112 Agfo Product Marketing',
							   'GEN-101 PACA',
							   'AGFO-113 Site Diagnostics and Project Design',
							   'GEN-102 HE/EE for Non-HE/EE',
							   'AGFO-109 Land Tenure and Forestry Code',
							   'AG-115 Permagardening',
							   'AGFO-110 Seed Collection Basics'
							   );
		$data['tiers']['Tier Two'] = array(
							   'UAG-201 Micro-Gardening, Part 1',
							   'UAG-202 Micro-Gardening, Part 2',
							   'BUS-204 Junior Achievement'
							   );
		$data['tiers']['Tier Three'] = array(
							   'AGFO-313 Grafting, Preparing Scion',
							   'AGFO-314 Grafting, Preparing Rootstock',
							   'AGFO-315 Grafting, Making Cuts'
							   );
		
		asort($data['tiers']['Tier Zero']);
		asort($data['tiers']['Tier One']);
		asort($data['tiers']['Tier Two']);
		asort($data['tiers']['Tier Three']);
		*/
		
	    // print the page
		$this->output->set_header("Cache-Control: max-age=3000, public, must-revalidate");
		
		$this->load->view('head', array('page_title' => $data['title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('jquery.url.js', 'resource.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('right_column');
		$this->load->view('module_list_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer', array('footer' => 'Footer Here'));
	}
	
	public function view()
	{
		if ($this->uri->segment(3, null))
		{
			$url = explode('-', $this->uri->segment(3, null));
			if (count($url) != 2 || ! is_string($url[0]) || ! is_numeric($url[1])) {
				$this->session->set_flashdata('error', 'Invalid module address. Addresses should be the course category and course number, joined by a hyphen. This error was generated by module/view');
				redirect('module');
			}
		}
		else
		{
			$this->session->set_flashdata('error', 'You must specify a module to view. This error was generated by module/view');
			redirect('module');
		}
		
		if (! $data = $this->module_class->view($url))
		{
			$this->session->set_flashdata('error', 'This does not appear to be a valid module. This error was generated by module/view');
			redirect('module');
		}
		
		$data['backtrack'] = array('resource' => 'Resources', 'module' => 'Modules', $this->uri->uri_string() => $data['title']);
		/*
		switch ($this->uri->segment(3, null))
		{
			case 'basic-garden-bed-preparation';
				$data['title'] = 'Basic Garden Bed Preparation';
				
				$data['lesson_plan'] = '<h3>Performance Goals & Objectives</h3>
<p>Goals: This session is designed as a field technology work session, where volunteers will be instructed on the methods of double digging and proper usage of soil amendments.  This is a field workshop, with the first 20 minutes dedicated to explaining the reasons for and the advantages of double digging and adding appropriate soil amendments. The last 40 minutes are dedicated to hands on practice at double digging.</p>';
				$data['resources'] = array(
										   'Documents' => array(
																'http://pcsenegal.org/download.php?file=library/Lesson%20Plan%20-%20Basic%20Garden%20Bed%20Prep.doc&extension=doc&id=799&embed=library&title=Lesson%20Plan%20-%20Basic%20Garden%20Bed%20Prep' => 'Lesson Plan [download]',
																'http://pcsenegal.org/download.php?file=library/Flipchart%20Guide%20-%20BASIC%20GARDEN%20BED%20PREP.doc&extension=doc&id=796&embed=library&title=Flipchart%20Guide%20-%20Basic%20Garden%20Bed%20Prep' => 'Flipchart Guide [download]',
																'http://pcsenegal.org/download.php?file=library/Tech%20TDA%20-%20Basic%20Garden%20Bed%20Prep.doc&extension=doc&id=797&embed=library&title=Tech%20TDA%20-%20Basic%20Garden%20Bed%20Prep' => 'Tech TDA [download]',
																'http://pcsenegal.org/download.php?file=library/Tech%20Handout%20-%20Basic%20Garden%20Bed%20Prep.doc&extension=doc&id=798&embed=library&title=Tech%20Handout%20-%20Basic%20Garden%20Bed%20Prep' => 'Tech Handout [download]'
															   ),
										   'Links' => array(
															'http://www.agriculture.gouv.sn/' => 'Ministry of Agriculture',
															'http://www.facebook.com/groups/158506604235841/' => 'Peace Corps Senegal Agriculture Group [Facebook]'
															),
										   'Podcasts' => array(
															   'http://itunes.apple.com/gb/podcast/instructional-videos/id367648546' => 'Visit our podcast to find informational videos on this and many other topics'
															   ),
										   'Presentations' => array(
																	'http://pcsenegal.org/download.php?file=library/07.%20Steps%20to%20Successful%20School,%20Community,%20and%20Family%20Gardens/gardening_presentation.pptx&extension=pptx&id=408&embed=library/07.%20Steps%20to%20Successful%20School,%20Community,%20and%20Family%20Gardens&title=gardening_presentation' => 'Gardening [download]'
																	),
										   'How-to Videos' => array(
																	'Double Digging' => '<iframe width="440" height="253" src="http://www.youtube.com/embed/Uc4A-sOSPcA?rel=0&wmode=Opaque" frameborder="0" allowfullscreen></iframe>'
																	),
										   'Manuals' => array(
															  'http://pcsenegal.org/download.php?file=library/urban_agriculture.pdf&extension=pdf&id=784&embed=library&title=Urban%20Agriculture' => 'Urban Agriculture Manual [download]',
															  'http://pcsenegal.org/download.php?file=library/uag_project_plan_april2009.doc&extension=doc&id=785&embed=library&title=Urban%20Ag%20Project%20Plan,%20revised%20April%202009' => 'Urban Ag Project Plan [download]',
															  'http://pcsenegal.org/download.php?file=library/Urban_Ag_Brochure.pdf&extension=pdf&id=594&embed=library&title=Urban_Ag_Brochure' => 'Urban Ag Brochure [download]'
															  ),
										   'Case Studies' => array(
																   'page/view/organic-gardening-training' => 'Organic Gardening Training',
																   'page/view/barkedji-field-day' => 'Barkedji Field Day'
																   ),
										   'Wordlists' => array(
																   'Sereer',
																   'Wolof'
																   )
										   );
				$data['people'] = array(
										'profile/view/peterson-austin' => 'Austin Peterson, Volunteer',
										'profile/view/blass-cassandra' => 'Cassie Blass, Volunteer',
										'profile/view/bouye-youssoupha' => 'Youssoupha Bouye, Ag Trainer'
										);
				$data['experts'] = array(
										 array(
											   'name' => 'Bassirou Ndiaye',
											   'description' => 'Local gardener; has significant experience reclaiming poor soil/garden beds; works with Volunteers.',
											   'address' => 'Ndorong Sereer, Fatick',
											   'phone' => '775558703',
											   'email' => 'bas.ndiaye@yahoo.fr'
											   )
										 );
				$data['social'] = array(
										'http://www.facebook.com/groups/158506604235841/' => 'Peace Corps Senegal | Agriculture Group [Facebook]'
										);
				break;
			case 'live-fencing':
				$data['title'] = 'Live Fencing';
				$data['lesson_plan'] = '<h3>Introduction:</h3>
<p>Introduce lesson, definition: A living fence is an animal-proof barrier composed of trees and shrubs planted at close spacing around the perimeter of a field.<p>
<p>Characteristics:</p>';
				$data['backtrack'] = array('resource' => 'Resources', 'module' => 'Modules', 'module/view/live-fencing' => 'Live Fencing');
				$data['resources'] = array(
										   'Documents' => array(
																'http://pcsenegal.org/download.php?file=library/Live_Fencing_Pocket_Manual.pdf&extension=pdf&id=793&embed=library&title=Live%20Fencing%20Pocket%20Manual' => 'Full Lesson Plan [download]'),
										   'Links' => array(
															'http://www.environnement.gouv.sn/rubrique.php3?id_rubrique=20' => '<em>Eaus et Forets</em> Senegal (Water and Forest Management)',
															'http://www.facebook.com/groups/158506604235841/' => 'Peace Corps Senegal Agriculture Group [Facebook]'
															),
										   'Podcasts' => array(
															   'http://itunes.apple.com/gb/podcast/instructional-videos/id367648546' => 'Visit our podcast to find informational videos on this and many other topics'),
										   'Presentations' => array(
																	'http://pcsenegal.org/download.php?file=library/Live%20Fencing%20for%20IST.ppt&extension=ppt&id=794&embed=library&title=Live%20Fencing%20for%20IST' => 'Live Fencing for IST [download]'
																	),
										   'How-to Videos' => array(
																	'Pruning <em>Parkinsonia</em>' => '<iframe width="440" height="253" src="http://www.youtube.com/embed/Jo3qO69Ozkc?rel=0&wmode=Opaque" frameborder="0" allowfullscreen></iframe>',
																	'Pruning <em>Acacia nilotica</em>' => '<iframe width="440" height="253" src="http://www.youtube.com/embed/22_jbyaNyso?rel=0&wmode=Opaque" frameborder="0" allowfullscreen></iframe>'
																	),
										   'Manuals' => array(
															  'http://pcsenegal.org/download.php?file=library/pcsenegal_agroforestry_manual.pdf&extension=pdf&id=369&embed=library&title=pcsenegal_agroforestry_manual' => 'Agroforestry Manual [download]',
															  'http://pcsenegal.org/download.php?file=library/Live_Fencing_Pocket_Manual.pdf&extension=pdf&id=793&embed=library&title=Live%20Fencing%20Pocket%20Manual' => 'Live Fencing Pocket Manual [download]'),
										   'Wordlists' => array('Sereer', 'Wolof'));
				$data['people'] = array(
										'profile/view/kelley-michael' => 'Michael Kelley, Staff',
										'profile/view/blass-cassandra' => 'Cassie Blass, Volunteer',
										'profile/view/constant-ariana' => 'Ariana Constant, Volunteer');
				$data['experts'] = array(
										 array(
											   'name' => 'Alpha Sow',
											   'description' => 'Local farmer who uses a lot of live fence technology; has worked with Volunteers to train other farmers.',
											   'address' => 'Saraya, Kedougou',
											   'phone' => '775558720',
											   'email' => 'sow.alpha@gmail.com'
											   )
										 );
				$data['social'] = array(
										'http://www.facebook.com/groups/158506604235841/' => 'Peace Corps Senegal | Agriculture Group [Facebook]'
										);
		}
		*/
		
	    // print the page
		$this->output->set_header("Cache-Control: max-age=3000, public, must-revalidate");
		
		$this->load->view('head', array('page_title' => $data['title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('basic.js', 'jquery.url.js')));
		$this->load->view('header');
		$this->load->view('main_open');
		$this->load->view('left_column');
		$this->load->view('right_column');
		$this->load->view('module_view', $data);
		$this->load->view('main_close');
		$this->load->view('footer', array('footer' => 'Footer Here'));
	}
}