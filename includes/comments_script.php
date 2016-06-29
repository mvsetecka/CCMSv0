<?php

if ($_POST['comment_text']<>NULL and $_POST['comment_autor_jmeno']<>NULL){
	$text_komentare = htmlspecialchars($_POST['comment_text']);
	$kom_autor_jmeno = htmlspecialchars($_POST['comment_autor_jmeno']);
	$kom_autor_email = htmlspecialchars($_POST['comment_autor_email']);
	$kom_autor_www = htmlspecialchars($_POST['comment_autor_www']);
	$kom_autor_ip = $_SERVER['REMOTE_ADDR'];
	$datum = date("Ymd");
	$cas = date("H:i:s");
	$clanek_id = $this->obsah;
	$sql_query = ("SELECT comment_id FROM komentare WHERE item_id = '".$clanek_id."' ORDER BY comment_id desc limit 1");
	$comment_ids = mysql_query($sql_query, $GLOBALS["database"]) or die(mysql_error());
	$comment_id = mysql_fetch_array($comment_ids);
	$comment_id_top = $comment_id['comment_id'];
	if (mysql_num_rows($comment_ids)==0)$comment_id_top=0;
	$comment_id_top = $comment_id_top + 1;
	$zobrazit = TRUE; 
	$sql_query = ("INSERT INTO komentare VALUES ('$comment_id_top', '$clanek_id', '$text_komentare', '$kom_autor_jmeno', '$kom_autor_email', '$kom_autor_ip', '$kom_autor_www', '$datum', '$cas', '$zobrazit')");
	//echo $sql_query;	
	mysql_query($sql_query, $GLOBALS["database"]) or die(mysql_error());

}

?>