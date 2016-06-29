<?php
include('./../includes/config.php');
include('./../includes/functions.php');
include('admin-functions.php');
include ('includes/jpgraph/jpgraph.php');
include ('includes/jpgraph/jpgraph_bar.php');

$month = $_GET['m'];
$year = $_GET['y'];

$pocet_dnu = cal_days_in_month(CAL_GREGORIAN, $month, $year);

for($i = 1; $i <= $pocet_dnu; $i++) 
{
 	$date = $year.$month."00";
 	$date = $date + $i;
    $dotaz = "SELECT count(*) FROM stats WHERE datum = ".$date;
	$query = new db_dotaz($dotaz);
    $query->proved_dotaz();
    $result = $query->get_vysledek();
    $datay[] = $result["count(*)"];  // pocet pristupu v jednotlivych dnech
    $query = NULL;
  }

// data pro osu X  
for($o = 1; $o <= $pocet_dnu; $o++)
{
	$datax[] = $o;
} 


  
  $graph = new Graph(800,300); 
  $graph->SetScale('textlin'); 

  $graph->img->SetMargin(40,20,30,30);  // velikost okraju 
  $graph->SetMarginColor('oldlace');  // barva pozadí grafu 
  $graph->SetShadow();  // stin grafu 

  // nastaveni titulku (font, barva)
  $titulek = "Mìsíèní návštìvnost ".$month."/".$year;
  $titulek = iconv("cp1250","utf-8", $titulek);
  $graph->title->Set($titulek); 
  $graph->title->SetFont(FF_ARIAL,FS_NORMAL,20); 
  $graph->title->SetColor('darkred'); 

  // nastavení fontu u obou os 
  $graph->xaxis->SetFont(FF_FONT1,FS_NORMAL); 
  $graph->yaxis->SetFont(FF_FONT1,FS_NORMAL,10); 

  // popisky na ose X 
  $graph->xaxis->SetTickLabels($datax); 

  // sloupcovy graf 
  $bplot = new BarPlot($datay); 

  $bplot->SetWidth(20);  // sirka sloupcu 
  $bplot->SetFillGradient('gold4','gold2',GRAD_HOR);  // nastaveni barevneho prechodu u sloupcu 
  $bplot->SetColor('navy');  // barva ramecku sloupcu 

  // pridej sloupcovy graf 
  $graph->Add($bplot); 

  // zobraz graf 
  $graph->Stroke();
?>