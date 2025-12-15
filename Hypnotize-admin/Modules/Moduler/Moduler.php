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
$action = isset($_GET["action"]) ? $_GET["action"] : '';
$module = isset($_GET["module"]) ? $_GET["module"] : '';
//if $action is "Deaktiver" and $module not is empty then
if ($action=="Deaktiver" && !empty($module)) {
	//update table Admin and set enable to 0 where module is $module limit 1
	$query_string = 'UPDATE `Admin` SET `enable` = "0" WHERE `module` = "'.$module.'" LIMIT 1 ;';
	mysqli_query($mlink, "$query_string") or mysqldie("Kan ikke skrive til $database.Admin");
//else if $action is "Aktiver" and $module not is empty then 
} elseif ($action=="Aktiver" && !empty($module)) {
	//update table Admin and set enable to 1 where module is $module limit 1
	$query_string = 'UPDATE `Admin` SET `enable` = "1" WHERE `module` = "'.$module.'" LIMIT 1 ;';
	mysqli_query($mlink, "$query_string") or mysqldie("Kan ikke skrive til $database.Admin");
};
//Query the MySQL database and get everything from the "Admin" table order by id ascending, die if a error occure
$result=mysqli_query($mlink, "SELECT * FROM Admin ORDER BY id asc") or mysqldie("Kan ikke lese fra $database.Admin");
//while $result not is empty then
while ($row = mysqli_fetch_array($result))
{	//get some information and fix the output
	$module2 = $row["module"];
	$module_name = smilies(chchar($row["module_name"]));
	$enable = $row["enable"];
	//if $enable is 1 then $enable_text is "Ja" else $enable_text is Nei
	if ($enable=="1") {$enable_text = "Ja";}else{$enable_text = "Nei";};
	//if $enable is 1 then $eaction is "Deaktiver" else $eaction is "Aktiver"
	if ($enable=="1") {$eaction = "Deaktiver";}else{$eaction = "Aktiver";};
	//if $module2 not is empty and $module_name not is empty and $enable not is empty then
	if (!empty($module2) && !empty($module_name) && $enable!="") {
//print out the "Module" box
print '<div class="flex-table">
    <div class="flex-header">
        <strong>Modul:</strong> '.$module2.'<br>
        <strong>Beskrivelse:</strong> '.$module_name.'<br>
        <strong>Aktivert?</strong> '.$enable_text.' - <strong><a href="index.php?site='.$site.'&amp;action='.$eaction.'&amp;module='.$module2.'">'.$eaction.'</a></strong>
    </div>
</div>
<br>';
};
};
?>
