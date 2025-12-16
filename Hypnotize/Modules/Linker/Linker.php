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
//get some information
$name = $_POST['name'] ?? '';
$description = $_POST['description'] ?? '';
$number = $_POST['number'] ?? '';
$link2 = $_POST['link2'] ?? '';

//get the date
$date=(date ("Y-m-d"));
//get the time
$time=(date ("H:i:s"));
//get the users ip address
$ip=$_SERVER["REMOTE_ADDR"];

//if $links2 and $description not is empty and $link2 not is like "https://" and md5($nubmer) is like ($_SESSION['image_random_value'] ?? '') then
if (!empty($link2) && !empty($description) && $link2 !="https://" && md5($number) == ($_SESSION['image_random_value'] ?? '')){
//add the link to the database
$result=mysqli_query($mlink, "INSERT INTO links (name, ip, date, time, description, link) VALUES ('".mysqli_real_escape_string($mlink, $name)."','".mysqli_real_escape_string($mlink, $ip)."','".mysqli_real_escape_string($mlink, $date)."','".mysqli_real_escape_string($mlink, $time)."','".mysqli_real_escape_string($mlink, $description)."','".mysqli_real_escape_string($mlink, $link2)."')") or mysqldie("Kan ikke skrive til $database.links");
//print out the box
print '<div class="flex-table">
    <div class="flex-header">
        <font face="Arial" size=2>
        <strong>Takk for at du la til en link!:)</strong>
        </font>
    </div>
    <div class="flex-content">
        <font face="Arial" size="1">
        <strong>Ditt navn:</strong> '.chchar($name).'<br>
        <strong>Beskrivelse:</strong> '.chchar($description).'<br>
        <strong>Link:</strong> <a href="'.$link2.'" target="_blank">'.chchar($link2).'</a><br>
        <br>
        <a href="'.rtrim($siteurl, '/').'/?site='.$site.'&amp;style='.$style.'">Trykk her for &aring; g&aring; tilbake til Linker!</a>
        </font>
    </div>
</div>
<br>';
return 0;//die
} else {
//if $dlinks not is like 1 then
if ($dlinks != "1") {
//print out the add a link box
print '<div class="flex-table">
    <div class="flex-header">
        <font size="2" face="Arial">
        <strong>Legg til en link</strong>
        </font>
    </div>
    <div class="flex-content">
        <form action="'.rtrim($siteurl, '/').'/?site='.$site.'&amp;style='.$style.'" method="post">
        <font size="2">';
//if $description and $link2 not is empty an $link2 not is like "https://" and md5($number) not is like ($_SESSION['image_random_value'] ?? '') then
if (!empty($description) && !empty($link2) && $link2 != "https://" && md5($number) != ($_SESSION['image_random_value'] ?? '')){
//print out "UGYLDIG VERIFIKASJONS KODE!"
print '<font size="2">UGYLDIG VERIFIKASJONS KODE!</font><br>';
//reset the value "image_random_value"
$_SESSION['image_random_value'] = '';
};
print '<strong>Verifikasjons kode:</strong><br>
<img src="./includes/image.php" border="0" alt="kode"><br>
<strong>Skriv inn nummerene over her:</strong><br>
<input type="text" name="number" size="30"><br>
<strong>Ditt navn:</strong><br>
<input type="text" name="name" size="30"><br>
<strong>Beskrivelse:</strong><br>
<textarea name="description" rows="6" cols="43"></textarea><br>
<strong>Link:</strong><br>
<input type="text" value="https://" name="link2" size="30"><br>
<br>
<input type="submit" value="Legg til"> || <input type="reset" value="Nullstill">
</font>
</form>
</div>
</div>
<br>';
;};
};
//query the MySQL database and get everything from the "links" table order by date descending, die if a error occure
$result=mysqli_query($mlink, "SELECT * FROM links ORDER BY date DESC") or mysqldie("Kan ikke lese fra $database.links");
//while $result not is empty then
while ($row = mysqli_fetch_array($result))
{
//get some information from the table and fix the output
$name = stripslashes(chchar($row["name"]));
$ip = $row["ip"];
$date = $row["date"];
$time = $row["time"];
$link = $row["link"];
if (preg_match('/^\s*javascript:/i', $link)) { $link = '#'; }
$description = stripslashes(parseurls(smilies(chchar($row["description"]))));
//print out a box
print '<div class="flex-table">
    <div class="flex-header">
        <font size="2" face="Arial"><strong>Fra:</strong> '.$name.' <strong>Dato:</strong> '.$date.' <strong>Kl:</strong> '.$time.'</font>
    </div>
    <div class="flex-content">
        <font size="2">
        '.$description.'
        </font>
    </div>
    <div class="flex-content under2">
        <font size="1"><a href="'.htmlspecialchars($link, ENT_QUOTES).'" class="under2" target="_blank"><strong>'.chchar($link).'</strong></a></font>
    </div>
</div>
<br>';
};
?>
