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
$cat = isset($_POST["cat"]) ? (string) mysqli_real_escape_string($mlink, $_POST["cat"]) : '';
$url = isset($_POST["url"]) ? (string) mysqli_real_escape_string($mlink, $_POST["url"]) : '';
$break = isset($_POST["break"]) ? 1 : 0;
$status = "0";
//if $cat not is empty then
if (!empty($cat)) {
	//Query the MySQL database and get everything from the "Admin" table, die if a error occure
	$result=mysqli_query($mlink, "SELECT * FROM Admin") or mysqldie("Kan ikke lese fra $database.Admin");
	//while $results not is empty then
	while ($row = mysqli_fetch_array($result))
	{
		//get some information from the table
		$module = $row["module"];
		$module_menu_name = $row["module_menu_name"];
		//if $cat is like $module or $cat is like $module_menu_name then
		if ($cat == $module or $cat == $module_menu_name) {
			//print out a error message ("Det finnes allerede en side/modul med navnet $cat")
			error('Det finnes allerede en side/modul med navnet "'.chchar($cat).'"');
			//set $status to 1
			$status="1";
		};
	};
//Query the MySQL database and get everything from the "menu" table, die if a error occure
$result=mysqli_query($mlink, "SELECT * FROM menu") or mysqldie("Kan ikke lese fra $database.menu");
//while $result not is empty then
while ($row = mysqli_fetch_array($result))
{
	//get some information
	$sitename = $row["sitename"];
	//if $cat is like $sitename then
	if ($cat == $sitename) {
		//print out a error message ("Det finnes allerede en side/modul med navnet $cat")
		error('Det finnes allerede en side/modul med navnet "'.chchar($cat).'"');
		//set $status to 1
		$status="1";
	};
};
//if $status not is like 1 then
if ($status != "1") {
    // Get max sort_id
    $res = mysqli_query($mlink, "SELECT MAX(sort_id) as max_sort FROM menu");
    $row = mysqli_fetch_array($res);
    $new_sort_id = $row['max_sort'] + 1;
	//insert the new site name to the table menu, die if a error occure
	mysqli_query($mlink, "INSERT INTO `menu` (`site_id`, `sitename`, `link`, `break`, `sort_id`) VALUES ('', '$cat', '$url', '$break', '$new_sort_id')") or mysqldie("Kan ikke skrive til $database.menu");
	//print out a info box with the text ("Siden $cat er naa lagt til!")
	info('Siden "'.chchar($cat).'" er n&aring; lagt til!');
};
};
//print out the add a page form
print '<div class="flex-table">
    <div class="flex-header">
        <font size="2" face="Arial"><strong>Legg til en side</strong></font>
    </div>
    <div class="flex-content">
        <form name="Category" action="index.php?site='.$site.'" method="post">
        <strong>Side navn:</strong><br>
        <input type="text" name="cat" size="30"><br>
        <strong>Ekstern URL (valgfritt):</strong><br>
        <input type="text" name="url" size="30"><br>
        <strong>Ny linje etter denne?</strong>
        <input type="checkbox" name="break" value="1"><br>
        <br>
        <input type="submit" value="Legg til"> || <input type="reset" value="Nullstill">
        </form>
    </div>
</div>
<br>';
?>
