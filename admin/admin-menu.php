<?php
require('admin-security.php');
?>

<?php
echo "<table cellspacing='0'>";
echo "<thead><tr><td class='main'>Nastaven�</td></tr></thead>";
echo "<tr><td><a href=index.php?action=config_web>Konfigurace webu</a></td></tr>";
echo "<tr><td><a href=index.php?action=config_content>Publikov�n�/Obsah</a></td></tr>";
echo "<tr><td><a href=index.php?action=config_metadata>METAdata</a></td></tr>";
echo "<tr><td><a href=index.php?action=config_password>Pr�stupov� heslo</a></td></tr>";
echo "<tr><td><a href=index.php?action=config_css>Konfigurace stylu</a></td></tr>";
echo "<tr><td><a href=index.php?action=config_mysql>Konfigurace MySQL</a></td></tr>";
echo "</table><br />";

echo "<table cellspacing='0'>";
echo "<thead><tr><td class='main'>Postrann� menu</td></tr></thead>";
echo "<tr><td><a href=index.php?action=show-menu-categories>Upravit menu/rubriky</a></td></tr>";
if($this->get_settings(web_version)=='CMS')
{
	echo "<tr><td><a href='index.php?action=pridat-kategorii&param=main'>Pridat hlavn� kategorii</a></td></tr>";
	echo "<tr><td><a href='index.php?action=pridat-kategorii&param=sub'>Pridat podkategorii</a></td></tr>";
}
echo "<tr><td><a href='index.php?action=ankety'>Ankety</a></td></tr>";
echo "</table><br />";

if($this->get_settings(web_version)=='CMS')
{    
echo "<table cellspacing='0'>";
echo "<thead><tr><td class='main'>Cl�nky</td></tr></thead>";
echo "<tr><td><a href=index.php?action=pridej-clanek>Pridat cl�nek</a></td></tr>";
echo "<tr><td><a href=index.php?action=zobrazit-clanky>Zobrazit publikovan�</a></td></tr>";
echo "<tr><td><a href=index.php?action=clanky-rozepsane>Rozepsan�</a></td></tr>";
echo "</table><br />";
}

echo "<table cellspacing='0'>";
echo "<thead><tr><td class='main'>Aktuality</td></tr></thead>";
echo "<tr><td><a href=index.php?action=pridej-aktualitu>Pridat aktualitu</a></td></tr>";
echo "<tr><td><a href=index.php?action=zobrazit-aktuality>Zobrazit v�echny zadan�</a></td></tr>";
echo "<tr><td><a href=index.php?action=nastaveni-aktualit>Nastaven�</a></td></tr>";
echo "</table><br />";

echo "<table cellspacing='0'>";
echo "<thead><tr><td class='main'>Texty</td></tr></thead>";
echo "<tr><td><a href=index.php?action=pridej-text>Pridat text</a></td></tr>";
echo "<tr><td><a href=index.php?action=zobrazit-texty>Zobrazit publikovan�</a></td></tr>";
echo "<tr><td><a href=index.php?action=texty-rozepsane>Rozepsan�</a></td></tr>";
echo "</table><br />";

echo "<table cellspacing='0'>";
echo "<thead><tr><td class='main'>N�v�t�vn� kniha</td></tr></thead>";
echo "<tr><td><a href=index.php?action=gb-nastaveni>Nastaven�</a></td></tr>";
echo "<tr><td><a href=index.php?action=gb-prispevky>P��sp�vky</a></td></tr>";
echo "</table><br />";

echo "<table cellspacing='0'>";
echo "<thead><tr><td class='main'>Koment�re</td></tr></thead>";
echo "<tr><td><a href=index.php?action=komentare>Zobrazit koment�re</a></td></tr>";
echo "<tr><td><a href=index.php?action=komentare-skryte>Skyt� koment�re</a></td></tr>";
echo "</table><br />";

echo "<table cellspacing='0'>";
echo "<thead><tr><td class='main'>Soubory</td></tr></thead>";
echo "<tr><td><a href=index.php?action=spravce-souboru>Spr�vce soubor�</a></td></tr>";
//echo "<tr><td><a href=index.php?action=nahrat-obrazek>Nahr�t obr�zky</a></td></tr>";
//echo "<tr><td><a href=index.php?action=nahrat-soubor>Nahr�t soubory</a></td></tr>";
echo "</table><br />";

echo "<table cellspacing='0'>";
echo "<thead><tr><td class='main'>Fotogalerie</td></tr></thead>";
echo "<tr><td><a href=index.php?action=galerie>Spr�vce</a></td></tr>";
echo "<tr><td><a href=index.php?action=vytvorit-galerii>Vytvo�it novou</a></td></tr>";
echo "</table><br />";

echo "<table cellspacing='0'>";
echo "<thead><tr><td class='main'>Statistiky</td></tr></thead>";
echo "<tr><td><a href=index.php?action=statistiky>Statistiky p��stup�</a></td></tr>";
echo "<tr><td><a href=index.php?action=statistiky-login>Pokusy o p�ihl�en�</a></td></tr>";
echo "</table><br />";

echo "<table cellspacing='0'>";
echo "<tr><td><a href=logout.php>Odhl�sit se</a></td></tr>";
echo "</table><br />";

?>