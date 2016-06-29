<?php
require('admin-security.php');
?>

<?php
echo "<table cellspacing='0'>";
echo "<thead><tr><td class='main'>Nastavení</td></tr></thead>";
echo "<tr><td><a href=index.php?action=config_web>Konfigurace webu</a></td></tr>";
echo "<tr><td><a href=index.php?action=config_content>Publikování/Obsah</a></td></tr>";
echo "<tr><td><a href=index.php?action=config_metadata>METAdata</a></td></tr>";
echo "<tr><td><a href=index.php?action=config_password>Prístupové heslo</a></td></tr>";
echo "<tr><td><a href=index.php?action=config_css>Konfigurace stylu</a></td></tr>";
echo "<tr><td><a href=index.php?action=config_mysql>Konfigurace MySQL</a></td></tr>";
echo "</table><br />";

echo "<table cellspacing='0'>";
echo "<thead><tr><td class='main'>Postranní menu</td></tr></thead>";
echo "<tr><td><a href=index.php?action=show-menu-categories>Upravit menu/rubriky</a></td></tr>";
if($this->get_settings(web_version)=='CMS')
{
	echo "<tr><td><a href='index.php?action=pridat-kategorii&param=main'>Pridat hlavní kategorii</a></td></tr>";
	echo "<tr><td><a href='index.php?action=pridat-kategorii&param=sub'>Pridat podkategorii</a></td></tr>";
}
echo "<tr><td><a href='index.php?action=ankety'>Ankety</a></td></tr>";
echo "</table><br />";

if($this->get_settings(web_version)=='CMS')
{    
echo "<table cellspacing='0'>";
echo "<thead><tr><td class='main'>Clánky</td></tr></thead>";
echo "<tr><td><a href=index.php?action=pridej-clanek>Pridat clánek</a></td></tr>";
echo "<tr><td><a href=index.php?action=zobrazit-clanky>Zobrazit publikované</a></td></tr>";
echo "<tr><td><a href=index.php?action=clanky-rozepsane>Rozepsané</a></td></tr>";
echo "</table><br />";
}

echo "<table cellspacing='0'>";
echo "<thead><tr><td class='main'>Aktuality</td></tr></thead>";
echo "<tr><td><a href=index.php?action=pridej-aktualitu>Pridat aktualitu</a></td></tr>";
echo "<tr><td><a href=index.php?action=zobrazit-aktuality>Zobrazit všechny zadané</a></td></tr>";
echo "<tr><td><a href=index.php?action=nastaveni-aktualit>Nastavení</a></td></tr>";
echo "</table><br />";

echo "<table cellspacing='0'>";
echo "<thead><tr><td class='main'>Texty</td></tr></thead>";
echo "<tr><td><a href=index.php?action=pridej-text>Pridat text</a></td></tr>";
echo "<tr><td><a href=index.php?action=zobrazit-texty>Zobrazit publikované</a></td></tr>";
echo "<tr><td><a href=index.php?action=texty-rozepsane>Rozepsané</a></td></tr>";
echo "</table><br />";

echo "<table cellspacing='0'>";
echo "<thead><tr><td class='main'>Návštìvní kniha</td></tr></thead>";
echo "<tr><td><a href=index.php?action=gb-nastaveni>Nastavení</a></td></tr>";
echo "<tr><td><a href=index.php?action=gb-prispevky>Pøíspìvky</a></td></tr>";
echo "</table><br />";

echo "<table cellspacing='0'>";
echo "<thead><tr><td class='main'>Komentáre</td></tr></thead>";
echo "<tr><td><a href=index.php?action=komentare>Zobrazit komentáre</a></td></tr>";
echo "<tr><td><a href=index.php?action=komentare-skryte>Skyté komentáre</a></td></tr>";
echo "</table><br />";

echo "<table cellspacing='0'>";
echo "<thead><tr><td class='main'>Soubory</td></tr></thead>";
echo "<tr><td><a href=index.php?action=spravce-souboru>Správce souborù</a></td></tr>";
//echo "<tr><td><a href=index.php?action=nahrat-obrazek>Nahrát obrázky</a></td></tr>";
//echo "<tr><td><a href=index.php?action=nahrat-soubor>Nahrát soubory</a></td></tr>";
echo "</table><br />";

echo "<table cellspacing='0'>";
echo "<thead><tr><td class='main'>Fotogalerie</td></tr></thead>";
echo "<tr><td><a href=index.php?action=galerie>Správce</a></td></tr>";
echo "<tr><td><a href=index.php?action=vytvorit-galerii>Vytvoøit novou</a></td></tr>";
echo "</table><br />";

echo "<table cellspacing='0'>";
echo "<thead><tr><td class='main'>Statistiky</td></tr></thead>";
echo "<tr><td><a href=index.php?action=statistiky>Statistiky pøístupù</a></td></tr>";
echo "<tr><td><a href=index.php?action=statistiky-login>Pokusy o pøihlášení</a></td></tr>";
echo "</table><br />";

echo "<table cellspacing='0'>";
echo "<tr><td><a href=logout.php>Odhlásit se</a></td></tr>";
echo "</table><br />";

?>