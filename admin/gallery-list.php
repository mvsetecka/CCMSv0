<?php
	require('admin-security.php');
	
	if(isset($_GET['stav']))
	{
		switch ($_GET['stav'])
		{
			case "0":
				$this->set_settings('gallery', 0);
			break;
			case "1";
				$this->set_settings('gallery', 1);
			break;
		}
	}
	
	if(isset($_POST['gallery_select']))
	{
		$this->set_settings('gallery_default', $_POST['gallery_select']);
	}
	else
	{

		if(isset($_GET['list_allowed']))
		{
		switch ($_GET['list_allowed'])
		{
			case "0":
				$query = new db_dotaz("SELECT url FROM galerie WHERE stav = 1 ORDER BY datetime desc");
				$query->proved_dotaz();
				if($query->pocet_vysledku()==1)
				{
					$zaznam = $query->get_vysledek();
					$gallery_def_setting = $zaznam['url']; 
				}
				else
				{
					$zaznam = $query->get_vysledek();
					$gallery_def_setting = $zaznam['url'];
				}
			
				$this->set_settings('gallery_default', $gallery_def_setting);
			break;
			case "1";
				$this->set_settings('gallery_default', '0');
			break;
		}
		}
	}
?>

<?php
	$query = new db_dotaz("SELECT * FROM galerie ORDER BY datetime desc");
	$query->proved_dotaz();
	
	echo "<h2>P�ehled fotogaleri�</h2>";
	
	echo "<table class='admin_tabulka' cellspacing=1>";
	echo "<thead>";
		echo "<tr><td>Datum zalo�en�</td><td>N�zev</td><td>Popis</td><td>Po�et fotografi�</td><td>Stav</td><td>Po�et zobrazen�</td></tr>";
	echo "</thead>";
	
	while($zaznam=$query->get_vysledek()):
	
		echo "<tr>";
		echo "<td>".date("d. m. Y", $zaznam['datetime'])."</td>";
		if($this->check_permission('photogallery_edit',TRUE))
		{
			echo "<td><a href='index.php?action=zobrazit-galerii&gid=".$zaznam['url']."'>".$zaznam['nazev']."</a></td>";	
		}
		else
		{
			echo "<td>".$zaznam['nazev']."</td>";
		}
		echo "<td>".$zaznam['popis']."</td>";
		echo "<td>".$zaznam['pocet_obrazu']."</td>";
		echo "<td>".$zaznam['stav']."</td>";
		echo "<td>".$zaznam['zobrazeni']."</td>";
		echo "</tr>";
	endwhile;
	echo "</table>";
	
	echo "<br />";
	
	echo "V sou�asn� dob� je zobrazov�n� fotogaleri�: ";
	switch ($this->get_settings('gallery'))
	{
	case "0":
		echo " <strong>vypnuto</strong> / <a href='index.php?action=galerie&stav=1'>Zapnout</a>";
	break;
	case "1":
		echo " <strong>zapnuto</strong> / <a href='index.php?action=galerie&stav=0'>Vypnout</a>";
	break;
	}
	echo "<br /><br />";
	/*$dotaz = new db_dotaz("INSERT INTO nastaveni VALUES ('', 'gallery_default', '0', '', '')");
	$dotaz->proved_dotaz();
	$dotaz = NULL;
	*/
	echo "<hr />";
	//echo $this->get_settings(gallery_default);
	echo "<br />";
	switch ($this->get_settings('gallery_default'))
	{
		case "0":
			echo "V sou�asn� dob� je povoleno <strong>v�ce fotogaleri�.</strong><br />";
			echo "<a href='index.php?action=galerie&list_allowed=0'>Povolit pouze jednu</a>";
		break;
		
		default:
			echo "<form method='post' action='".$_SERVER["PHP_SELF"]."?".$_SERVER["QUERY_STRING"]."'>";
			$galerie_def_url = $this->get_settings('gallery_default');
			$query = new db_dotaz("SELECT nazev FROM galerie WHERE url = '".$galerie_def_url."'");
			$query->proved_dotaz();
			if($query->pocet_vysledku()==1)
			{
				$zaznam = $query->get_vysledek();
				$galerie_def_nazev = $zaznam['nazev'];
			}
			echo "V sou�asn� dob� je nastavena pouze jedna fotogalerie (p��mo zobrazen� po kliknut� na odkaz).<br />";
			echo "<a href='index.php?action=galerie&list_allowed=1'>Povolit v�ce fotogaleri� (seznam)</a><br /><br />";
			echo "<div><label for='gallery_select'>Vyberte</label><br />";
				echo "<select name='gallery_select' id='gallery_select' style='width:207px;'>";
					$query = new db_dotaz("SELECT * FROM galerie WHERE stav = 1");
					$query->proved_dotaz();
					while($zaznam = $query->get_vysledek()):
						$checked = "";
						if($zaznam['nazev']==$galerie_def_nazev)$checked=" selected";
						echo "<option ".$checked.">".$zaznam['nazev']."</option>";
					endwhile;
					$query = NULL;
				echo "</select>";
			echo "</div>";
			echo "<br />";
			$this->add_submit_button('Ulo�it');
		break;
	}
?>