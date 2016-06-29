<?php
	require('admin-security.php');
	$this->check_permission('category_edit');
?>

<SCRIPT LANGUAGE="JavaScript">
    function validate() {
		if(document.f1.new_name.value=='')
		{
			alert("Název kategorie je nutné vyplnit!");
			return false;
		}
    }
</SCRIPT>

<?php
	
	echo "<h2>Zmìnit název kategorie</h2>";
	
	if(isset($_REQUEST['err']))
	{
		switch($_REQUEST['err'])
		{
			case "1":
				echo "<strong>CHYBA! Kategorie se zadaným názvem již existuje</strong>";
			break;	
		}
	}
	
	$type = $_GET['param2'];
	$id = $_GET['param1'];
	
	if($type)
	{
		switch($type){
			case "sub":
				$sql_query = "SELECT * FROM menu_subkategorie WHERE URL='".$id."'";
			break;
		}
	}
	$vyber = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
	$vyber = mysql_fetch_array($vyber);
	echo "<form method='post' action='category-edit-script.php' name='f1' onSubmit='return validate();'>";
		$this->add_text_input('new_name','kategorie','Nový název',$vyber['nazev'], 50, 50);
				if($this->get_settings('lang_en')=="on")
				{
					$sql_query = "SELECT * FROM menu_subkategorie_langs WHERE parent_id='".$id."' AND jazyk='EN'";
					$vyber_langs = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
					$vyber_langs = mysql_fetch_array($vyber_langs);
					$this->add_text_input('name_en','name_en','Název - Anglicky',$vyber_langs['nazev'], 50, 50);
					$vyber_langs = NULL;
				}
				
				if($this->get_settings('lang_de')=="on")
				{
					$sql_query = "SELECT * FROM menu_subkategorie_langs WHERE parent_id='".$id."' AND jazyk='DE'";
					$vyber_langs = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
					$vyber_langs = mysql_fetch_array($vyber_langs);
					$this->add_text_input('name_de','name_de','Název - Nìmecky',$vyber_langs['nazev'], 50, 50);
					$vyber_langs = NULL;
				}
				
				if($this->get_settings('lang_du')=="on")
				{
					$sql_query = "SELECT * FROM menu_subkategorie_langs WHERE parent_id='".$id."' AND jazyk='DU'";
					$vyber_langs = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
					$vyber_langs = mysql_fetch_array($vyber_langs);
					$this->add_text_input('name_du','name_du','Název - Další jazyk',$vyber_langs['nazev'], 50, 50);
					$vyber_langs = NULL;
				}
		
		$this->add_hidden_input('akce','edit');
		$this->add_hidden_input('old_id',$id);
		$this->add_hidden_input('old_name',$vyber['nazev']);
		$this->add_hidden_input('typ',$type);
		$this->add_hidden_input('old_parent','simple');
		$this->add_hidden_input('new_parent','simple');
		$this->add_submit_button('Uložit zmìny');
	echo "</form>";
	
?>