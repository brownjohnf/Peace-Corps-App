<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

		</div><!-- end #outer_container -->
			<div id="footer_outer">
				<div id="footer_inner">
					<img src="<?php echo base_url(); ?>img/baobab.png" id="baobab" />
					<div id="google_search"><!-- Google search -->
						<form method="get" action="http://www.google.com/search">
							<input type="hidden" name="ie" value="UTF-8" />
							<input type="hidden" name="oe" value="UTF-8" />
							<input type="hidden" name="domains" value="http://pcsenegal.org" />
							<input type="hidden" name="sitesearch" value="http://pcsenegal.org" checked />
							<div>
							<!--<input type="submit" name="btnG" value="Google Search" height="50px" />-->
							<input type="text" name="q" maxlength="200" value="Search pcsenegal.org using Google Search" />
							<br class="clearfloat"/>
							</div>
						</form>
					</div><!--END Search Google -->
					
					<div class="footer_column">Icons courtesy of Neurovit.</div>
					<div class="footer_column">&nbsp;</div>
					<div class="footer_column"><?php echo '<h2>Browse</h2>'.$this->page_class->menu(); ?></div>
					
					
					<div style="clear:both;">
						All content and design protected under Creative Commons Copyright. &copy;2011 Peace Corps Senegal.<br><br>The contents of this web site do not reflect in any way the positions of the U.S. Government or the United States Peace Corps. This web site is managed and supported by Peace Corps Senegal Volunteers and our supporters. It is not a U.S. Government web site.
					</div>
				</div><!-- END footer_inner -->
			</div><!-- end #footer -->
</body>
</html>