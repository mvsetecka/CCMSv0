<?php
include('includes/language.php');

$img['filename']=$_GET['img_id'];
$img['gal_id']=$_GET['gallery_id'];

$query = new db_dotaz("SELECT stav FROM galerie WHERE url = '".$img['gal_id']."' LIMIT 1");
$query->proved_dotaz();
$zaznam = $query->get_vysledek();
$img['gal_status'] = $zaznam['stav'];
if($img['gal_status']==1 && $this->get_settings('gallery')==1)
{
		$query = new db_dotaz("SELECT id, popis FROM galerie_obrazky WHERE soubor = '".$img['filename']."' AND slozka = '".$img['gal_id']."' LIMIT 1");
		$query->proved_dotaz();
		$zaznam = $query->get_vysledek();
		$img['img_id'] = $zaznam['id'];
		$img['img_desc'] = $zaznam['popis'];
		$query = NULL;
		$zaznam = NULL;

		//Zjistí pøedchozí obrázek
		$query = new db_dotaz("SELECT * FROM galerie_obrazky WHERE slozka = '".$img['gal_id']."' AND id < ".$img['img_id']." ORDER BY id desc LIMIT 1");
		$query->proved_dotaz();
		$zaznam = $query->get_vysledek();
		$img['img_back'] = $zaznam['soubor'];
		$query = NULL;
		$zaznam = NULL;
		
		//Zjistí následující obrázek
		$query = new db_dotaz("SELECT * FROM galerie_obrazky WHERE slozka = '".$img['gal_id']."' AND id > ".$img['img_id']." ORDER BY id asc LIMIT 1");
		$query->proved_dotaz();
		$zaznam = $query->get_vysledek();
		$img['img_forward'] = $zaznam['soubor'];
		$query = NULL;
		$zaznam = NULL;
		
		//Naète poèet obrázkù z galerie
		$query = new db_dotaz("SELECT * FROM galerie_obrazky WHERE slozka = '".$img['gal_id']."'");
		$query->proved_dotaz();
		$img['img_count'] = $query->pocet_vysledku();
		$query = NULL;

		//Naète informace o galerii
		$query = new db_dotaz("SELECT * FROM galerie WHERE url = '".$img['gal_id']."' LIMIT 1");
		$query->proved_dotaz();
		$zaznam = $query->get_vysledek();
		$img['gal_name'] = $zaznam['nazev'];
		$img['gal_desc'] = $zaznam['popis'];
		$query = NULL;
		
		echo "<div style='text-align:center'>";		
		echo $img['gal_name'];

		echo "<br />";
		echo $img['img_id']."/".$img['img_count'];
		echo "</div>";
		echo "<a name='img' />";
		echo "<div style='text-align:center'><img class='galerie-img' src='".$this->root."/gallery/".$img['gal_id']."/".$img['filename']."' alt='".$img['img_desc']."' title='".$img['img_desc']."'/></div>";
		echo "<br />";
		echo "<div style='text-align:center'>";
		echo "<p><strong>".$img['img_desc']."</strong></p>";
		if($img['img_back']<>"")
		{
			echo "<a href='".$this->root."/galerie/".$img['gal_id']."/".$img['img_back']."#img'>";
			echo "<img style='border:none' src='".$this->root."/CSS/".$this->get_settings(stylesheet_dir)."/Arrows/gal_arrow_back.png' alt='".$language['fotogalerie_back'][$this->language]."' title='".$language['fotogalerie_back'][$this->language]."' />";
			echo "</a>";
		}

		if($img['img_forward']<>"")
		{
			echo "<a href='".$this->root."/galerie/".$img['gal_id']."/".$img['img_forward']."#img''>";
			echo "<img style='border:none' src='".$this->root."/CSS/".$this->get_settings(stylesheet_dir)."/Arrows/gal_arrow_forward.png' alt='".$language['fotogalerie_forward'][$this->language]."' title='".$language['fotogalerie_forward'][$this->language]."' />";
			echo "</a>";
		}
		echo "<p><a href='".$this->root."/galerie/".$img['gal_id'].".html'>".$language['fotogalerie_back_tb'][$this->language]."</a></p>";
		echo "</div>";
}
else
{
	echo "<strong>".$language['not_found'][$this->language]."</strong>";
} 

		
?>