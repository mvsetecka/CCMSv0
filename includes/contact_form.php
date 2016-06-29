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
		$message = "Chyba! Všechny položky kromì telefonního èísla jsou povinné!";
	}
	elseif($this->check_email($email)==FALSE)
	{
		$message = "Chyba! Zadaný email není platný.";
	}
    elseif(!isset($_POST['antispam']) OR strtolower($_POST['antispam'])!="osm")
    {
        $message = "Chyba! Dva krát ètyøi?";
    }
	else
	{
	
	$text_zpravy = "Jméno odesílatele: ".$jmeno." \n\n Text zprávy: ".$text."\n\n Telefon: ".$telefon."\n\n E-mail: ".$email."\n\n ---Konec---";
	
	
	//require_once ("includes/class.phpmailer.php");
    //require_once ("includes/class.smtp.php");
    require_once ("includes/PHPMailerAutoload.php");
	$mail = new PHPMailer();
	$mail->IsSMTP();  // k odeslání e-mailu použijeme SMTP server
	$mail->Host = $this->get_settings('contact_smtp');  // zadáme adresu SMTP serveru
	
	if($this->get_settings('contact_smtp_auth')=="on")
	{
		$mail->SMTPAuth = true; // nastavíme true v pøípadì, že server vyžaduje SMTP autentizaci
		$mail->Username = $this->get_settings('contact_user');   // uživatelské jméno pro SMTP autentizaci
		$mail->Password = $this->get_settings('contact_password'); // heslo pro SMTP autentizaci
	}
	else
	{
		$mail->SMTPAuth = false;
	}
	$mail->Hostname = $this->get_settings('web_url');
	$mail->From = $email;   // adresa odesílatele skriptu
	$mail->FromName = $jmeno; // jméno odesílatele skriptu (zobrazí se vedle adresy odesílatele)
	
	$mail->AddAddress($prijemce);  // pøidáme pøíjemce
	
	$mail->Subject = $predmet;    // nastavíme pøedmìt e-mailu
  	$mail->Body = $text_zpravy;  // nastavíme tìlo e-mailu
  	$mail->WordWrap = 50;   // je vhodné taky nastavit zalomení (po 50 znacích)
  	$mail->CharSet = "windows-1250";   // nastavíme kódování, ve kterém odesíláme e-mail
	
	if(!@$mail->Send()) // odešleme e-mail
	{
     	$message =  '<strong>Došlo k chybì pøi odeslání e-mailu. Chybová hláška: ' . $mail->ErrorInfo.'</strong>';
  	}
  	else
  	{
     	$message =  '<strong>E-mail byl v poøádku odeslán.</strong>';
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
    add_text_input('antispam','antispam','Kolik je dva krát ètyøi (slovy)','',8,8);
	echo "<br />";
	$this->add_submit_button($language['form_send'][$this->language]);
	echo "</h5>";
?>
    </fieldset>

</form>

<?php
}
?>
