<?php
	require('admin-security.php');
	$this->check_permission('photogallery_create');
?>

<?php

if(isset($_POST['krok']))
{
    switch($_POST['krok']){
        case "1":
   	        //include_once('gallery-new-2-swfupl.php');
            //include_once('gallery-new-2.php');
            include_once('gallery-new-2-flexupload.php');
        break;
        
        case "2":
            include_once('gallery-new-3.php');
        break;
    }
}else{
    include_once('gallery-new-1.php');
}
?>