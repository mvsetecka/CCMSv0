<?php

require('admin-security.php');

?>



<script language="javascript" type="text/javascript" src="includes/tinymce/tiny_mce.js"></script>



<script language="javascript" type="text/javascript">

	tinyMCE.init({

		mode : "textareas",

		theme : "advanced",

		plugins : "style,table,advhr,advimage,advlink,emotions, contextmenu, xhtmlxtras,inlinepopups, preview, paste",

		dialog_type : "modal",

		entity_encoding : "named",

		language: "en",
        

		theme_advanced_buttons1 : "fontselect,fontsizeselect,|,styleselect,forecolor,backcolor,|,mymenubutton,bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,undo,redo,link,unlink,image",
        theme_advanced_buttons2 : "tablecontrols,|,hr,|,cite, acronym, code",
        theme_advanced_buttons3 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",

		file_browser_callback : "myFileBrowser",
        
        extended_valid_elements: "code",
        
        style_formats : [{title : 'Code', block : 'div', classes : 'inlinecode' }],

		relative_urls : true,

		remove_script_host : true,

		inline_styles : false,

		document_base_url : "<?php echo $this->get_settings('web_url'); ?>/"

});



	function myFileBrowser (field_name, url, type, win) {

	

    //alert("Field_Name: " + field_name + "\nURL: " + url + "\nType: " + type + "\nWin: " + win); // debug/testing



    /* If you work with sessions in PHP and your client doesn't accept cookies you might need to carry

       the session name and session ID in the request string (can look like this: "?PHPSESSID=88p0n70s9dsknra96qhuk6etm5").

       These lines of code extract the necessary parameters and add them back to the filebrowser URL again. */



    //var cmsURL = window.location.toString();    // script URL - use an absolute path!

    var cmsURL = "browser.php";    // script URL - use an absolute path!

    cmsURL = cmsURL + "?type=" + type;



    tinyMCE.activeEditor.windowManager.open({

        file : cmsURL,

        title : 'File Browser',

        width : 750,  // Your dimensions may differ - toy around with them!

        height : 500,

        resizable : "no",

        inline : "yes",  // This parameter only has an effect if you use the inlinepopups plugin!

        close_previous : "no"

    }, {

        window : win,

        input : field_name

    });

    return false;

  }

  

	</script>