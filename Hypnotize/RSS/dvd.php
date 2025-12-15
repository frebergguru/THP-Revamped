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
include '../includes/config.php';
include '../includes/functions.php';
$link = mysqli_connect("$hostname", "$username", "$password", "$database") or mysqldie("Cant connect to $hostname");
include '../includes/getconfig.php';
header("Content-Type: application/rss+xml; charset=ISO-8859-1");
print '<?xml version="1.0" encoding="ISO-8859-1"?>
<rss version="2.0">

<channel>
<title>'.htmlspecialchars($pagename).'</title>
<link>'.htmlspecialchars($siteurl).'</link>
<description>'.htmlspecialchars($backend_description).' - DVD</description>
<language>'.htmlspecialchars($backend_language).'</language>
<pubDate>'.date("r").'</pubDate>
<generator>Hypnotize CMS</generator>';
$result=mysqli_query($link, "SELECT * FROM dvd ORDER BY ID DESC LIMIT 15") or mysqldie ("Cant read data from $database.dvd");
while ($row = mysqli_fetch_array($result))
{
$id = $row["id"];
$title = $row["title"];
$item_link = htmlspecialchars($siteurl).'/?site=DVD&amp;sub=view&amp;id='.htmlspecialchars($id);
print '
<item>
<title>Title: '.htmlspecialchars($title).'</title>
<link>'.$item_link.'</link>
<guid>'.$item_link.'</guid>
</item>';
};
mysqli_close($link);
print '</channel>
</rss>';
?>
