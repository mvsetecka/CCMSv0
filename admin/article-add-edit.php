<?php
require('admin-security.php');
?>

<SCRIPT LANGUAGE="JavaScript">
    function validate() {
		if(document.f1.clanek_titulek.value=='')
		{
			alert("Je nutné zadat titulek èlánku!");
			return false;
		}
    }
</SCRIPT>
	  

<?php
if ($_SESSION['logged']!==1) header("Location:login.php");
$editor = "";

if(!isset($_GET['param1']))
{
    $action="add";
}else{
    $action="edit";
    $item_id=$_GET['param1'];
}





if($action=="edit")
{
	$this->check_permission('article_edit');
}
else
{
	$this->check_permission('article_add');
}

if($action=="edit")
{	
	$sql_query = ("SELECT * FROM clanky WHERE id='".$item_id."'");
	$zaznam = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
	if(mysql_num_rows($zaznam)==0){$action="add";}
}

if($action=="add")
{
	echo "<h2>Pøidat obsah - èlánek</h2>";
}
else
{
	echo "<h2>Upravit èlánek</h2>";
}

if($action=="add")
{
		$sql_query = ("SELECT * FROM menu_subkategorie");
		$clanky = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
		if(mysql_num_rows($clanky)==0)
		{
			echo "<h3>Nejprve musíte založit kategorii èlánkù!</h3>";
			echo "<a href='index.php?action=pridat-kategorii&param=sub'>Pøejít na pøidání kategorie</a>";
			exit(0);
		}
}
//show_form($action,$item_id);

//function show_form($action,$item_id)
//{
	if($action=="edit")
	{
		$sql_query = ("SELECT * FROM clanky WHERE id= '".$item_id."'");
		//echo $sql_query;
		$clanky = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
		$clanek = mysql_fetch_array($clanky);
	}else{
        $clanek['subkategorie'] = "";
        $clanek['titulek'] = "";
        $clanek['strucne'] = "";
        $clanek['text'] = "";
        $clanek['autor'] = "";
        $item_id = "";
    }
	$this->tiny_mce_settings();
	echo "<form method='post' action='article-add-edit-script.php' name='f1' onSubmit='return validate();'>";
	add_category_select('clanek_kategorie', 'category', "Zvolte kategorii èlánku",$clanek['subkategorie']);
	echo "<br />";
	$this->add_text_input('clanek_titulek', 'titulek', "Titulek èlánku", $clanek['titulek'], 50, 100);
	echo "<br />";
	$this->add_text_area('clanek_strucne', 'strucne', "Struèný obsah èlánku", htmlspecialchars($clanek['strucne'], ENT_IGNORE,"iso-8859-1"), 60, 15, $editor);
	echo "<br />";
	$this->add_text_area('clanek_text', 'text', "Text èlánku", htmlspecialchars($clanek['text'], ENT_IGNORE,"iso-8859-1"), 60, 30, $editor);
	echo "<br />";
	$this->add_text_input('clanek_autor', 'autor', "Autor èlánku", $clanek['autor'], 50, 50);
	echo "<br />";
	switch($action)
	{
		case "add":
				$this->add_radio_select('komentare','komentare_ano','Povolit komentování èlánku','on',"checked");
				$this->add_radio_select('komentare','komentare_ne','Zakázat komentování èlánku','off',"");
				$this->add_radio_select('komentare','komentare_skryt','Zakázat bez zobrazení','off_hidden',"");
		break;
		case "edit":
				if($clanek['komentare']=="on"){
				    $komentare_ano="checked";
                    $komentare_dis_hidden = NULL;
                    $komentare_dis_shown = NULL;
                }elseif($clanek['komentare']=="dis_hidden"){
                    $komentare_dis_hidden="checked";
                    $komentare_ano = NULL;
                    $komentare_dis_shown = NULL;
                }elseif($clanek['komentare']=="dis_shown"){
                    $komentare_dis_shown="checked";
                    $komentare_dis_hidden = NULL;
                    $komentare_ano = NULL;
                }else{
                    echo("<p>Komentáøe jsou nyní zakázány.<p>");
                }
				$this->add_radio_select('komentare','komentare_ano','Povolit komentování èlánku','on',$komentare_ano);
				$this->add_radio_select('komentare','komentare_dis_hidden','Zakázat komentování a skrýt již napsané kometáøe','dis_hidden',$komentare_dis_hidden);
				$this->add_radio_select('komentare','komentare_dis_shown','Zakázat komentování a již napsané komentáøe ponechat zobrazené','dis_shown',$komentare_dis_shown);
		break;		
	}
	echo "<br />";
	$this->add_radio_select('clanek_zobrazovat','zobrazovat','Zobrazit','ano',"checked");
	$this->add_radio_select('clanek_zobrazovat','nezobrazovat','Uložit do rozepsaných','ne',"");
	echo "<br />";
	echo "<input type='hidden' name='action' value='".$action."' />";
	echo "<input type='hidden' name='editor' value='".$editor."' />";
	echo "<input type='hidden' name='item_id_old' value='".$item_id."' />";
	echo "<input type='Submit' value='Uložit' />";
	echo "</form>";
		


function add_category_select($name, $id, $title, $selected){
	echo "<div><label for='".$id."'>".$title."</label><br /><select name='".$name."' id='".$id."' style='width:207px;'>";
	$sql_query = "SELECT * FROM menu_kategorie";
	$kategorie = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
			while ($zaznam=mysql_fetch_array($kategorie)):
				$sql_query = ("SELECT * FROM menu_subkategorie WHERE parent_url= '".$zaznam['URL']."' AND typ='list'");
				$subkategorie = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
					while ($subzaznam=mysql_fetch_array($subkategorie)):
						$checked="";
						if ($subzaznam["nazev"]==$selected)$checked=" selected";
						//echo "<option".$checked.">".$zaznam["nazev"]."-".$subzaznam["nazev"]."</option>";
						echo "<option".$checked.">".$subzaznam["nazev"]."</option>";
					endwhile;
			endwhile;
	echo "</select></div>";
}

?>