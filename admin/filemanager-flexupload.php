<?php

/**
 * including the FlexUpload class
 */
 
 echo "<h2>Správce souborù - nahrát soubory</h2>";
 
require_once("includes/flexupload/class.flexupload.inc.php");

// should work in most cases to generate the url to the upload file
// if it don't work, set a hard coded string e.g.
// $url = 'http://localhost/upload_example.php';
$web_url=$this->get_settings('web_url');
$url = $web_url."/admin/includes/flexupload/upload.php";

$path = $_POST['upload_path'];
echo $path;



$fup = new FlexUpload($url.'?path='.rawurlencode($path));
$fup->setWidth(800);

if(preg_match('^../media/files^',$path))
{
	$fup->setFileExtensions("");
}
elseif(preg_match('^../media/images^',$path))
{
	$fup->setFileExtensions("*.gif;*.jpeg;*.jpg;*.png");
}

$fup->setPathToSWF($web_url."/admin/includes/flexupload/");
$fup->setPathToSWFObject($web_url."/admin/includes/flexupload/js/");
$fup->setLocale($web_url."/admin/includes/flexupload/locale/cs.xml");
$fup->setMaxFileSize(5*1024*1024);
$fup->printHTML(true, 'flexupload1');

echo "<br />";
echo "<br />";
echo "<form method='POST' action='index.php?action=spravce-souboru' >";
echo "<input type='submit' value='Zpìt k procházení složek' />";
echo "<input type='hidden' name='path_return' value='".$path."'>";
echo "</form>";
$fup = NULL;
?>