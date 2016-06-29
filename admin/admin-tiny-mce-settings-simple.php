<?php

require('admin-security.php');

?>



<script language="javascript" type="text/javascript" src="includes/tinymce/tiny_mce.js"></script>



<script language="javascript" type="text/javascript">

	tinyMCE.init({

		mode : "textareas",

		theme : "advanced",
        
        oninit : "setPlainText",

		plugins : "paste",

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