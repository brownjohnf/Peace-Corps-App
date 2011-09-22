<?php if (isset($studies)): foreach ($studies as $study): ?>
	<h2><?php echo $study['title']; ?></h2>
	<p><u><?php echo $study['id'].'</u>&nbsp;'.anchor('admin/case_study/view/'.$study['id'], 'View').'&nbsp;'.anchor('admin/case_study/delete/'.$study['id'], 'Delete').'&nbsp;'.anchor('admin/case_study/update/'.$study['id'], 'Update'); ?><br />
	<?php echo $study['description']; ?></p>

	<?php endforeach; else: ?>

    <h2>No posts found</h2>
 
<?php endif; ?>
<div style="text-align: center;"><?=$pagination?></div>