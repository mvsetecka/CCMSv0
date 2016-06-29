<?php
$GLOBALS["database"]=mysql_connect(SQL_HOST, SQL_USERNAME, SQL_PASSWORD);
mysql_select_db(SQL_DBNAME); //Glob·lnÌ promÏnn· pro prÌstup k datab·zi MySQL
mysql_query("SET NAMES 'cp1250'");

class db_dotaz{
	
	private $dotaz;
	private $vysledek;
	
	function __construct($vlozeny_dotaz){
		$this->dotaz = $vlozeny_dotaz;
	}

	public function proved_dotaz(){
		$this->vysledek = mysql_query($this->dotaz)or die(mysql_error());
		$this->mysql_queries_count();
		return $this->vysledek;
	}
	
	public function pocet_vysledku(){
		return mysql_num_rows($this->vysledek);
	}
	
	public function get_vysledek(){
		return mysql_fetch_assoc($this->vysledek);
	}
	
	public function opraveno_zaznamu(){
		$zaznamu = mysql_affected_rows($this->vysledek);
		//return 
	}
	
	private function mysql_queries_count()
	{
		$query = "UPDATE nastaveni SET hodnota = hodnota + 1 WHERE param = 'mysql_queries'";
		 mysql_query($query);
	}
	
}

class stranka{
	private $kategorie;
	private $kategorie_nazev;
	private $obsah;
	private $akce;
	private $web_title;
	public $root;
	public $page_title;
	public $anketa_stav;

	function __construct()
	{
	    //$param=isset($_GET['param']) ? $_GET['param'] : 'default';
		$this->anketa();
	 	$this->set_language();
		$this->hlavni_kategorie = isset($_GET['main_cat']) ? $_GET['main_cat'] : '' ;
		$this->kategorie = isset($_GET['category']) ? $_GET['category'] : '';
		$this->obsah = isset($_GET['item']) ? $_GET['item'] : '';
		$this->obsah_stats = NULL;
		$this->akce = isset($_GET['action']) ? $_GET['action'] : '';
		$this->root = dirname($_SERVER['PHP_SELF']);
		if($this->root=="/")
		{
			$this->root="";
		}
		$this->write_visit(); 
		
		$this->web_title = $this->get_settings('titulek_webu');
		if($this->get_settings('web_status')=='closed')
		{
		 	$allowed_ip = $this->get_settings('allowed_ip');
		 	$allowed_ip = explode(";",$allowed_ip);
		 	$this_ip = $_SERVER['REMOTE_ADDR'];
		 	
		 	foreach ($allowed_ip as $value)
			{
    			if($value==$this_ip)
    			{
					$web_allowed=TRUE;		
				}else{
				    $web_allowed=FALSE;
				}
			}
		 	
		 	if(!$web_allowed)
		 	{
			echo "<h1>".$this->get_settings('web_closed_message')."</h1>";
			echo "Vaöe IP adresa je: ".$_SERVER['REMOTE_ADDR'];
			exit;
			}
		}
		
		if(isset($_POST['comm_send']) && $_POST['comm_send']==1)
		{
			include_once('includes/comments_script.php');
		}
	
		$this->pre_load();
		
		if($this->get_settings('stats')=='1')
		{
			$this->write_stats();	
		}
		
	}
	
	public function header()
	{
		include ('includes/page_header.php');
	}
	
	public function set_language()
	{
			if(isset($_GET['lang']))
			{
				$_SESSION['language'] = $_GET['lang'];
				$this->language = $_SESSION['language'];
			}
			else
			{
			 	if(isset($_SESSION['language']))
				{
					$this->language = $_SESSION['language'];
				}
				else
				{
					$_SESSION['language'] = "CZ";
					$this->language = $_SESSION['language'];	
				}
			}
			if($this->language<>"CZ")
			{
			 	$temp = strtolower("lang_".$this->language);
			 	
				if($this->get_settings($temp)=='on')
				{
					
				}
				else
				{
					$this->language = "CZ";
				}
			}
	}
	
	private function anketa()
	{
		$sql_query = new db_dotaz("SELECT nazev FROM anketa WHERE id=1");
		$sql_query->proved_dotaz();
		$zaznam=$sql_query->get_vysledek();
		$sql_query=NULL;
		$susenka=$zaznam['nazev'];
		
		if(isset($_COOKIE[$susenka]) && $_COOKIE[$susenka]=="TRUE")
		{
			$this->anketa_stav = 1;
		}
		else
		{
			if(isset($_REQUEST['hlas']))
			{
				$hlas_id = $_REQUEST['hlas']."_hlasu";
				$sql_query = new db_dotaz("UPDATE anketa SET ".$hlas_id."=".$hlas_id."+1");
				$sql_query->proved_dotaz();
				$sql_query=NULL;
				$sql_query = new db_dotaz("SELECT nazev FROM anketa WHERE id=1");
				$sql_query->proved_dotaz();
				$zaznam=$sql_query->get_vysledek();
				$sql_query=NULL;
				$cookie_time = time()+($this->get_settings('poll_cookie_time')*60*60);
				setcookie($zaznam['nazev'],"TRUE",$cookie_time,"/");
                //setcookie($zaznam['nazev'],"TRUE",time() + 60*60,"/");
				$this->anketa_stav = 1;
				//define("ANKETA", 1);
			}
			else
			{
				$this->anketa_stav = 0;
			}
		}
	}
	
	private function pre_load()
	{
	 	
	 	include('includes/language.php');
	 	
		$nazev_kategorie = new db_dotaz("SELECT nazev FROM menu_subkategorie WHERE url='".$this->kategorie."' LIMIT 1");
		$nazev_kategorie->proved_dotaz();
		$zaznam=$nazev_kategorie->get_vysledek();
		$this->kategorie_nazev = $zaznam['nazev'];
		$nazev_kategorie = NULL;
		
		//zjisti z databaze pocet komentaru k clanku
		$pocet_komentaru = new db_dotaz("SELECT COUNT(item_id) AS pocet_komentaru FROM komentare WHERE item_id = '".$this->obsah."'");
		$pocet_komentaru->proved_dotaz();
		$pocet_komentaru_temp = $pocet_komentaru->get_vysledek();
		$this->article_comments_count="Koment·¯e (".$pocet_komentaru_temp['pocet_komentaru'].")";
		$pocet_komentaru = NULL;
		//---
		
		switch($this->akce)
		{	
			case "vypis-kategorie":
			
				$nazev_kategorie = new db_dotaz("SELECT nazev FROM menu_subkategorie WHERE url='".$this->kategorie."' LIMIT 1");
				$nazev_kategorie->proved_dotaz();
				$zaznam=$nazev_kategorie->get_vysledek();
				if($nazev_kategorie->pocet_vysledku()==1)
				{
					$this->page_title = $this->kategorie_nazev." | ".$this->web_title;
					$this->article_title = $this->kategorie_nazev . " - v˝pis kategorie";
					$this->obsah_stats = "categorylist_".$this->kategorie;	
				}
				else
				{
					$this->page_title = $language['error'][$this->language]." | ".$this->web_title;
					$this->article_title = $language['error'][$this->language];
				}
				$nazev_kategorie = NULL;
			break;
			
			case "zobraz-clanek":
				$clanek = new db_dotaz("SELECT * from clanky WHERE id='".$this->obsah."' AND subkategorie='".$this->kategorie_nazev."' AND zobrazovat='ano' LIMIT 1");
				$clanek->proved_dotaz();
				
				if($clanek->pocet_vysledku()==1)
				{
					$zaznam=$clanek->get_vysledek();
					$this->article_title=$zaznam['titulek'];
					$this->article_abstract=$zaznam['strucne'];
					$this->article_text= $this->article_abstract.$zaznam['text'];
					$this->article_comments=$zaznam['komentare'];
					$this->article_date=$zaznam['datum'];
					$this->article_time=$zaznam['cas'];
					$this->article_author=$zaznam['autor'];
					$this->article_comments=$zaznam['komentare'];
					$this->article_zobrazeni=$zaznam['zobrazeni'];
					$this->obsah_stats = "article_".$this->obsah;
				}
				else
				{
					$this->article_text=$language['not_found'][$this->language];
					$this->article_title=$language['error'][$this->language];
				}
				
				$clanek=NULL;
				$this->page_title = $this->article_title." | ".$this->web_title;
				//$clanek=new db_dotaz("UPDATE clanky SET zobrazeni = zobrazeni + 1 WHERE id = '".$this->obsah."'");
				//$clanek->proved_dotaz();
				//$clanek=NULL;
			break;
			
			case "zobraz-text":
				$clanek = new db_dotaz("SELECT * from texty WHERE id='".$this->obsah."' AND kategorie_id='".$this->hlavni_kategorie."' AND (zobrazovat='ano' OR zobrazovat='nmenu') LIMIT 1");
				$clanek->proved_dotaz();
				
				if($clanek->pocet_vysledku()==1)
				{
					$zaznam=$clanek->get_vysledek();
						$this->article_title=$zaznam['titulek'];
						$this->article_text=$zaznam['text'];
						$this->article_comments=$zaznam['komentare'];
						$this->article_date=$zaznam['datum'];
						$this->article_time=$zaznam['cas'];
						$this->article_author=$zaznam['autor'];
						$this->text_category_name=$zaznam['kategorie'];
						$this->article_comments=$zaznam['komentare'];
						$this->article_zobrazeni=$zaznam['zobrazeni'];
						$this->obsah_stats = "text_".$this->obsah;
					if($this->language<>"CZ")
					{
						$clanek_lang = new db_dotaz("SELECT * FROM texty_langs WHERE parent_id='".$this->obsah."' AND lang='".$this->language."'");
						$clanek_lang->proved_dotaz();
						$subzaznam = $clanek_lang->get_vysledek();
						$this->article_text = $subzaznam['text'];
						$this->article_title = $subzaznam['nazev'];
					}
				}
				else
				{
					$this->article_text=$language['not_found'][$this->language];
					$this->article_title=$language['error'][$this->language];
				}
				
				$clanek=NULL;
				$this->page_title = $this->article_title." | ".$this->web_title;
				//$clanek=new db_dotaz("UPDATE texty SET zobrazeni = zobrazeni + 1 WHERE id = '".$this->obsah."'");
				//$clanek->proved_dotaz();
				//$clanek=NULL;
			break;
			
			case "hledat":
				$this->page_title = "V˝sledek hled·nÌ | ".$this->web_title;
				$this->obsah_stats = "search_".$_POST['hledane_slovo'];
			break;
			
			case "guestbook":
					$this->page_title = $language['guestbook'][$this->language]." | ".$this->web_title;
					$this->article_title = $language['guestbook'][$this->language];
					$this->obsah_stats = "guestbook_";
			break;
			
			case "galerie":
				$this->page_title = $language['fotogalerie'][$this->language]." | ".$this->web_title;
				$this->article_title = $language['fotogalerie'][$this->language];
				$this->obsah_stats = isset($_GET['gallery_id']) ? "gallery_".$_GET['gallery_id'] : "gallery_default";
			break;
			
			case "gal_show_img":
				$this->page_title = $language['fotogalerie'][$this->language]." | ".$this->web_title;
				$this->article_title = $language['fotogalerie'][$this->language];
				$this->obsah_stats = "gallery_".$_GET['gallery_id']."_img_".$_GET['img_id'];
			break;
			
			case "contact_form":
				$this->article_title = $language['contact_form'][$this->language];
				$this->page_title = $language['contact_form'][$this->language]." | ".$this->web_title;
				$this->obsah_stats = "contact_";
			break;
			
			case "show_news":
				$this->article_title = $language['news'][$this->language];
				$this->page_title = $language['news'][$this->language]." | ".$this->web_title;
				$this->obsah_stats = "news_";
			break;
			
			case "contact_info":
				$this->article_title = $language['contact_info'][$this->language];
				$this->page_title = $language['contact_info'][$this->language]." | ".$this->web_title;
				$this->obsah_stats = "contactpage_";
			break;
			
			default:
			
				$this->obsah_stats = "home-page";
			
				if($this->language=="CZ")
				{
					$this->page_title = "⁄vodnÌ strana | ".$this->web_title;	
				}
				else
				{
					$this->page_title = $language['home-page'][$this->language]." | ".$this->web_title;	
				}
				
				$home_page = $this->get_settings('home_page');
				
				switch($home_page)
				{
					case ('article'):
						
						if($this->language=="CZ")
						{
							$clanek = new db_dotaz("SELECT * from texty WHERE id='home-page' AND zobrazovat='home' LIMIT 1");
							$clanek->proved_dotaz();
							$zaznam=$clanek->get_vysledek();
							$this->article_text=$zaznam['text'];
							$clanek = NULL;	
						}
						else
						{
							$clanek = new db_dotaz("SELECT * from texty_langs WHERE id='home-page' AND lang='".$this->language."' LIMIT 1");
							$clanek->proved_dotaz();
							$zaznam=$clanek->get_vysledek();
							$this->article_text=$zaznam['text'];
							$clanek = NULL;
						}
						
					break;
					
					case ('list'):
						//V˝pis poslednÌch Ël·nk˘
					break;
				}
			break;
		}
	}
	
	public function show_menu(){
	 	
		include('includes/language.php');
	
		require_once("includes/function.simple_menu.php");
		
		
		if($this->get_settings('guestbook')==1)
		{
		echo "<menu class='block'>";
			$css_class = "menu";
			if($this->akce=="guestbook")
			{
				$css_class = "menu_active";
			}
			echo "<li><a class='".$css_class."' href='".$this->root."/guestbook/'>".$language['guestbook'][$this->language]."</a></li>";
		echo "</menu>";
		}
	
		if($this->get_settings('gallery')==1)
		{
		echo "<menu class='block'>";
			$css_class = "menu";
			if($this->akce=="galerie")
			{
				$css_class = "menu_active";
			}
			echo "<li><a class='".$css_class."' href='".$this->root."/galerie/'>".$language['fotogalerie'][$this->language]."</a></li>";
		echo "</menu>";
		}
		
		if($this->get_settings('contact_form')=="on")
		{
		echo "<menu class='block'>";
			$css_class = "menu";
			if($this->akce=="contact_form")
			{
				$css_class = "menu_active";
			}
			echo "<li><a class='".$css_class."' href='".$this->root."/kontakt/'>".$language['contact_form'][$this->language]."</a></li>";
		echo "</menu>";
		}
		
		if($this->get_settings('contact_info')=='on')
		{
			echo "<menu class='block'>";
			$css_class = "menu";
			if($this->akce=="contact_info")
			{
				$css_class = "menu_active";
			}
			echo "<li><a class='".$css_class."' href='".$this->root."/o-nas.html'>".$language['contact_info'][$this->language]."</a></li>";
			echo "</menu>";
		}
		
		?>
        
		<div id='search-box'>
		<table>
		<thead><tr><td><?php echo $language['hledat'][$this->language]; ?></td></tr></thead>
		<tr>
			<td>
				<form method="post" action="<?php echo $this->root; ?>/hledat/">
					<input class="search" type="text" name="hledane_slovo" size="20" onmouseover="document.getElementById('search-box').style.borderColor='#286ea0'" onmouseout="document.getElementById('search-box').style.borderColor='#cccccc'" /><br />
					<input type="submit" value ="Hledat" />
				</form>
			</td>
		</tr>
		</table>
		</div>
        
		<?php
		$this->get_opinion_poll();
	}
	
	public function show_content(){
		
		include('includes/language.php');
		
		switch($this->akce)
		{
			case "vypis-kategorie":
                  //zjisti z databaze pocet komentaru k clanku
		          $pocet_komentaru = new db_dotaz("SELECT COUNT(item_id) AS pocet_komentaru FROM komentare WHERE item_id = '".$this->obsah."'");
		          $pocet_komentaru->proved_dotaz();
		          $pocet_komentaru_temp = $pocet_komentaru->get_vysledek();
                  $this->article_comments_count="Koment·¯e (".$pocet_komentaru_temp['pocet_komentaru'].")";
		          $pocet_komentaru = NULL;
		          //---
            
            
            
				$sql_query = "SELECT menu_kategorie.URL, menu_subkategorie.url, clanky.id, clanky.kategorie, clanky.subkategorie, clanky.titulek, clanky.strucne, clanky.autor, clanky.datum, clanky.cas, clanky.zobrazeni FROM menu_kategorie, menu_subkategorie, clanky WHERE menu_kategorie.URL='".$this->hlavni_kategorie."' AND menu_subkategorie.url='".$this->kategorie."' AND clanky.subkategorie=menu_subkategorie.nazev AND clanky.zobrazovat='ano' ORDER BY clanky.datum desc, clanky.cas desc";
				$vypis = new db_dotaz($sql_query);
				$vypis->proved_dotaz();
				if($vypis->pocet_vysledku()==0)
				{
					echo "<h4>".$language['empty_cat'][$this->language]."</h4>";
				}
				else
				{
				while($zaznam=$vypis->get_vysledek()):
					echo "<div class='article_box'>";
					echo "<h2 class='titulek_clanku'><a href='".$this->root."/".$zaznam['url']."/".$zaznam['id'].".html'>".$zaznam['titulek']."</a></h2>";
					$this->show_article_header($zaznam);
					echo "<div class='vypis_strucne'>".$zaznam['strucne']."</div>";
					//echo "<a class='vypis_pokracovat' href='".$this->root."/".$zaznam['URL']."/".$zaznam['url']."/".$zaznam['id'].".html'>[PokraËov·nÌ]</a><br /><br />";
					echo "<a class='vypis_pokracovat' href='".$this->root."/".$zaznam['url']."/".$zaznam['id'].".html'>[PokraËov·nÌ]</a><br /><br /></div>";
				endwhile;
				}
				$vypis = NULL;
			break;
			
			case "zobraz-clanek":
			case "zobraz-text":
				$zaznam['datum']=$this->article_date;
				$zaznam['cas']=$this->article_time;
				$zaznam['autor']=$this->article_author;
				$zaznam['subkategorie']=$this->kategorie_nazev;
				$zaznam['zobrazeni']=$this->article_zobrazeni;	
				if($this->kategorie_nazev==NULL)$zaznam['subkategorie']=$this->text_category_name;
				//echo "<h2 class='titulek_clanku'>".$this->article_title."</h2>";
				echo "<h2 class='titulek'>".$this->article_title."</h2>";
				if($this->akce=='zobraz-clanek')
				{
					$this->show_article_header($zaznam);
				}
				echo $this->article_text;
				$this->comments($this->obsah,$this->akce, $this->article_comments);
			break;
			
			
			case "hledat":
				//echo $_POST['hledane_slovo'];
				include("includes/search.php");
			break;
			
			case "guestbook":
				//Kniha n·vötÏv
				if($this->get_settings('guestbook')==1)
				{
					include("includes/guestbook.php");
				}
			break;
			
			case "galerie":
				include('includes/gallery.php');
			break;
			
			case "gal_show_img":
				include_once('includes/gallery_show_img.php');
			break;
			
			case "contact_form":
				include_once('includes/contact_form.php');
			break;
			
			case "show_news":
				include_once('includes/news_page.php');
			break;
			
			case "contact_info":
				include_once('includes/show_contact_info.php');
			break;
						
			default:
				// "⁄vodnÌ strana";
				echo $this->article_text;
				if($this->get_settings('news')=="1")
				{
					echo "<hr />";
					echo "<h3>Novinky</h3>";
					include_once('includes/news_list.php');	
				}
			break;
		}
	}
	
	public function show_language_menu()
	{
	   /*
	 	if(isset($_SERVER['REQUEST_URI']) && ereg('[?]',$_SERVER['REQUEST_URI']))
		{
			$url_symbol = "&";
		}
		else
		{
			$url_symbol = "?";
		}
	 	*/
	 	
		if($this->get_settings('lang_cz')=='on')
		{
			echo "<a href='".$this->root."?lang=CZ'><img src='".$this->root."/CSS/Flags/czech_republic.jpg' class='flags' title='»esky' alt='»esky' /></a>";
		}
		
		if($this->get_settings('lang_en')=='on')
		{
			echo "<a href='".$this->root."?lang=EN'><img src='".$this->root."/CSS/Flags/united_kingdom.jpg' class='flags' title='English' alt='English'/></a>";
		}
		
		if($this->get_settings('lang_de')=='on')
		{
			echo "<a href='".$this->root."?lang=DE'><img src='".$this->root."/CSS/Flags/germany.jpg' class='flags' title='Deutsch' alt='Deutsch' /></a>";
		}
		
		if($this->get_settings('lang_du')=='on')
		{
			echo "<a href='".$this->root."?lang=DU'><img src='".$this->root."/CSS/Flags/netherlands.jpg' class='flags' title='Dutch' alt='Dutch' /></a>";
		}
	}
	
	public function get_others($parametr)
	{
		$ostatni = new db_dotaz("SELECT value FROM ostatni WHERE param_name ='".$parametr."'");
		$ostatni->proved_dotaz();
		$zaznam=$ostatni->get_vysledek();
		$hodnota = $zaznam["value"];
		$nastaveni = NULL;
		return($hodnota);
	}
	
	public function set_others($parametr, $hodnota)
	{
		$nastaveni = new db_dotaz("UPDATE ostatni SET value='".$hodnota."' WHERE param_name='".$parametr."'");
		if($nastaveni->proved_dotaz())
		{
			return True;
		}
		$nastaveni = NULL;
	}
	
	public function get_settings($parametr)
	{
		$nastaveni = new db_dotaz("SELECT hodnota FROM nastaveni WHERE param ='".$parametr."'");
		$nastaveni->proved_dotaz();
		$zaznam=$nastaveni->get_vysledek();
		$hodnota = $zaznam["hodnota"];
		$nastaveni = NULL;
		return($hodnota);
	}
	
	public function set_settings($parametr, $hodnota)
	{
		$nastaveni = new db_dotaz("UPDATE nastaveni SET hodnota='".$hodnota."' WHERE param='".$parametr."'");
		$nastaveni->proved_dotaz();
		$nastaveni = NULL;
	}

	public function friendly_url($URL)
	{
	$disallowed = array("û", "é", "ö", "ä", "Ë", "»", "¯", "ÿ", "Ô", "œ", "ù", "ç", "Ú", "“", "·", "¡", "È", "…", "Ï", "Ã", "Ì", "Õ", "Û", "”", "˙", "⁄", "˘", "Ÿ", " ", "/","$","Ä","@",".","(",")","˝","?",",","!");
	$allowed = array("z", "z", "s", "s", "c", "c", "r", "r", "d", "d", "t", "t", "n", "n", "a", "a", "e", "e", "e", "e", "i", "i", "o", "o", "u", "u", "u", "u", "-", "-", "-","-","-at-","-","-","-","y","","-","");
	$friendly_url = str_replace($disallowed, $allowed, $URL);
	$friendly_url = strtolower($friendly_url);
	return $friendly_url;
	}
	
	public function footer()
	{
		include('includes/page_footer.php');
	}
	
	public function get_opinion_poll(){
		include ('includes/opinion-poll.php');
	}
	
	public function write_stats(){
		include ('includes/stats.php');
	}
	
	public function show_page_title(){
        echo "<h1><a href='".$this->root."'>".$this->web_title."</a></h1>";
		//echo "<h2>".$this->get_settings(web_desc)."</h2>";
		//if($this->article_title!="")
        if(isset($this->article_title))
		{
			echo "<h2>".$this->article_title."</h2>";	
		}
		else
		{
			echo "<h2>".$this->get_settings('web_desc')."</h2>";
		}
	}
	
	public function show_article_header($zaznam){

        if(isset($zaznam['id'])){
        //zjisti z databaze pocet komentaru k clanku
        $pocet_komentaru = new db_dotaz("SELECT COUNT(item_id) AS pocet_komentaru FROM komentare WHERE item_id = '".$zaznam['id']."'");
        $pocet_komentaru->proved_dotaz();
        $pocet_komentaru_temp = $pocet_komentaru->get_vysledek();
        $this->article_comments_count="Koment·¯e (".$pocet_komentaru_temp['pocet_komentaru'].")";
        $pocet_komentaru = NULL;
        //---
        }
         
         
        $date = $zaznam['datum'];
		$date = strtotime($zaznam['datum']);
		$date = $this->date_cz_month($date,"j. F Y");
		//$date = date("d.m.Y", $date);
		echo "<table class='article_info'>";
		echo "<tr>";
		if($this->get_settings('show_date')=="on"){echo "<td class='calendar'></td><td>".$date." - ".$zaznam['cas']."</td>";};
		if($this->get_settings('show_category')=="on"){echo "<td class='category'></td><td><a href='".$this->root."/".$this->friendly_url($zaznam['subkategorie'])."/'>".$zaznam['subkategorie']."</a></td>";};
		if($this->get_settings('show_author')=="on"){echo "<td class='user'></td><td>".$zaznam['autor']."</td>";};
		if($this->get_settings('show_views')=="on"){echo "<td class='eye'></td><td>".$zaznam['zobrazeni']."x</td>";};
		IF($this->get_settings('show_comments_count')){
        echo "<td class='comments'></td><td>".$this->article_comments_count."</td>";
        }
        echo "</tr></table>";
	}
	
	public function comments($clanek_id, $typ, $status)
	{
		switch($status)
		{
			case "on":
				$this->show_comments($clanek_id, $typ);
				include_once('includes/comments_form.php');
			break;
			
			case "off":
				//Nezobrazovat koment·¯e
				echo("<h3>".$this->get_settings('comm_disabled')."</h3>");
			break;
				
			case "dis_hidden":
				//Zak·zat komentov·nÌ a skr˝t koment·¯e
				echo("<h3>".$this->get_settings('comm_disabled_hidden')."</h3>");
			break;
				
			case "dis_shown":
				//Zak·zat komentov·nÌ a zobrazit koment·¯e
				$this->show_comments($clanek_id, $typ);
				echo("<h3>".$this->get_settings('comm_disabled_shown')."</h3>");
			break;
			
			case "off_hidden";
			break;
				
			default:
				//echo("<p>Chyba p¯i naËÌt·nÌ str·nky!</p>");
			break;
		}
	}
	
	
	public function show_comments($clanek_id, $typ)
	{
		include_once('includes/comments_show.php');
	}
	
	public function date_cz_month($timestamp, $format)
	{
		$aj = array("January","February","March","April","May","June","July","August","September","October","November","December");
		$cz = array("ledna","˙nora","b¯ezna","dubna","kvÏtna","Ëervna","Ëervence","srpna","z·¯Ì","¯Ìjna","listopadu","prosince");
		$datum = str_replace($aj, $cz, date($format, $timestamp));
		return $datum;
	}
	
	public function add_text_input($name,$id,$title,$value, $size, $maxlength)
	{
		echo "<div><label for='".$id."'>".$title."</label><br /><input name='".$name."' id='".$id."' size='".$size."' maxlength='".$maxlength."' value='".$value."' /></div><br />";
	}
	
	public function add_text_area($name,$id,$title,$value, $cols, $rows){
		echo "<div><label for='".$id."'>".$title."</label><br /><textarea name='".$name."' id='".$id."' cols='".$cols."' rows='".$rows."'>".$value."</textarea></div><br />";
	}
	
	public function add_submit_button($value){
		echo "<input type='Submit' class='SubmitButton' value='".$value."' onClick=\"return confirm('Opravdu?')\" />";
	}
	
	public function add_hidden_input($name,$value){
		echo "<input type='hidden' name='".$name."' value='".$value."'/>";
	}
	
	// definujeme masku

// zda se vam, ze neco nesedi? :)

	public function check_email($mail)
	{
		$maska = '^([[:alnum:]]+)@([[:alnum:]]+)\.([[:alpha:]]{2,4})$^';
		//if (EregI($maska ,$mail)) return TRUE;
        if (preg_match($maska ,$mail)) return TRUE;
		else return FALSE;
	}
	
	public function write_visit()
	{
		require_once('includes/function.write_visit.php');
	}
}
?>