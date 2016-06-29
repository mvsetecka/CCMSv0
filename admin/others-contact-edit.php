<?php
require('admin-security.php');
echo "<h2>Kontaktní informace</h2>";

if(isset($_GET['lang']))
{
	switch($_GET['lang'])
	{
		case "DE":
			$lang = "L3";
			$desc = "Nìmecky";
		break;
		
		case "EN":
			$lang = "L2";
			$desc = "Anglicky"; 
		break;
		
		case "DU";
			$lang = "L4";
			$desc = "Další";
		break;
	}
	
}
else
{
	$lang = "L1";
    $desc = NULL;
}

if(isset($_POST['contact_data_text']))
{
	$param_save = $_POST['param_name'];
	if($this->set_others($param_save,$_POST['contact_data_text']))
	{
		echo "<strong>Uloženo v poøádku</strong>";	
	}
}
$this->tiny_mce_settings();
?>
<form method="POST" action="<?php echo($_SERVER["PHP_SELF"])."?".$_SERVER["QUERY_STRING"] ?>">
<?php
$param = "contact_info_".$lang;
echo $desc;
$this->add_text_area('contact_data_text', 'contact_data_text', "",$this->get_others($param) , 90, 30);
$this->add_hidden_input('param_name', $param);
$this->add_submit_button('Uložit');
?>