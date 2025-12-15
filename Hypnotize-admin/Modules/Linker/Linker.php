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
$action = (string) ($_GET["action"] ?? '');
$id = (int) ($_GET["id"] ?? 0);
$editname = mysqli_real_escape_string($mlink, $_POST["name"] ?? '');
$editip = mysqli_real_escape_string($mlink, $_POST["ip"] ?? '');
$editdate = mysqli_real_escape_string($mlink, $_POST["date"] ?? '');
$edittime = mysqli_real_escape_string($mlink, $_POST["time"] ?? '');
$editdesc = mysqli_real_escape_string($mlink, $_POST["description"] ?? '');
$editlink = mysqli_real_escape_string($mlink, $_POST["link"] ?? '');
//get the users ip address
$ip = $_SERVER["REMOTE_ADDR"];
//get the date
$date=date("Y-m-d");
//get the time
$time=date("H:i:s");
//if $action is "Added" then
if ($action=="Added") {
	//Add the link
	$query_string ="INSERT INTO `links` ( `name` , `ip` , `date` , `time` , `description` , `link` ) VALUES ('$editname', '$editip', '$editdate', '$edittime', '$editdesc', '$editlink')";
	mysqli_query($mlink, "$query_string") or mysqldie("Kan ikke skrive til $database.links");
//else if $action is "Add" then
} elseif ($action=="Add") {
//print out the "Add a link" box
print '<div class="flex-table">
    <div class="flex-header">
        <font size="2" face="Arial"><strong>Legg til en link</strong></font>
    </div>
    <div class="flex-content">
        <form name="Links" action="index.php?site='.$site.'&amp;action=Added" method="post">
        <strong>IP:</strong><br>
        <input type="text" name="ip" value="'.htmlspecialchars($ip, ENT_QUOTES).'" size="30"><br>
        <strong>Dato:</strong><br>
        <input type="text" name="date" value="'.htmlspecialchars($date, ENT_QUOTES).'" size="30"><br>
        <strong>Klokken:</strong><br>
        <input type="text" name="time" value="'.htmlspecialchars($time, ENT_QUOTES).'" size="30"><br>
        <strong>Navn:</strong><br>
        <input type="text" name="name" value="" size="30"><br>
        <strong>Link:</strong><br>
        <input type="text" name="link" value="http://" size="30"><br>
        <strong>Beskrivelse:</strong><br>
        <textarea name="description" rows="6" cols="43"></textarea><br>
        <br>
        <input type="submit" value="Legg til"> || <input type="reset" value="Nullstill">
        </form>
    </div>
</div>
<br>';
//else if $action is "Edited" then
} elseif ($action=="Edited") {
	//update the database table links with new information
	$query_string ="UPDATE links SET name='$editname', ip='$editip', date='$editdate', time='$edittime', description='$editdesc', link='$editlink' WHERE ID like '$id'";
	mysqli_query($mlink, "$query_string") or mysqldie("Kan ikke skrive til $database.links");
//else if $action is "Edit" then
} elseif ($action=="Edit") {
	//Query the MySQL database and get everything from the "links" table where id is $id order by id ascending, die if a error occure
	$result=mysqli_query($mlink, "SELECT * FROM links WHERE id='$id' ORDER BY id ASC") or mysqldie("Kan ikke skrive til $database.links");
	//get the results
	$row = mysqli_fetch_array($result);
	//get some information and fix the output
	$id = $row["id"];
	$name = stripslashes($row["name"]);
	$ip = $row["ip"];
	$date = $row["date"];
	$time = $row["time"];
	$description = stripslashes($row["description"]);
	$link = $row["link"];
//print out the "Edit a link" box
print '<div class="flex-table">
    <div class="flex-header">
        <font size="2" face="Arial"><strong>Rediger en link</strong></font>
    </div>
    <div class="flex-content">
        <form name="Links" action="index.php?site='.$site.'&amp;action=Edited&amp;id='.$id.'" method="post">
        <strong>IP:</strong><br>
        <input type="text" name="ip" value="'.htmlspecialchars($ip, ENT_QUOTES).'" size="30"><br>
        <strong>Dato:</strong><br>
        <input type="text" name="date" value="'.htmlspecialchars($date, ENT_QUOTES).'" size="30"><br>
        <strong>Klokken:</strong><br>
        <input type="text" name="time" value="'.htmlspecialchars($time, ENT_QUOTES).'" size="30"><br>
        <strong>Navn:</strong><br>
        <input type="text" name="name" value="'.htmlspecialchars($name, ENT_QUOTES).'" size="30"><br>
        <strong>Link:</strong><br>
        <input type="text" name="link" value="'.htmlspecialchars($link, ENT_QUOTES).'" size="30"><br>
        <strong>Beskrivelse:</strong><br>
        <textarea name="description" rows="6" cols="43">'.htmlspecialchars($description, ENT_QUOTES).'</textarea><br>
        <br>
        <input type="submit" value="Rediger"> || <input type="reset" value="Nullstill">
        </form>
    </div>
</div>
<br>';
//else if $action is "Delete" then
} elseif ($action=="Delete"){
	//Delete the link from the database table "link" where id is $id limit 1
	$query_string = 'DELETE FROM `links` WHERE `id` = '."$id".' LIMIT 1';
	mysqli_query($mlink, "$query_string") or mysqldie("Kan ikke slette fra $database.links");
};
//else if $action not is "Add" then
if ($action !="Add"){
//print out the "Add a link" box
print '<div class="flex-table">
    <div class="flex-header">
        <div align="center">
            <strong><a href="?site='.$site.'&amp;action=Add">Legg til en link</a></strong>
        </div>
    </div>
</div>
<br>';
};
//Query the MySQL database and get everything from the "links" table order by id descending, die if a error occure
$result=mysqli_query($mlink, "SELECT * FROM links ORDER BY id desc") or mysqldie("Kan ikke lese fra $database.links");
//while $result not is empty then
while ($row = mysqli_fetch_array($result))
{	//get some information and fix the output
	$id = $row["id"];
	$name = stripslashes(chchar($row["name"]));
	$ip = $row["ip"];
	$date = $row["date"];
	$time = $row["time"];
	$description = stripslashes(parseurls(smilies(chchar($row["description"]))));
	$link = $row["link"];
	if (preg_match('/^\s*javascript:/i', $link)) { $link = '#'; }
//print out the links
print '<div class="flex-table">
    <div class="flex-content">
        <strong><a href="?site='.$site.'&amp;action=Edit&amp;id='.$id.'">Rediger</a> || <a href="?site='.$site.'&amp;action=Delete&amp;id='.$id.'">Slett</a></strong>
    </div>
    <div class="flex-header">
        <font size="2" face="Arial"><strong>Fra:</strong> '.$name.' <strong>IP:</strong> '.$ip.' <strong>Dato:</strong> '.$date.' <strong>Kl:</strong>'.$time.'</font>
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
