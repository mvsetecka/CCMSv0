<?php 
require_once "guestbook-insert.php";
include "language.php";
	


if(!isset($start)){
    $start=0;
}
  $prispevku = $this->get_settings('gb_listing'); // pocet prispevku na jedne strance
  
 	if(isset($_GET['page']))
  	{
		$strana = $_GET['page'];
  		$start = ($strana*$prispevku)-$prispevku;
	}

  $sql_query = new db_dotaz("SELECT * FROM guestbook order by id desc limit " . $start . ", " . $prispevku . "");
  $sql_query->proved_dotaz();
  
  
  $pocet = mysql_num_rows(mysql_query('SELECT * from guestbook'));
  
  $trida = "neakt";

echo "\n  <div id=\"prispevky\">\n \n ";

while($row=$sql_query->get_vysledek()) {
  
  if ($row['web'] == "") { $jmenoo = "<strong class='$trida'>" . $row['jmeno'] . "</strong>"; }
  else { $jmenoo = "<strong class='$trida'><a class='$trida' href='http://" . $row['web'] . "'>" . $row['jmeno'] . "</a></strong>"; }  

  if ($row['email'] == "") { $emailo = " "; }
  else { $emailo = " <small><a class='' href='mailto:" . $row['email'] . "'>[mail]</a></small>"; }

  echo "
   <div class='prispevek'>
    <div class='horni'>
    
     <p>
      <small class='tajm'>" . $row['datum'] . "</small>" . 
      " ".$jmenoo . " " . 
      $emailo . " 
     </p>
    
    </div>
    <div class='text'>
    
     <p>" . htmlspecialchars_decode($row['text'], ENT_QUOTES) . "</p>
    
    </div>
   </div><!-- /prispevek -->
  ";
  
}

//echo "\n<hr />\n\n  </div><!-- prispevky -->\n";
//echo "\n  <div class='zobrazit'>\n \n   <b>Stránkování:</b><br />\n \n";
echo "<br />";

$pocet_stran = ceil($pocet/$prispevku);
//$pocet_stran = 5;
if($pocet_stran>1)
{
 	echo "Strana:<br />";
	for($i=1; $i <=$pocet_stran; $i++)
	{
		echo "<a href='".$this->root."/guestbook/?page=".$i."'>".$i."</a>";
	}
}
include "guestbook-form.php";

?>
</div>



