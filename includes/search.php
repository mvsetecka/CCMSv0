<?php
	if($_POST['hledane_slovo']=="")
	{
		echo "<h2>Nezadali jste žádné slovo</h3>";
	}
	elseif(strlen($_POST['hledane_slovo'])<3)
	{
		echo "<h2>Mùžete hledat pouze slovo delší než 3 znaky</h3>";
	}
	else
	{
	$hledane_slovo = $_POST['hledane_slovo'];
	echo "<h2>Výsledky hledání slova: ".$hledane_slovo."</h2>";
	$sql_query1 = ("SELECT * FROM clanky WHERE (titulek regexp '".$hledane_slovo."' or text regexp '.".$hledane_slovo.".' or strucne regexp '.".$hledane_slovo.".') and zobrazovat='ano'");
	$sql_query2 = ("SELECT * FROM texty WHERE (titulek regexp '".$hledane_slovo."' or text regexp '.".$hledane_slovo.".') and zobrazovat='ano'");
	$clanky = new db_dotaz($sql_query1);
	$clanky->proved_dotaz();
	$texty = new db_dotaz($sql_query2);
	$texty->proved_dotaz();
	$radku=$clanky->pocet_vysledku() + $texty->pocet_vysledku();
	if($radku==1){$zaznam="záznamu";}else{$zaznam="záznamech";}
	echo "<p>Hledané slovo se nachází v ".$radku." ".$zaznam."...</p>";
	echo "<p>";
	while ($zaznam=$clanky->get_vysledek()):
			echo "<h3><a href=".$this->root."/".$this->friendly_url($zaznam['subkategorie'])."/".$zaznam['id'].".html>".$zaznam['titulek']."</a></h3>";
	endwhile;
		while ($zaznam=$texty->get_vysledek()):
			echo "<h3><a href=".$this->root."/".$zaznam['id'].".html>".$zaznam['titulek']."</a></h3>";
	endwhile;
	$clanky = NULL;
	$texty = NULL;
	echo "</p>";
	}
?>