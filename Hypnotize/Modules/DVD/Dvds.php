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
$sub=$_GET['sub'] ?? '';
if($sub=="view") {
$id=$_GET['id'] ?? 0;
//Query the MySQL database and get everything from the "dvd" table where id is like $id order by title ascending, die if a error occure
$result=mysqli_query($mlink, "SELECT * FROM dvd WHERE id='$id' ORDER BY title ASC") or mysqldie("Kan ikke lese fra $database.dvd");
//get data from the array $result
$row = mysqli_fetch_array($result);
//get some information from the table and fix the output
$producers = stripslashes(chchar($row["producers"]));
$directors = stripslashes(chchar($row["directors"]));
$manufacturer = stripslashes(chchar($row["manufacturer"]));
$rating = $row["rating"];
$region = $row["region"];
$format = stripslashes($row["format"]);
$genre = stripslashes(chchar($row["genre"]));
$length = $row["length"];
$title = stripslashes(chchar($row["title"]));
$actors = stripslashes(chchar($row["actors"]));
$year = $row["year"];
$subtitles = stripslashes(chchar($row["subtitles"]));
$screen = stripslashes(chchar($row["screen"]));
$languages = stripslashes(chchar($row["languages"]));
$comment = stripslashes(parseurls(smilies(chchar($row["comment"]))));
$dice = $row["dice"];
//check if some of the strings is empty and change the output of the string to N/A if it is empty
if (empty($producers)){$producers="N/A";};
if (empty($directors)){$directors="N/A";};
if (empty($manufacturer)){$manufacturer="N/A";};
if (empty($rating)){$rating="N/A";};
if (empty($region)){$region="N/A";}elseif($region=="0"){$region="0 - Region fri";}elseif($region=="1"){$region="1 - USA, Canada, Puerto Rico";}elseif($region=="2"){$region="2 - Europa, Midt &Oslash;sten, Japan";}elseif($region=="3"){$region="3 - S&oslash;r&oslash;st Asia, Hong Kong, Taiwan";}elseif($region=="4"){$region="4 - Mellom - Amerika, Mexico, S&oslash;r Amerika, Australia, New Zealand";}elseif($region=="5"){$region="5 - Den russiske f&oslash;derasjonen, Afrika (unntatt Egypt og S&oslash;r Afrika) India, Pakistan";}elseif($region=="6"){$region="6 - Kina";}elseif($region=="7"){$region="7 - Reservert for senere bruk!";}elseif($region=="8"){$region="8 - Internasjonale territorier (Skip, Fly etc)";}elseif($region=="9"){$region="9 - Ekpansjon (ofte brukt som region fri)";};
if (empty($format)){$format="N/A";};
if (empty($genre)){$genre="N/A";};
if (empty($length)){$length="N/A";};
if (empty($title)){$title="N/A";};
if (empty($actors)){$actors="N/A";};
if (empty($year)){$year="N/A";};
if (empty($subtitles)){$subtitles="N/A";};
if (empty($screen)){$screen="N/A";};
if (empty($languages)){$languages="N/A";};
if (empty($comment)){$comment="N/A";};
if (empty($dice)){$dice="N/A";} elseif (!empty($dice)){$dice="<img src=\"./images/dvd/".$dice.".gif\" border=\"0\" alt=\"".$dice."\">";};
//print out the box
print '<div class="flex-table">
    <div class="flex-header">
        <font size="2" face="Arial"><strong>'.$title.'</strong></font>
    </div>
    <div class="flex-content">
        <font size="2">
        <strong>Regis&oslash;r(er):</strong> '.$producers.'<br>
        <br>
        <strong>Leder(e):</strong> '.$directors.'<br>
        <br>
        <strong>Utgiver:</strong> '.$manufacturer.'<br>
        <br>
        <strong>Aldersgrense / Kode:</strong> '.$rating.'<br>
        <br>
        <strong>Mitt terningkast:</strong> '.$dice.'<br>
        <br>
        <strong>Region:</strong> '.$region.'<br>
        <br>
        <strong>Format:</strong> '.$format.'<br>
        <br>
        <strong>Sjanger:</strong> '.$genre.'<br>
        <br>
        <strong>Lengde:</strong> '.$length.'<br>
        <br>
        <strong>Skuespillere:</strong> '.$actors.'<br>
        <br>
        <strong>&Aring;r:</strong> '.$year.'<br>
        <br>
        <strong>Undertekster:</strong> '.$subtitles.'<br>
        <br>
        <strong>Skjerm:</strong> '.$screen.'<br>
        <br>
        <strong>Spr&aring;k:</strong> '.$languages.'<br>
        <br>
        <strong>Kommentar:</strong> '.$comment.'
        </font>
    </div>
</div>
<br>';
}
else
{
$sort = $_GET["sort"] ?? 'y';
$order = $_GET["order"] ?? 'asc';

// Logic for Title link
$title_order = 'asc';
if ($sort == 't' && $order == 'asc') {
    $title_order = 'desc';
}

// Logic for Year link
$year_order = 'asc';
if ($sort == 'y' && $order == 'asc') {
    $year_order = 'desc';
}

print '<div class="flex-table">
    <div class="flex-header">
        <font size="2" face="Arial"><strong>Sortering</strong></font>
    </div>
    <div class="flex-content">
        <font size="2">
        Sorter etter <a href="'.$_SERVER["PHP_SELF"].'?site=DVD&amp;sort=t&amp;order='.$title_order.'"><strong>Tittel</strong></a> || <a href="'.$_SERVER["PHP_SELF"].'?site=DVD&amp;sort=y&amp;order='.$year_order.'"><strong>&Aring;r</strong></a>
        </font>
    </div>
</div>
<br>';

//if $sort is y and $order is asc or $sort is y and $order is empty then 
if ($sort=="y" && $order=="asc" OR $sort=="y" && empty($order)){
//query the database
$result=mysqli_query($mlink, "SELECT * FROM dvd ORDER BY year ASC") or mysqldie("Kan ikke lese fra $database.dvd");
//else if $sort is y and $order is desc then
}elseif($sort=="y" && $order=="desc") {
//query the database
$result=mysqli_query($mlink, "SELECT * FROM dvd ORDER BY year DESC") or mysqldie("Kan ikke lese fra $database.dvd");
//else if $sort is t and $order is asc or $sort is t and $order is empty then
}elseif($sort=="t" && $order=="asc" OR $sort=="t" && empty($order)){
//query the database
$result=mysqli_query($mlink, "SELECT * FROM dvd ORDER BY title ASC") or mysqldie("Kan ikke lese fra $database.dvd");
//else if $sort is t and $order is desc then
}elseif($sort=="t" && $order=="desc"){
//query the database
$result=mysqli_query($mlink, "SELECT * FROM dvd ORDER BY title DESC") or mysqldie("Kan ikke lese fra $database.dvd");
//else if $sort is id and $order is asc or $sort is id and $order is empty or $sort and $order is empty then
}elseif($sort=="id" && $order=="asc" OR $sort=="id" && empty($order) OR empty($sort) && empty($order)){
//query the database
$result=mysqli_query($mlink, "SELECT * FROM dvd ORDER BY id ASC") or mysqldie("Kan ikke lese fra $database.dvd");
}else{
//query the database
$result=mysqli_query($mlink, "SELECT * FROM dvd ORDER BY id DESC") or mysqldie("Kan ikke lese fra $database.dvd");
};
//set $i to 0
$i = 0;
//while $result not is empty then
while ($row = mysqli_fetch_array($result))
{
//get some information from the table and fix the output
$id = $row["id"];
$title = stripslashes(chchar($row["title"]));
$year = $row["year"];

//make a counter
$i=$i+1; //$i is like $i + 1
print '<div class="flex-table">
    <div class="flex-header">
        <font size="2" face="Arial"><strong>'.$title.'</strong></font>
    </div>
    <div class="flex-content">
        <font size="2">
        NR: '.$i.'<br>
        Tittel: '.$title.'<br>
        &Aring;r: '.$year.'<br>
        </font>
    </div>
    <div class="flex-content under2">
        <font size="1"><a href="?site='.$site.'&amp;style='.$style.'&amp;sub=view&amp;id='.$id.'" class="under2"><strong>Trykk her for mer informasjon</strong></a></font>
    </div>
</div>
<br>
';
};
};
?>
