<?php
require('admin-security.php');
echo "<h2>Upravit pati�ku str�nky</h2>";

if(isset($_POST['footer_content']))
{
	if($this->set_others('footer_content',$_POST['footer_content']))
	{
		echo "<strong>Ulo�eno v po��dku</strong>";	
	}
}
$this->tiny_mce_settings();
?>
<form method="POST" action="<?php echo($_SERVER["PHP_SELF"])."?".$_SERVER["QUERY_STRING"] ?>">
<?php
$this->add_text_area('footer_content', 'footer_content', "",$this->get_others('footer_content') , 90, 10);
$this->add_submit_button('Ulo�it');
?>