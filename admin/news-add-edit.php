<?php
	require('admin-security.php');
	$this->check_permission('news_add');
?>

<?php
	if(isset($_GET['id']))
	{
		echo "<h2>Upravit aktualitu</h2>";
	}
	else
	{
		echo "<h2>Pøidat aktualitu</h2>";
	}

?>

<form method="POST" action='news-update-script.php'>

<?php

$this->tiny_mce_settings_simple();

if(!isset($_GET['id']))
{
	$this->add_text_area('aktualita','aktualita','Text aktuality','', 30, 10);
	$this->add_hidden_input('akce', 'add');
}
else
{
	$id = $_GET['id'];
	$query = new db_dotaz("SELECT text FROM aktuality WHERE id = ".$id."");
	$query->proved_dotaz();
	$text = $query->get_vysledek();
	//$text = $text['text'];
	$this->add_text_area('aktualita','aktualita','Text aktuality',$text['text'], 30, 10);
	$this->add_hidden_input('id', $id);
	$this->add_hidden_input('akce', 'edit');
}
echo "<br />";
$this->add_submit_button('Uložit');
?>

</form>