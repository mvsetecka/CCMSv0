<?php
	require('admin-security.php');
	$this->check_permission('photogallery_edit');

	$this->tiny_mce_settings_simple();
    
	$img['gid'] = $_GET['gid'];
	$img['name'] = $_GET['pid'];
	
	$query = new db_dotaz("SELECT * FROM galerie_obrazky WHERE slozka = '".$img['gid']."' AND soubor = '".$img['name']."' LIMIT 1");
	$query->proved_dotaz();
	$zaznam = $query->get_vysledek();
	$query = NULL;
	
	echo "<img src='../gallery/".$img['gid']."/thumbs/".$img['name']."' />";
	echo "<br />";
	echo "<form method='POST' action='gallery-update-img-desc-script.php'>";
		$this->add_text_area('img_desc', 'img_desc', "Stru�n� popis fotografie",$zaznam['popis'], 53, 5,'');
		$this->add_hidden_input('gid', $img['gid']);
		$this->add_hidden_input('pid', $img['name']);
		$this->add_submit_button('Ulo�it');
	echo "</form>";
	echo "<p><a href='index.php?action=zobrazit-galerii&gid=".$img['gid']."'>Zp�t na str�nku galerie</a></p>";
?>