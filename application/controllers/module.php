<?php
class Module extends MY_Controller {
	
	function __construct()
	{
	    parent::__construct();
	}
	
	public function index()
	{
		$data['title'] = 'Modules';
		$data['backtrack'] = array('resource' => 'Resources', 'module' => 'Modules');
		
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
		
	    // print the page
		$this->output->set_header("Cache-Control: max-age=3000, public, must-revalidate");
		
		$this->load->view('head', array('page_title' => $data['title'], 'stylesheets' => array('layout_outer.css', 'layout_inner.css', 'theme.css'), 'scripts' => array('basic.js', 'jquery.url.js')));
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
		switch ($this->uri->segment(3, null))
		{
			case 'basic-garden-bed-preparation';
				$data['title'] = 'Basic Garden Bed Preparation';
				$data['backtrack'] = array('resource' => 'Resources', 'module' => 'Modules', 'module/view/double-digging' => 'Double Digging');
				$data['lesson_plan'] = '<h3>Performance Goals & Objectives</h3>
<p>Goals: This session is designed as a field technology work session, where volunteers will be instructed on the methods of double digging and proper usage of soil amendments.  This is a field workshop, with the first 20 minutes dedicated to explaining the reasons for and the advantages of double digging and adding appropriate soil amendments. The last 40 minutes are dedicated to hands on practice at double digging.</p>

<p>By the end of this session students will be able to:</p>
<ul>
	<li>Distinguish Top Soil from Sub-Soil</li>
	<li>Understand  the reasoning behind and advantages of Double-Digging</li>
	<li>Be able to Double-Dig a Garden Bed</li>
	<li>Identify the required amendments for good garden bed prep</li>
	<li>Use water to indicate that the finished bed is level</li>
	<li>Be aware of the basic dimensions of a standard garden bed.</li>
</ul>

<h3>Equipment, Materials, and Tools</h3>
<p>PS - Per Student; m - meter; WL - Wheelbarrow Loads</p>
Description:	Number:	Description:	Number:
<ul>
	<li>Shovel - Square	.5PS</li>
	<li>Wood Ash	1 WL</li>
	<li>Pick	.5PS</li>
	<li>Watering Can	4</li>
	<li>Large Hoe	.5PS</li>
	<li>Bucket	4 - 6</li>
	<li>Rake	.5PS</li>
	<li>Markers</li>
	<li>Wheelbarrow	2 - 3</li>
	<li>Finished Compost	2 - 4 WL</li>
	<li>Charcoal Powder	2 WL</li>
</ul>

<h3>Special Materials/Visual Aids</h3>
<ul>
	<li>Flip Chart - Basic Garden Bed Prep</li>
</ul>

<h3>Required Trainer Readings</h3>
<ul>
	<li>How to Grow more Vegetables: Chapter on Double-Digging and Bed Preparation</li>
</ul>

<h3>Trainer Preparation</h3>
<ol>
	<li>Decide whether to hold the session in the Vegetable Garden or in the Sand Box
		<ul>
			<li>IF SESSION IS BEING HELD IN THE VEGETABLE GARDEN: Designate which permanent beds will be used for the session (1 bed for every 2-4 PCTs)</li>
			<li>IF SESSION IS BEING HELD IN THE SAND BOX: Measure and mark 1 1x4m bed for every 2-4 PCTs</li>
		</ul>
	</li>
	<li>Bring Tools to training area and lay them out on designated bed spaces (1 shovel, 1 pick, 1 hoe, 1 rake, and 1 watering can per bed)</li>
	<li>Bring Compost, Charcoal Powder, and Wood Ash to Training Area</li>
	<li>Remove the first Topsoil strip and place it at the end of the bed so that you can show the PCTs the difference between topsoil and subsoil before they start the hands on portion of the training.</li>
	<li>NOTE: If soil is dry, water the training area heavily the day before the training is scheduled</li>
</ol>

<h3>Required Trainee Readings</h3>
<ul>
	<li>How to Grow more Vegetables: Chapter on Double-Digging and Bed Preparation</li>
</ul>

<h3>Lesson Plan Outline</h3>
<p>Discussion Session</p>
<ol>
	<li>Run through the basic concept of Double-Digging using the “Basic Garden Bed Prep” flip chart. (10 min)</li>
</ol>

<h3>Field Workshop</h3>
<ol>
	<li>Demonstrate the Double-Digging process on the first bed with the entire group watching  (10min)</li>
	<li>Divide the group into groups of 2 - 4 PCTs.</li>
	<li>Have groups begin to Double-Dig (20min)</li>
	<li>Once groups have Double-Dug and amended the subsoil, have them level, amend and re-level the topsoil (15min)</li>
	<li>Use watering cans to see if beds are level, if they are not, re-level them (5min)</li>
	<li>Congratulations! You are finished!</li>
</ol>

<h3>Follow-up TDAs</h3>
<ul>
	<li>PCTs will double dig and amend 3 1x3meter beds</li>
</ul>

<h3>Quiz and Final Exam Questions</h3>
<p>Quiz Questions:</p>
<ol>
	<li>Why is it important not to mix the topsoil with the subsoil when double-digging?</li>
	<li>What is the purpose of loosening the subsoil?</li>
	<li>Why is double-digging worth the extra time labor when you could just use traditional practices?</li>
</ol>

<h3>Final Exam</h3>
	<p>1 multiple choice questions & 2 short answer/practical questions</p>';
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
<p>Characteristics:</p>
<ul>
	<li>Tolerant of minor injuries - pruning, animals</li>
	<li>Fast growing</li>
	<li>Compatible with crops</li>
	<li>No competition for resources</li>
	<li>Produce useful products
		<ul>
			<li>livestock fodder</li>
			<li>green manure</li>
			<li>fuel wood</li>
			<li>erosion control</li>
		</ul>
	</li>
	<li>Protection to keep animals out
		<ul>
			<li>stiff branches</li>
			<li>thorns, spines</li>
			<li>nettles</li>
			<li>irritating latex</li>
		</ul>
	</li>
	<li>Vegetative propagation
		<ul>
			<li>Grow true to parent</li>
			<li>Very fast establishment</li>
		</ul>
	</li>
</ul>

<h3>Thorny Hedge</h3>
<ul>
	<li>Spacing: 25-50cm</li>
	<li>Maintenance:
		<ul>
			<li>Weed during establishment</li>
			<li>Prune once at desired branching height  (not target height), then annually a month or two before the rains</li>
		</ul>
	</li>
	<li>Pros:
		<ul>
			<li>Inexpensive</li>
			<li>Long life span</li>
		</ul>
	</li>
	<li>Cons:
		<ul>
			<li>Labor intensive</li>
			<li>Takes field space away from crops</li>
			<li>Takes a few years to establish</li>
		</ul>
	</li>
</ul>

<h3>Impenetrable Barrier</h3>
<ul>
	<li>Spacing: 10-20cm</li>
	<li>Maintenance:
		<ul>
			<li>Weed during establishment</li>
			<li>Prune as desired</li>
			<li>Replace holes as they occur</li>
		</ul>
	</li>
	<li>Pros
		<ul>
			<li>Fast growing</li>
			<li>Inexpensive</li>
			<li>Cuttings make replacement easy</li>
		</ul>
	</li>
	<li>Cons
		<ul>
			<li>Susceptible to rot</li>
			<li>Needs constant maintenance to ensure damage is replace or fence will be ineffective</li>
		</ul>
	</li>
</ul>

<h3>Living Fence Posts</h3>
<ul>
	<li>Spacing: 1-2m</li>
	<li>Maintenance:
		<ul>
			<li>Weed during establishment</li>
			<li>Prune to ensure straight, strong trunks</li>
		</ul>
	</li>
	<li>Pros
		<ul>
			<li>Multipurpose (poles, fodder, etc)</li>
			<li>Less labor intensive than other live fence designs</li>
		</ul>
	</li>
	<li>Cons
		<ul>
			<li>Still need barbed wire or other material to complete fence</li>
		</ul>
	</li>
</ul>

<h3>Species</h3>
<ul>
	<li>Thorny Species
		<ul>
			<li><em>Acacia spp.</em></li>
			<li><em>Prosopis juliflora</em></li>
			<li><em>Ziziphus mauritiana</em></li>
			<li><em>Bauhinia Rufescens</em></li>
		</ul>
	</li>
	<li>Unpalatable Species
		<ul>
			<li><em>Euphorbia spp.</em></li>
			<li><em>Jatropha curcas</em></li>
		</ul>
	</li>
	<li>Live Fence Post Species
		<ul>
			<li><em>Leuceana Leucocephala</em></li>
			<li><em>Moringa Oleifera</em></li>
			<li><em>Parkinsonia aculeata</em></li>
			<li><em>Azadirachta Indica</em></li>
		</ul>
	</li>
</ul>

<h3>Establishment</h3>
<ul>
	<li>Thorny Hedges:
		<ul>
			<li>Pepiniere: Allow for 3-4 trees per meter of your fence</li>
			<li>Direct seed: 1-2 seeds every 25-35cm</li>
			<li>Prune when trees reach desired branching height</li>
		</ul>
	</li>
	<li>Impenetrable Barriers
		<ul>
			<li>Pepiniere: Allow for 10 trees per meter of your fence</li>
			<li>Direct seed: 1 seed every 10cm</li>
			<li>Cuttings: 50cm-1m long, every 10cm</li>
		</ul>
	</li>
	<li>Living Fence Posts
		<ul>
			<li>Pepiniere: Allow for 1 tree every 1-2m</li>
			<li>Cuttings: For appropriate species, large cuttings of 1m</li>
		</ul>
	</li>
</ul>

<h3>Protection</h3>
<ul>
	<li>Fencing (grillage/barbed wire/sacket)
		<ul>
			<li>Most effective, but also most expensive if not already in place</li>
		</ul>
	</li>
	<li>Dead wood
		<ul>
			<li>Weave branches to create a dead wood fence around your trees</li>
		</ul>
	</li>
	<li>Thorny Branches
		<ul>
			<li>Cut branches off of pre-established thorny trees to place around new out-plants</li>
			<li>Not 100% effective, but better than no protection</li>
		</ul>
	</li>
</ul>

<h3>Pruning</h3>
<ul>
	<li>Encourage early branching low on the trunk
		<ul>
			<li>Prune terminal buds twice</li>
			<li>At the nursery stage</li>
			<li>At 25-30cm</li>
		</ul>
	</li>
	<li>Dry season
		<ul>
			<li>Once a year, a month or two before the rains to ensure heavy branching between 20 and 70cm</li>
			<li>Avoid unnecessary infections.</li>
		</ul>
	</li>
</ul>

<h3>Field Trip</h3>
<ul>
	<li>Take trainees to a local field that has at least one type of live fencing</li>
	<li>Discuss the characteristics of the fence</li>
	<li>Is it a good live fence?</li>
	<li>What are its good aspects?</li>
	<li>What has been done improperly?</li>
	<li>How can it be improved?</li>
	<li>What, if anything, should have been done differently?</li>
	<li>Are the trees properly spaced and maintained?</li>
</ul>

<h3>Quiz and Final Exam Questions</h3>
<ol>
	<li>What are the three different types of live fencing?</li>
	<li>What species can be used as live fences?</li>
	<li>When should you prune?</li>
</ol>
';
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