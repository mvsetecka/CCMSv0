<?php
	require('admin-security.php');
?>

<?php

if($this->get_settings('web_version')=='CMS')
{
echo "<table rules='all'>";
echo "<thead>";
	echo "<tr>";
	echo "<td>Kategorie</td>";
	echo "<td>Subkategorie</td>";
	echo "<td>Typ</td>";
	echo "<td colspan='2'>Poøadí v menu</td>";
	echo "<td></td>";
	echo "</tr>";
echo "</thead>";

	$kategorie = mysql_query("SELECT * FROM menu_kategorie ORDER BY pozice asc",$GLOBALS['database'])or die(mysql_error());
	while ($zaznam=mysql_fetch_array($kategorie)):
		echo "<tr>";
			echo "<td>".$zaznam['nazev']."</td>";
			echo "<td>";
			echo "<a href='index.php?action=pridat-kategorii&param=sub&param2=".$zaznam['URL']."'>Nová...</a>";
			echo "</td>";
			echo "<td></td>";
			if ($zaznam['pozice']>1){
			echo "<td class='center'><a href='category-move-script.php?type=cat&action=up&id=".$zaznam['URL']."'><img src='includes/images/orange_up.gif' /></a></td>";
		}else{
		 	echo "<td></td>";
		}
		
		$posledni_pozice = $this->get_last_cat_position();
		if ($zaznam['pozice']!==$posledni_pozice){
		echo "<td class='center'><a href='category-move-script.php?type=cat&action=down&id=".$zaznam['URL']."'><img src='includes/images/orange_down.gif' /></a></td>";
		}else{
			echo "<td></td>";
		}
		
		echo "<td><a href='category-delete.php?type=main&id=".$zaznam['URL']."' onClick=\"return confirm('Opravdu chcete tuto kategorii odstranit (vèetnì èlánkù, textù a podkategorií)?')\">Smazat</a><br />";
		echo "<a href='index.php?action=update-menu-categories&param1=".$zaznam['URL']."&param2=main' >Upravit</a></td>";
	echo "</tr>";

$sql_query = ("SELECT * FROM menu_subkategorie WHERE parent_url= '".$zaznam['URL']."' AND zobrazovat='ano' ORDER BY pozice asc");
$subkategorie = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
while ($subzaznam=mysql_fetch_array($subkategorie)):
	echo "<tr>";
		echo "<td></td>";
		echo "<td>".$subzaznam['nazev']."</td>";
		echo "<td>";
			switch($subzaznam['typ']){
				case "list":
					echo "Kategorie";
				break;
				case "text":
					echo "Text";
				break;
			}
		echo "</td>";
		
		if ($subzaznam['pozice']>1){
		echo "<td class='center'><a href='category-move-script.php?type=subcat&action=up&id=".$subzaznam['url']."&parent_id=".$zaznam['URL']."'><img src='includes/images/blue_up.gif' /></a></td>";
		}else{
		 	echo "<td></td>";
		}
		
		$posledni_pozice = $this->get_last_subcat_position($subzaznam['parent']);
		if ($subzaznam['pozice']!==$posledni_pozice){
			echo "<td class='center'><a href='category-move-script.php?type=subcat&action=down&id=".$subzaznam['url']."&parent_id=".$zaznam['URL']."'><img src='includes/images/blue_down.gif' /></a></td>";
		}else{
			echo "<td></td>";
		}
		
		echo "<td>";
			switch($subzaznam['typ']){
				case "list":
					echo "<a href='category-delete.php?type=sub&id=".$subzaznam['url']."' onClick=\"return confirm('Opravdu chcete tuto kategorii odstranit (vèetnì èlánkù a textù)?')\">Smazat</a><br />";
					echo "<a href='index.php?action=update-menu-categories&param1=".$subzaznam['url']."&param2=sub' >Upravit</a>";
				break;
				
				case "text":
					echo "<a href='text-delete.php?id=".$subzaznam['url']."&parent=".$zaznam['nazev']."' onClick=\"return confirm('Opravdu chcete tento text odstranit?')\">Smazat</a><br />";
					echo "<a href='index.php&action=uprav-text&param1=".$subzaznam['url']."'>Upravit</a>";
				break;
			}
		echo "</td>";
	echo "</tr>";
endwhile;	
endwhile;
echo "</table>";

	echo "<a href='index.php?action=pridat-kategorii&param=main'>Pøidat hlavní kategorii</a><br />";
}
else
{
	require_once('category-show-simple.php');
}
?>