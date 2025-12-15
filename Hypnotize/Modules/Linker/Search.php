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
$search = (string) ($_POST['search'] ?? ''); //find out what the users is searching after
//if $search not is empty then
if (!empty($search)) {
//query the table links where ?? is like $search
$result=mysqli_query($mlink, "SELECT * FROM links WHERE description LIKE '%".mysqli_real_escape_string($mlink, $search)."%' OR name LIKE '%".mysqli_real_escape_string($mlink, $search)."%' OR ip LIKE '%".mysqli_real_escape_string($mlink, $search)."%'OR link LIKE '%".mysqli_real_escape_string($mlink, $search)."%' ORDER BY id") or mysqldie ("Cant read data from $database.links");
$tr=mysqli_num_rows($result);
print '<div class="flex-table">
    <div class="flex-header">
        <font face="Arial" size="2">
        <strong>S&oslash;ke resultat</strong>
        </font>
    </div>
    <div class="flex-content">
        S&oslash;ke etter "'.stripslashes(chchar($search)).'" ga '."$tr".' resultater
    </div>
</div>
<br>';
//while $result not is empty then
while ($row = mysqli_fetch_array($result))
{
//get some information from the table and fix the output
$name = stripslashes(chchar($row["name"]));
$ip = $row["ip"];
$date = $row["date"];
$description = stripslashes(parseurls(smilies(chchar($row["description"]))));
$link = $row["link"];
//print out the box
print '<div class="flex-table">
    <div class="flex-header">
        <font size="1" face="Arial">
        <strong>Fra:</strong> '.$name.' <strong>IP:</strong> '.$ip.' <strong>Dato:</strong> '.$date.'
        </font>
    </div>
    <div class="flex-content">
        <font size="2">
        '.$description.'
        </font>
    </div>
    <div class="flex-content under2">
        <font size="1">
        <a href="'.$link.'" class="under2"><strong>'.chchar($link).'</strong></a>
        </font>
    </div>
</div>
<br>';
};
};
?>
