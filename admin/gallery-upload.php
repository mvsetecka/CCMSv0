<?php
	include './../includes/config.php';
	include './../includes/functions.php';
	include 'session.php';
	include 'admin-functions.php';
	if ($_SESSION['logged']!==1)header("Location:login.php");



// Code for Session Cookie workaround
	if (isset($_POST["PHPSESSID"])) {
		session_id($_POST["PHPSESSID"]);
	} else if (isset($_GET["PHPSESSID"])) {
		session_id($_GET["PHPSESSID"]);
	}

	session_start();

function createthumb($name,$filename,$new_w,$new_h,$thumbs)
	{
		$system=explode('.',$name);
		$src_img=imagecreatefromjpeg($name);

		$old_x=imageSX($src_img);
		$old_y=imageSY($src_img);

		if ($old_x > $old_y)
		{
			$thumb_w=$new_w;
			$thumb_h=$old_y*($new_h/$old_x);
		}

		if ($old_x < $old_y)
		{
			$thumb_w=$old_x*($new_w/$old_y);
			$thumb_h=$new_h;
		}

		if ($old_x == $old_y)
		{
			$thumb_w=$new_w;
			$thumb_h=$new_h;
		}
		
		if ($thumbs==TRUE)
		{
			if ($old_x > $old_y)
			{
				$thumb_h=$new_h;
				$thumb_w=$old_x*($new_w/$old_y);
				//$thumb_w=$new_w;
				//$thumb_h=$old_y*($new_h/$old_x);
			}
			
			if ($old_x < $old_y)
			{
				$thumb_h=$new_h;
				$thumb_w=$old_x*($new_w/$old_y);
			}

			if ($old_x == $old_y)
			{
				$thumb_w=$new_w;
				$thumb_h=$new_h;
			}
			
		}

		$dst_img=imagecreatetruecolor($thumb_w,$thumb_h);
		imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,
		$old_x,$old_y);

		if (preg_match("/png/",$system[1]))
		{
			imagepng($dst_img,$filename);
		}
		else
		{
			imagejpeg($dst_img,$filename);
		}

		imagedestroy($dst_img);
		imagedestroy($src_img);
}




// Check post_max_size (http://us3.php.net/manual/en/features.file-upload.php#73762)
	$POST_MAX_SIZE = ini_get('post_max_size');
	$unit = strtoupper(substr($POST_MAX_SIZE, -1));
	$multiplier = ($unit == 'M' ? 1048576 : ($unit == 'K' ? 1024 : ($unit == 'G' ? 1073741824 : 1)));

	if ((int)$_SERVER['CONTENT_LENGTH'] > $multiplier*(int)$POST_MAX_SIZE && $POST_MAX_SIZE) {
		header("HTTP/1.1 500 Internal Server Error");
		echo "POST exceeded maximum allowed size.";
		exit(0);
	}

// Settings
	$save_path = $_REQUEST['path'];
	$save_path_thumbs = $_REQUEST['path_thumbs'];
	$gallery_id = $_REQUEST['gid'];
	
	$save_path = $_POST['path'];
	$save_path_thumbs = $_POST['path_thumbs'];
	$gallery_id = $_POST['gid'];
	//$gallery_id = $_POST['id']				// The path were we will save the file (getcwd() may not be reliable and should be tested in your environment)
	$upload_name = "Filedata";
	$max_file_size_in_bytes = 2147483647;				// 2GB in bytes
	$extension_whitelist = array("jpg", "gif", "png");	// Allowed file extensions
	$valid_chars_regex = '.A-Z0-9_ !@#$%^&()+={}\[\]\',~`-';				// Characters allowed in the file name (in a Regular Expression format)
	
// Other variables	
	$MAX_FILENAME_LENGTH = 260;
	$file_name = "";
	$file_extension = "";
	$uploadErrors = array(
        0=>"There is no error, the file uploaded with success",
        1=>"The uploaded file exceeds the upload_max_filesize directive in php.ini",
        2=>"The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
        3=>"The uploaded file was only partially uploaded",
        4=>"No file was uploaded",
        6=>"Missing a temporary folder"
	);


// Validate the upload
	if (!isset($_FILES[$upload_name])) {
		HandleError("No upload found in \$_FILES for " . $upload_name);
		exit(0);
	} else if (isset($_FILES[$upload_name]["error"]) && $_FILES[$upload_name]["error"] != 0) {
		HandleError($uploadErrors[$_FILES[$upload_name]["error"]]);
		exit(0);
	} else if (!isset($_FILES[$upload_name]["tmp_name"]) || !@is_uploaded_file($_FILES[$upload_name]["tmp_name"])) {
		HandleError("Upload failed is_uploaded_file test.");
		exit(0);
	} else if (!isset($_FILES[$upload_name]['name'])) {
		HandleError("File has no name.");
		exit(0);
	}
	
// Validate the file size (Warning: the largest files supported by this code is 2GB)
	$file_size = @filesize($_FILES[$upload_name]["tmp_name"]);
	if (!$file_size || $file_size > $max_file_size_in_bytes) {
		HandleError("File exceeds the maximum allowed size");
		exit(0);
	}
	
	if ($file_size <= 0) {
		HandleError("File size outside allowed lower bound");
		exit(0);
	}


// Validate file name (for our purposes we'll just remove invalid characters)
	$file_name = preg_replace('/[^'.$valid_chars_regex.']|\.+$/i', "", basename($_FILES[$upload_name]['name']));
	if (strlen($file_name) == 0 || strlen($file_name) > $MAX_FILENAME_LENGTH) {
		HandleError("Invalid file name");
		exit(0);
	}


// Validate that we won't over-write an existing file
	if (file_exists($save_path . $file_name)) {
		HandleError("File with this name already exists");
		exit(0);
	}

// Validate file extension
	$path_info = pathinfo($_FILES[$upload_name]['name']);
	$file_extension = $path_info["extension"];
	$is_valid_extension = false;
	foreach ($extension_whitelist as $extension) {
		if (strcasecmp($file_extension, $extension) == 0) {
			$is_valid_extension = true;
			break;
		}
	}
	if (!$is_valid_extension) {
		HandleError("Invalid file extension");
		exit(0);
	}

// Validate file contents (extension and mime-type can't be trusted)
	/*
		Validating the file contents is OS and web server configuration dependant.  Also, it may not be reliable.
		See the comments on this page: http://us2.php.net/fileinfo
		
		Also see http://72.14.253.104/search?q=cache:3YGZfcnKDrYJ:www.scanit.be/uploads/php-file-upload.pdf+php+file+command&hl=en&ct=clnk&cd=8&gl=us&client=firefox-a
		 which describes how a PHP script can be embedded within a GIF image file.
		
		Therefore, no sample code will be provided here.  Research the issue, decide how much security is
		 needed, and implement a solution that meets the needs.
	*/


// Process the file
	/*
		At this point we are ready to process the valid file. This sample code shows how to save the file. Other tasks
		 could be done such as creating an entry in a database or generating a thumbnail.
		 
		Depending on your server OS and needs you may need to set the Security Permissions on the file after it has
		been saved.
	*/
	if (@move_uploaded_file($_FILES[$upload_name]["tmp_name"], $save_path.$file_name)) {
		$picture['full_path'] = $save_path.$_FILES[$upload_name]["name"];
		$picture['thumb_path'] = $save_path_thumbs.$_FILES[$upload_name]["name"];
		createthumb($picture['full_path'],$picture['thumb_path'],120,120, TRUE);
		createthumb($picture['full_path'],$picture['full_path'],550,550, FALSE);
		//$query = "INSERT INTO galerie_obrazky VALUES ('".$galerie['images_uploaded']."', '".$_FILES["soubor"]["name"][$key]."', '".$galerie['id']."', '', '".$_FILES["soubor"]["size"][$key]."', '0', '1')";
		$query = "INSERT INTO galerie_obrazky VALUES ('".time()."', '".$_FILES[$upload_name]["name"]."', '".$gallery_id."', '', '".$_FILES[$upload_name]["size"]."', '0', '1')";
		$sql_query = new db_dotaz($query);
		$sql_query->proved_dotaz();
		$sql_query = NULL;
	}
	else
	{
		HandleError("File could not be saved.");
		exit(0);
	}

// Return output to the browser (only supported by SWFUpload for Flash Player 9)

	echo "File Received";
	exit(0);


/* Handles the error output.  This function was written for SWFUpload for Flash Player 8 which
cannot return data to the server, so it just returns a 500 error. For Flash Player 9 you will
want to change this to return the server data you want to indicate an error and then use SWFUpload's
uploadSuccess to check the server_data for your error indicator. */
function HandleError($message) {
	header("HTTP/1.1 500 Internal Server Error");
	echo $message;
}
?>