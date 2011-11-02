<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>
			<div id="bottom_of_page"></div>
		</div><!-- end #outer_container -->
			<div id="footer_outer">
				<div id="footer_upper">
					<div id="footer_upper_inner">
						<?php if ($this->uri->segment(2) == 'splash'): ?>
						<!--<img id="baskets" src="<?php echo base_url(); ?>img/baskets.png" />
						<img id="baobab" src="<?php echo base_url(); ?>img/baobab.png" />-->
						<?php endif; ?>
						<img id="watermark" src="<?php echo base_url(); ?>img/pc_logo_watermark.png" />
						
						<div id="google_search" name="google_search"><!-- Google search -->
							<form method="get" action="http://www.google.com/search">
								<input type="hidden" name="ie" value="UTF-8" />
								<input type="hidden" name="oe" value="UTF-8" />
								<input type="hidden" name="domains" value="http://pcsenegal.org" />
								<input type="hidden" name="sitesearch" value="http://pcsenegal.org" checked />
								<!--<input type="submit" name="btnG" value="Google Search" height="50px" />-->
								<input type="text" name="q" maxlength="200" value="Search pcsenegal.org using Google Search" />
							</form>
						</div><!--END Search Google -->
						
						<ul>
							<h4>Pages</h4>
							<li>Recently Added</li>
							<li><?php echo anchor('feed/page', 'Recently Updated'); ?></li>
							<li>Most Popular</li>
							<li>Site Map</li>
						</ul>
						<ul>
							<h4>Blogs</h4>
							<li>View by Region</li>
							<li>View by Sector</li>
							<li>Most Popular</li>
							<li><?php echo anchor('feed/blog', 'Recently Updated'); ?></li>
						</ul>
						<ul>
							<h4>Modules</h4>
							<li>View By Sector</li>
							<li>View by Curriculum</li>
							<li>Recently Added</li>
							<li>Recently Updated</li>
							<li>Search</li>
						</ul>
						<ul class="ie_last">
							<h4>Profiles & Photos</h4>
							<li>Search</li>
							<li><?php echo anchor('photo/gallery', 'All Photos'); ?></li>
							<li>Photo Albums</li>
							<li>Browse Profiles</li>
						</ul>
						<br class="clearfloat" />
					</div><!-- END footer_upper_inner -->
				</div><!-- END footer_upper -->
				<div id="footer_lower">
					<div id="footer_lower_inner">
						<div id="legal">
							<?php echo anchor('disclaimer', 'Disclaimer').anchor('privacy', 'Privacy Policy').anchor('support', 'Support').anchor('security', 'Security').anchor('about', 'About'); if ( $this->fb_data['uid'] || $this->fb_data['me']): echo anchor($this->fb_data['logoutUrl'], 'Log Out'); endif; ?>
							<br />Content &copy;2011 Peace Corps Senegal. Design &copy;2011 John F. Brown. Icons courtesy of Neurovit.
						</div>
						<div id="powered">
							Powered by <a href="http://php.net" target="_blank">PHP</a>, <a href="http://mysql.com" target="_blank">MySQL</a>, <a href="http://jquery.com" target="_blank">jQuery</a>. Built on <a href="http://codeigniter.com" target="_blank">Codeigniter Framework</a>.
						</div>
						<br class="clearfloat" />
					</div><!-- END footer_lower_inner -->
				</div><!-- END footer_lower -->
			</div><!-- end #footer_outer -->
</body>
</html>