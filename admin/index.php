<?php
	define('INCLUDED',1);
	include('./../includes/config.php');
	include('./../includes/functions.php');
	include('admin-functions.php');
	include('session.php');
	if ($_SESSION['logged']!==1)header("Location:login.php");
	$administrace = new stranka_admin;
	$administrace->get_admin_html_header();
?>

	<div id="header"><?php $administrace->get_admin_header() ?></div>
	<div id="dropdown"><?php $administrace->get_admin_menu() ?></div>
	<div id="content-box">
		<!--  <div id="navlinks"></div> -->
		<div id="content"><?php $administrace->get_admin_content() ?></div>
	</div>
	</div>
	<div id="footer"></div>
  
	</body>
	</html>