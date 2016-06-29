<?php
	require('admin-security.php');
	$this->check_admin();
?>

<?php
	echo "<h2>Konfigurace webu</h2>";
	
	//$test = new db_dotaz("INSERT INTO nastaveni VALUES ('55', 'multilanguage','0','','')");
	//$test->proved_dotaz();
	//$test = NULL;

if ($_SESSION['logged']!==1) header("Location:login.php");

if (isset($_POST['titulek_webu'])){
    $this->set_settings('titulek_webu', $_POST['titulek_webu']);
	$this->set_settings('web_desc', $_POST['popis_webu']);
	$this->set_settings('web_url', $_POST['adresa_webu']);
	//$this->set_settings(home_page, $_POST['home_page']);
	//$this->set_settings(rss_articles, $_POST['rss_articles']);
	//$this->set_settings(rss_comments, $_POST['rss_comments']);
	$this->set_settings('web_status', $_POST['status']);
	$this->set_settings('web_closed_message', $_POST['closed_message']);
	$this->set_settings('favicon', $_POST['favicon']);
	$this->set_settings('allowed_ip', $_POST['povolena_ip']);
    
	if(isset($_POST['show_date'])){
	   $this->set_settings('show_date', $_POST['show_date']);  
	}else{
        $this->set_settings('show_date', "");
    }
	
    if(isset($_POST['show_category'])){
        $this->set_settings('show_category', $_POST['show_category']);   
    }else{
        $this->set_settings('show_category', "");
    }
	
    if(isset($_POST['show_author'])){
        $this->set_settings('show_author', $_POST['show_author']);   
    }else{
        $this->set_settings('show_author', "");
    }
	
    if(isset($_POST['show_views'])){
        $this->set_settings('show_views', $_POST['show_views']);   
    }else{
        $this->set_settings('show_views', "");
    }
    
    if(isset($_POST['show_comments_count'])){
        $this->set_settings('show_comments_count', $_POST['show_comments_count']);   
    }else{
        $this->set_settings('show_comments_count', "");
    }
	
    $this->set_settings('poll_cookie_time', $_POST['poll_cookie_time']);
	$this->set_settings('views_cookie_time', $_POST['views_cookie_time']);
	if(isset($_POST['contact_info']))$this->set_settings('contact_info', $_POST['contact_info']);
	
	//if($_POST['lang_de']=="on" || $_POST['lang_en']=="on" || $_POST['lang_du']=="on") && $_POST['lang_cz']=="")
    if(((isset($_POST['lang_de']) || isset($_POST['lang_en']) || isset($_POST['lang_du'])) && !isset($_POST['lang_cz']) ))
	{
		$cz = "on";
		echo "<p><strong>Èeština</strong> byla automaticky zapnuta...</p>";
	}
	elseif(isset($_POST['lang_cz']))
	{
		$cz = $_POST['lang_cz'];
	}
	
	if((isset($_POST['lang_de']) && $_POST['lang_de']=="on") || (isset($_POST['lang_en']) && $_POST['lang_en']=="on") || (isset($_POST['lang_du']) && $_POST['lang_du']=="on"))
	{
		$this->set_settings('multilanguage', 1);
		echo "<p>Stránky byly pøepnuty na <strong>vícejazyèné</strong></p>";
	}
	else
	{
		$this->set_settings('multilanguage', 0);
		echo "<p>Stránky byly pøepnuty na <strong>jednojazyèné</strong></p>";
	}
	
	if(isset($cz)){
	   $this->set_settings('lang_cz', $cz);  
	}else{
	   $this->set_settings('lang_cz', "off");
	}
    
	if(isset($_POST['lang_de'])){
	   $this->set_settings('lang_de', $_POST['lang_de']);
	}else{
	   $this->set_settings('lang_de', "off");
	}
    
	if(isset($_POST['lang_en'])){
	   $this->set_settings('lang_en', $_POST['lang_en']);
	}else{
	   $this->set_settings('lang_en', "off");
	}
    
	if(isset($_POST['lang_du'])){
	   $this->set_settings('lang_du', $_POST['lang_du']);
	}else{
	   $this->set_settings('lang_du', "off");
	}
	
	$this->set_settings('contact_mail', $_POST['contact_mail']);
	$this->set_settings('contact_header', $_POST['contact_header']);
	$this->set_settings('contact_form', $_POST['contact_form']);
	
	$this->set_settings('contact_smtp', $_POST['smtp_server']);
	$this->set_settings('contact_user', $_POST['smtp_user']);
	$this->set_settings('contact_password', $_POST['smtp_password']);
	$this->set_settings('contact_smtp_auth', $_POST['smtp_auth']);
	
	$this->set_settings('admin_name', $_POST['admin_name']);
	$this->set_settings('admin_mail', $_POST['admin_mail']);
	
	echo "<p>Zmìny uloženy</p>";
}

if($this->get_settings('home_page')=="list"){$hp_list="checked";}else{$hp_article="checked";};
if($this->get_settings('rss_articles')=="on"){$rss_articles="checked";};
if($this->get_settings('rss_comments')=="on"){$rss_comments="checked";};
if($this->get_settings('web_status')=="open"){$web_open="checked";}else{$web_closed="checked";};

if($this->get_settings('show_date')=="on"){$show_date="checked";}
if($this->get_settings('show_category')=="on"){$show_category="checked";}
if($this->get_settings('show_author')=="on"){$show_author="checked";}
if($this->get_settings('show_views')=="on"){$show_views="checked";}
if($this->get_settings('show_comments_count')=="on"){$show_comments_count="checked";}

if($this->get_settings('lang_cz')=="on"){$lang_cz="checked";}
if($this->get_settings('lang_de')=="on"){$lang_de="checked";}
if($this->get_settings('lang_en')=="on"){$lang_en="checked";}
if($this->get_settings('lang_du')=="on"){$lang_du="checked";}

if($this->get_settings('contact_form')=="on"){$cf_status="checked";}

if($this->get_settings('contact_smtp_auth')=="on"){$contact_smtp_auth="checked";}

?>

<form method="POST" action="<?php echo($_SERVER["PHP_SELF"])."?".$_SERVER["QUERY_STRING"] ?>">
	<fieldset style="width: 450px;">
    <legend>Stránky v provozu?</legend>
	    <div><input type="radio" name="status" value="open" <?php echo isset($web_open)? $web_open : NULL ?>/><label>Ano</label></div>
		<div><input type="radio" name="status" value="closed" <?php echo isset($web_closed) ? $web_closed : NULL  ?>/><label>Ne</label></div>
        <br />
        <?php $this->add_text_input('closed_message', 'closed_message', "Text pøi, který se má zobrazit pøi odstaveném webu...", $this->get_settings('web_closed_message'), 50, 100); ?>
        <?php $this->add_text_input('povolena_ip', 'povolena_ip', "Z následujících adres povolit pøístup<br />Možno zadat více adres oddìlených støedníkem bez mezery.", $this->get_settings('allowed_ip'), 50, 50); ?>
    </fieldset>
    <br />
    <br />
    <fieldset style="width: 450px;">
	<legend>Údaje o webu</legend>
	<?php $this->add_text_input('titulek_webu', 'titulek_webu', "Titulek webu", $this->get_settings('titulek_webu'), 50, 50); ?>	
    <?php $this->add_text_input('popis_webu', 'popis_webu', "Struèný popis webu", $this->get_settings('web_desc'), 50, 100); ?>
    <?php $this->add_text_input('adresa_webu', 'adresa_webu', "Adresa webu (http://www.example.com). <br /> <strong>Bez lomítka na konci!</strong>", $this->get_settings('web_url'), 50, 100); ?>
    <?php $this->add_text_input('favicon', 'favicon', "Ikona webu (favicon)", $this->get_settings('favicon'), 50, 100); ?>
	</fieldset>
	<br />
	<br />
	
	
	<?php
	/*
	<fieldset style="width: 450px;">
		<legend>Úvodní strana</legend>
		<div><input type="radio" name="home_page" value="list" <?php echo $hp_list ?>/><label>Výpis posledních èlánkù</label></div>
		<div><input type="radio" name="home_page" value="article" <?php echo $hp_article ?>/><label>Vybraný èlánek</label></div><a href="index.php?action=uprav-text&param1=home-page">Upravit...</a>
	</fieldset>
	<br />
    <br />
    
	<fieldset style="width: 450px;">
	<legend>Nastavení RSS</legend>
	<div><input type="checkbox" name="rss_articles" <?php echo $rss_articles ?> disabled /><label>Povolit RSS èlánkù</label></div>
	<div><input type="checkbox" name="rss_comments" <?php echo $rss_comments ?> disabled /><label>Povolit RSS komentáøù</label></div>
	</fieldset>
	<br />
    <br />
    
    */
    ?>
    
	<fieldset style="width: 450px;">
	<legend>Nastavení hlavièky èlánkù</legend>
	<div><input type="checkbox" name="show_date" <?php echo isset($show_date) ? $show_date : NULL ?> /><label>Datum vložení</label></div>
	<div><input type="checkbox" name="show_category" <?php echo isset($show_category) ? $show_category : NULL ?> /><label>Kategorie</label></div>
	<div><input type="checkbox" name="show_author" <?php echo isset($show_author) ? $show_author : NULL ?> /><label>Autor</label></div>
	<div><input type="checkbox" name="show_views" <?php echo isset($show_views) ? $show_views : NULL ?> /><label>Poèet zobrazení</label></div>
    <div><input type="checkbox" name="show_comments_count" <?php echo isset($show_comments_count) ? $show_comments_count : NULL ?> /><label>Poèet komentáøù</label></div>
	</fieldset>
    <br />
    <br />
    
    
    <fieldset style="width: 450px;">
	<legend>Pøepínání jazykù</legend>
	<div><input type="checkbox" name="lang_cz" <?php echo isset($lang_cz) ? $lang_cz : NULL ?> /><label>Èeština</label></div>
	<div><input type="checkbox" name="lang_de" <?php echo isset($lang_de) ? $lang_de : NULL ?> /><label>Nìmèina</label></div>
	<div><input type="checkbox" name="lang_en" <?php echo isset($lang_en) ? $lang_en : NULL ?> /><label>Angliètina</label></div>
	<div><input type="checkbox" name="lang_du" <?php echo isset($lang_du) ? $lang_du : NULL ?> /><label>Další (Holadština)</label></div>
	</fieldset>
	<br />
	<br />
	
	<fieldset style="width: 450px;">
	<legend>Odesílání zpráv z Webu</legend>
	<div><input type="checkbox" name="contact_form" <?php echo isset($cf_status) ? $cf_status : NULL ?> /><label>Povolit kontaktní formuláø</label></div><br />
	<?php $this->add_text_input('contact_mail', 'contact_mail', "E-mailová adresa", $this->get_settings('contact_mail'), 50, 50); ?>	
    <?php $this->add_text_input('contact_header', 'contact_header', "Pøedmìt zprávy", $this->get_settings('contact_header'), 50, 100); ?>
    
    <?php $this->add_text_input('smtp_server', 'smtp_server', "SMTP server", $this->get_settings('contact_smtp'), 50, 50); ?>
    <br />
    	<div><input type="checkbox" name="smtp_auth" <?php echo isset($contact_smtp_auth) ? $contact_smtp_auth : NULL ?> /><label>SMTP server vyžaduje autorizaci</label></div>
    <br />
    <?php $this->add_text_input('smtp_user', 'smtp_user', "SMTP user", $this->get_settings('contact_user'), 50, 100); ?>
    <?php $this->add_text_input('smtp_password', 'smtp_password', "SMTP user", $this->get_settings('contact_password'), 50, 100); ?>

	</fieldset>
	<br />
	<br />
	<fieldset style="width: 450px;">
	<legend>Cookie</legend>
	<?php $this->add_text_input('poll_cookie_time', 'poll_cookie_time', "Platnost cookie pro anketu v hodinách", $this->get_settings('poll_cookie_time'), 10, 10); ?>	
	<?php $this->add_text_input('views_cookie_time', 'views_cookie_time', "Platnost cookie pro poèítadlo zobrazení v minutách", $this->get_settings('views_cookie_time'), 10, 10); ?>
	</fieldset>
	<br />
	<br />
	<fieldset style="width: 450px;">
	<legend>Ostatní</legend>
	<div>
	<?php $this->add_checkbox('contact_info',$this->get_settings('contact_info')); ?>
	<label>Informaèní stránka (kontakt)</label>
	</div>
	<?php
		//<a href='index.php?action=kontaktni-informace'>Upravit</a>
	?>
	</fieldset>
	<br />
	<br />
	<fieldset style="width: 450px;">
	<legend>Správce stránek</legend>
	<?php $this->add_text_input('admin_name', 'admin_name', "Jméno", $this->get_settings('admin_name'), 50, 50); ?>	
    <?php $this->add_text_input('admin_mail', 'admin_mail', "E-mail", $this->get_settings('admin_mail'), 50, 100); ?>
	</fieldset>
	
	<input type="Submit" value="Uložit zmìny">
</form>

