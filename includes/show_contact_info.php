<?php
	switch($this->language)
	{
		case "CZ":
			$lang = "L1";
		break;
		
		case "DE":
			$lang = "L3";
		break;
		
		case "EN":
			$lang = "L2";
		break;
		
		case "DU":
			$lang = "L4";
		break;	
	}
	
	$param = "contact_info_".$lang;

	$text = $this->get_others($param);
	echo $text;
?>