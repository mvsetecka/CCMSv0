<?php
	switch($this->akce)
	{
		case('zobraz-clanek'):
			if(!isset($_COOKIE["article_".$this->obsah]))
			{
				$zapis_navstevu = new db_dotaz("UPDATE clanky SET zobrazeni = zobrazeni + 1 WHERE id = '".$this->obsah."' AND zobrazovat='ano'");
				
				if($zapis_navstevu->proved_dotaz()!=0)
				{
					$time = (time()+($this->get_settings('views_cookie_time')*60));
					//setcookie("article_".$this->obsah, "visited", $time,"/");
					//echo ($this->get_settings('views_cookie_time')*60);
					setcookie("article_".$this->obsah, "visited", ($time),"/");
					//setcookie("HELLO_WORLD","YES",time()+50000,"/");
				}
				$zapis_navstevu = NULL;
			}
		break;
		
		case('zobraz-text'):
			if(!isset($_COOKIE["text_".$this->obsah]))
			{
				$zapis_navstevu = new db_dotaz("UPDATE texty SET zobrazeni = zobrazeni + 1 WHERE id = '".$this->obsah."' AND (zobrazovat='ano' OR zobrazovat='nmenu')");
				
				if($zapis_navstevu->proved_dotaz()!=0)
				{
					$time = time()+($this->get_settings('views_cookie_time')*60);
					setcookie("text_".$this->obsah, "visited", $time,"/");
					
				}
				$zapis_navstevu = NULL;
			}
		break;
		
		case('galerie'):
		case('gal_show_img'):
			if(isset($_GET['gallery_id']))
			{
				$gid = $_GET['gallery_id'];
				if(!isset($_COOKIE["gallery_".$gid]))
				{
					$zapis_navstevu = new db_dotaz("UPDATE galerie SET zobrazeni = zobrazeni + 1 WHERE url = '".$gid."' AND stav = 1");
					
					if($zapis_navstevu->proved_dotaz()!=0)
					{
					$time = time()+($this->get_settings('views_cookie_time')*60);
					setcookie("gallery_".$gid, "visited", $time,"/");
					
					}
				}	
			}
		break;
		
	}


?>