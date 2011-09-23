<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

		<div style="background-color: black;">
			<div style="margin: 0 auto; width: 980px;">
				<div id="s3slider">
					<ul id="s3sliderContent">
						<?php foreach ($slides as $slide): ?>
						<li class="s3sliderImage">
							<a href="<?php echo $slide['path']; ?>"><img src="<?php echo base_url().'img/'.$slide['img']; ?>" alt="1" width="980px" height="250px" /></a>
							<span class="<?php echo $slide['position']; ?>"><a href="<?php echo $slide['path']; ?>"><strong><?php echo $slide['title']; ?></strong><br /><?php echo $slide['caption']; ?></a></span>
						</li>
						<?php endforeach; ?>
						<div class="clear s3sliderImage"></div>
					</ul>
				</div>
			</div>
		</div>