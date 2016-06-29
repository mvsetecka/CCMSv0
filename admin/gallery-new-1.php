<?php
	require('admin-security.php');
?>

<?php
		$this->tiny_mce_settings_simple();
		echo "<h2>Vytvoøit novou fotogalerii - Krok 1/3</h2>";
		echo "<form method='post' action='".$_SERVER["PHP_SELF"]."?".$_SERVER['QUERY_STRING']."'>";
		$this->add_text_input('galerie_nazev', 'nazev', "Název galerie",'', 50, 100);
		echo "<br />";
		$this->add_text_area('galerie_popis', 'popis', "Struèný popis obsahu galerie",'', 50, 15,'');
		$this->add_hidden_input("krok","1");
		echo "<br />";
		$this->add_submit_button("Pokraèovat");
		echo "</form>";
?>