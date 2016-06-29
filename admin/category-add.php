<?php
	require('admin-security.php');
	$this->check_permission('category_edit');
?>

<SCRIPT LANGUAGE="JavaScript">
    function validate() {
		if(document.f1.name.value=='')
		{
			alert("Název kategorie je nutné vyplnit!");
			return false;
		}
    }
</SCRIPT>

<?php
	echo "<h2>Pøidat kategorii èlánkù</h2>";
	
	$type = $_GET['param'];
	//$selected = $_GET['param2'];
	
	if(isset($_REQUEST['err']))
	{
		switch($_REQUEST['err'])
		{
			case "1":
				echo "<strong>CHYBA! Kategorie se zadaným názvem již existuje</strong>";
			break;	
		}
	}
	
	if($type)
	{
	 	echo "<form method='post' action='category-add-script.php' name='f1' onSubmit='return validate();'>";
		switch($type)
		{
			case "sub":
				$this->add_text_input('name','name','Název','', 50, 50);
				if($this->get_settings('lang_en')=="on")
				{
					$this->add_text_input('name_en','name_en','Název - Anglicky','', 50, 50);
				}
				
				if($this->get_settings('lang_de')=="on")
				{
					$this->add_text_input('name_de','name_de','Název - Nìmecky','', 50, 50);
				}
				
				if($this->get_settings('lang_du')=="on")
				{
					$this->add_text_input('name_du','name_du','Název - Další jazyk','', 50, 50);
				}
				
				$this->add_submit_button('Uložit');
			break;
		}
			$this->add_hidden_input('type',$type);
		echo "</form>";
	}

?>