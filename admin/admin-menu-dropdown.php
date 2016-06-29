<?php
require('admin-security.php');
?>

<script type="text/javascript" src="includes/js/dropdown.js"></script>

<ul id="sddm">
    <?php
    
    	/*
		$items[]['url'] = '';
		$items[]['name'] = '';
		$items[]['permission'] = ''; 
		*/
    
    	$items = array();
		$items[1]['url'] = 'config_web';
		$items[1]['name'] = 'Globální konfigurace';
		$items[1]['permission'] = 'admin';
		$items[2]['url'] = 'config_content';
		$items[2]['name'] = 'Publikování/Obsah';
		$items[2]['permission'] = 'admin';
		$items[3]['url'] = 'config_metadata';
		$items[3]['name'] = 'METAdata';
		$items[3]['permission'] = 'admin';
		$items[4]['url'] = 'config_password';
		$items[4]['name'] = 'Prístupové heslo';
		$items[4]['permission'] = 'everyone';
		$items[5]['url'] = 'config_css';
		$items[5]['name'] = 'Konfigurace stylu';
		$items[5]['permission'] = 'admin';
		$items[6]['url'] = 'config_users';
		$items[6]['name'] = 'Správa uživatelù';
		$items[6]['permission'] = 'admin';
		$items[7]['url'] = 'paticka';
		$items[7]['name'] = 'Upravit patièku';
		$items[7]['permission'] = 'admin';
		$this->dropdown_menu('m1','Nastavení',$items);	
		$items = NULL;
    
				
		$items[1]['url'] = "show-menu-categories";
		$items[1]['name'] = "Upravit menu";
		$items[1]['permission'] = "category_edit";
		$items[2]['url'] = 'ankety';
		$items[2]['name'] = 'Ankety'; 
		$items[2]['permission'] = 'opinion_poll';
		$items[3]['url'] = 'pridat-kategorii&param=sub';
		$items[3]['name'] = 'Pridat kategorii èlánkù';
		$items[3]['permission'] = 'category_edit';
		$this->dropdown_menu('m2','Postranní menu',$items);
		$items = NULL;
	
		$items[1]['url'] = 'pridej-aktualitu';
		$items[1]['name'] = 'Pøidat novinku';
		$items[1]['permission'] = 'news_add';
		$items[2]['url'] = 'zobrazit-aktuality';
		$items[2]['name'] = 'Zobrazit všechny';
		$items[2]['permission'] = 'news_add';
		$items[3]['url'] = 'nastaveni-aktualit';
		$items[3]['name'] = 'Nastavení';
		$items[3]['permission'] = 'news_add';
		$this->dropdown_menu('m3','Novinky',$items);
		$items = NULL;
	
		$items[1]['url'] = 'pridej-text';
		$items[1]['name'] = 'Pøidat text';
		$items[1]['permission'] = 'text_add';
		$items[2]['url'] = 'zobrazit-texty';
		$items[2]['name'] = 'Zobrazit publikované';
		$items[2]['permission'] = 'text_edit';
		$items[3]['url'] = 'texty-rozepsane';
		$items[3]['name'] = 'Rozepsané';
		$items[3]['permission'] = 'text_add';
		$this->dropdown_menu('m4','Texty',$items);
		$items = NULL;
		
		$items[1]['url'] = 'pridej-clanek';
		$items[1]['name'] = 'Pridat èlánek';
		$items[1]['permission'] = 'article_add';
		$items[2]['url'] = 'zobrazit-clanky';
		$items[2]['name'] = 'Zobrazit publikované';
		$items[2]['permission'] = 'article_edit';
		$items[3]['url'] = 'clanky-rozepsane';
		$items[3]['name'] = 'Rozepsané';
		$items[3]['permission'] = 'article_add';
		$this->dropdown_menu('m5','Èlánky',$items);
		$items = NULL;
		
		$items[1]['url'] = 'gb-nastaveni';
		$items[1]['name'] = 'Nastavení';
		$items[1]['permission'] = 'guestbook_edit';
		$items[2]['url'] = 'gb-prispevky';
		$items[2]['name'] = 'Pøíspìvky';
		$items[2]['permission'] = 'guestbook_edit';
		$this->dropdown_menu('m6','Návštìvní kniha',$items);
		$items = NULL;
		
		$items[1]['url'] = 'komentare';
		$items[1]['name'] = 'Zobrazit komentáre';
		$items[1]['permission'] = 'comments_edit';
		$items[2]['url'] = 'komentare-skryte';
		$items[2]['name'] = 'Skryté komentáre';
		$items[2]['permission'] = 'comments_edit';
		$this->dropdown_menu('m7','Komentáøe',$items);
		$items = NULL;
		
		$items[1]['url'] = 'spravce-souboru';
		$items[1]['name'] = 'Správce souborù';
		$items[1]['permission'] = 'filemanager';
		$this->dropdown_menu('m8','Soubory',$items);
		$items = NULL;
		
		$items[1]['url'] = 'galerie';
		$items[1]['name'] = 'Správce galerií';
		$items[1]['permission'] = 'photogallery_edit';
		$items[2]['url'] = 'vytvorit-galerii';
		$items[2]['name'] = 'Vytvoøit novou';
		$items[2]['permission'] = 'photogallery_create';
		$this->dropdown_menu('m9','Fotogalerie',$items);
		$items = NULL;
		
		$items[1]['url'] = 'statistiky';
		$items[1]['name'] = 'Statistiky pøístupù';
		$items[1]['permission'] = 'everyone';
		$items[2]['url'] = 'statistiky-login';
		$items[2]['name'] = 'Pokusy o pøihlášení';
		$items[2]['permission'] = 'admin';
		$this->dropdown_menu('m10','Statistiky',$items);
		$items = NULL;
	?>
</ul>
<div style="clear:both"></div>