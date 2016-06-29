<?php
	require('admin-security.php');
	$this->check_admin();
?>

<?php
echo "<h2>Konfigurace - Styl CSS</h2>";

if(!empty($_POST))
{
	$this->set_settings('stylesheet_dir', $_POST['css_stylesheet']);
	echo "<p>Zmìny uloženy</p>";
}
?>

<form method="POST" action="<?php echo($_SERVER["PHP_SELF"])."?".$_SERVER["QUERY_STRING"] ?>">
	<fieldset style="width: 450px;">
	<legend>Adresáø s CSS stylem</legend>
		<?php 
			$this->add_text_input('css_stylesheet', 'css_stylesheet', "", $this->get_settings('stylesheet_dir'), 50, 50);
			$this->add_submit_button("Uložit"); 
		?>	
	</fieldset>
</form>