<?php
// odesilaci skript
if(isset($_POST['submit'])) {

  $jmeno = strip_tags($_POST['jmeno']);
  $web = htmlspecialchars($_POST['web'], ENT_QUOTES|ENT_SUBSTITUTE);
  $email = htmlspecialchars($_POST['email'], ENT_QUOTES|ENT_SUBSTITUTE);
  $addr = $_SERVER['REMOTE_ADDR'];
  $zprava = htmlspecialchars($_POST['zprava'], ENT_QUOTES|ENT_IGNORE,"iso-8859-1");
  //echo $zprava;
  
  
  $post = "TRUE";
  
   // text zpravy a jmeno jsou povinna
   // if ((($zprava=="") || ($jmeno=="")) || ((empty($zprava)) || (empty($jmeno)))) {
   if(!$_POST['antispam'] OR strtolower($_POST['antispam'])!="deset")
   {
        $post = "FALSE";
        $message = "Ètyøi + šest?";
   }
   
   
   if (empty($zprava))
    {
      $post = "FALSE";
      $message = $message."<br/>Nezadali jste text zprávy.";
    }
    
    if (empty($jmeno))
    {
      $post = "FALSE";
      $message = $message."<br/>Nezadali jste jméno";
    }
    
    
    if (!preg_match("~@~", $email)) {
      $post = "FALSE";
      $message = $message."<br/>Chyba v e-mailové adrese...";
    }

    // pokud je ve zprave vic jak 10 retezcu http:// jedna se pravdepodobne o spam
    if (substr_count($zprava, 'http://') > 10) {
      $post = "FALSE";
      $message = $message."<br/>Zpráva je pro spam-filtr pøíliš podezøelá...";
    }
 
    // pokud prispevek prosel vsemi kontrolami, ulozime ho do databaze
    if ($post != "FALSE")
    {
    
      $zprava = SubStr($zprava, 0, 1500); // pouze prvnich 1500 znaku
      $zprava = Trim($zprava);
      $zprava = Str_Replace("\n","<br />", $zprava); // nahradime odradkovani tagem br

      // datum pouze v jednoduchem formatu
      $datum = Date("j. " . "m. " . "Y,  " . "H:i:s");
        
      // ulozime do databaze  
      $sql_query = new db_dotaz("INSERT INTO guestbook SET jmeno='".$jmeno."', datum='".$datum."', addr='".$addr."', email='".$email."', web='".$web."', text='".$zprava."';");
      $sql_query->proved_dotaz();
      $sql_query = NULL;
		
		$jmeno = NULL;
  		$zprava = NULL;
  		$web = NULL;
  		$email = NULL;
  		$addr = NULL;
    }
}

?>  
