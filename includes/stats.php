<?php
	$datum = date("Ymd");
	$cas = date("His");
	$ip = $_SERVER['REMOTE_ADDR'];
	$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
	$pid = $this->obsah_stats;
	$browser = $_SERVER['HTTP_USER_AGENT'];
	$os = 1;
	$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	$zapis_statistiky = new db_dotaz("INSERT INTO stats SET datum = ".$datum.", cas = '".$cas."', ip = '".$ip."', referrer = '".$referrer."', pid = '".$pid."', hostname = '".$hostname."'");
	$zapis_statistiky->proved_dotaz();
	$zapis_statistiky = NULL;
	//$query = "INSERT INTO stats VALUES datum = ".$datum.", cas = '".$cas."', ip = '".$ip."', referrer = '".$referrer."', pid = '".$pid."'";
	//echo $query;
		
?>