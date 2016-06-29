<?php
$query = new db_dotaz("SELECT * FROM aktuality ORDER BY id DESC");
$query->proved_dotaz();

while($aktuality = $query->get_vysledek())
{
	 echo $this->date_cz_month($aktuality['datetime'], "j. F, Y");
	 echo "<br />";
	 echo $aktuality['text'];
	 echo "<br />";
	 echo "<br />";
}
?>