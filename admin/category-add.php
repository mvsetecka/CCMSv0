<?php
	require('admin-security.php');
	$this->check_permission('category_edit');
?>

<SCRIPT LANGUAGE="JavaScript">
    function validate() {
		if(document.f1.name.value=='')
		{
			alert("N�zev kategorie je nutn� vyplnit!");
			return false;
		}
    }
</SCRIPT>

<?php
	echo "<h2>P�idat kategorii �l�nk�</h2>";
	
	$type = $_GET['param'];
	//$selected = $_GET['param2'];
	
	if(isset($_REQUEST['err']))
	{
		switch($_REQUEST['err'])
		{
			case "1":
				echo "<strong>CHYBA! Kategorie se zadan�m n�zvem ji� existuje</strong>";
			break;	
		}
	}
	
	if($type)
	{
	 	echo "<form method='post' action='category-add-script.php' name='f1' onSubmit='return validate();'>";
		switch($type)
		{
			case "sub":
				$this->add_text_input('name','name','N�zev','', 50, 50);
				if($this->get_settings('lang_en')=="on")
				{
					$this->add_text_input('name_en','name_en','N�zev - Anglicky','', 50, 50);
				}
				
				if($this->get_settings('lang_de')=="on")
				{
					$this->add_text_input('name_de','name_de','N�zev - N�mecky','', 50, 50);
				}
				
				if($this->get_settings('lang_du')=="on")
				{
					$this->add_text_input('name_du','name_du','N�zev - Dal�� jazyk','', 50, 50);
				}
				
				$this->add_submit_button('Ulo�it');
			break;
		}
			$this->add_hidden_input('type',$type);
		echo "</form>";
	}

?>