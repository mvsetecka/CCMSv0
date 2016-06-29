<?php
	
	if($this->get_settings('gallery_default')=='0')
	{	
		if(isset($_GET['gallery_id']))
		{
			include_once('includes/gallery_show.php');
		}
		else
		{
			include_once('includes/gallery_list.php');
		}
	}
	else
	{
		include_once('includes/gallery_show.php');
	}
?>