<?php
	include('./../includes/config.php');
	include('./../includes/functions.php');
	include('admin-functions.php');
	$browser = new stranka_admin; 
?>

<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<script language="javascript" type="text/javascript" src="includes/tinymce/tiny_mce_popup.js"></script>

<script language="javascript" type="text/javascript">
var FileBrowserDialogue = {
    init : function () {
        // Here goes your code for setting your custom things onLoad.
        var win = tinyMCEPopup.getWindowArg("window");
		var input = tinyMCEPopup.getWindowArg("input");
		var res = tinyMCEPopup.getWindowArg("resizable");
		var inline = tinyMCEPopup.getWindowArg("inline");
    },
    mySubmit : function () {
		
	}
}

function send_picture(URL, preview){
		var win = tinyMCEPopup.getWindowArg("window");
		win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = URL;
		//win.ImageDialog.getImageData();
        win.ImageDialog.showPreviewImage(URL);
		tinyMCEPopup.close();
};

function send_link(url, title){
 	var win = tinyMCEPopup.getWindowArg("window");
 	win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = url;
	win.document.getElementById("title").value = title;
	tinyMCEPopup.close();
};

tinyMCEPopup.onInit.add(FileBrowserDialogue.init, FileBrowserDialogue);
		
</script>

</head>


<?php

switch($_GET['type'])
{
	case "image":
		require_once('browser-pictures.php');
	break;
	
	case "file":
		require_once('browser-links.php');
	break;
}
?>


</html>