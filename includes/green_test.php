<?php
	if(INCLUDED<>1)
	{
		echo "Nem�te opr�vn�n�!";
		exit;
	}
	else
	{
		if(!file_exists('includes/config.php'))
		{
			header("Location: install/index.php");
		}
		if(file_exists('install/index.php') OR file_exists('install/install-script.php'))
		{
			echo('Sma�te adres�� \install');
			exit;
		}
	}
?>