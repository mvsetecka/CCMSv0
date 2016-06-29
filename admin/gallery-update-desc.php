<?php
	require('admin-security.php');
	$this->check_permission('photogallery_edit');
?>

<?php
	$this->tiny_mce_settings_simple();
	$galerie['id'] = $_GET['gid'];
	$query = new db_dotaz("SELECT * FROM galerie WHERE url = '".$galerie['id']."' LIMIT 1");
	$query->proved_dotaz();
	$zaznam = $query->get_vysledek();
	$query = NULL;
	echo "<form method='POST' action='gallery-update-desc-script.php'>";
		$this->add_text_area('gal_desc', 'gal_desc', "Struèný popis obsahu galerie",$zaznam['popis'], 50, 15,'');
		$this->add_hidden_input('gid', $galerie['id']);
		$this->add_submit_button('Uložit');
	echo "</form>";
	echo "<p><a href='index.php?action=zobrazit-galerii&gid=".$galerie['id']."'>Zpìt na stránku galerie</a></p>";
?>