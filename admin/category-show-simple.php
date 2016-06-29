<?php
	require('admin-security.php');
?>

<?php
echo "<h2>Nastavení navigaèního menu</h2>";

echo "<table class='admin_tabulka' cellspacing=1>";
echo "<thead>";
	echo "<tr>";
	echo "<td>Položka</td>";
	echo "<td colspan='2'>Poøadí v menu</td>";
	echo "<td>Typ</td>";
	echo "<td>Akce</td>";
	echo "</tr>";
echo "</thead>";

$sql_query = ("SELECT * FROM menu_subkategorie WHERE parent_url= 'simple' AND zobrazovat='ano' ORDER BY pozice asc");
$subkategorie = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
while ($subzaznam=mysql_fetch_array($subkategorie)):
	echo "<tr>";
		echo "<td>".$subzaznam['nazev']."</td>";
			
		if ($subzaznam['pozice']>1){
		echo "<td class='center'><a href='category-move-script.php?type=subcat&action=up&id=".$subzaznam['url']."&parent_id=simple'><img src='includes/images/blue_up.gif' style='border:none;' /></a></td>";
		}else{
		 	echo "<td class='center'>-</td>";
		}
		
		$posledni_pozice = $this->get_last_subcat_position('simple');
		if ($subzaznam['pozice']!==$posledni_pozice){
			echo "<td class='center'><a href='category-move-script.php?type=subcat&action=down&id=".$subzaznam['url']."&parent_id=simple'><img src='includes/images/blue_down.gif' style='border:none;' /></a></td>";
		}else{
			echo "<td class='center'>-</td>";
		}
		
		echo "<td class='center'>";
			switch($subzaznam['typ'])
			{
				case "list":
					echo "Kategorie";
				break;
				case "text":
					echo "Text";
				break;
			}
		echo "</td>";
		
		echo "<td class='center'>";
		if($this->check_permission('category_edit',TRUE))
		{
			switch($subzaznam['typ']){
				case "list":
					echo "<a href='category-delete.php?type=sub&id=".$subzaznam['url']."' onClick=\"return confirm('Opravdu chcete tuto kategorii odstranit (vèetnì èlánkù a textù)?')\">Smazat</a><br />";
					echo "<a href='index.php?action=update-menu-categories&param1=".$subzaznam['url']."&param2=sub'>Upravit</a>";
				break;
				
				case "text":
					//echo "<a href='text-delete.php?id=".$subzaznam['url']."&parent=".$zaznam['nazev']."' onClick=\"return confirm('Opravdu chcete tento text odstranit?')\">Smazat</a><br />";
					echo "<a href='text-delete.php?id=".$subzaznam['url']."' onClick=\"return confirm('Opravdu chcete tento text odstranit?')\">Smazat</a><br />";
                    echo "<a href='index.php?action=uprav-text&param1=".$subzaznam['url']."'>Upravit</a>";
				break;
				
				case "separator":
					echo "<a href='category-delete.php?type=separator&id=".$subzaznam['url']."' onClick=\"return confirm('Opravdu chcete tuto kategorii odstranit (vèetnì èlánkù a textù)?')\">Smazat</a><br />";
				break;
			}
		}
		echo "</td>";
	echo "</tr>";
endwhile;	
echo "</table>";
if($this->check_permission('category_edit',TRUE))
{
	echo "<a href='category-add-script.php?type=separator'>Pøidat oddìlovaè</a><br />";	
}
?>