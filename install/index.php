<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs">

<head>
    <title>Instalace</title>
    <meta http-equiv="content-type" content="text/html; charset=windows-1250" />
    <meta http-equiv="content-language" content="cs" />
</head>

<body>
<p>Instalace CLOCKWORK CMS v0.9beta</p>
	<form action="install-script.php" method="post">
		<?php
			add_text_input('db_server','db_server','Jméno (adresa) databázového serveru','localhost',20,20);
			add_text_input('db_name','db_name','Jméno databáze','',20,20);
			add_text_input('db_user','db_user','Uživatel','root',20,20);
			add_pass_input('db_pass','db_pass','Heslo','',20,20);
			echo "<br />";
			echo "<br />";
			add_pass_input('admin_pass','admin_pass','Heslo do administrace','',20,20);
			add_pass_input('admin_pass_rep','admin_pass_rep','Heslo znovu','',20,20);
			
			add_text_input('www','www','Adresa stránek (bez lomítka na konci např. http://www.example.com)','',50,50);
			add_submit_button('Vytvořit');
		?>
	</form>
</body>
</html>




<?php
function add_text_input($name,$id,$title,$value, $size, $maxlength){
	echo "<div><label for='".$id."'>".$title."</label><br /><input name='".$name."' id='".$id."' size='".$size."' maxlength='".$maxlength."' value='".$value."' /></div><br />";
}

function add_pass_input($name,$id,$title,$value, $size, $maxlength){
	echo "<div><label for='".$id."'>".$title."</label><br /><input type='password' name='".$name."' id='".$id."' size='".$size."' maxlength='".$maxlength."' value='".$value."' /></div><br />";
}

function add_text_area($name,$id,$title,$value, $cols, $rows){
	echo "<div><label for='".$id."'>".$title."</label><br />".$texy_tlacitka."<textarea name='".$name."' id='".$id."' cols='".$cols."' rows='".$rows."'>".$value."</textarea></div><br />";
}

function add_submit_button($value){
	echo "<input type='Submit' value='".$value."' onClick=\"return confirm('Opravdu?')\" />";
}

function add_hidden_input($name,$value){
	echo "<input type='hidden' name='".$name."' value='".$value."'/>";
}

function add_checkbox($name,$checked){
	echo "<input type='checkbox' name='".$name."' ".$checked." />";
}

function add_radio_select($name,$id,$title,$value,$checked){
	echo "<div><input type ='radio' name='".$name."' id='".$id."' value='".$value."'".$checked." /><label for='".$id."'>".$title."</label></div>";
}
?>