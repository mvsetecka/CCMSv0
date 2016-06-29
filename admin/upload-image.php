<?php
	require('admin-security.php');
?>

<?php 
//error_reporting(E_ALL);
	if ($_REQUEST["odeslano"]==1)
{
  //if ($_FILES['hloupost']['size']>2000000) die ("Soubor je pøíliš velký ;-(");
  //if (!is_file($_FILES['hloupost']['tmp_name'])) dief ("Žádný soubor jste neuploadovali !!!");
  if(is_file($_FILES['obrazek_1']['tmp_name']))$path_1 = ("..\media\\images\\" . $_FILES['obrazek_1']['name']);
  if(is_file($_FILES['obrazek_2']['tmp_name']))$path_2 = ("..\media\\images\\" . $_FILES['obrazek_2']['name']);
  if(is_file($_FILES['obrazek_3']['tmp_name']))$path_3 = ("..\media\\images\\" . $_FILES['obrazek_3']['name']);
  if(is_file($_FILES['obrazek_4']['tmp_name']))$path_4 = ("..\media\\images\\" . $_FILES['obrazek_4']['name']);
  if(is_file($_FILES['obrazek_5']['tmp_name']))$path_5 = ("..\media\\images\\" . $_FILES['obrazek_5']['name']);
  
  if(move_uploaded_file($_FILES['obrazek_1']['tmp_name'], "$path_1"))echo($_FILES['obrazek_1']['name']." - <strong>OK</strong><br />");else echo ("Chyba<br />");
  if(move_uploaded_file($_FILES['obrazek_2']['tmp_name'], "$path_2"))echo($_FILES['obrazek_2']['name']." - <strong>OK</strong><br />"); else echo "Chyba<br />";
  if(move_uploaded_file($_FILES['obrazek_3']['tmp_name'], "$path_3"))echo($_FILES['obrazek_3']['name']." - <strong>OK</strong><br />"); else echo "Chyba<br />";
  if(move_uploaded_file($_FILES['obrazek_4']['tmp_name'], "$path_4"))echo($_FILES['obrazek_4']['name']." - <strong>OK</strong><br />"); else echo "Chyba<br />";
  if(move_uploaded_file($_FILES['obrazek_5']['tmp_name'], "$path_5"))echo($_FILES['obrazek_5']['name']." - <strong>OK</strong><br />"); else echo "Chyba<br />";
  
 /* if (move_uploaded_file($_FILES['hloupost']['tmp_name'], "$path"))
  {
    echo "Soubor <B>".$_FILES['hloupost']['name']."</B> z Vašeho PC";
    echo " typu <B>".$_FILES['hloupost']['type']."</B>";
    echo " o velikosti <B>".$_FILES['hloupost']['size']."</B> bajtù";
    echo " byl na serveru uložen pod doèasným názevem <B>".$_FILES['hloupost']['tmp_name']."</B>";
    echo " a následnì zpracován.";
  };
  */
}
?>
	<br />
    <form method="POST" ENCTYPE="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]."?".$_SERVER['QUERY_STRING']?>"> 
    <table border="1" >
      <tr>
        <td>Obrázek 1</td>
        <td>
        <input type="file" name="obrazek_1" accept="image/*" size="40">
        </td>
      </tr>
      <tr>
        <td>Obrázek 2</td>
        <td>
        <input type="file" name="obrazek_2" accept="image/*" size="40">
        </td>
      </tr>
      <tr>
        <td>Obrázek 3</td>
        <td>
        <input type="file" name="obrazek_3" accept="image/*" size="40">
        </td>
      </tr>
      <tr>
        <td>Obrázek 4</td>
        <td>
        <input type="file" name="obrazek_4" accept="image/*" size="40">
        </td>
      </tr>
      <tr>
        <td>Obrázek 5</td>
        <td>
        <input type="file" name="obrazek_5" accept="image/*" size="40">
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <input type="hidden" name="odeslano" value="1">
          <p><input type="submit" value="Nahrát"></td>
      </tr>
    </table>
    </form>