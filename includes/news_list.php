<?php
echo "<div id='news-box'>";
$pocet = $this->get_settings('news_count');
$query = new db_dotaz("SELECT * FROM aktuality ORDER BY id DESC LIMIT ".$pocet."");
$query->proved_dotaz();

while($aktuality = $query->get_vysledek())
{
	 echo $this->date_cz_month($aktuality['datetime'], "j. F, Y");
	 echo "<br />";
	 echo $aktuality['text'];
	 echo "<br />";
	 echo "<br />";
}


$query = NULL;
?>

<a href='<?php echo $this->root ?>/novinky/'>Pokraèovat...</a>

<?php
/*
<a href='#' onClick="document.getElementById('news-show-all').innerHTML='<?php echo $vsechno ?>';return true">Zobrazit všechny</a>
*/
?>


</div>