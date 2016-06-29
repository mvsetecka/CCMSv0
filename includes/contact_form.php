<?php
	if($this->get_settings('contact_form')=="on")
	{
	
	include('includes/language.php');
	
	if(isset($_POST['jmeno']))
	{	
	
	$prijemce = $this->get_settings('contact_mail');
	$predmet = $this->get_settings('contact_header')." - ".$this->get_settings('titulek_webu');
    $charset = "windows-1250";
	$encoded_subject="=?$charset?B?".base64_encode($predmet)."?=\n";
	$predmet = $encoded_subject; 
	$jmeno = $_POST['jmeno'];
	$text = $_POST['zprava'];
	$telefon = $_POST['telefon'];
	$email = $_POST['email'];
	
	if($jmeno == "" || $text == "" || $email=="")
	{
		$message = "Chyba! V�echny polo�ky krom� telefonn�ho ��sla jsou povinn�!";
	}
	elseif($this->check_email($email)==FALSE)
	{
		$message = "Chyba! Zadan� email nen� platn�.";
	}
    elseif(!isset($_POST['antispam']) OR strtolower($_POST['antispam'])!="osm")
    {
        $message = "Chyba! Dva kr�t �ty�i?";
    }
	else
	{
	
	$text_zpravy = "Jm�no odes�latele: ".$jmeno." \n\n Text zpr�vy: ".$text."\n\n Telefon: ".$telefon."\n\n E-mail: ".$email."\n\n ---Konec---";
	
	
	//require_once ("includes/class.phpmailer.php");
    //require_once ("includes/class.smtp.php");
    require_once ("includes/PHPMailerAutoload.php");
	$mail = new PHPMailer();
	$mail->IsSMTP();  // k odesl�n� e-mailu pou�ijeme SMTP server
	$mail->Host = $this->get_settings('contact_smtp');  // zad�me adresu SMTP serveru
	
	if($this->get_settings('contact_smtp_auth')=="on")
	{
		$mail->SMTPAuth = true; // nastav�me true v p��pad�, �e server vy�aduje SMTP autentizaci
		$mail->Username = $this->get_settings('contact_user');   // u�ivatelsk� jm�no pro SMTP autentizaci
		$mail->Password = $this->get_settings('contact_password'); // heslo pro SMTP autentizaci
	}
	else
	{
		$mail->SMTPAuth = false;
	}
	$mail->Hostname = $this->get_settings('web_url');
	$mail->From = $email;   // adresa odes�latele skriptu
	$mail->FromName = $jmeno; // jm�no odes�latele skriptu (zobraz� se vedle adresy odes�latele)
	
	$mail->AddAddress($prijemce);  // p�id�me p��jemce
	
	$mail->Subject = $predmet;    // nastav�me p�edm�t e-mailu
  	$mail->Body = $text_zpravy;  // nastav�me t�lo e-mailu
  	$mail->WordWrap = 50;   // je vhodn� taky nastavit zalomen� (po 50 znac�ch)
  	$mail->CharSet = "windows-1250";   // nastav�me k�dov�n�, ve kter�m odes�l�me e-mail
	
	if(!@$mail->Send()) // ode�leme e-mail
	{
     	$message =  '<strong>Do�lo k chyb� p�i odesl�n� e-mailu. Chybov� hl�ka: ' . $mail->ErrorInfo.'</strong>';
  	}
  	else
  	{
     	$message =  '<strong>E-mail byl v po��dku odesl�n.</strong>';
  	}
	
	}
	}
?>


<form action="<?php echo $this->root ?>/kontakt/" method="POST">
    
	<fieldset class='contact_form'>
<?php

	//echo "<legend><strong>".$language['guestbook_title'][$this->language]."</strong></legend>";
	echo "<h3 class='contact_form_title'>".$language['guestbook_title'][$this->language]."</h3>";
	if(isset($message))
    {
        echo "<h4 class='contact_form_error_message'>".$message."</h4>";
	}
    
	echo "<h5>";
	add_text_input('jmeno','jmeno',$language['guestbook_name'][$this->language],'',30,30);
	add_text_input('telefon','telefon',$language['contact_phone'][$this->language],'',30,30);
	add_text_input('email','email','E-mail','',30,30);
	echo "<br />";
	add_text_area('zprava','zprava','Text','',30,8);
    add_text_input('antispam','antispam','Kolik je dva kr�t �ty�i (slovy)','',8,8);
	echo "<br />";
	$this->add_submit_button($language['form_send'][$this->language]);
	echo "</h5>";
?>
    </fieldset>

</form>

<?php
}
?>
