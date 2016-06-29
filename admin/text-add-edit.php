<?php
	require('admin-security.php');
?>

<SCRIPT LANGUAGE="JavaScript">
    function validate() {
		if(document.f1.clanek_titulek.value=='')
		{
			alert("Je nutn� zadat titulek �l�nku!");
			return false;
		}
    }
</SCRIPT>

<?php

$editor = "";


if(!isset($_GET['param1']))
{
    $action="add";
    $item_id = NULL;
}elseif(isset($_GET['param1']) && $_GET['param1']=="home-page")
{
    $action="home";
    $item_id="home-page";
}else{
    $action="edit";
    $item_id=$_GET['param1'];
}

//echo $item_id;

$this->tiny_mce_settings();

if($action=="add"){$this->check_permission('text_add');}else{$this->check_permission('text_edit');}

echo "<h2>P�idat obsah - text</h2>";

if(isset($_REQUEST['err']))
{
	switch($_REQUEST['err'])
	{
		case "1":
			$page['error'] = 1;
			echo "<strong>CHYBA - Text s t�mto titulkem ji� existuje!</strong>";
		break;
	}
}

if($action=="edit")
{	
	$sql_query = ("SELECT * FROM texty WHERE id='".$item_id."'");
	$zaznam = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
	if(mysql_num_rows($zaznam)==0){$action="add";}
}
else
{
    $text['titulek'] = NULL;
	$text['text'] = NULL;
	$text['autor'] = NULL;
}

	if(isset($_GET['lang']))
	{
	 	$lang = $_GET['lang'];
	 	$action = "edit_lang";
	}
	else
	{
		$lang = "CZ";
	}

	if($action=="edit")
	{
		$sql_query = ("SELECT * FROM texty WHERE id= '".$item_id."'");
		$vyber = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
		$text = mysql_fetch_array($vyber);
	}
	elseif($action=="edit_lang")
	{
		$sql_query = ("SELECT * FROM texty_langs WHERE parent_id= '".$item_id."' AND lang='".$lang."'");
		$vyber = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
		$text = mysql_fetch_array($vyber);
	}
	elseif($action=="home")
	{
		$sql_query = ("SELECT * FROM texty WHERE id= '".$item_id."' AND zobrazovat='home'");
		$vyber = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
		$text = mysql_fetch_array($vyber);
	}
    else
    {
        $text['zobrazovat'] = "";
        $text['kategorie'] = "";
    }
	echo "<form method='post' action='text-add-edit-script.php' name='f1'>";
	
	if(isset($page) && $page['error'] == 1)
	{
		$text['titulek'] = $_SESSION['article_title_saved'];
		$text['text'] = $_SESSION['article_text_saved'];
		$text['autor'] = $_SESSION['article_author_saved'];
		$_SESSION['article_title_saved'] = NULL;
		$_SESSION['article_text_saved'] = NULL;
		$_SESSION['article_author_saved'] = NULL;
	}
	
	if($action!=="home" && $action!=="edit_lang")
	{
	 	if($this->get_settings('web_version')=='CMS')
	 	{
		add_category_select('clanek_kategorie', 'category', "Zvolte kategorii �l�nku",$text['kategorie']);
		}
		echo "<br />";
		$this->add_checkbox('menu_zobrazovat','checked');
		echo "Zobrazovat v menu";
		echo "<br />";
		echo "<br />";
		$this->add_text_input('clanek_titulek', 'titulek', "Titulek textu - polo�ka v menu", $text['titulek'], 50, 50);
		echo "<br />";
	}
	
	if($action=="edit_lang" && $_GET['param1']!=="home-page")
	{
		$this->add_text_input('clanek_titulek', 'titulek', "Titulek �l�nku", $text['nazev'], 100, 100);
		echo "<br />";
	}
	$this->add_text_area('clanek_text', 'text', "Text �l�nku", htmlspecialchars($text['text'], ENT_IGNORE,"iso-8859-1"), 90, 30, $editor);
    //htmlspecialchars_decode()

	if($action!=="home" && $action!=="edit_lang")
	{
		$this->add_text_input('clanek_autor', 'autor', "Autor �l�nku", $text['autor'], 50, 50);
		echo "<br />";
	}

	/*switch($action)
	{
		case "add":
				$this->add_radio_select(komentare,komentare_ano,'Povolit komentov�n� �l�nku',on,"checked");
				$this->add_radio_select(komentare,komentare_ne,'Zak�zat komentov�n� �l�nku',off,"");
				$this->add_radio_select(komentare,komentare_skryt,'Zak�zat bez zobrazen�',off_hidden,"");
		break;
		case "edit":
				if($text['komentare']=="on"){$komentare_ano="checked";}elseif($text['komentare']=="dis_hidden"){$komentare_dis_hidden="checked";}elseif($text['komentare']=="dis_shown"){$komentare_dis_shown="checked";}else{echo("<p>Koment��e jsou nyn� zak�z�ny.<p>");}
				$this->add_radio_select(komentare,komentare_ano,'Povolit komentov�n� �l�nku',on,$komentare_ano);
				$this->add_radio_select(komentare,komentare_dis_hidden,'Zak�zat komentov�n� a skr�t ji� napsan� komet��e',dis_hidden,$komentare_dis_hidden);
				$this->add_radio_select(komentare,komentare_dis_shown,'Zak�zat komentov�n� a ji� napsan� koment��e ponechat zobrazen�',dis_shown,$komentare_dis_shown);
		break;		
	}
	*/
	
	if($action!=="home" && $action!=="edit_lang")
	{
		echo "<br />";
		$this->add_radio_select('clanek_zobrazovat','zobrazovat','Zobrazit','ano',"checked");
		$this->add_radio_select('clanek_zobrazovat','nezobrazovat','Ulo�it do rozepsan�ch','ne',"");
	}
	echo "<br />";
	echo "<input type='hidden' name='language' value='".$lang."' />";
	echo "<input type='hidden' name='action' value='".$action."' />";
	echo "<input type='hidden' name='editor' value='".$editor."' />";
	echo "<input type='hidden' name='item_id_old' value='".$item_id."' />";
	echo "<input type='hidden' name='zobrazovat_old' value='".$text['zobrazovat']."' />";
	echo "<input type='hidden' name='clanek_kategorie_old' value='".$text['kategorie']."' />";
	
	if($action=="home")
	{
		echo "<input type='Submit' value='Ulo�it' />";
	}
	else
	{
		echo "<input type='Submit' value='Ulo�it' onClick='return validate();' />";	
	}
	
	echo "</form>";
	

function add_category_select($name, $id, $title, $selected){
	echo "<div><label for='".$id."'>".$title."</label><br /><select name='".$name."' id='".$id."'>";
	$sql_query = "SELECT * FROM menu_kategorie";
	$kategorie = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
			while ($zaznam=mysql_fetch_array($kategorie)):
						$checked="";
						if ($zaznam["nazev"]==$selected)$checked=" selected";
						echo "<option".$checked.">".$zaznam["nazev"]."</option>";
						$checked="";
			endwhile;
			if($selected=="")$checked=" selected";
	echo "</select></div>";
}

?>