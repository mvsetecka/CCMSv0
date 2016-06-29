<?php
	require('admin-security.php');
	$this->check_admin();
?>

<?php
echo "<h2>Konfigurace - publikov�n� a obsah</h2>";

if(!empty($_POST))
{
	$this->set_settings('comm_disabled_hidden', $_POST['comm_dis_hidden']);
	$this->set_settings('comm_disabled_shown', $_POST['comm_dis_shown']);
	$this->set_settings('comm_disabled', $_POST['comm_disabled']);
	echo "<p>Zm�ny ulo�eny</p>";
}
?>

<form method="POST" action="<?php echo($_SERVER["PHP_SELF"])."?".$_SERVER["QUERY_STRING"] ?>">
	<fieldset style="width: 300px">
	<legend>Koment��e</legend>
	<div><label>Koment��e zak�z�ny a skryty</label><br /><input name="comm_dis_hidden" size="45" value="<?php echo $this->get_settings('comm_disabled_hidden'); ?>" /></div><br />
	<div><label>Koment��e zak�z�ny a zobrazeny</label><br /><input name="comm_dis_shown" size="45" value="<?php echo $this->get_settings('comm_disabled_shown'); ?>" /></div><br />
	<div><label>Koment��e zak�z�ny od po��tku</label><br /><input name="comm_disabled" size="45" value="<?php echo $this->get_settings('comm_disabled'); ?>" /></div><br />
	</fieldset>
	<br />
	<input type="Submit">
</form>