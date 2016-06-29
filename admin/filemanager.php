<?php
	require('admin-security.php');

	if(isset($_POST['upload_files']) && $_POST['upload_files']=="flexupload")
	{
		require('filemanager-flexupload.php');
	}
	else
	{
		require('filemanager-browser.php');
	}
?>
