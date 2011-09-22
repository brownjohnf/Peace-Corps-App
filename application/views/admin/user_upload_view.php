<h1>Upload CSV Users File</h1>
<?php echo $error;?>

<?php echo form_open_multipart('admin/user/upload_user');?>

	<input type="file" name="userfile" size="20" />

	<br /><br />

	<input type="submit" value="Add Users" />

</form>

<h2>Instructions</h2>
<p>This is for uploading files of users in .csv, or comma-separatad value, format. Files must meet the following requirements:</p>
<ul>
	<li>Column headers must be in the first row</li>
	<li>User information must include ID#, email, first and last names, and project.</li>
	<li>Edit the array in application/models/people_model.php, part of the addUser() function, to reflect your column names.</li>
	<li>Any questions, ask Jack (jfbrown.wa@gmail.com)</li>
</ul>