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
//Query the MySQL database and get everything from the "Admin" table, die if a error occure
$result = mysqli_query($mlink, "SELECT * FROM Admin") or mysqldie("Kan ikke lese fra $database.Admin");
//while $results not is empty then
while($row = mysqli_fetch_array($result)) {
//add the query result to a array
$array_modules[$row["module"]] = $row["enable"];
};
//query the MySQL database and get everything from the "boxes" table and order by sort_id asscending, die if a error occure
$result=mysqli_query($mlink, "SELECT * FROM boxes ORDER BY sort_id DESC") or mysqldie("Kan ikke lese fra $database.boxes");
//while $result not is empty then
while ($row = mysqli_fetch_array($result))
{
//get some information from the table and fix the output
$headline = stripslashes(chchar($row["headline"]));
$uheadline = stripslashes(smilies(chchar($row["uheadline"])));
$text = parseurls(stripslashes(smilies(chchar($row["text"]))));
$link = $row["link"];
$image = $row["image"];
$module = $row["module"];
$dbsite = $row["site"];
$position = $row["position"];
$allsites = $row["allsites"];
//if $module not is empty and $array_modules is like 1 and $allsites is like 0 and $dbsite is like $site then
if (!empty($module) && $array_modules[$module] == "1" && $allsites == "0" && $dbsite == $site) {
//set $filename to "Modules/$module/center.php"
$filename = 'Modules/'.$module.'/center.php';
//if the file $filename exists then
if (file_exists($filename)) {
//include the file
include $filename;
};
//elseif $module is empty and $array_modules is like 1 and $allsites is like 1 then
}elseif(!empty($module) && $array_modules[$module] == "1" && $allsites == "1"){
//set the file $filename to "Modules/$module/center.php"
$filename = 'Modules/'.$module.'/center.php';
//if the file $filename exists then
if (file_exists($filename)) {
//include the file
include $filename;
};
//else if $headline not is empty and $image not is empty and $allsites is like 0 and $dbsite is like $site and $position is like c then
}elseif (!empty($headline) && empty($image) && ($allsites == "1" || ($allsites == "0" && $dbsite == $site)) && $position == "c") {
//print out the box
print '<div class="box">
<div class="box-header">
'.smilies($headline);
if(!empty($uheadline)){print'<br>
<span class="smaller-text">
'.$uheadline.'
</span>';};
print'</div>
<div class="box-content">
'.$text;
if(!empty($link)){print'<br><a href="'.htmlspecialchars($link, ENT_QUOTES, 'ISO-8859-1').'"><strong>'.htmlspecialchars($link, ENT_QUOTES, 'ISO-8859-1').'</strong></a>';};
print'</div>
</div>
<br>';
//else if $headline not is empty and $image not is empty and $allsites is like 0 and $dbsite is like $site and $position is like c then
} elseif (!empty($headline) && !empty($image) && ($allsites == "1" || ($allsites == "0" && $dbsite == $site)) && $position == "c") {
//print out the box
print '<div class="box">
<div class="box-header">
'.smilies($headline).'
</div>
<div class="box-content text-center">
<a href="./includes/watermark.php?filename='.$image.'" target="_blank"><img src="./includes/thumb.php?filename='.$image.'" border="0" alt="'.$headline.'"></a>
</div>
</div>
<br>';
}
};
?>
