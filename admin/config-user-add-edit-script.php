<?php
	include './../includes/config.php';
	include './../includes/functions.php';
	include 'session.php';
	include 'admin-functions.php';
	if ($_SESSION['logged']!==1)header("Location:login.php");

	
	if($_POST['do']=='edit')
	{
		$query = "UPDATE uzivatele SET
		username = '".$_POST['username']."',
		jmeno_prijmeni = '".$_POST['jmeno']."',
		text_add = '".$_POST['text_add']."',
		text_edit = '".$_POST['text_edit']."',
		article_add = '".$_POST['article_add']."',
		article_edit = '".$_POST['article_edit']."',
		news_add = '".$_POST['news_add']."',
		guestbook_edit = '".$_POST['guestbook_edit']."',
		comments_edit = '".$_POST['comments_edit']."',
		filemanager = '".$_POST['filemanager']."',
		filemanager_mkdir = '".$_POST['filemanager_mkdir']."',
		filemanager_rmdir = '".$_POST['filemanager_rmdir']."',
		filemanager_delete_file = '".$_POST['filemanager_delete_file']."',
		photogallery_create = '".$_POST['photogallery_create']."',
		photogallery_edit = '".$_POST['photogallery_edit']."',
		category_edit = '".$_POST['category_edit']."',
		opinion_poll = '".$_POST['opinion_poll']."'
		WHERE username = '".$_POST['uname_old']."'";
	$sql_query = new db_dotaz($query);
	$sql_query->proved_dotaz();
	//echo $query;
	$sql_query = NULL;
	}
	else
	{
		if(isset($_POST['jmeno'])&&isset($_POST['username'])&&isset($_POST['password']))
		{
		$query = "INSERT INTO uzivatele VALUES ('".$_POST['username']."','".md5($_POST['password'])."', ".time().", ".time().", '".$_POST['jmeno']."', '', '".$_POST['text_add']."', '".$_POST['text_edit']."', '".$_POST['article_add']."', '".$_POST['article_edit']."', '".$_POST['news_add']."', '".$_POST['guestbook_edit']."', '".$_POST['comments_edit']."', '".$_POST['filemanager']."', '".$_POST['filemanager_mkdir']."', '".$_POST['filemanager_rmdir']."', '".$_POST['filemanager_delete_file']."', '".$_POST['photogallery_create']."', '".$_POST['photogallery_edit']."', '".$_POST['category_edit']."', '".$_POST['opinion_poll']."')";
		//echo "<strong>".$query."</strong>";
		$sql_query = new db_dotaz($query);
		$sql_query->proved_dotaz();
		$sql_query = NULL;
		}
	}
	Header("Location: index.php?action=config_users");
?>