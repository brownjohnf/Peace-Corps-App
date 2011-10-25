<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>


		<!-- This clearing element should immediately follow the #content div in order to force the #main_inner div to contain all child floats -->
		<br class="clearfloat" />
		<?php
			//$browser = get_browser(null, true);
			//print_r($browser);
			echo $_SERVER['HTTP_USER_AGENT'];
		?>
		<!-- clearing element, keeps the footer pushed down to the bottom, and ensures that the images on top of it keep clear of the page content. -->
		<div id="bottom_of_page">
		</div>
		<!-- end #bottom_of_page -->
		
		<!-- close #main_inner -->
	</div>
	
	<!-- close #main_outer -->
</div>