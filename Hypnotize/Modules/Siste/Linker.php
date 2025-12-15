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
//Query the MySQL database and get everything from the "links" table order by id limit 1, die if a error occure
$result=mysqli_query($mlink, "SELECT * FROM links ORDER BY id DESC limit 1") or mysqldie("Kan ikke lese fra $database.links");
//while $result not is empty then
while ($row = mysqli_fetch_array($result))
{
//get some information from the table and fix the output
$name = stripslashes(chchar($row["name"]));
$date = $row["date"];
$description = stripslashes(parseurls(smilies(chchar($row["description"]))));
$link = $row["link"];
if (preg_match('/^\s*javascript:/i', $link)) { $link = '#'; }
$time = $row["time"];
//print out the box
print '<div class="flex-table">

<div class="flex-header">
<font size="2" face="Arial">
<strong>Siste fra Linker</strong>
</font>
<br>
<font size="1" face="Arial">
<strong>Fra:</strong> '.$name.' <strong>Dato:</strong> '.$date.' <strong>Kl:</strong> '.$time.'
</font></div>
<div class="flex-content">
<font size="2">
'.$description.'
</font>
</div>
<div class="flex-content under2">
<font size="1">
<a href="'.htmlspecialchars($link, ENT_QUOTES).'" class="under2" target="_blank"><strong>'.chchar($link).'</strong></a>
</font>
</div>


</div>


<br>';
};
?>
