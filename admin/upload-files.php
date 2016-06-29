<?php
	require('admin-security.php');
?>

<?php
	if ($_REQUEST["odeslano"]==1)
{
  //if ($_FILES['hloupost']['size']>2000000) die ("Soubor je pøíliš velký ;-(");
  //if (!is_file($_FILES['hloupost']['tmp_name'])) die ("Žádný soubor jste neuploadovali !!!");
  if(is_file($_FILES['soubor_1']['tmp_name']))$path_1 = ("..\media\\files\\" . $_FILES['soubor_1']['name']);
  if(is_file($_FILES['soubor_2']['tmp_name']))$path_2 = ("..\media\\files\\" . $_FILES['soubor_2']['name']);
  if(is_file($_FILES['soubor_3']['tmp_name']))$path_3 = ("..\media\\files\\" . $_FILES['soubor_3']['name']);
  if(is_file($_FILES['soubor_4']['tmp_name']))$path_4 = ("..\media\\files\\" . $_FILES['soubor_4']['name']);
  if(is_file($_FILES['soubor_5']['tmp_name']))$path_5 = ("..\media\\files\\" . $_FILES['soubor_5']['name']);
  
  if(move_uploaded_file($_FILES['soubor_1']['tmp_name'], "$path_1"))echo("Soubor 1 - ".$_FILES['soubor_1']['name']." - ".($_FILES['soubor_1']['size']/1000)." kB - <strong>OK</strong><br />");else echo ("Chyba<br />");
  if(move_uploaded_file($_FILES['soubor_2']['tmp_name'], "$path_2"))echo("Soubor 2 - ".$_FILES['soubor_2']['name']." - ".($_FILES['soubor_2']['size']/1000)." kB - <strong>OK</strong><br />"); else echo "Chyba<br />";
  if(move_uploaded_file($_FILES['soubor_3']['tmp_name'], "$path_3"))echo("Soubor 3 - ".$_FILES['soubor_3']['name']." - ".($_FILES['soubor_3']['size']/1000)." kB - <strong>OK</strong><br />"); else echo "Chyba<br />";
  if(move_uploaded_file($_FILES['soubor_4']['tmp_name'], "$path_4"))echo("Soubor 4 - ".$_FILES['soubor_4']['name']." - ".($_FILES['soubor_4']['size']/1000)." kB - <strong>OK</strong><br />"); else echo "Chyba<br />";
  if(move_uploaded_file($_FILES['soubor_5']['tmp_name'], "$path_5"))echo("Soubor 5 - ".$_FILES['soubor_5']['name']." - ".($_FILES['soubor_5']['size']/1000)." kB - <strong>OK</strong><br />"); else echo "Chyba<br />";
  
 /* if (move_uploaded_file($_FILES['hloupost']['tmp_name'], "$path"))
  {
    echo "Soubor <B>".$_FILES['hloupost']['name']."</B> z Vašeho PC";
    echo " typu <B>".$_FILES['hloupost']['type']."</B>";
    echo " o velikosti <B>".$_FILES['hloupost']['size']."</B> bajtù";
    echo " byl na serveru uložen pod doèasným názevem <B>".$_FILES['hloupost']['tmp_name']."</B>";
    echo " a následnì zpracován.";
  };
  */
};
?>
	<br />
    <form method="POST" ENCTYPE="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]."?".$_SERVER['QUERY_STRING']?>"> 
    <table border="1" >
      <tr>
        <td>Soubor 1</td>
        <td>
        <input type="file" name="soubor_1" accept="image/*" size="40">
        </td>
      </tr>
      <tr>
        <td>Soubor 2</td>
        <td>
        <input type="file" name="soubor_2" accept="image/*" size="40">
        </td>
      </tr>
      <tr>
        <td>Soubor 3</td>
        <td>
        <input type="file" name="soubor_3" accept="image/*" size="40">
        </td>
      </tr>
      <tr>
        <td>Soubor 4</td>
        <td>
        <input type="file" name="soubor_4" accept="image/*" size="40">
        </td>
      </tr>
      <tr>
        <td>Soubor 5</td>
        <td>
        <input type="file" name="soubor_5" accept="image/*" size="40">
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <input type="hidden" name="odeslano" value="1">
          <p><input type="submit" value="Nahrát"></td>
      </tr>
    </table>
    </form>