	<h1><?=$title?></h1>
	<p><u><?php echo $id.'</u>&nbsp;'.anchor('admin/case_study/delete/'.$id, 'Delete').'&nbsp;'.anchor('admin/case_study/update/'.$id, 'Update'); ?><br />
	<?=$description?></p>
	<?=$content?>
