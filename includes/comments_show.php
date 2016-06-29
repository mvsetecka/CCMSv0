<?php

$komentare = new db_dotaz("SELECT * FROM komentare WHERE item_id = '".$clanek_id."' ORDER BY datum desc, cas desc");
$komentare->proved_dotaz();
echo "<h4 class='comment_desc'>Komentáøe návštìvníkù</h4>";
if($komentare->pocet_vysledku()==0)
{
	echo "<p>Zatím nikdo nekomentoval.</p>";
}
else
{
while($zaznam=$komentare->get_vysledek()):
	$datum = date("d. m. Y", strtotime($zaznam['datum']));
	echo "<table class='komentare_table' cellspacing='0'>";
	echo "<tr class='komentare_radek'><td>"." ".$zaznam['comment_id']." | ".$zaznam['autor_nick']." | ".$datum." - ".$zaznam['cas']."</td>
	<td class='komentare_radek_odkaz'><a class='comment-link' href='".$_SERVER['REQUEST_URI']."#comment-".$zaznam['comment_id']."'>#</a><a name='comment-".$zaznam['comment_id']."'/></td>
	</tr>";
	echo "<tr><td colspan='2'>".$zaznam['text']."</td></tr>";
	echo "</table><br />";
endwhile;
}
$komentare=NULL;
?>