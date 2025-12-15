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
//query the MySQL database
$result=mysqli_query($mlink, "SELECT * FROM config LIMIT 1") or mysqldie("Kan ikke lese fra $database.config");
//get the result
$row = mysqli_fetch_array($result);
//get the page title
$title = htmlspecialchars(stripslashes($row["title"]), ENT_QUOTES, 'ISO-8859-1');
//get the page name
$pagename = htmlspecialchars(stripslashes($row["pagename"]), ENT_QUOTES, 'ISO-8859-1');
//get the maintenance status (0 or 1)
$maintenance = $row["maintenance"];
//get the maintenance ip address
$maintenanceip = $row["maintenanceip"];
//get the "Disable Guestbook" status (0 or 1)
$dguestbook = $row["dguestbook"];
//get the "Disable Links" status (0 or 1)
$dlinks = $row["dlinks"];
//get the site url
$siteurl = htmlspecialchars($row["siteurl"], ENT_QUOTES, 'ISO-8859-1');
//get the backend description
$backend_description = htmlspecialchars(stripslashes($row["backend_description"]), ENT_QUOTES, 'ISO-8859-1');
//get the backend language
$backend_language = htmlspecialchars(stripslashes($row["backend_language"]), ENT_QUOTES, 'ISO-8859-1');
//get the images path
$images = htmlspecialchars($row["images"], ENT_QUOTES, 'ISO-8859-1');
//get the style
$style = htmlspecialchars(stripslashes($row["style"]), ENT_QUOTES, 'ISO-8859-1');
?>
