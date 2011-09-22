<?php
class Blog extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->defaultview_tags['navpath'][] = anchor('blog','Blogs');
		
		$this->defaultview_tags['leftmenu'] = array(
													'Country Director' => array(
																		  anchor('','Chris Hedrick')
																		  ),
													'Program Directors' => array(
																				 anchor('','Mamadou Diaw (Health)'),
																				 anchor('','Famara Massaly (Agriculture)'),
																				 anchor('','Demba Sidibe (Agroforestry)'),
																				 anchor('','Amar Sall (Business)')
																				 ),
													'&nbsp;' => array(
																	  anchor('','Volunteer Blogs'),
																	  anchor('','Regional Blogs')
																	  ), 
													);
	}

	public function index()
	{	
		$this->headview_tags['page_title'] = 'Blogs';
		
		$this->defaultview_tags['content'] = "<h1>Peace Corps Senegal Blogs</h1><p>We encourage both Volunteers and staff to maintain blogs, and following them can be a great way to stay up to date on what's going here at Peace Corps Senegal, whether you're in a small village or America.</p>";
		
		$this->load->view('headview', $this->headview_tags);
		$this->load->view('defaultview', $this->defaultview_tags);
		$this->load->view('footview', $this->footview_tags);
	}

	public function blog()
	{
		
		$this->headview_tags['page_title'] = 'Blogs > '.$this->uri->segment(3, 'All');
		
		$this->defaultview_tags['content'] = "Someone's blog here.";
		$this->defaultview_tags['navpath'][] = anchor('blog/','someones blog');
		$this->defaultview_tags['rightmenu'] = array(
													'Quick Links' => array(
																		   anchor('','Bio')
																		   )
													);
		
		$this->load->view('headview', $this->headview_tags);
		$this->load->view('defaultview', $this->defaultview_tags);
		$this->load->view('footview', $this->footview_tags);
	}

	public function email() {
		
		$this->load->library('typography');
		
		/* send an email  
		$this->load->library('email');  
		$this->email->from('pcsenegaladmin@gmail.com','PCSenegal');  
		$this->email->to("jfbrown.wa@gmail.com");  
		$this->email->subject('A test email from CodeIgniter using Gmail');  
		$this->email->message("I can now email from CodeIgniter using Gmail as my server!");  
		$this->email->send();  */
		
		
		
		
	/* connect to gmail */
$hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
$username = 'pcsenegaladmin@gmail.com';
$password = 'Pe3ceC04ps';

/* try to connect */
$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());

/* grab emails */
$emails = imap_search($inbox,'SUBJECT "BLOG-POST"');

/* if emails are returned, cycle through each... */
if($emails) {
	
	/* begin output var */
	$output = '';
	
	/* put the newest emails on top */
	rsort($emails);
	
	/* for every email... */
	foreach($emails as $email_number) {
		
		/* get information specific to this email */
		$overview = imap_fetch_overview($inbox,$email_number,0);
		$message = imap_fetchbody($inbox,$email_number,2);
		
		/* output the email header information */
		$output.= '<p class="toggler '.($overview[0]->seen ? 'read' : 'unread').'">';
		$output.= '<span class="subject">'.$overview[0]->subject.'</span> ';
		$output.= '<span class="from">'.$overview[0]->from.'</span>';
		$output.= '<span class="date">on '.$overview[0]->date.'</span>';
		$output.= '</p>';
		
		/* output the email body */
		$output.= '<p>'.$message.'</p>';
	}
	
	$this->defaultview_tags['content'] = nl2br($output);
	
	//echo $this->typography->auto_typography($output);
	$this->load->view('headview',$this->headview_tags);
	$this->load->view('defaultview',$this->defaultview_tags);
	$this->load->view('footview',$this->footview_tags);
} 

/* close the connection */
imap_close($inbox);
	}
	
	
}
?>