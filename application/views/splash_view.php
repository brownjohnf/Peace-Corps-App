<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

		<div id="slider_container">
			<ul id="slider1">
				<?php foreach ($splash as $slide): ?>
				<li>
					<table>
						<tr>
						<?php if (true)://(rand() % 2): ?>
							<td class="splash_text" id="splash_text_left">
								<h1><?=$slide['title']?></h1>
								<p><?=$slide['text']?></p>
								<p><?=$slide['link']?><span style="color:darkred;">&nbsp;&gt;&nbsp;&gt;</span></p>
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
		</div>
		&nbsp;
	</body>
</html>