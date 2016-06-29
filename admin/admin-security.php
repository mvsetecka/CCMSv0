<?php

if(INCLUDED!==1)
{
	include 'session.php';
	if ($_SESSION['logged']!==1)
	{
		header("Location:login.php");	
	}
	else
	{
		echo "Nemáte oprávnìní!";
	}
exit;
}

?>