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
$search = (string) ($_POST['search'] ?? ''); //find out what the user is searching after
//if $search not is empty then
if (!empty($search)) {
//query the table boxes where ?? is like $search
$result=mysqli_query($mlink, "SELECT * FROM boxes WHERE headline LIKE '%".mysqli_real_escape_string($mlink, $search)."%' OR uheadline LIKE '%".mysqli_real_escape_string($mlink, $search)."%' OR link LIKE '%".mysqli_real_escape_string($mlink, $search)."%' OR text LIKE '%".mysqli_real_escape_string($mlink, $search)."%' OR uheadline LIKE '%".mysqli_real_escape_string($mlink, $search)."%' ORDER BY id") or mysqldie("Cant read data from $database.boxes");
//while $result not is empty then
while ($row = mysqli_fetch_array($result))
{
//get some information from the table and fix the output
$site2 = $row["site"];
$headline = stripslashes(chchar($row["headline"]));
$uheadline = stripslashes(chchar($row["uheadline"]));
$text = stripslashes(parseurls(smilies(chchar($row["text"]))));
$link = $row["link"];
$position = $row["position"];
//if $site2 not is like "Sok" and $position is like l then
if ($site2 != "Sok" && $position == "l") {
//print out the box
print '<div class="flex-table">

<div class="flex-header">
<font size="2" face="Arial">
<strong>Side: '.$site2.'<br>
Overskrift: '.$headline.'</strong>
</font><br>
<font size="1" face="Arial">
'.$uheadline.'
</font>
</strong>
</div>
<div class="flex-content">
<font size="2">
'.$text.'
</font>
</div>
<div class="flex-content under2"><font size="1"><a href="'.$link.'" class="under2">'.chchar($link).'</a></font></div>


</div>


<br>';
}
};
};
?>
