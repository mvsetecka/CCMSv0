<?php
	require('admin-security.php');
	$this->check_admin();
?>

<?php
echo "<h2>Konfigurace METAdat</h2>";

if(!empty($_POST))
{
	$this->set_settings('meta_description', $_POST['description']);
	$this->set_settings('meta_keywords', $_POST['keywords']);
	$this->set_settings('meta_author', $_POST['author']);
	echo "<p>Zmìny uloženy</p>";
}
?>

<form method="POST" action="<?php echo($_SERVER["PHP_SELF"])."?".$_SERVER["QUERY_STRING"] ?>">
	<?php $this->add_text_area('description','description','META - description',$this->get_settings('meta_description'), 50, 3) ?>
    <?php $this->add_text_area('keywords','keywords','META - keywords',$this->get_settings('meta_keywords'), 50, 3) ?>
    <?php $this->add_text_input('author','author','META - author',$this->get_settings('meta_author'), 50, 50) ?>
    <?php $this->add_submit_button('Uložit zmìny') ?>
</form>