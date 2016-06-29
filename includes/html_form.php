<?php

	function add_text_input($name,$id,$title,$value, $size, $maxlength){
		echo "<div><label for='".$id."'>".$title."</label><br /><input name='".$name."' id='".$id."' size='".$size."' maxlength='".$maxlength."' value='".$value."' /></div><br />";
	}
	
	function add_file_input($name,$id,$title){
		echo "<div><label for='".$id."'>".$title."</label><br /><input type='file' name='".$name."' id='".$id."' /></div><br />";
	}

	function add_text_area($name,$id,$title,$value, $cols, $rows){
		echo "<div><label for='".$id."'>".$title."</label><br /><textarea name='".$name."' id='".$id."' cols='".$cols."' rows='".$rows."'>".$value."</textarea></div><br />";
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