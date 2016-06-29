<?php
	//echo "<br />".$_SERVER['REQUEST_URI']."<br />";
?>
<h4 class='comment_desc'>Pøidat vlastní komentáø</h4>
<form method="post" action="<?php echo($_SERVER['REQUEST_URI'])?>">
	<fieldset class="komentare_form">
		<table>
		<tr>
		<td><label>Jméno</label></td><td><input type="text" size="20" name="comment_autor_jmeno" /></td>
		</tr>
		<tr>
		<td><label>E-mail</label></td><td><input type="text" size="20" name="comment_autor_email" /></td>
		</tr>
		<tr>
		<td><label>WEB</label></td><td><input type="text" size="20" name="comment_autor_www" /></td>
		</tr>
		<tr>
		<td><label>Komentáø</label></td><td><textarea cols="30" rows="10" name="comment_text"></textarea></td>
		</tr>
		<tr>
		<td>
			<input type="submit" class="SubmitButton" value="Odeslat" name="odesli" />
			<input type="hidden" name="comm_send" value="1" />
		</td>
		</tr>
		</table>
	</fieldset>
</form>

