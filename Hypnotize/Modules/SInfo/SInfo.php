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
$result=mysqli_query($mlink, "SELECT * FROM Admin") or mysqldie("Kan ikke lese fra $database.Admin");
//while $results not is empty then
while($row = mysqli_fetch_array($result)) {
//add the query result to a array
$array_modules[$row["module"]] = $row["enable"];
};

//START FUNCTION SUPTIME
function suptime() {
$dirty = file("/proc/uptime");          // grab the line
$ticks = trim(strtok($dirty[0], " "));  // sanitize it (pull out the ticks)
$mins  = $ticks / 60;                   // total mins
$hours = $mins  / 60;                   // total hours
$days  = floor($hours / 24);            // total days
$hours = floor($hours - ($days * 24));  // hours left
$mins  = floor($mins  - ($days * 60 * 24) - ($hours * 60)); // mins left
$uptime = "";
$uptime .= "$days dager, ";              // construct the string
$uptime .= "$hours timer, ";
$uptime .= "$mins minutter";
return $uptime;                         // return the string
};
//STOP FUNCTION SUPTIME
?>
<div class="flex-table">
    <div class="flex-header">
        <div align="center">
            <font face="Arial" size="2">
            <strong>Innformasjon</strong>
            </font>
        </div>
    </div>
    <div class="flex-content">
        <font face="Arial" size="1">
        <strong>Oppetid:</strong><br>
        <?php print suptime(); ?><br>
        <?php
        //if $array_modules["DVD"] is like 1 (enabled) then
        if (($array_modules["DVD"] ?? '0') == "1") {
        print '<br>
        <strong>Antall DVD\'er:</strong><br>';
        //Query the MySQL database and get everything from the "dvd" table, die if a error occure
        $result=mysqli_query($mlink, "SELECT * FROM dvd") or mysqldie ("Kan ikke lese fra $database.dvd");
        //print out how many results we got
        print mysqli_num_rows($result);
        print '<br>';
        };
        //if $array_modules["Linker"] is like 1 (enabled) then
        if (($array_modules["Linker"] ?? '0') == "1") {
        print '<br>
        <strong>Antall Linker:</strong><br>';
        //Query the MySQL database and get everything from the "links" table, die if a error occure
        $result=mysqli_query($mlink, "SELECT * FROM links") or mysqldie ("Kan ikke lese fra $database.links");
        //print out how many results we got
        print mysqli_num_rows($result);
        print '<br>';};
        if (($array_modules["Gjestebok"] ?? '0') == "1") {
        print '<br>
        <strong>Antall meldinger i Gjesteboken:</strong><br>';
        //Query the MySQL database and get everything from the "guestbook" table, die if a error occure
        $result=mysqli_query($mlink, "SELECT * FROM guestbook") or mysqldie ("Kan ikke lese fra $database.guestbook");
        //print out how many results we got
        print mysqli_num_rows($result);
        print '<br>';};
        ?>
        </font>
    </div>
</div>
<br>
