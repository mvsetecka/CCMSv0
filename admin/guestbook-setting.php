<?php
	require('admin-security.php');
	$this->check_permission('guestbook_edit');
?>

<?php
	
	echo "<h2>Nastavení návštìvní knihy</h2>";
	
	
	if(isset($_GET['stav']))
	{
		switch ($_GET['stav'])
		{
			case "0":
				$this->set_settings('guestbook', 0);
			break;
			case "1";
				$this->set_settings('guestbook', 1);
			break;
		}
	}
	
	if(!empty($_POST))
	{
		if(isset($_POST['gb_listing']))
		{
			$this->set_settings('gb_listing', $_POST['gb_listing']);
		}
	}
	
	
	echo "V souèasné dobì je návštìvní kniha: ";
	switch ($this->get_settings('guestbook'))
	{
	case "0":
		echo " <strong>zakázána</strong> / <a href='index.php?action=gb-nastaveni&stav=1'>Povolit</a>";
	break;
	case "1":
		echo " <strong>povolena</strong> / <a href='index.php?action=gb-nastaveni&stav=0'>Zakázat</a>";
	break;
	}
	echo "<br />";
	echo "<br />";
?>
	<form method="POST" action="<?php echo($_SERVER["PHP_SELF"])."?".$_SERVER["QUERY_STRING"] ?>">
<?php
	$this->add_text_input('gb_listing','gb_listing','Poèet pøíspìvkù na stránkce',$this->get_settings('gb_listing'), 10, 10);
	$this->add_submit_button("Uložit");
	echo "</form>";
?>