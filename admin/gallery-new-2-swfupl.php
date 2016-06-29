<?php
	require('admin-security.php');
	$galerie['nazev'] = $_POST['galerie_nazev'];
	$galerie['popis'] = $_POST['galerie_popis'];
	$galerie['id'] = $this->friendly_url($galerie['nazev']);
	
	$galerie['path'] =("../gallery/".$galerie['id']."/");
	$galerie['path_thumbs'] =("../gallery/".$galerie['id']."/thumbs/");
	mkdir($galerie['path'], 0700, TRUE);
	mkdir($galerie['path_thumbs'], 0700, TRUE);
	$galerie['images_uploaded']=0;
		
	$query = ("INSERT INTO galerie VALUES ('".$galerie['id']."', '".$galerie['nazev']."', '".$galerie['popis']."', '".time()."', '0', '0', '', '0')");
	$sql_query = new db_dotaz($query);
	$sql_query->proved_dotaz();
	$sql_query = NULL;
	
	echo "<h2>Vytvoøit novou fotogalerii - Krok 2/3 - Nahrát fotografie</h2>";
	
	require('admin-swf-settings.php');
?>

<div id="content">
	<form id="form1" action="index.php?action=gallery-new" method="post" enctype="multipart/form-data">
			
			
			<div class="" id="fsUploadProgress">
				<span class="legend">Fronta</span>
			</div>
			<div id="divStatus">Úspìšnì nahráno fotografií: <b>0</b></div>
			<div>
			
				<span id="spanButtonPlaceHolder"></span>
				
				<input id="btnCancel" type="button" value="Zrušit" onclick="cancelQueue(swfu);" disabled="disabled" style="font-size: 8pt;" />
				
				<br />
				
				
				
			</div>

	</form>
</div>


<div id="uploadcount"></div>
<?php
	echo "<form method='post' action='".$_SERVER["PHP_SELF"]."?".$_SERVER['QUERY_STRING']."' >";
		$this->add_hidden_input("krok","2");
		$this->add_hidden_input("id",$galerie['id']);
		?>
			<input id="btnContinue" type="submit" value="Pokraèovat k vytvoøení galerie" disabled="disabled" style="font-size: 8pt;" />

</form>