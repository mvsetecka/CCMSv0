<?php

if(!file_exists('../includes/config.php') && !file_exists('../install/index.php'))
{
    die("Závažná chyba systému, nelze pokraèovat!");
}


if(!file_exists('../includes/config.php'))
{
    header('"Location: ../install/index.php"');
}

include 'session.php';
include './../includes/config.php';
include './../includes/functions.php';
include 'admin-functions.php';

$login_page = new stranka_admin;

if (!empty($_POST['login_name']))
{
	$login_name = $_POST['login_name'];
	$login_password = $_POST['login_password'];
	
		$password_db = $login_page->get_settings('admin_pass_md5');
		if($login_name=='admin' && (md5($login_password)==$password_db))
		{
			$_SESSION['logged']=1;
			$_SESSION['user']='admin';
			HEADER("Location: index.php");
			exit(0);
		}
		
		$uzivatel = new db_dotaz("SELECT username, password FROM uzivatele WHERE username = '".$login_name."' LIMIT 1");
		$uzivatel->proved_dotaz();
		$zaznam = $uzivatel->get_vysledek();
		if($uzivatel->pocet_vysledku()==1 && md5($login_password)==$zaznam['password'])
		{
			if(md5($login_password)==$zaznam['password'])
			{
				$_SESSION['logged']=1;
				$_SESSION['user']=$zaznam['username'];
				$uzivatel = new db_dotaz("UPDATE uzivatele SET last_login = '".time()."'");
				$uzivatel->proved_dotaz();
				$uzivatel = NULL;
				HEADER("Location: index.php");
			}
		}
		else
		{
			$error_text =  "<div id='hlaseni'><strong>Heslo nebo jméno nesouhlasí, vaše IP adresa byla uložena do DB!</strong></div>";
			$datum = date("Ymd");
			$cas = date("His");
			$ip = $_SERVER['REMOTE_ADDR'];
			$remote_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$referrer = $_SERVER['HTTP_REFERER'];
			$stats_login = new db_dotaz("INSERT INTO stats_login SET datum = ".$datum.", cas = '".$cas."', ip = '".$ip."', remote_name = '".$remote_name."', referrer = '".$referrer."', ent_name = '".$login_name."', ent_pass = '".$login_password."' ");
			$stats_login->proved_dotaz();
			$stats_login = NULL;
		}
	
}
elseif((!empty($_POST)) && isset($_POST['login_name']))
	{
	echo "<div id='hlaseni'><strong>Musíte zadat uživatelské jméno!</strong></div>";
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs">

	<head>
    	<meta http-equiv="content-type" content="text/html; charset=windows-1250" />
    	<meta http-equiv="content-language" content="cs" />
    	<link rel="stylesheet" href="CSS/stylesheet-login.css" media="screen" type="text/css" />
		<title>Pøihlášení do administrace</title>
	</head>
	<body>
	<div id="header">
		<h1>Pøihlášení do administrace</h1>
	</div>
	<?php
		echo isset($error_text) ? $error_text : NULL;
	?>
	<div id="content">
		<img src="CSS/computer.png" style="width: 100px;" />
		<br />
		<br />
		<fieldset class="content-fieldset">
			<form method="POST" action= <?php echo($_SERVER["PHP_SELF"]); ?> >
			<div>
				<label for="name" class="text_label"></label><br />
				<img src="CSS/user_suit.png" />
				<input type="text" name="login_name" id="name" class="text">
			</div>
			
			<br />
			
			<div>
				<label for="password" class="text_label"></label><br />
				<img src="CSS/key.png" />
				<input type="password" name="login_password" id="password" class="text">
			</div><br />
			
			<input style="border: 1px solid black;" type="Submit" value="Pøihlásit">
			</form>
		</fieldset>
	<div>
	</body>
</html>