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
//Get some information
$action = (string) ($_GET["action"] ?? '');
$id = (int) ($_GET["id"] ?? 0);
$editname = mysqli_real_escape_string($mlink, $_POST["name"] ?? '');
$editip = mysqli_real_escape_string($mlink, $_POST["ip"] ?? '');
$editdate = mysqli_real_escape_string($mlink, $_POST["date"] ?? '');
$edittime = mysqli_real_escape_string($mlink, $_POST["time"] ?? '');
$editdesc = mysqli_real_escape_string($mlink, $_POST["description"] ?? '');
$editmail = mysqli_real_escape_string($mlink, $_POST["mail"] ?? '');
$editmessage = mysqli_real_escape_string($mlink, $_POST["message"] ?? '');
$edithomepage = mysqli_real_escape_string($mlink, $_POST["homepage"] ?? '');
//get the users ip address
$ip = $_SERVER["REMOTE_ADDR"];
//get the date
$date=date("Y-m-d");
//get the time
$time=date("H:i:s");
//if $action is "Added" then
if ($action=="Added") {
//insert the messages to the guestbook
	$query_string = "INSERT INTO `guestbook` ( `name` , `ip` , `date` ,`time` , `mail` , `homepage` , `message` ) VALUES ('$editname', '$editip', '$editdate', '$edittime', '$editmail', '$edithomepage' , '$editmessage')";
	mysqli_query($mlink, "$query_string") or mysqldie("Kan ikke skrive til $database.guestbook");
//else if $action is "Add" then
} elseif ($action=="Add") {
//print out the Add a message to the guestbook box
print '<div class="flex-table">
    <div class="flex-header">
        <font size="2" face="Arial"><strong>Add a message</strong></font>
    </div>
    <div class="flex-content">
        <form name="Guestbook" action="index.php?site='.$site.'&amp;action=Added" method="post">
        <strong>IP:</strong><br>
        <input type="text" name="ip" value="'.htmlspecialchars($ip, ENT_QUOTES).'" size="30"><br>
        <strong>Dato:</strong><br>
        <input type="text" name="date" value="'.htmlspecialchars($date, ENT_QUOTES).'" size="30"><br>
        <strong>Klokken:</strong><br>
        <input type="text" name="time" value="'.htmlspecialchars($time, ENT_QUOTES).'" size="30"><br>
        <strong>Navn:</strong><br>
        <input type="text" name="name" value="" size="30"><br>
        <strong>Mail:</strong><br>
        <input type="text" name="mail" value="" size="30"><br>
        <strong>Hjemmeside:</strong><br>
        <input type="text" name="homepage" value="" size="30"><br>
        <strong>Melding:</strong><br>
        <textarea name="message" rows="6" cols="43"></textarea><br>
        <br>
        <input type="Submit" value="Legg til"> || <input type="reset" value="Nullstill">
        </form>
    </div>
</div>
<br>';
//else if $action is "Edited" then
} elseif ($action=="Edited") {
	//update the database with new guestbook information
	$query_string = "UPDATE guestbook SET name='$editname', ip='$editip', date='$editdate', time='$edittime', mail='$editmail', homepage='$edithomepage', message='$editmessage'  WHERE ID like '$id'";
	mysqli_query($mlink, "$query_string") or mysqldie("Kan ikke skrive til $database.guestbook");
//else if $action is "Edit" then
} elseif ($action=="Edit") {
	//Query the MySQL database and get everything from the "guestbook" table where id is $id order by id ascending, die if a error occure
	$result=mysqli_query($mlink, "SELECT * FROM guestbook WHERE id='$id' ORDER BY id ASC") or mysqldie("Kan ikke lese fra $database.guestbook");
	//get the result
	$row = mysqli_fetch_array($result);
	//get some innformation and fix the output
	$id = $row["id"];
	$name = stripslashes($row["name"]);
	$ip = $row["ip"];
	$date = $row["date"];
	$time = $row["time"];
	$mail = $row["mail"];
	$homepage = stripslashes($row["homepage"]);
	$message = stripslashes($row["message"]);
//print out the "Edit a message" box
print '<div class="flex-table">
    <div class="flex-header">
        <font size="2" face="Arial"><strong>Rediger en melding</strong></font>
    </div>
    <div class="flex-content">
        <form name="Guestbook" action="index.php?site='.$site.'&amp;action=Edited&amp;id='.$id.'" method="post">
        <strong>IP:</strong><br>
        <input type="text" name="ip" value="'.htmlspecialchars($ip, ENT_QUOTES).'" size="30"><br>
        <strong>Dato:</strong><br>
        <input type="text" name="date" value="'.htmlspecialchars($date, ENT_QUOTES).'" size="30"><br>
        <strong>Klokken:</strong><br>
        <input type="text" name="time" value="'.htmlspecialchars($time, ENT_QUOTES).'" size="30"><br>
        <strong>Navn:</strong><br>
        <input type="text" name="name" value="'.htmlspecialchars($name, ENT_QUOTES).'" size="30"><br>
        <strong>Mail:</strong><br>
        <input type="text" name="mail" value="'.htmlspecialchars($mail, ENT_QUOTES).'" size="30"><br>
        <strong>Hjemmeside:</strong><br>
        <input type="text" name="homepage" value="'.htmlspecialchars($homepage, ENT_QUOTES).'" size="30"><br>
        <strong>Melding:</strong><br>
        <textarea name="message" rows="6" cols="43">'.htmlspecialchars($message, ENT_QUOTES).'</textarea><br>
        <br>
        <input type="Submit" value="Rediger"> || <input type="reset" value="Nullstill">
        </form>
    </div>
</div>
<br>';
//else if $action is "Delete" then
} elseif ($action=="Delete"){
	//Delete the message from the guestbook table where id is $id limit 1
	$query_string = 'DELETE FROM `guestbook` WHERE `id` = '."$id".' LIMIT 1';
	mysqli_query($mlink, "$query_string") or mysqldie("Kan ikke slette fra $database.guestbook");
};
//if $action not is Add then
if ($action !="Add"){
//print out the "Add a new message" box
print '<div class="flex-table">
    <div class="flex-header">
        <div align="center">
            <strong><a href="?site='.$site.'&amp;action=Add">Legg til en melding</a></strong>
        </div>
    </div>
</div>
<br>';
};
//Query the MySQL database and get everything from the "guestbook" table order by id descending, die if a error occure
$result=mysqli_query($mlink, "SELECT * FROM guestbook ORDER BY id desc") or mysqldie("Kan ikke lese fra $database.guestbook");
//while $result not is empty then
while ($row = mysqli_fetch_array($result))
{
	//get some innformation and fix the output
	$id = $row["id"];
	$name = stripslashes(chchar($row["name"]));
	$ip = $row["ip"];
	$date = $row["date"];
	$time = $row["time"];
	$mail = $row["mail"];
	$homepage_raw = stripslashes($row["homepage"]);
	$homepage_clean = chchar($homepage_raw);

	// Validate Mail
	$mail_link = $name;
	if (!empty($mail) && filter_var($mail, FILTER_VALIDATE_EMAIL)) {
		$mail_link = '<a href="mailto:'.htmlspecialchars($mail, ENT_QUOTES).'" class="over2">'.$name.'</a>';
	}

	// Validate Homepage
	$homepage_html = '';
	if (!empty($homepage_raw) && filter_var($homepage_raw, FILTER_VALIDATE_URL) && !preg_match('/^\s*javascript:/i', $homepage_raw)) {
		$homepage_html = '<div class="flex-content under2"><font size="1"><a href="'.$homepage_clean.'" class="under2" target="_blank"><strong>Hjemmeside</strong></a></font></div>';
	}

	$message = stripslashes(parseurls(smilies(chchar($row["message"]))));
//print out the messages
print '<div class="flex-table">
    <div class="flex-content">
        <strong><a href="?site='.$site.'&amp;action=Edit&amp;id='.$id.'">Rediger</a> || <a href="?site='.$site.'&amp;action=Delete&amp;id='.$id.'">Slett</a></strong>
    </div>
    <div class="flex-header">
        <font size="2" face="Arial"><strong>Fra:</strong> '.$mail_link.' <strong>IP:</strong> '.$ip.' <strong>Dato:</strong> '.$date.' <strong>Kl:</strong> '.$time.'</font>
    </div>
    <div class="flex-content">
        <font size="2">
        '.$message.'
        </font>
    </div>
    '.$homepage_html.'
</div>
<br>';
};
?>
