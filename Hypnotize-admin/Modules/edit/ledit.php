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
include_once __DIR__ . '/../../includes/move_box.php';
//get some information and fix the output
$action = isset($_GET["action"]) ? $_GET["action"] : '';
$module = isset($_GET["module"]) ? $_GET["module"] : '';
$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;
$edited = isset($_GET["edited"]) ? $_GET["edited"] : '';
$editheadline = isset($_POST["headline"]) ? mysqli_real_escape_string($mlink, $_POST["headline"]) : '';
$edituheadline = isset($_POST["uheadline"]) ? mysqli_real_escape_string($mlink, $_POST["uheadline"]) : '';
$editlink = isset($_POST["link"]) ? mysqli_real_escape_string($mlink, $_POST["link"]) : '';
$edittext = isset($_POST["text"]) ? mysqli_real_escape_string($mlink, $_POST["text"]) : '';
$editallsites = isset($_POST["allsites"]) ? 1 : 0;
//if $action is "LMoveUp" then
if ($action=="LMoveUp") {
    move_box($mlink, $id, 'up', $id2, 'l');
//else if $action is "LMoveDown" then
} elseif ($action=="LMoveDown") {
    move_box($mlink, $id, 'down', $id2, 'l');
//if $action is "LAdded" then
} elseif ($action=="LAdded") {
	//add the text to the selected page
    // Get the highest sort_id for this position and catid
    $res = mysqli_query($mlink, "SELECT MAX(sort_id) as max_sort FROM boxes WHERE catid='$id2' AND position='l'");
    $row = mysqli_fetch_array($res);
    $new_sort_id = $row['max_sort'] + 1;
	$query_string = "INSERT INTO `boxes` ( `site` , `catid` , `position` , `headline` , `uheadline` , `link` , `text`, `image`, `module`, `sort_id`, `allsites` ) VALUES ('$id2', '$id2', 'l', '$editheadline', '$edituheadline', '$editlink', '$edittext', '', '', '$new_sort_id', '$editallsites')";
	mysqli_query($mlink, "$query_string") or mysqldie("Kan ikke skrive til $database.boxes");
//else if $action is like "LAddedI" then
} elseif ($action=="LAddedI") {
	$editimage_select = isset($_POST["image_select"]) ? mysqli_real_escape_string($mlink, $_POST["image_select"]) : '';
	//if $editheadline is empty then
	if (empty($editheadline)){
		//print out a error box with the text "Du m&aring; skrive inn et navn til bilde!"
		error('Du m&aring; skrive inn et navn til bilde!');
	//else check if the image type is valid
	} elseif (!empty($editimage_select)) {
	    // Check if an existing image is selected
		$editimage = $editimage_select;
		$imagefile = $_SERVER["DOCUMENT_ROOT"].$images.'/'.$editimage;
		if (file_exists($imagefile)) {
            // Get the highest sort_id
            $res = mysqli_query($mlink, "SELECT MAX(sort_id) as max_sort FROM boxes WHERE catid='$id2' AND position='l'");
            $row = mysqli_fetch_array($res);
            $new_sort_id = $row['max_sort'] + 1;
			$query_string = "INSERT INTO `boxes` ( `site` , `catid` , `position` , `headline` , `image`, `uheadline`, `link`, `text`, `module`, `sort_id`, `allsites` ) VALUES ('$id2', '$id2', 'l', '$editheadline', '$editimage', '', '', '', '', '$new_sort_id', '$editallsites')";
			mysqli_query($mlink, "$query_string") or mysqldie("Kan ikke skrive til $database.boxes");
			info('Bilde lagt til: '.$editimage);
		} else {
			error('Valgt bilde finnes ikke.');
		}
	} elseif (($_FILES["image"]["type"] == "image/gif") or ($_FILES["image"]["type"] == "image/jpeg") or ($_FILES["image"]["type"] == "image/png"))
    {	//if a error has ocured then
        if ($_FILES["image"]["error"] > 0)
        {	//print out a error message
            error('Det skjedde en feil: '.$_FILES["image"]["error"]);
	} else { //else set $imagefile to $_SERVER["DOCUMENT_ROOT"]/$images/$_FILES["image"]["name"]
	    $imagefile = $_SERVER["DOCUMENT_ROOT"].$images.'/'.$_FILES["image"]["name"];
		//if the image do exist then
            if (file_exists($imagefile))
            {	//print out a error box with the text "... finnes allerede."
                error($_FILES["image"]["name"].' finnes allerede.');
            } else {//else move the uploaded image to the correct folder on the server
            $moveto = $_SERVER["DOCUMENT_ROOT"].$images.'/'.$_FILES["image"]["name"];
            if (!file_exists(dirname($moveto))) { mkdir(dirname($moveto), 0777, true); }
            move_uploaded_file($_FILES["image"]["tmp_name"],$moveto);
		//and print out a info box with the text "Bilde ble lagret i ...."
            info('Bilde ble lagret i: '.$images.'/'. $_FILES["image"]["name"]);
		//set $editimage to $_FILES["image"]["name"]
            $editimage = $_FILES["image"]["name"];
		//insert the path to the image to the database
            // Get the highest sort_id
            $res = mysqli_query($mlink, "SELECT MAX(sort_id) as max_sort FROM boxes WHERE catid='$id2' AND position='l'");
            $row = mysqli_fetch_array($res);
            $new_sort_id = $row['max_sort'] + 1;
            $query_string = "INSERT INTO `boxes` ( `site` , `catid` , `position` , `headline` , `image`, `uheadline`, `link`, `text`, `module`, `sort_id`, `allsites` ) VALUES ('$id2', '$id2', 'l', '$editheadline', '$editimage', '', '', '', '', '$new_sort_id', '$editallsites')";
            mysqli_query($mlink, "$query_string") or mysqldie("Kan ikke skrive til $database.boxes");
            }
        }
    } else {
        if (!empty($_FILES["image"]["name"])) {
             error('Ugyldig bilde format: '. $_FILES["image"]["type"]);
        } else {
		     error('Du m&aring; velge et bilde eller laste opp et nytt.');
        }
    }
//else if $action == "LAddI" then 
} elseif ($action=="LAddI") {
	$img_path = $_SERVER["DOCUMENT_ROOT"].$images;
	$image_options = '<option value="">-- Velg et eksisterende bilde --</option>';
	if (is_dir($img_path)) {
		$files = scandir($img_path);
		foreach ($files as $file) {
			if ($file != "." && $file != ".." && !is_dir($img_path.'/'.$file)) {
				if (preg_match('/\.(gif|jpg|jpeg|png)$/i', $file)) {
					$image_options .= '<option value="'.$file.'">'.$file.'</option>';
				}
			}
		}
	}
//print out the "Add a image" box
print '<div class="flex-table">
    <div class="flex-header">
        <font size="2" face="Arial"><strong>Legg til et bilde</strong></font>
    </div>
    <div class="flex-content">
        <form name="LBox" action="index.php?site='.$site.'&amp;id2='.$id2.'&amp;action=LAddedI" method="post" enctype="multipart/form-data">
        <strong>Navn:</strong><br>
        <input type="text" name="headline" value="" size="30"><br>
        <strong>Velg eksisterende bilde:</strong><br>
        <select name="image_select" class="width-200">
        '.$image_options.'
        </select><br><br>
        <strong>Eller last opp nytt:</strong><br>
        <input type="file" name="image"><br>
        <input type="checkbox" name="allsites" value="1"> Vis p&aring; alle sider<br>
        <br>
        <input type="Submit" value="Legg til"> || <input type="reset" value="Nullstill">
        </form>
    </div>
</div>
<br>';
//else if $action is "LAdd" then
} elseif ($action=="LAdd") {//print out the "Add a text" box
print '<div class="flex-table">
    <div class="flex-header">
        <font size="2" face="Arial"><strong>Legg til en tekst</strong></font>
    </div>
    <div class="flex-content">
        <form name="LBox" action="index.php?site='.$site.'&amp;id2='.$id2.'&amp;action=LAdded" method="post">
        <strong>Overskrift:</strong><br>
        <input type="text" name="headline" value="" size="30"><br>
        <strong>Under overskrift:</strong><br>
        <input type="text" name="uheadline" value="" size="30"><br>
        <strong>Link:</strong><br>
        <input type="text" name="link" value="" size="30"><br>
        <strong>Tekst:</strong><br>
        <textarea name="text" rows="6" cols="43"></textarea><br>
        <input type="checkbox" name="allsites" value="1"> Vis p&aring; alle sider<br>
        <br>
        <input type="Submit" value="Legg til"> || <input type="reset" value="Nullstill">
        </form>
    </div>
</div>
<br>';//else if $action is "LEditedI" then
} elseif ($action=="LEditedI") {
	//update the database with new image information
	$query_string = "UPDATE boxes SET headline='$editheadline', allsites='$editallsites' WHERE ID like '$id'";
	mysqli_query($mlink, "$query_string") or mysqldie("Kan ikke skrive til $database.boxes");
//else if $ation is "LEdited" then
} elseif ($action=="LEdited") {
	//update the database with new text information
	$query_string = "UPDATE boxes SET headline='$editheadline', uheadline='$edituheadline', link='$editlink', text='$edittext', allsites='$editallsites' WHERE ID like '$id'";
	mysqli_query($mlink, "$query_string") or mysqldie("Kan ikke skrive til $database.boxes");
//else if $action is "LEditI" then
} elseif ($action=="LEditI") {
    //Query the MySQL database and get everything from the "boxes" table where id is $id, die if a error occure
	$result=mysqli_query($mlink, "SELECT * FROM boxes WHERE id='$id'") or mysqldie("Kan ikke lese fra $database.boxes");
	$row = mysqli_fetch_array($result);
	//get some information from the table and fix the output
	$id = $row["id"];
	$headline = stripslashes($row["headline"]);
	$image = $row["image"];
    $allsites = $row["allsites"];
    $allsites_checked = ($allsites == 1) ? 'checked' : '';
//print out the "Edit a image" box
print '<div class="flex-table">
    <div class="flex-header">
        <font size="2" face="Arial"><strong>Rediger "bilde"</strong></font>
    </div>
    <div class="flex-content">
        <form name="LAdderI" action="index.php?site='.$site.'&amp;id2='.$id2.'&amp;action=LEditedI&amp;id='.$id.'" method="post">
        <strong>Navn:</strong><br>
        <input type="text" name="headline" value="'.htmlspecialchars($headline, ENT_QUOTES).'" size="30"><br>
        <br>
        <img src="./includes/thumb.php?filename='.$image.'" alt="'.$headline.'" border="0"><br>
        <input type="checkbox" name="allsites" value="1" '.$allsites_checked.'> Vis p&aring; alle sider<br>
        <br>
        <input type="submit" value="Rediger"> || <input type="reset" value="Nullstill">
        </form>
    </div>
</div>
<br>';
//else if $action is "LEdit" then
} elseif ($action=="LEdit") {
	//Query the MySQL database and get everything from the "boxes" table where id is $id, die if a error occure
	$result=mysqli_query($mlink, "SELECT * FROM boxes WHERE id='$id' ORDER BY id ASC") or mysqldie("Kan ikke lese fra $database.boxes");
	$row = mysqli_fetch_array($result);//get the result
	//get some information from the table and fix the output
	$id = $row["id"];
	$headline = stripslashes($row["headline"]);
	$uheadline = stripslashes($row["uheadline"]);
	$link = $row["link"];
	$text = stripslashes($row["text"]);
    $allsites = $row["allsites"];
    $allsites_checked = ($allsites == 1) ? 'checked' : '';
//print out the "Edit a text" box
print '<div class="flex-table">
    <div class="flex-header">
        <font size="2" face="Arial"><strong>Rediger en melding</strong></font>
    </div>
    <div class="flex-content">
        <form name="CAdder" action="index.php?site='.$site.'&amp;id2='.$id2.'&amp;action=LEdited&amp;id='.$id.'" method="post">
        <strong>Overskrift:</strong><br>
        <input type="text" name="headline" value="'.htmlspecialchars($headline, ENT_QUOTES).'" size="30"><br>
        <strong>Under overskrift:</strong><br>
        <input type="text" name="uheadline" value="'.htmlspecialchars($uheadline, ENT_QUOTES).'" size="30"><br>
        <strong>Link:</strong><br>
        <input type="text" name="link" value="'.htmlspecialchars($link, ENT_QUOTES).'" size="30"><br>
        <strong>Tekst:</strong><br>
        <textarea name="text" rows="6" cols="43">'.htmlspecialchars($text, ENT_QUOTES).'</textarea><br>
        <input type="checkbox" name="allsites" value="1" '.$allsites_checked.'> Vis p&aring; alle sider<br>
        <br>
        <input type="Submit" value="Rediger"> || <input type="reset" value="Nullstill">
        </form>
    </div>
</div>
<br>';//else if $action is "LDelete" then
} elseif ($action=="LDelete"){
	//Delete the text from the page
	$query_string = 'DELETE FROM `boxes` WHERE `id` = '."$id".' LIMIT 1';
	mysqli_query($mlink, "$query_string") or mysqldie("Kan ikke slette fra $database.boxes");
//else if $action is "LDeleteI" then
} elseif ($action=="LDeleteI"){
	//Delete the image path from the database
	$result=mysqli_query($mlink, "SELECT * FROM boxes WHERE id='$id'") or mysqldie("Kan ikke lese fra $database.boxes");
	$row = mysqli_fetch_array($result);
	$image = $row["image"];
	//set $dimage to $_SERVER["DOCUMENT_ROOT"]/$images/$image
	$dimage = $_SERVER["DOCUMENT_ROOT"].$images.'/'.$image;
	unlink($dimage);//delete the image from the server
	//delete the image from the page
	$query_string = 'DELETE FROM `boxes` WHERE `id`= '.$id.' LIMIT 1';
	mysqli_query($mlink, "$query_string") or mysqldie("Kan ikke slette fra $database.boxes");
};//else if $action not is "LAdd" or "LAddI" then
if ($action !="LAdd" && $action !="LAddI"){
//print out the "Add a text or image" box
print '<div class="flex-table">
    <div class="flex-header">
        <div align="center">
            <strong><a href="?site='.$site.'&amp;id2='.$id2.'&amp;action=LAdd">Legg til en tekst</a></strong>
        </div>
    </div>
</div>
<br>
<div class="flex-table">
    <div class="flex-header">
        <div align="center">
            <strong><a href="?site='.$site.'&amp;id2='.$id2.'&amp;action=LAddI">Legg til et bilde</a></strong>
        </div>
    </div>
</div>
<br>';
};//Query the database table boxes where catid is $id2 and position is l order by sort_id descending
$result=mysqli_query($mlink, "SELECT * FROM boxes WHERE (catid='$id2' OR allsites='1') AND position='l' ORDER BY sort_id DESC") or mysqldie("Kan ikke lese fra $database.boxes");
//while $result not is empty then
while ($row = mysqli_fetch_array($result))
{	//get some information and fix the output
	$id = $row["id"];
	$headline = stripslashes(chchar($row["headline"]));
	$uheadline = stripslashes(smilies(chchar($row["uheadline"])));
	$link = $row["link"];
	$text = parseurls(stripslashes(smilies(chchar($row["text"]))));
	$image = $row["image"];
//print out the boxes
print '<div class="flex-table">
    <div class="flex-content">
        <strong><a href="?site='.$site.'&amp;id2='.$id2.'&amp;action=LMoveUp&amp;id='.$id.'">Opp</a> || <a href="?site='.$site.'&amp;id2='.$id2.'&amp;action=LMoveDown&amp;id='.$id.'">Ned</a> || <a href="?site='.$site.'&amp;id2='.$id2.'&amp;action=';if (!empty($image)) {print 'LEditI';}else{print 'LEdit';};print '&amp;id='.$id.'">Rediger</a> || <a href="?site='.$site.'&amp;id2='.$id2.'&amp;action=';if(!empty($image)){print 'LDeleteI';} else {print 'LDelete';};print'&amp;id='.$id.'">Slett</a></strong>
    </div>
    <div class="flex-header">
        <font size="2" face="Arial">
        <strong>'.smilies($headline).'</strong><br>'.$uheadline.'</font>
    </div>
    <div class="flex-content">
        <font size="2">';
        if (!empty($image)) {print '<img src="./includes/thumb.php?filename='.$image.'" alt="'.$headline.'" border="0">';};
        if (!empty($text)) {print $text;};
        print '</font>
    </div>
    <div class="flex-content under2">
        <font size="1">
        <a href="'.$link.'" class="under2" target="_blank"><strong>'.chchar($link).'</strong></a>
        </font>
    </div>
</div>
<br>';
};
?>
