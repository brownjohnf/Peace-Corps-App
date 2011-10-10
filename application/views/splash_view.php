<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

		<?php
			$splash = array(
							array(
								  'visual' => '<iframe width="658" height="390" src="http://www.youtube.com/embed/gt4VYGd178I?rel=0&wmode=Opaque" frameborder="0" allowfullscreen></iframe>',
								  'width' => '658px',
								  'title' => 'Welcome Aggies!',
								  'text' => "Peace Corps Senegal welcomes its newest agriculture stage! Over the next nine weeks, they'll learn a local language, learn about Senegalese culture, and aquire all the skills they'll need to be an effective Volunteer over the next two years.",
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
		
		<div id="splash_container">
			<div id="slider_container">
				<div id="slider">
					<ul id="slider1">
						<?php foreach ($splash as $slide): ?>
						<li>
							<table>
								<tr>
								<?php if (rand() % 2): ?>
									<td style="color: #fff; padding: 12px 12px 12px 0px; margin: 0px;">
										<h1><?=$slide['title']?></h1>
										<p style="text-align: justify;"><?=$slide['text']?></p>
										<p><?=$slide['link']?></p>
									</td>
									<td width="<?=$slide['width']?>">
										<?=$slide['visual']?>
									</td>
								<?php else: ?>
									<td width="<?=$slide['width']?>">
										<?=$slide['visual']?>
									</td>
									<td style="color: #fff; padding: 12px 0 12px 12px; margin: 0;">
										<h1><?=$slide['title']?></h1>
										<p style="text-align: justify;"><?=$slide['text']?></p>
										<p><?=$slide['link']?></p>
									</td>
								<?php endif; ?>
								</tr>
							</table>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
			<div id="splash_footer">
				<div>
					<?=$col1?>
				</div>
				<div>
					<?=$col2?>
				</div>
				<div>
					<?=$col3?>
				</div>
			</div>
		</div>
	</body>
</html>