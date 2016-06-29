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
    //echo $galerie['path'];
	
	echo "<h2>Vytvoøit novou fotogalerii - Krok 2/3 - Nahrát fotografie</h2>";
	
	require_once("includes/flexupload/class.flexupload.inc.php");

    // should work in most cases to generate the url to the upload file
    // if it don't work, set a hard coded string e.g.
    // $url = 'http://localhost/upload_example.php';
    $web_url=$this->get_settings('web_url');
    $url = $web_url."/admin/includes/flexupload/upload.php";
    
    $fup = new FlexUpload($url.'?path='.rawurlencode($galerie['path']));
    $fup->setWidth(800);
	$fup->setFileExtensions("*.gif;*.jpeg;*.jpg;*.png");

    $fup->setPathToSWF($web_url."/admin/includes/flexupload/");
    $fup->setPathToSWFObject($web_url."/admin/includes/flexupload/js/");
    $fup->setLocale($web_url."/admin/includes/flexupload/locale/cs.xml");
    $fup->setMaxFileSize(5*1024*1024);
    $fup->printHTML(true, 'flexupload1');
    $fup=NULL;
    
    echo "<p><strong>Pokraèovat k vytvoøení galerie</strong></p>";
			echo "<form method='post' action='".$_SERVER["PHP_SELF"]."?".$_SERVER['QUERY_STRING']."' >";
				$this->add_hidden_input("krok","2");
				$this->add_hidden_input("id",$galerie['id']);
				$this->add_submit_button("Pokraèovat");
			echo "</form>";

?>