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
date_default_timezone_set('Europe/Oslo');
session_start();
//START FUNCTION CHECKS
//If the function "stripslashes" not is avaiable then
if(!function_exists("stripslashes")){
//Die and write out "Kan ikke bruke stripslashes funksjonen!"
die("Kan ikke bruke stripslashes() funksjonen!");
};
//STOP FUNCTION CHECKS

//Find out what page that should be shown
$site = isset($_GET['site']) ? (string) $_GET['site'] : '';
// Sanitize $site
$site = htmlspecialchars($site, ENT_QUOTES, 'ISO-8859-1');

//Find the users IP address and save it in $origip
$origip = $_SERVER["REMOTE_ADDR"];

//Find out what page that should be edited (used by the edit module)
$id2 = isset($_GET['id2']) ? (int) $_GET['id2'] : 0;
//Get the configuration from "includes/config.php"
include 'includes/config.php';
//Launche the functions for THP from "includes/functions.php"
include 'includes/functions.php';

//Logout logic
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: index.php");
    exit();
}

//Login check
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    include 'includes/login_form.php';
    exit();
}

// Fix large sort_ids (system modules) to ensure they stay at bottom with DESC sort
mysqli_query($mlink, "UPDATE boxes SET sort_id = -1 WHERE sort_id > 2000000000");

// Auto-fix sort_id if they are all 0 (migration for existing installations)
// We check if there are any "normal" boxes (sort_id >= 0 and < 2000000000) that are all 0
$res = mysqli_query($mlink, "SELECT COUNT(*) as count FROM boxes WHERE sort_id > 0 AND sort_id < 2000000000");
$row = mysqli_fetch_array($res);
// If no normal boxes have been sorted yet (count is 0), but we have boxes with 0
$res_zeros = mysqli_query($mlink, "SELECT COUNT(*) as count FROM boxes WHERE sort_id = 0");
$row_zeros = mysqli_fetch_array($res_zeros);

if ($row['count'] == 0 && $row_zeros['count'] > 0) {
    // Initialize normal boxes to creation order (so newest will be highest)
    $result = mysqli_query($mlink, "SELECT id FROM boxes WHERE sort_id = 0 ORDER BY id ASC");
    $counter = 1;
    while ($row = mysqli_fetch_array($result)) {
        $id = $row['id'];
        mysqli_query($mlink, "UPDATE boxes SET sort_id = $counter WHERE id = $id");
        $counter++;
    }
}

//if $site is empty then set $site to "edit" and set $id2 to "0"
if (empty($site)) { $site="edit"; $id2="0";}

//Get the configuration from the MySQL database
include 'includes/getconfig.php';

if (empty($style)) { $style = "default"; }

// Sanitize $style to prevent XSS and path traversal
$style = preg_replace('/[^a-zA-Z0-9_-]/', '', $style);

//Make a string named $filename with this content: "css/$style.css" where $style is the style name
$filename = 'css/'.$style.'.css';
//if the file $filename exists then do nothing else set the style to default
if (file_exists($filename)) {} else { $style="default"; }

//print out the page
print '<!DOCTYPE html>
<html>
<head>
<title>'.($title ?? '').'</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="author" content="Hypnotize">
<meta name="copyright" content="Copyleft">
<meta name="keywords" content="LastNetwork, Hypnotize">
<meta name="description" content="The Hypnotize Project, Web Portal">
<meta name="generator" content="linux/vi">
<link rel="stylesheet" type="text/css" href="css/'.$style.'.css">
<link rel="stylesheet" type="text/css" href="css/admin-menu.css">
</head>
<body class="body">
<div class="container">
    <div class="adminmenu">
        <strong>ADMINISTRASJONS MENY</strong><br>
        <br>
        <a href="?site=Moduler" class="menu">Moduler</a> | 
        <a href="?site=addcat" class="menu">Legg til en side</a> | 
        <a href="?site=editcat" class="menu">Rediger en side</a> | 
        <a href="?site=rmcat" class="menu">Fjern en side</a> | 
        <a href="?site=setconfig" class="menu">Konfigurasjon</a> |
        <a href="?site=chpass" class="menu">Bytt Passord</a> |
        <a href="?action=logout" class="menu">Logg ut</a>
    </div>

    <div class="header">
        <a href="'.$_SERVER["PHP_SELF"].'" class="over">'.($pagename ?? '').'</a><br>
        <font face="Arial" size="1">';
        //Run the *NIX command "uptime" and print out the result 
        //echo `uptime`;
        $time = date('H:i:s');
        $uptime_str = "up ?";
        if (file_exists('/proc/uptime')) {
            $uptime_seconds = (float)file_get_contents('/proc/uptime');
            $days = floor($uptime_seconds / 86400);
            $uptime_seconds %= 86400;
            $hours = floor($uptime_seconds / 3600);
            $uptime_seconds %= 3600;
            $minutes = floor($uptime_seconds / 60);
            $uptime_str = "up ";
            if ($days > 0) {
                $uptime_str .= "$days day" . ($days > 1 ? 's' : '') . ", ";
            }
            $uptime_str .= sprintf("%d:%02d", $hours, $minutes);
        }

        $load_str = "load average: 0.00, 0.00, 0.00";
        if (function_exists('sys_getloadavg')) {
            $load = sys_getloadavg();
            $load_str = "load average: " . implode(', ', array_map(function($n) { return sprintf('%.2f', $n); }, $load));
        } elseif (file_exists('/proc/loadavg')) {
            $content = file_get_contents('/proc/loadavg');
            $parts = explode(' ', $content);
            if (count($parts) >= 3) {
                $load_str = "load average: " . $parts[0] . ", " . $parts[1] . ", " . $parts[2];
            }
        }
        print " $time $uptime_str,  $load_str";
        print '</font><br>
        <strong>[</strong> <a href="./index.php" class="menu">Hjem</a> <strong>]</strong> '; include 'includes/menu.php'; print'
    </div>

    <div class="main-content">
        <div class="left-column">';
        //include the left boxes
        include 'includes/lbox.php';
        print '</div>
        <div class="center-column">';
        //include the center boxes
        include 'includes/cbox.php';
        print '</div>
        <div class="right-column">';
        //include the right boxes
        include 'includes/rbox.php';
        print '</div>
    </div>

    <div class="footer">
        <a href="https://www.linux.org" target="_blank"><img src="./images/linux.jpg" border="0" alt="Linux"></a> <a href="https://www.php.net" target="_blank"><img src="./images/php.jpg" border="0" alt="PHP"></a> <a href="https://www.mysql.com" target="_blank"><img src="./images/mysql.jpg" border="0" alt="MySQL"></a> <a href="https://www.apache.org" target="_blank"><img src="./images/apache.jpg" border="0" alt="Apache Web Server"></a> <a href="https://github.com/frebergguru/THP-Revamped" target="_blank"><img src="./images/Hypnotize.jpg" border="0" alt="The Hypnotize Project"></a><br>
        <br>
        <strong>CopyLeft &copy; <a href="https://github.com/frebergguru/THP-Revamped" target="_blank">The Hypnotize Project</a> og Glenn Eriksen.<br>
        Lisensiert under <a href="http://www.gnu.org/" target="_blank">GNU/GPL lisensen</a>.<br>
    </div>
</div>
</body>
</html>';
//if the MySQL link is up then
if (!empty($mlink)) {
//close the connection
mysqli_close($mlink);
};
?>
