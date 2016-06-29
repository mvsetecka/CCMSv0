<?php
if($_POST['admin_pass']<>$_POST['admin_pass_rep'])
{
	header("Location: index.php");
}
if($_POST['www']=="")
{
	header("Location: index.php");
}
$file = fopen('../includes/config.php','w');
rewind($file);
$db_server = $_POST['db_server'];
$db_name = $_POST['db_name'];
$db_user = $_POST['db_user'];
$db_pass = $_POST['db_pass'];
$string = ("<?php\r\ndefine('SQL_HOST','".$db_server."');\r\ndefine('SQL_DBNAME','".$db_name."');\r\ndefine('SQL_USERNAME','".$db_user."');\r\ndefine('SQL_PASSWORD','".$db_pass."');\r\n?>");
fwrite($file, $string);
fclose($file);
mysql_connect($db_server, $db_user, $db_pass);
mysql_select_db($db_name);
mysql_query("SET NAMES 'utf8'") or die(mysql_error());
//
//
//
//tabulka galerie
$query = "CREATE TABLE `galerie` (
  `url` text,
  `nazev` text,
  `popis` blob,
  `datetime` text,
  `pocet_obrazu` int(11) default NULL,
  `zobrazeni` int(11) default NULL,
  `autor` text,
  `stav` text
) ENGINE=InnoDB CHARACTER SET=utf8 COLLATE=utf8_czech_ci;";
mysql_query($query) or die(mysql_error());
//
//tabulka galerie_obrazky
$query = "CREATE TABLE `galerie_obrazky` (
  `id` int(11) default NULL,
  `soubor` text,
  `slozka` text,
  `popis` blob,
  `velikost` text,
  `zobrazeni` int(11) default NULL,
  `stav` text
) ENGINE=InnoDB CHARACTER SET=utf8 COLLATE=utf8_czech_ci;";
mysql_query($query) or die(mysql_error());
//
//tabulka clanky
$query = "CREATE TABLE `clanky` (
  `id` varchar(100) character set utf8 collate utf8_bin NOT NULL,
  `kategorie` varchar(30) character set utf8 collate utf8_bin NOT NULL,
  `subkategorie` varchar(30) character set utf8 collate utf8_bin NOT NULL,
  `titulek` varchar(100) character set utf8 NOT NULL,
  `datum` date NOT NULL,
  `cas` time NOT NULL,
  `autor` varchar(30) character set utf8 collate utf8_bin NOT NULL,
  `strucne` text character set utf8 NOT NULL,
  `text` text character set utf8 NOT NULL,
  `komentare` varchar(15) character set utf8 collate utf8_bin NOT NULL,
  `zobrazovat` varchar(5) character set utf8 collate utf8_bin NOT NULL,
  `zobrazeni` int(11) default NULL,
  `editor` varchar(20) character set utf8 collate utf8_bin default NULL,
  `last_change_date` date default NULL,
  `last_change_time` time default NULL
) ENGINE=InnoDB CHARACTER SET=utf8 COLLATE=utf8_czech_ci;";
mysql_query($query) or die(mysql_error());
//
//tabulka texty
$query = "CREATE TABLE `texty` (
  `id` varchar(100) character set utf8 collate utf8_bin NOT NULL,
  `kategorie_id` varchar(30) collate utf8_unicode_ci NOT NULL,
  `kategorie` varchar(30) character set utf8 collate utf8_bin NOT NULL,
  `titulek` varchar(100) character set utf8 NOT NULL,
  `datum` date NOT NULL,
  `cas` time NOT NULL,
  `autor` varchar(30) character set utf8 collate utf8_bin NOT NULL,
  `text` text character set utf8 NOT NULL,
  `komentare` varchar(15) character set utf8 collate utf8_bin NOT NULL,
  `zobrazovat` varchar(5) character set utf8 collate utf8_bin NOT NULL,
  `zobrazeni` int(11) default NULL,
  `editor` varchar(20) character set utf8 collate utf8_bin default NULL,
  `last_change_date` date default NULL,
  `last_change_time` time default NULL
) ENGINE=InnoDB CHARACTER SET=utf8 COLLATE=utf8_czech_ci;";
mysql_query($query) or die(mysql_error());
//
$query = "CREATE TABLE `texty_langs` (
  `parent_id` text,
  `id` text,
  `nazev` text,
  `text` blob,
  `lang` text
) ENGINE=InnoDB CHARACTER SET=utf8 COLLATE=utf8_czech_ci;";
mysql_query($query) or die(mysql_error());
//
//
//tabulka aktuality
$query = "CREATE TABLE `aktuality` (
  `id` int(11) NOT NULL,
  `datetime` text NOT NULL,
  `text` blob NOT NULL,
  `language` text NOT NULL
) ENGINE=InnoDB CHARACTER SET=utf8 COLLATE=utf8_czech_ci;";
mysql_query($query) or die(mysql_error());
//
//tabulka menu_kategorie
$query = "CREATE TABLE `menu_kategorie` (
  `nazev` varchar(30) collate utf8_bin NOT NULL,
  `URL` varchar(30) collate utf8_bin NOT NULL,
  `pozice` int(11) default NULL
) ENGINE=InnoDB CHARACTER SET=utf8 COLLATE=utf8_czech_ci;";
mysql_query($query) or die(mysql_error());
//
//tabulka menu_subkategorie
$query = "CREATE TABLE `menu_subkategorie` (
  `parent` varchar(30) collate utf8_bin NOT NULL,
  `parent_url` varchar(30) collate utf8_bin NOT NULL,
  `nazev` varchar(30) collate utf8_bin NOT NULL,
  `url` varchar(30) collate utf8_bin NOT NULL,
  `typ` varchar(10) collate utf8_bin NOT NULL,
  `zobrazovat` varchar(5) collate utf8_bin default NULL,
  `pozice` int(11) default NULL
) ENGINE=InnoDB CHARACTER SET=utf8 COLLATE=utf8_czech_ci;";
mysql_query($query) or die(mysql_error());
//
//tabulka anketa
$query = "CREATE TABLE `anketa` (
  `id` int(1) default NULL,
  `nazev` text NOT NULL,
  `otazka` blob NOT NULL,
  `1_text` text,
  `1_hlasu` int(11) default NULL,
  `2_text` text,
  `2_hlasu` int(11) default NULL,
  `3_text` text,
  `3_hlasu` int(11) default NULL,
  `4_text` text,
  `4_hlasu` int(11) default NULL,
  `5_text` text,
  `5_hlasu` int(11) default NULL,
  `datum` text
) ENGINE=InnoDB CHARACTER SET=utf8 COLLATE=utf8_czech_ci;";
mysql_query($query) or die(mysql_error());
//
//tabulka guestbook
$query = "CREATE TABLE `guestbook` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `jmeno` blob,
  `text` blob,
  `datum` blob,
  `cas` time default NULL,
  `email` blob,
  `web` blob,
  `addr` blob,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 CHARACTER SET=utf8 COLLATE=utf8_czech_ci;";
mysql_query($query) or die(mysql_error());
//
$query = "CREATE TABLE `uzivatele` (
  `username` text,
  `password` text,
  `zalozeno` text,
  `cas` text,
  `jmeno_prijmeni` text,
  `last_login` text,
  `text_add` text,
  `text_edit` text,
  `article_add` text,
  `article_edit` text,
  `news_add` text,
  `guestbook_edit` text,
  `comments_edit` text,
  `filemanager` text,
  `filemanager_mkdir` text,
  `filemanager_rmdir` text,
  `filemanager_delete_file` text,
  `photogallery_create` text,
  `photogallery_edit` text,
  `category_edit` text,
  `opinion_poll` text
) ENGINE=MyISAM AUTO_INCREMENT=30 CHARACTER SET=utf8 COLLATE=utf8_czech_ci;";
mysql_query($query) or die(mysql_error());
//
//
$query = "CREATE TABLE `komentare` (
  `comment_id` int(11) default NULL,
  `item_id` text,
  `text` blob,
  `autor_nick` text,
  `autor_email` text,
  `autor_ip` text,
  `autor_www` text,
  `datum` date default NULL,
  `cas` time default NULL,
  `zobrazit` text
) ENGINE=InnoDB CHARACTER SET=utf8 COLLATE=utf8_czech_ci;";
mysql_query($query) or die(mysql_error());
//
$query = "CREATE TABLE `menu_subkategorie_langs` (
  `parent_id` text,
  `id` text,
  `nazev` text,
  `jazyk` text
) ENGINE=InnoDB CHARACTER SET=utf8 COLLATE=utf8_czech_ci;";
mysql_query($query) or die(mysql_error());
//
//tabulka stats
$query = "CREATE TABLE `stats` (
  `datum` date NOT NULL,
  `cas` time NOT NULL,
  `ip` text NOT NULL,
  `referrer` text NOT NULL,
  `hostname` text,
  `pid` text
) ENGINE=InnoDB CHARACTER SET=utf8 COLLATE=utf8_czech_ci;";
mysql_query($query) or die(mysql_error());
//
//tabulka stats_login
$query = "CREATE TABLE `stats_login` (
  `datum` date NOT NULL,
  `cas` time NOT NULL,
  `ip` text NOT NULL,
  `remote_name` text NOT NULL,
  `referrer` text,
  `ent_name` text,
  `ent_pass` text
) ENGINE=InnoDB CHARACTER SET=utf8 COLLATE=utf8_czech_ci;";
mysql_query($query) or die(mysql_error());
//
//tabulka ostatni
$query = "CREATE TABLE `ostatni` (
  `param_name` text,
  `value` blob
) ENGINE=InnoDB CHARACTER SET=utf8 COLLATE=utf8_czech_ci;";
mysql_query($query) or die(mysql_error());
//
//tabulka nastaveni + zakladni hodnoty
$query = "CREATE TABLE `nastaveni` (
  `id` int(11) NOT NULL auto_increment,
  `param` varchar(20) collate utf8_bin NOT NULL,
  `hodnota` varchar(500) collate utf8_bin NOT NULL,
  `last_modified` varchar(50) collate utf8_bin NOT NULL,
  `last_modified_ip` varchar(16) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB CHARACTER SET=utf8 COLLATE=utf8_czech_ci;";
mysql_query($query) or die(mysql_error());
//
$query ="
INSERT INTO `nastaveni` (`id`, `param`, `hodnota`, `last_modified`, `last_modified_ip`)
VALUES
('1', 'titulek_webu', 'CLOCKWORK CMS v0.9beta', '', ''),
('2', 'admin_pass_md5', '".md5($_POST['admin_pass'])."', '', ''),
('3', 'admin_name', 'Administrator', '', ''),
('4', 'admin_mail', '', '', ''),
('5', 'rss_articles', '', '', ''),
('6', 'rss_comments', '', '', ''),
('8', 'page_url', '', '', ''),
('9', 'page_title', '', '', ''),
('10', 'web_desc', 'Prezentační systém', '', ''),
('11', 'articles_editor', 'wysiwyg', '', ''),
('12', 'home_page', 'article', '', ''),
('13', 'comm_disabled_shown', 'Přidávání dalších komentářů bylo zakázáno.', '', ''),
('14', 'comm_disabled_hidden', 'Komentování tohoto článku byo zrušeno.', '', ''),
('15', 'comm_disabled', 'Tento článek není možné komentovat.', '', ''),
('16', 'web_status', 'open', '', ''),
('17', 'web_closed_message', 'Tento web je dočasně mimo provoz. Zkuste to prosím později.<BR />Děkujeme za pochopení.', '', ''),
('18', 'favicon', 'favicon.ico', '', ''),
('19', 'meta_description', 'CLOCKWORK CMS', '', ''),
('20', 'meta_keywords', 'PHP, CMS', '', ''),
('21', 'meta_author', '', '', ''),
('22', 'opinion_poll', '0', '', ''),
('23', 'guestbook', '0', '', ''),
('24', 'stats', '1', '', ''),
('25', 'allowed_ip', '', '', ''),
('26', 'show_date', '', '', ''),
('27', 'show_category', '', '', ''),
('28', 'show_author', '', '', ''),
('29', 'show_views', '', '', ''),
('30', 'gallery', '0', '', ''),
('31', 'gb_listing', '50', '', ''),
('32', 'web_version', 'simple', '', ''),
('33', 'menu_separator', '0', '', ''),
('34', 'lang_cz', '0', '', ''),
('35', 'lang_de', '0', '', ''),
('36', 'lang_eng', '0', '', ''),
('37', 'lang_du', '0', '', ''),
('38', 'version', '0.9beta', '', ''),
('39', 'contact_form', '0', '', ''),
('40', 'contact_mail', 'admin@mysite.com', '', ''),
('41', 'contact_header', 'Zprava z webu www.mysite.com', '', ''),
('42', 'contact_smtp', 'smtp.example.com', '', ''),
('43', 'contact_user', 'smtp_user', '', ''),
('44', 'contact_password', 'smtp_password', '', ''),
('45', 'contact_smtp_auth', '', '', ''),
('46', 'web_url', '".$_POST['www']."', '', ''),
('47', 'news', '0', '', ''),
('48', 'news_count', '0', '', ''),
('49', 'stylesheet_dir', 'default', '', ''),
('50', 'poll_cookie_time', '24', '', ''),
('51', 'gallery_default', '1', '', ''),
('52', 'views_cookie_time', '30', '', ''),
('53', 'mysql_queries', '0', '', ''),
('54', 'contact_info', '', '', ''),
('55', 'multilanguage','0','','')
";
mysql_query($query) or die(mysql_error());
$query ="
INSERT INTO `ostatni` (`param_name`, `value`)
VALUES
('contact_info_L1', ''),
('contact_info_L2', ''),
('contact_info_L3', ''),
('contact_info_L4', ''),
('footer_content', '')
";
mysql_query($query) or die(mysql_error());
//
$query = "
INSERT INTO `texty` VALUES ('home-page', '', '', '', '0000-00-00', '00:00:00', '', '<p>Gratulujeme! Právě jste úspěšně nainstalovali Prezentační systém <strong>CLOCKWORK CMS verze 0.9beta</strong>. Přejeme Vám mnoho úspěchů!</p>', '', 'home', null, null, null, null)";
mysql_query($query) or die(mysql_error());
//
$query = "INSERT INTO `texty_langs` VALUES ('home-page', 'home-page', '', '', 'DE')";
mysql_query($query) or die(mysql_error());
//
$query = "INSERT INTO `texty_langs` VALUES ('home-page', 'home-page', '', '', 'EN')";
mysql_query($query) or die(mysql_error());
//
$query = "INSERT INTO `texty_langs` VALUES ('home-page', 'home-page', '', '', 'DU')";
mysql_query($query) or die(mysql_error());
//
$query = "INSERT INTO `anketa` (`id`) VALUES ('1')";
mysql_query($query) or die(mysql_error());
//
$query = "INSERT INTO `menu_kategorie` VALUES ('simple', 'simple', null)";
mysql_query($query) or die(mysql_error());
//
//header("Location: ../admin/login.php");
?>
<a href="../admin/login.php">Prihlaseni do administrace</a>