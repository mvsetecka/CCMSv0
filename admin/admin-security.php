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
		echo "Nem�te opr�vn�n�!";
	}
exit;
}

?>