<?php

$GLOBALS['database']=mysql_connect(SQL_HOST, SQL_USERNAME, SQL_PASSWORD);
mysql_select_db(SQL_DBNAME); //Globální promìnná pro prístup k databázi MySQL
mysql_query("SET NAMES 'cp1250'");

class stranka_admin extends stranka
{
	public $root;

	function __construct()
	{
		$this->root = dirname($_SERVER['PHP_SELF']);
	}
	
	public function get_admin_html_header()
	{
		include('admin-header.php');
	}
	
	public function get_admin_menu()
	{
		//include('admin-menu.php');
		include('admin-menu-dropdown.php');
	}
	
	public function get_admin_header()
	{
		echo "<h1>".$this->get_settings('titulek_webu')." - ".$this->get_settings('web_desc')."</h1>";
		echo "<p>Dnes je: <strong>".date("d.m.Y")."</strong></p>";
		echo "<p>Pøihlášen jako: ".$this->get_user_name($_SESSION['user'])."</p>";
		
		echo "<div class='right'>";
			echo "<p>Verze: <strong>".$this->get_settings('version')."</strong><p>";
			echo "<br />";
			echo "<p>[<a href='..'>>Pøejít na web<</a>]</p>";
			echo "<p>[<a href='logout.php'>>Odhlásit se<</a>]</p>";
		echo "</div>";
	}
	
	public function get_admin_content()
	{
		$admin_content = isset($_GET['action']) ? $_GET['action'] : "";
		if ($admin_content=="config_web")include ("config-web.php");
		if ($admin_content=="config_password")include ("config-password.php");
		if ($admin_content=="config_metadata")include ("config-metadata.php");
		if ($admin_content=="config_content")include ("config-content.php");
		if ($admin_content=="config_mysql")include ("config-mysql.php");
		if ($admin_content=="config_css")include ("config-css.php");
		if ($admin_content=="config_users")include ("config-users.php");
		if ($admin_content=="add_edit_user")include ("config-users-add-edit.php");
	
		if ($admin_content=="show-menu-categories")include ("category-show.php");
		if ($admin_content=="update-menu-categories")include ("category-edit.php");
		if ($admin_content=="pridat-kategorii")include ("category-add.php");
		if ($admin_content=="ankety")include ("polls-show.php");
	
		if ($admin_content=="zobrazit-clanky")include ("article-show-all.php");
		if ($admin_content=="clanky-rozepsane")include ("article-show-saved.php");
		if ($admin_content=="pridej-clanek")include ("article-add-edit.php");
		if ($admin_content=="uprav-clanek")include ("article-add-edit.php");

		if ($admin_content=="pridej-aktualitu")include ("news-add-edit.php");
		if ($admin_content=="upravit-aktualitu")include ("news-add-edit.php");
		if ($admin_content=="zobrazit-aktuality")include ("news-show.php");
		if ($admin_content=="nastaveni-aktualit")include ("news-settings.php");
	
		if ($admin_content=="pridej-text")include ("text-add-edit.php");
		if ($admin_content=="uprav-text")include ("text-add-edit.php");
		if ($admin_content=="zobrazit-texty")include ("text-show-all.php");
		if ($admin_content=="texty-rozepsane")include ("text-show-saved.php");
		
		if ($admin_content=="gb-nastaveni")include ("guestbook-setting.php");
		if ($admin_content=="gb-prispevky")include ("guestbook-posts.php");
		if ($admin_content=="uprav-prispevek")include ("guestbook-edit-post.php");
	
		if ($admin_content=="komentare")include ("comments-show.php");
		if ($admin_content=="uprav-komentar")include ("comments-edit.php");
		if ($admin_content=="komentare-skryte")include ("comments-show-saved.php");
		
		if ($admin_content=="nahrat-obrazek")include ("upload-image.php");
		if ($admin_content=="nahrat-soubor")include ("upload-files.php");
		if ($admin_content=="spravce-souboru")include ("filemanager.php");
		
		if ($admin_content=="vytvorit-galerii")include ("gallery-new.php");
		if ($admin_content=="upravit-galerii")include ("gallery-update.php");
		if ($admin_content=="zobrazit-galerii")include ("gallery-show.php");
		if ($admin_content=="galerie")include ("gallery-list.php");
		
		if ($admin_content=="statistiky")include ("stats-show.php");
		if ($admin_content=="statistiky-login")include ("stats-login.php");
		
		if ($admin_content=="kontaktni-informace")include ("others-contact-edit.php");
		if ($admin_content=="paticka")include ("others-footer.php");
	
		if ($admin_content=="pokus")include ("pokus.php");
		if ($admin_content=="pokus2")include ("pokus2.php");
		if ($admin_content=="pokus3")include ("pokus3.php");
		
		if ($admin_content=="")include ("admin-main-page.php");
		
	}
	
	public function get_last_cat_position()
	{
		$vyber = new db_dotaz("SELECT pozice FROM menu_kategorie ORDER by pozice desc LIMIT 1");
		$vyber->proved_dotaz();
		$zaznam = $vyber->get_vysledek();
		$last_position =  $zaznam['pozice'];
		$vyber = NULL;
		return $last_position;
	}

	public function get_last_subcat_position($clanek_kategorie)
	{
		$vyber = new db_dotaz("SELECT pozice FROM menu_subkategorie WHERE parent='".$clanek_kategorie."' ORDER by pozice desc LIMIT 1");
		$vyber->proved_dotaz();
		$zaznam = $vyber->get_vysledek();
		$last_position =  $zaznam['pozice'];
		$vyber = NULL;
		return $last_position;
	}
	
	public function reorder_subcat_positions($parent)
	{
	$sql_query = ("SELECT pozice FROM menu_subkategorie WHERE parent='".$parent."'");
		$vyber = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
		$pocet_subkategorii = mysql_num_rows($vyber);
		$vyber = mysql_fetch_array($vyber);
		$a = 0;
		do{
			$a = $a + 1;
			$sql_query = ("SELECT pozice FROM menu_subkategorie WHERE parent='".$parent."' AND pozice='".$a."'");
			$vyber = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
			if(mysql_num_rows($vyber)==0)
		 	{
		 	 	$posledni_pozice = stranka_admin::get_last_subcat_position($parent);
		 	 	$b = $a;
				do{
				 	$b=$b+1;
					$sql_query = ("UPDATE menu_subkategorie SET pozice=pozice-1 WHERE pozice='".$b."' AND parent='".$parent."'");
					mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());	
				}while($b<($posledni_pozice+1));
			}
			
		}while($a<$pocet_subkategorii);
	}
	
	public function reorder_category_positions()
	{
	$sql_query = ("SELECT pozice FROM menu_kategorie");
		$vyber = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
		$pocet_kategorii = mysql_num_rows($vyber);
		$vyber = mysql_fetch_array($vyber);
		$a = 0;
		do{
			$a = $a + 1;
			$sql_query = ("SELECT pozice FROM menu_kategorie WHERE pozice='".$a."'");
			$vyber = mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());
			if(mysql_num_rows($vyber)==0)
		 	{
		 	 	$posledni_pozice = stranka_admin::get_last_cat_position();
		 	 	$b = $a;
				do{
				 	$b=$b+1;
					$sql_query = ("UPDATE menu_kategorie SET pozice=pozice-1 WHERE pozice='".$b."'");
					mysql_query($sql_query, $GLOBALS['database']) or die(mysql_error());	
				}while($b<($posledni_pozice+1));
			}
			
		}while($a<$pocet_kategorii);
	}
	
	public function tiny_mce_settings()
	{
		include('admin-tiny-mce-settings.php');
	}
    
    public function tiny_mce_settings_simple()
	{
		include('admin-tiny-mce-settings-simple.php');
	}
	
	public function add_text_input($name,$id,$title,$value, $size, $maxlength){
		echo "<div><label for='".$id."'>".$title."</label><br /><input name='".$name."' id='".$id."' size='".$size."' maxlength='".$maxlength."' value='".$value."' /></div><br />";
	}
	
	public function add_file_input($name,$id,$title){
		echo "<div><label for='".$id."'>".$title."</label><br /><input type='file' name='".$name."' id='".$id."' /></div><br />";
	}

	function add_text_area($name,$id,$title,$value, $cols, $rows){
	   //echo "<div><label for='".$id."'>".$title."</label><br />".$texy_tlacitka."<textarea name='".$name."' id='".$id."' cols='".$cols."' rows='".$rows."'>".$value."</textarea></div><br />";
       echo "<div><label for='".$id."'>".$title."</label><br /><textarea name='".$name."' id='".$id."' cols='".$cols."' rows='".$rows."'>".$value."</textarea></div><br />";
	}
	
	function add_submit_button($value){
		echo "<input type='Submit' value='".$value."' onClick=\"return confirm('Opravdu?')\" />";
	}
	
	function add_hidden_input($name,$value){
		echo "<input type='hidden' name='".$name."' value='".$value."'/>";
	}
	
	function add_checkbox($name,$checked){
		$checked_f = ($checked=="on")?$checked_f="checked":$checked_f=$checked;
		echo "<input type='checkbox' name='".$name."' ".$checked_f." />";
	}
	
	function add_radio_select($name,$id,$title,$value,$checked){
		echo "<div><input type ='radio' name='".$name."' id='".$id."' value='".$value."'".$checked." /><label for='".$id."'>".$title."</label></div>";
	}
	
	public function createthumb($name,$filename,$new_w,$new_h,$thumbs)
	{
		$system=explode('.',$name);
		$src_img=imagecreatefromjpeg($name);

		$old_x=imageSX($src_img);
		$old_y=imageSY($src_img);

		if ($old_x > $old_y)
		{
			$thumb_w=$new_w;
			$thumb_h=$old_y*($new_h/$old_x);
		}

		if ($old_x < $old_y)
		{
			$thumb_w=$old_x*($new_w/$old_y);
			$thumb_h=$new_h;
		}

		if ($old_x == $old_y)
		{
			$thumb_w=$new_w;
			$thumb_h=$new_h;
		}
		
		if ($thumbs==TRUE)
		{
			if ($old_x > $old_y)
			{
				$thumb_h=$new_h;
				$thumb_w=$old_x*($new_w/$old_y);
				//$thumb_w=$new_w;
				//$thumb_h=$old_y*($new_h/$old_x);
			}
			
			if ($old_x < $old_y)
			{
				$thumb_h=$new_h;
				$thumb_w=$old_x*($new_w/$old_y);
			}

			if ($old_x == $old_y)
			{
				$thumb_w=$new_w;
				$thumb_h=$new_h;
			}
			
		}

		$dst_img=imagecreatetruecolor($thumb_w,$thumb_h);
		imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,
		$old_x,$old_y);

		if (preg_match("/png/",$system[1]))
		{
			imagepng($dst_img,$filename);
		}
		else
		{
			imagejpeg($dst_img,$filename);
		}

		imagedestroy($dst_img);
		imagedestroy($src_img);
}
	
	public function get_user_name($username)
	{
		if($username=="admin")
		{
			return($this->get_settings('admin_name'));
		}
		else
		{
			$dotaz = new db_dotaz("SELECT jmeno_prijmeni FROM uzivatele WHERE username = '".$username."' ");
			$dotaz->proved_dotaz();
			$jmeno = $dotaz->get_vysledek();
			$dotaz = NULL;
			return $jmeno['jmeno_prijmeni'];
		}
	}
	
	public function get_user_permission($username, $permission)
	{
		//$query = "SELECT ".$permission." FROM uzivatele WHERE username = '".$username."' LIMIT 1";
		//echo $query;
		//f($_SESSION['user']=='admin')
		if($username=='admin')
		{
			return 'on';
		}
		else
		{
			$dotaz = new db_dotaz("SELECT ".$permission." FROM uzivatele WHERE username = '".$username."' LIMIT 1");
			$dotaz->proved_dotaz();
			$zaznam = $dotaz->get_vysledek();
			return $zaznam[$permission];
		}
	}
	
	public function check_admin($return = FALSE)
	{
		if($return == TRUE)
		{
			if($_SESSION['user']=='admin')
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			if($_SESSION['user']<>'admin')
			{
				echo "<h2>Nemáte oprávnìní</h2>";
				exit;
			}
		}
	}

	public function check_permission($page, $return = FALSE)
	{
		if($return==FALSE)
		{
			if($this->get_user_permission($_SESSION['user'],$page)<>'on')
			{
				echo "<h2>Nemáte oprávnìní</h2>";
				echo $this->get_user_permission($_SESSION['user'],$page);
				exit;
			}
			else
			{
				return True;
			}
		}
		elseif($return==TRUE)
		{
			if($this->get_user_permission($_SESSION['user'],$page)<>'on')
			{
				return false;
			}
			else
			{
				return true;
			}
		}
	}
	
		public function check_menu_permission($menu_id)
		{
			$menu['m2'] = array("opinion_poll","category_edit");
			
			//reset($menu[$menu_id]);
			$permission = FALSE;
			foreach($menu as $v1)
			{
				foreach($v1 as $v2)
				{
					if($this->check_permission($v2, TRUE)==TRUE)
					{
						$permission = TRUE;
					}
				}
			}
			return $permission;
		}
	
	public function dropdown_menu($number, $caption, $items)
	{
	echo "<li id='".$number."_li'><a href='#' 
        onmouseover=\"mopen('".$number."')\" 
        onmouseout='mclosetime()'>".$caption."</a>
        <div id='".$number."' 
            onmouseover='mcancelclosetime()' 
            onmouseout='mclosetime()'>\n";
        $a = 0;
		foreach($items as $v1)
        {
			if(($v1['permission']=='admin' && $this->check_admin(TRUE)) || ($v1['permission']=='everyone'))
			{
				echo "<a href='index.php?action=".$v1['url']."'>".$v1['name']."</a> \n";
				$a++;
			}
			elseif($v1['permission']<>'admin')
			{
				if($this->check_permission($v1['permission'],TRUE))
				{
					echo "<a href='index.php?action=".$v1['url']."'>".$v1['name']."</a>\n";
					$a++;
				}
			}
		}
		if($a==0)
		{
			$li_id = $number."_li";
			?>
			<script type="text/javascript">
				document.getElementById("<?php echo $li_id; ?>").style.display="none";
			</script>
			<?php
		}
		echo "</div></li>";
		$a = NULL;
	}
}
?>