<?php
/*
    The Hypnotize Project is a Content Management System (CMS) that allows you to easily make your own webpage.

    Copyright (C) 2004-2025  Hypnotize

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.

    https://www.github.com/frebergguru/THP-Revamped
*/
//get some information and fix the output
$title = isset($_POST["title"]) ? (string) mysqli_real_escape_string($mlink, $_POST["title"]) : '';
$pagename = isset($_POST["pagename"]) ? mysqli_real_escape_string($mlink, $_POST["pagename"]) : '';
$maintenance = isset($_POST["maintenance"]) ? (int) $_POST["maintenance"] : 0;
$maintenanceip = isset($_POST["maintenanceip"]) ? $_POST["maintenanceip"] : '';
$dguestbook = isset($_POST["dguestbook"]) ? (int) $_POST["dguestbook"] : 0;
$dlinks = isset($_POST["dlinks"]) ? $_POST["dlinks"] : '';
$siteurl = isset($_POST["siteurl"]) ? (string) mysqli_real_escape_string($mlink, $_POST["siteurl"]) : '';
$backend_description = isset($_POST["backend_description"]) ? mysqli_real_escape_string($mlink, $_POST["backend_description"]) : '';
$backend_language = isset($_POST["backend_language"]) ? (string) mysqli_real_escape_string($mlink, $_POST["backend_language"]) : '';
$images = isset($_POST["images"]) ? (string) mysqli_real_escape_string($mlink, $_POST["images"]) : '';
$style_setting = isset($_POST["style"]) ? mysqli_real_escape_string($mlink, $_POST["style"]) : '';

// Mail settings
$smtp_host = isset($_POST["smtp_host"]) ? mysqli_real_escape_string($mlink, $_POST["smtp_host"]) : '';
$smtp_port = isset($_POST["smtp_port"]) ? (int) $_POST["smtp_port"] : 25;
$smtp_user = isset($_POST["smtp_user"]) ? mysqli_real_escape_string($mlink, $_POST["smtp_user"]) : '';
$smtp_pass = isset($_POST["smtp_pass"]) ? mysqli_real_escape_string($mlink, $_POST["smtp_pass"]) : '';
$smtp_encryption = isset($_POST["smtp_encryption"]) ? mysqli_real_escape_string($mlink, $_POST["smtp_encryption"]) : '';
$admin_email = isset($_POST["admin_email"]) ? mysqli_real_escape_string($mlink, $_POST["admin_email"]) : '';


$save = isset($_GET["save"]) ? (int) $_GET["save"] : 0;
//if $save is 1 then
if ($save == "1") {
	//update the table config
	$query_string ="UPDATE `config` SET `title` = '$title',`pagename` = '$pagename',`maintenance` = '$maintenance',`maintenanceip` = '$maintenanceip',`dguestbook` = '$dguestbook',`dlinks` = '$dlinks',`siteurl` = '$siteurl',`backend_description` = '$backend_description',`backend_language` = '$backend_language',`images` = '$images',`style` = '$style_setting', `smtp_host` = '$smtp_host', `smtp_port` = '$smtp_port', `smtp_user` = '$smtp_user', `smtp_pass` = '$smtp_pass', `smtp_encryption` = '$smtp_encryption', `admin_email` = '$admin_email';";
	mysqli_query($mlink, "$query_string") or mysqldie("Kan ikke skrive til $database.config");
	//print out a information box with the text "Innstillingene er n&aring; lagret!"
	info("Innstillingene er n&aring; lagret!");
}
//Query the MySQL database and get everything from the "config" table, die if a error occure
$result=mysqli_query($mlink, "SELECT * FROM config") or mysqldie("Kan ikke lese fra $database.config");
//get the result
$row = mysqli_fetch_array($result);
//get some information and fix the output
$id = $row["id"];
$title = stripslashes($row["title"]);
$pagename = stripslashes($row["pagename"]);
$maintenance = $row["maintenance"];
$maintenanceip = $row["maintenanceip"];
$dguestbook = $row["dguestbook"];
$dlinks = $row["dlinks"];
$siteurl = stripslashes($row["siteurl"]);
$backend_description = stripslashes($row["backend_description"]);
$backend_language = stripslashes($row["backend_language"]);
$images = $row["images"];
$style_setting = htmlspecialchars(stripslashes($row["style"]), ENT_QUOTES, 'ISO-8859-1');

// Mail
$smtp_host = stripslashes($row["smtp_host"] ?? '');
$smtp_port = $row["smtp_port"] ?? 25;
$smtp_user = stripslashes($row["smtp_user"] ?? '');
$smtp_pass = stripslashes($row["smtp_pass"] ?? '');
$smtp_encryption = stripslashes($row["smtp_encryption"] ?? '');
$admin_email = stripslashes($row["admin_email"] ?? '');

//print out the "Edit CMS configuration" box
print '<div class="flex-table">
    <div class="flex-header">
        <font size="2" face="Arial"><strong>CMS konfigurering</strong></font>
    </div>
    <div class="flex-content">
        <form name="setconfig" action="index.php?site='.$site.'&amp;save=1" method="post">
        <strong>Titelen til siden:</strong><br>
        <input type="text" name="title" value="'.htmlspecialchars($title, ENT_QUOTES).'" size="30" class="form"><br>
        <br>
        <strong>Style (CSS):</strong><br>
        <input type="text" name="style" value="'.htmlspecialchars($style_setting, ENT_QUOTES).'" size="30" class="form"><br>
        <br>
        <strong>Navnet til siden:</strong><br>
        <input type="text" name="pagename" value="'.htmlspecialchars($pagename, ENT_QUOTES).'" size="30" class="form"><br>
        <br>
        <strong>Vedlikehold:</strong><br>
        <select name="maintenance">
        <option value="0"'; if($maintenance=="1"){print 'selected';}; print '> Nei
        <option value="1"'; if($maintenance=="1"){print 'selected';}; print '> Ja
        </select><br>
        <br>
        <strong>Vedlikeholds ip:</strong><br>
        <input type="text" name="maintenanceip" value="'.htmlspecialchars($maintenanceip, ENT_QUOTES).'" size="30"><br>
        <br>
        <strong>Koble ut skriving til gjesteboken:</strong><br>
        <select name="dguestbook">
        <option value="0"'; if($dguestbook=="1"){print 'selected';}; print '> Nei
        <option value="1"'; if($dguestbook=="1"){print 'selected';}; print '> Ja
        </select><br>
        <br>
        <strong>Koble ut legge til linker:</strong><br>
        <select name="dlinks">
        <option value="0"'; if($dlinks=="1"){print 'selected';}; print '> Nei
        <option value="1"'; if($dlinks=="1"){print 'selected';}; print '> Ja
        </select><br>
        <br>
        <strong>Adressen til siden (url):</strong><br>
        <input type="text" name="siteurl" value="'.htmlspecialchars($siteurl, ENT_QUOTES).'" size="30"><br>
        <br>
        <strong>Backend beskrivelse (RSS):</strong><br>
        <input type="text" name="backend_description" value="'.htmlspecialchars($backend_description, ENT_QUOTES).'" size="30"><br>
        <br>
        <strong>Backend spr&aring;k:</strong><br>
        Eks: no-bokmaal<br>
        <input type="text" name="backend_language" value="'.htmlspecialchars($backend_language, ENT_QUOTES).'" size="30"><br>
        <br>
        <strong>Hvor ligger bildene p&aring; web serveren ?</strong><br>
        Eks: Hvis bildene ligger p&aring; <strong>http://example.com/bilder</strong> s&aring; skriver du <strong>/bilder</strong> i formen under:<br>
        <input type="text" name="images" value="'.htmlspecialchars($images, ENT_QUOTES).'" size="30"><br>
        <br>
        <hr>
        <h3>Mail Innstillinger (SMTP)</h3>
        <strong>SMTP Host:</strong><br>
        <input type="text" name="smtp_host" value="'.htmlspecialchars($smtp_host, ENT_QUOTES).'" size="30"><br>
        <strong>SMTP Port:</strong><br>
        <input type="text" name="smtp_port" value="'.htmlspecialchars($smtp_port, ENT_QUOTES).'" size="10"><br>
        <strong>SMTP Bruker:</strong><br>
        <input type="text" name="smtp_user" value="'.htmlspecialchars($smtp_user, ENT_QUOTES).'" size="30"><br>
        <strong>SMTP Passord:</strong><br>
        <input type="password" name="smtp_pass" value="'.htmlspecialchars($smtp_pass, ENT_QUOTES).'" size="30"><br>
        <strong>Kryptering (tls/ssl/ingen):</strong><br>
        <select name="smtp_encryption">
            <option value="" '.($smtp_encryption==''?'selected':'').'>Ingen</option>
            <option value="tls" '.($smtp_encryption=='tls'?'selected':'').'>TLS</option>
            <option value="ssl" '.($smtp_encryption=='ssl'?'selected':'').'>SSL</option>
        </select><br>
        <strong>Admin E-post (Mottaker):</strong><br>
        <input type="text" name="admin_email" value="'.htmlspecialchars($admin_email, ENT_QUOTES).'" size="30"><br>
        <br>
        <input type="Submit" name="submit" value="Rediger" class="form"> || <input type="reset" name="reset" value="Nullstill" class="form">
        </form>
    </div>
</div>
<br>';
?>
