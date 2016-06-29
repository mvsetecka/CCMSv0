<?php
	require('admin-security.php');

	echo "<h2>Konfigurace - správa uživatelù a práv - pøidat (editovat) uživatele</h2>";
	
	if($_GET['do']=='edit')
	{
		$user = $_GET['uid']; 
		$query=new db_dotaz("SELECT jmeno_prijmeni FROM uzivatele WHERE username = '".$user."' LIMIT 1");
		$query->proved_dotaz();
		$zaznam = $query->get_vysledek();
		$uname=$zaznam['jmeno_prijmeni'];
		$query = NULL;
	}
	//echo $user['name'];
?>	
	<form method="POST" action="config-user-add-edit-script.php">
	<?php
	$this->add_text_input('jmeno','jmeno','Celé jméno',$uname,50,50);
	$this->add_text_input('username','username','Uživatelské jméno (pro pøihlášení)',$user,20,20);
	if($_GET['do']=='add')
	{
	$this->add_text_input('password','password','Heslo','',20,20);
	}
	else
	{
		$this->add_hidden_input('do','edit');
		$this->add_hidden_input('uname_old',$user);
	}
	$this->add_checkbox('text_add',$this->get_user_permission($user, 'text_add'));
	echo "Pøidat text";
	echo "<br />";
	$this->add_checkbox('text_edit',$this->get_user_permission($user, 'text_edit'));
	echo "Upravit text";
	echo "<br />";
	$this->add_checkbox('article_add',$this->get_user_permission($user, 'article_add'));
	echo "Pøidat èlánek";
	echo "<br />";
	$this->add_checkbox('article_edit',$this->get_user_permission($user, 'article_edit'));
	echo "Upravit èlánek";
	echo "<br />";
	$this->add_checkbox('news_add',$this->get_user_permission($user, 'news_add'));
	echo "Pøidat / editovat novinku";
	echo "<br />";
	$this->add_checkbox('guestbook_edit',$this->get_user_permission($user, 'guestbook_edit'));
	echo "Spravovat návštìvní knihu";
	echo "<br />";
	$this->add_checkbox('comments_edit',$this->get_user_permission($user, 'comments_edit'));
	echo "Moderovat komentáøe";
	echo "<br />";
	$this->add_checkbox('filemanager',$this->get_user_permission($user, 'filemanager'));
	echo "Používat správce souborù";
	echo "<br />";
	$this->add_checkbox('filemanager_mkdir',$this->get_user_permission($user, 'filemanager_mkdir'));
	echo "Správce souborù - vytváøet podsložky";
	echo "<br />";
	$this->add_checkbox('filemanager_rmdir',$this->get_user_permission($user, 'filemanager_rmdir'));
	echo "Správce souborù - mazat a pøejmenovávat podsložky";
	echo "<br />";
	$this->add_checkbox('filemanager_delete_file',$this->get_user_permission($user, 'filemanager_delete_file'));
	echo "Správce souborù - mazat a pøejmenovávat soubory";
	echo "<br />";
	$this->add_checkbox('photogallery_create',$this->get_user_permission($user, 'photogallery_create'));
	echo "Zakládat nové fotogalerie";
	echo "<br />";
	$this->add_checkbox('photogallery_edit',$this->get_user_permission($user, 'photogallery_edit'));
	echo "Editovat již vytvoøené galerie";
	echo "<br />";
	$this->add_checkbox('category_edit',$this->get_user_permission($user, 'category_edit'));
	echo "Spravovat kategorie";
	echo "<br />";
	$this->add_checkbox('opinion_poll',$this->get_user_permission($user, 'opinion_poll'));
	echo "Spravovat anketu";
	echo "<br />";
	echo "<br />";
	if($_GET['do']=='edit')
	{
		$this->add_submit_button('Uložit zmìny');
	}
	else
	{
		$this->add_submit_button('Vytvoøit');	
	}
?>
	</form>