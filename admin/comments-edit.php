<?php
	require('admin-security.php');
	$this->check_permission('comments_edit');
?>

<?php

$item_id = $_GET['article_id'];
$comment_id = $_GET['comm_id'];

$query = new db_dotaz("SELECT * FROM komentare WHERE comment_id = ".$comment_id." AND item_id = '".$item_id."'");
$query->proved_dotaz();
$komentare = $query->get_vysledek();
?>

<form method="POST" action='comments-update-script.php'>

<?php
$this->add_text_area('Komentar','Komentar1','Komentáø',$komentare['text'], 60, 20,'');

$this->add_hidden_input('akce', 'edit');
add_radio_select('oznacit','ozacit_ano','Oznaèit zmìnu datem a podpisem','ano','checked');
add_radio_select('oznacit','oznacit_ne','Neoznaèovat zmìnu','ne','');
echo "<br />";
$this->add_hidden_input('item_id', $item_id);
$this->add_hidden_input('comment_id', $comment_id);
$this->add_submit_button('Uložit');
?>

</form>

<?php

function add_radio_select($name,$id,$title,$value,$checked){
	echo "<div><input type ='radio' name='".$name."' id='".$id."' value='".$value."'".$checked." /><label for='".$id."'>".$title."</label></div>";
}

?>