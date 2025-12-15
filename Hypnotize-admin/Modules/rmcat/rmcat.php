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
$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0; //get the id (only numbers is allowed)
//if $id not is empty then
if(!empty($id)){
	//delete the page from table menu where id is $id
	$query_string = "DELETE FROM menu WHERE id = '$id';";
	mysqli_query($mlink, "$query_string") or mysqldie("Kan ikke slette fra $database.menu");
	//delete the page from table boxes where catid is $id
	$query_string = "DELETE FROM boxes WHERE catid = '$id';";
	mysqli_query($mlink, "$query_string") or mysqldie("Kan ikke slette fra $database.boxes");
	//print out a information box with the text "Siden er n&aring; fjernet!"
	info('Siden er n&aring; fjernet!');
}
//print out the "Delete a page" box
print '<div class="flex-table">
    <div class="flex-header">
        <font size="2" face="Arial"><strong>Trykk p&aring; siden du vil fjerne!</strong></font>
    </div>
    <div class="flex-content">';
    //Query the MySQL database and get everything from the "menu" table, die if a error occure
    $result=mysqli_query($mlink, "SELECT * FROM menu") or mysqldie("Kan ikke lese fra $database.menu");
    //check how many results the query did get
    $numres=mysqli_num_rows($result);
    //if $numres is empty then print out "Det finnes ingen sider!"
    if ($numres == ""){print "Det finnes ingen sider!";};
    //while $result not is empty then
    while ($row = mysqli_fetch_array($result))
    {	//get some information and fix the output
        $sitename = stripslashes(chchar($row["sitename"]));
        $id = $row["id"];
        //print out the page name
        print '<a href="?site='.$site.'&amp;id='.$id.'">'.$sitename.'</a><br><br>';
    };
    print '</div>
</div>
<br>';
?>
