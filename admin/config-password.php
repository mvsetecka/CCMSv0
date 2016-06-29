<?php
	require('admin-security.php');
?>

<?php
echo "<h2>Zmìna pøístupového hesla</h2>";

if (isset($_POST['admin_password']) && isset($_POST['admin_password_again']) && $_POST['admin_password'] <>NULL and $_POST['admin_password_again']<>NULL)
{
	if($_POST['admin_password']==$_POST['admin_password_again'])
	{
		if (strlen($_POST["admin_password"])<5)
		{
			echo "<p>Minimální délka hesla je 5 znakù!";
		}
		else
		{
			$heslo = md5($_POST["admin_password"]);
			
			if($_SESSION['user']=='admin')
			{
				$this->set_settings('admin_pass_md5', $heslo);	
			}
			else
			{
				$query = new db_dotaz("UPDATE uzivatele SET password = '".$heslo."' WHERE username = '".$_SESSION['user']."' LIMIT 1");
				$query->proved_dotaz();
				$query = NULL;
			}
			
			echo "<p>Heslo bylo úspìšnì zmìnìno</p>";
			
		}
	}
	else
	{
		echo "<p>Zadaná hesla se neshodují. Zkuste to znovu.<p>";
	}
}
?>

<form method="POST" action="<?php echo($_SERVER["PHP_SELF"])."?".$_SERVER["QUERY_STRING"] ?>">
	<fieldset style="width: 300px">
	<legend>Zmìna heska</legend>
	<table style='border: none;'>
		<tr><td><label>Heslo</label></td>
		<td><input type="password" name="admin_password" size="20" maxlenght="20"></td></tr>
		<tr><td><label>Potvrzení hesla</label></td>
		<td><input type="password" name="admin_password_again" size="20" maxlenght="20"></td></tr>
	</table>
	<br />
	<input type="Submit" value="Uložit" />
	</fieldset>
</form>