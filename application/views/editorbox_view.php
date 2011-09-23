<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.
?>

					<p style="padding: 10px 0; margin: 0;">
					<?php if (isset($editors)): ?>
						Editors:&nbsp;
						<?php foreach ($editors as $editor): ?>
						<?php echo $editor; ?>&nbsp;&nbsp;
						<?php endforeach; ?>

					<?php endif; ?>
						You are an editor.&nbsp;
						<?php foreach ($options as $option): ?>
						<?php echo $option; ?>&nbsp;&nbsp;
						<?php endforeach; ?>
					</p>
