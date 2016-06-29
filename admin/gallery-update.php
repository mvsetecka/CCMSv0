<?php
	require('admin-security.php');
	$this->check_permission('photogallery_edit');
?>

<?php
	$w = $_GET['w'];
	switch($w)
	{
		case "gal_desc":
			include_once('gallery-update-desc.php');
		break;
		
		case "img_desc":
			include_once('gallery-update-img-desc.php');
		break;
		
		case "add_img":
			include_once('gallery-add-img.php');
		break;
		
	}
?>