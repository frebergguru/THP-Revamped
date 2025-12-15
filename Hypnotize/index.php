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
//START "GENERATE TIME COUNTER"
$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
$start_time = $mtime;
//STOP "GENERATE TIME COUNTER"

//START FUNCTION CHECKS
//If the function "stripslashes" not is avaiable then
if(!function_exists("stripslashes"))
{
//Die and write out "Kan ikke bruke stripslashes funksjonen!"
die("Kan ikke bruke stripslashes() funksjonen!");
};
//STOP FUNCTION CHECKS

//Get the string $error from $_GET["error"], only numbers is allowed
$error = isset($_GET["error"]) ? (int) $_GET["error"] : 0;

//Get the configuration from "includes/config.php"
include 'includes/config.php';
//Launche the functions for THP from "includes/functions.php"
include 'includes/functions.php';

//If $error not is like 503 then
if ($error != "503") {
//Get the configuration from the MySQL database
include 'includes/getconfig.php';
};

//Find the users IP address and save it in $origip
$origip = $_SERVER["REMOTE_ADDR"];

if (empty($style)) { $style = "default"; }

// Sanitize $style to prevent XSS and path traversal
$style = preg_replace('/[^a-zA-Z0-9_-]/', '', $style);

//Find out what page that should be shown
$site = isset($_GET['site']) ? $_GET['site'] : '';
// Sanitize $site to prevent XSS
$site = htmlspecialchars($site, ENT_QUOTES, 'ISO-8859-1');

//If $site is like "Gjestebok" then start a server session
if($site=="Gjestebok"){session_start();};
//If $site is like "Linker" then start a server session
if($site=="Linker"){session_start();};

//Make a string named $filename with this content: "css/$style.css" where $style is the style name
$filename = 'css/'.$style.'.css';
//if the file $filename exists then do nothing else set the style to default
if (file_exists($filename)) {} else { $style="default"; }
//if $site is empty then set $site to 0 (Mainpage)
if (empty($site)) { $site="0"; }

print '<!DOCTYPE html>
<html>
<head>
<title>';if($error != "503"){print $title ?? '';}else{print "ERROR";}; print '</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="author" content="Hypnotize">
<meta name="copyright" content="Copyleft">
<meta name="keywords" content="LastNetwork, Hypnotize">
<meta name="description" content="The Hypnotize Project, Web Portal">
<meta name="generator" content="linux/vi">
<link rel="alternate" type="application/rss+xml" title="'.($backend_description ?? '').'" href="./RSS/backend2.php">
<link rel="alternate" type="application/rss+xml" title="'.($backend_description ?? '').' - DVD" href="./RSS/dvd2.php">
<link rel="stylesheet" type="text/css" href="css/'.$style.'.css">
</head>
<body>
<div class="container">
    <div class="header">
        <a href="'.$_SERVER["PHP_SELF"].'" class="over">';
        //if $error not is like "503 then print out the pagename else print out "ERROR"
        if($error != "503"){print $pagename ?? '';}else{print "ERROR";};print'</a><br>
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
        <strong>[</strong> <a href="'.$_SERVER["PHP_SELF"].'" class="menu">Hjem</a> <strong>]</strong> ';if($error != "503"){ if (($maintenance ?? '0')=="1" && $origip == ($maintenanceip ?? '')) { include 'includes/menu.php';}elseif(($maintenance ?? '0')=="0") { include 'includes/menu.php';};}; print'
    </div>

    <div class="main-content">
        <div class="left-column">
        ';if($error != "503") {
        if (($maintenance ?? '0')=="1" && $origip == ($maintenanceip ?? '')) { include 'includes/lbox.php';}elseif(($maintenance ?? '0')=="0") { include 'includes/lbox.php';};
        };
        print '
        </div>
        <div class="center-column">';
        //if $error is like 404 then
        if ($error == "404") {
        //print out a error message
        srverror("404", "Filen eller dokumentet <strong>".htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES, 'ISO-8859-1')."</strong><br>finnes ikke, vennligst pr&oslash;v et annet sted");
        //if $error is like 401 then
        }elseif($error == "401") {
        //print out a error message
        srverror("401", "Du har ikke tilgang til denne siden!");
        //if $error is like 500 then
        }elseif($error == "500") {
        //print out a error message
        srverror("500", "Det har skjedd en intern server feil, vennligst pr&oslash;v igjen senere!");
        //if $error is like 503 then
        }elseif($error == "503"){
        //print out a error message
        srverror("503", "Serveren er fortiden overbelastet, vennligst pr&oslash;v igjen senere!");
        }else{ //else check if the page is under maintenance and print out the maintenance message if it is else print out the center boxes
        if (($maintenance ?? '0')=="1" && $origip == ($maintenanceip ?? '')) { include 'includes/cbox.php';}elseif(($maintenance ?? '0')=="0") { include 'includes/cbox.php';}elseif(($maintenance ?? '0')=="1" && $origip != ($maintenanceip ?? '')) {msg("Vedlikehold","Siden er fortiden under vedlikehold, vennligst pr&oslash;v igjen senere!");};
        };
        print '</div>
        <div class="right-column">';if($error != "503") { //if $error not is like 503 then
        if (($maintenance ?? '0')=="1" && $origip == ($maintenanceip ?? '')) { // if the page is under maintenance and $origip is like $maintenanceip then
        //if $site not is like "DVD" then
        if ($site != "DVD") {
            include "includes/RSS.php"; //include "inclues/RSS.php"
        };
        include "includes/rbox.php"; //include "includes/rbox.php"
        } elseif(($maintenance ?? '0')=="0") { //else if the page not is under maintenance then
        if ($site != "DVD") { //if $site not is like "DVD" then
                include "includes/RSS.php"; //include "includes/RSS.php"
        };
        include "includes/rbox.php"; //include "includes/rbox.php"
        };
        };
        print '</div>
    </div>

    <div class="footer">
        <a href="https://www.linux.org" target="_blank"><img src="./images/linux.jpg" border="0" alt="Linux"></a> <a href="https://www.php.net" target="_blank"><img src="./images/php.jpg" border="0" alt="PHP"></a> <a href="https://www.mysql.com" target="_blank"><img src="./images/mysql.jpg" border="0" alt="MySQL"></a> <a href="https://www.apache.org" target="_blank"><img src="./images/apache.jpg" border="0" alt="Apache Web Server"></a> <a href="https://github.com/frebergguru/THP-Revamped" target="_blank"><img src="./images/Hypnotize.jpg" border="0" alt="The Hypnotize Project"></a><br>
        <br>
        <strong>CopyLeft &copy; <a href="https://github.com/frebergguru/THP-Revamped" target="_blank">The Hypnotize Project</a> og Glenn Eriksen.<br>
        Lisensiert under <a href="http://www.gnu.org/" class="gpl" target="_blank">GNU/GPL lisensen</a>.<br>';
        //START "STOP TIME GENERATOR"
        $mtime = microtime();
        $mtime = explode(" ",$mtime);
        $mtime = $mtime[1] + $mtime[0];
        $end_time = $mtime;
        $total_time = ($end_time - $start_time);
        $total_time = round($total_time, 2);
        //STOP "STOP TIME GENERATOR"
        print 'Sidegenerering: '.$total_time.' sekunder!</strong>
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
