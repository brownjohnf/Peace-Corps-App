<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

		<?php
			$splash = array(
							array(
								  'visual' => '<iframe width="658" height="390" src="http://www.youtube.com/embed/0ad-aaaVZ-E?rel=0&wmode=Opaque" frameborder="0" allowfullscreen></iframe>',
								  'width' => '658px',
								  'title' => 'Kolda Ag Fair A Success!',
								  'text' => "Peace Corps Senegal organized and executed an agricultural fair in the southern regional capital of Kolda. Combining elements of a farmers market with a food transformation expo, it attracted many local agricultural producers and buyers.",
								  'link' => anchor('http://youtube.com/user/pcsenegaladmin', 'Visit our YouTube Channel >', array('target' => '_blank'))
								  ),
							array(
								  'visual' => '<iframe width="658" height="390" src="http://www.youtube.com/embed/gt4VYGd178I?rel=0&wmode=Opaque" frameborder="0" allowfullscreen></iframe>',
								  'width' => '658px',
								  'title' => 'Welcome Aggies!',
								  'text' => "Peace Corps Senegal welcomes its newest agriculture stage! Over the next nine weeks, they'll learn a local language, learn about Senegalese culture, and aquire all the skills they'll need to be an effective Volunteer for the next two years.",
								  'link' => anchor('http://youtube.com/user/pcsenegaladmin', 'Visit our YouTube Channel >', array('target' => '_blank'))
								  ),
							array(
								'visual' => img(array('src' => base_url().'img/splash_1.jpg', 'width' => '658px', 'height' => '390px')),
								'width' => '658px',
								'title' => 'Photo Contest 2011',
								'text' => "Check out the winners from this year's annual Peace Corps West Africa Volunteer Contest. The photos are beautiful, and range from poignant to funny.",
								'link' => anchor('feed/page', 'See More >')
								)
							);
		?>
<!--	
		<div id="splash_container">
			<div id="slider_container">-->
				<div style="background-color:black;">
					<ul id="slider1">
						<?php foreach ($splash as $slide): ?>
						<li>
							<table>
								<tr>
								<?php if (rand() % 2): ?>
									<td class="splash_text" id="splash_text_left">
										<h1><?=$slide['title']?></h1>
										<p><?=$slide['text']?></p>
										<p><?=$slide['link']?></p>
									</td>
									<td width="<?=$slide['width']?>">
										<?=$slide['visual']?>
									</td>
								<?php else: ?>
									<td width="<?=$slide['width']?>">
										<?=$slide['visual']?>
									</td>
									<td class="splash_text" id="splash_text_right">
										<h1><?=$slide['title']?></h1>
										<p><?=$slide['text']?></p>
										<p><?=$slide['link']?></p>
									</td>
								<?php endif; ?>
								</tr>
							</table>
						</li>
						<?php endforeach; ?>
					</ul>
				</div><!--
			</div>
		</div>
		<div id="splash_content">
			<div>
				<h2>We've got a new look!</h2>
				<p>And the content to match! You'll find the new site more informative, less cluttered, and easier to navigate. Plus, log in with Facebook to receive updates about content, contact Volunteers and Staff, and more!</p>
				<p>For the best experience, make sure you're using an up-to-date, standards-compliant browser. Such browsers include Mozilla Firefox, Google Chrome, and Safari. At this point in time, we do not recommend the use of Internet Explorer.</p>
			</div>
		</div>
		<div id="splash_footer_clear">
		</div>-->
		</div> <!-- END outer container -->
		<div style="position:absolute; top:440px; left:0; width:100%;" id="test_splash">
			<div style="position:relative; margin:0 auto; width:980px; margin-top:30px;">
				<div class="first">
					<h1>Seed Distributions</h1>
					<p><img src="http://pcsenegal.com/uploads/ad8f43cf48574073b9bbf386789e9bd1_180w.JPG">Agriculture Volunteers all over the country are finally able to begin evaluating the yield returned by improved seed varieties.<br>read more --></p>
				</div>
				<div class="second">
					<h1>Malaria Boot Camp</h1>
					<p>
					<img src="http://pcsenegal.com/uploads/a737077cfc0f12c77861a184b2b84251_180w.JPG">Test paragraph 2</p>
				</div>
				<div class="third">
					<h1>Master Farmers</h1>
					<p>
					<img src="http://pcsenegal.com/uploads/ba7764d88298a2ea4d64198d535dd1c9_180w.jpg">Test paragraph 3</p>
				</div>
				<div class="clearfloat">
					
				</div>
			</div>
		</div>
	</body>
</html>