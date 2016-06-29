<?php
	require('admin-security.php');
	
	$galerie['id']=$_GET['gid'];
	$galerie['path'] =("../gallery/".$galerie['id']."/");
	$galerie['path_thumbs'] =("../gallery/".$galerie['id']."/thumbs/");
?>

<h2>Pøidat fotografii do galerie</h2>

<?php
    //echo $galerie['path']."<br />";
	echo "<p><a href='index.php?action=zobrazit-galerii&gid=".$galerie['id']."'>Zpìt na stránku galerie</a></p>";

    require_once("includes/flexupload/class.flexupload.inc.php");

    // should work in most cases to generate the url to the upload file
    // if it don't work, set a hard coded string e.g.
    // $url = 'http://localhost/upload_example.php';
    
    $web_url=$this->get_settings('web_url');
    $url = $web_url."/admin/gallery-add-img-upload.php";
    
    $fup = new FlexUpload($url.'?path='.rawurlencode($galerie['path']).'&gid='.rawurlencode($galerie['id']));
    //$fup = new FlexUpload($url.'?path='.rawurlencode($galerie['path']));
    $fup->setWidth(800);
	$fup->setFileExtensions("*.gif;*.jpeg;*.jpg;*.png");

    $fup->setPathToSWF($web_url."/admin/includes/flexupload/");
    $fup->setPathToSWFObject($web_url."/admin/includes/flexupload/js/");
    $fup->setLocale($web_url."/admin/includes/flexupload/locale/cs.xml");
    $fup->setMaxFileSize(5*1024*1024);
    $fup->printHTML(true, 'flexupload1');
    $fup=NULL;

?>