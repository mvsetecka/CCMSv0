<h3 class='gb_desc'>Pøidat pøíspìvek do návštìvní knihy</h3>
<?php
	if(isset($post) && $post=="FALSE")
	{
		echo "<div class='gb_error'><p>".$message."</p></div>";
	}
    else
    {
        $jmeno = NULL;
        $email = NULL;
        $web = NULL;
        $zprava = NULL;
    }
?>
<script language="javascript" type="text/javascript" src="admin/includes/tinymce/tiny_mce.js"></script>

<script language="javascript" type="text/javascript">

	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		plugins : "paste",
        oninit : "setPlainText",
		dialog_type : "modal",
		entity_encoding : "raw",
        language: "en",
        theme_advanced_buttons1 : "bold,italic,underline, strikethrough",
        theme_advanced_buttons2 : "",
        theme_advanced_buttons3 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "center",
        theme_advanced_statusbar_location : "",
});

function setPlainText() {
        //var ed = tinyMCE.get('elm1');
        var ed = tinyMCE.activeEditor;

        ed.pasteAsPlainText = true;  

        //adding handlers crossbrowser
        if (tinymce.isOpera || /Firefox\/2/.test(navigator.userAgent)) {
            ed.onKeyDown.add(function (ed, e) {
                if (((tinymce.isMac ? e.metaKey : e.ctrlKey) && e.keyCode == 86) || (e.shiftKey && e.keyCode == 45))
                    ed.pasteAsPlainText = true;
            });
        } else {            
            ed.onPaste.addToTop(function (ed, e) {
                ed.pasteAsPlainText = true;
            });
        }
}
</script>


<div class='gb_form_box'>
<form class='gb_form' action="<?php echo $this->root ?>/guestbook/" method="POST">
    
<?php
			$this->add_text_input('jmeno','jmeno',$language['guestbook_name'][$this->language],$jmeno,30,60);
     		$this->add_text_input('email','email','E-mail',$email,30,60);
     		$this->add_text_input('web','web','Web',$web,30,60);
            $this->add_text_input('antispam','antispam', "Kolik je ètyøi + šest (slovy)?",NULL,10,10);
		 
			$this->add_text_area('zprava','zprava',$language['guestbook_message'][$this->language], $zprava,40,10);
			$this->add_hidden_input('submit',TRUE);
			$this->add_submit_button($language['form_send'][$this->language]);
?>

</form>
</div>
<div class='gb_form_info_box'>
<p>Položky Jméno, E-mail a Zpráva jsou povinné. <br /> <strong>Upozoròujeme, že veškeré vulgární pøíspìvky budou smazány! </strong><br /> <em>Nepoužívejte HTML Tagy!</em></p>
</div>