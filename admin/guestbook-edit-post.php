<?php
	require('admin-security.php');
?>

<?php

$pid = $_GET['pid'];

$query = new db_dotaz("SELECT * FROM guestbook WHERE id = ".$pid."");
$query->proved_dotaz();
$komentare = $query->get_vysledek();
?>

<form method="POST" action='guestbook-update-script.php'>

<?php
$this->tiny_mce_settings_simple();
$this->add_text_area('Komentar','Komentar1','Komentáø',$komentare['text'], 60, 20,'');

$this->add_hidden_input('akce', 'edit');
add_radio_select('oznacit','ozacit_ano','Oznaèit zmìnu datem a podpisem','ano','checked');
add_radio_select('oznacit','oznacit_ne','Neoznaèovat zmìnu','ne','');
echo "<br />";
$this->add_hidden_input('pid', $pid);
$this->add_submit_button('Uložit');
?>

</form>

<?php

function add_radio_select($name,$id,$title,$value,$checked){
	echo "<div><input type ='radio' name='".$name."' id='".$id."' value='".$value."'".$checked." /><label for='".$id."'>".$title."</label></div>";
}

?>