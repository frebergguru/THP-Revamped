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
//get the configuration
include 'config.php';
//get the functions
include 'functions.php';

// $mlink is created in config.php now

//get the page configuration
include 'getconfig.php';
//set $bilde_fil to ?filename
$bilde_fil = (string) ($_GET['filename'] ?? '');
// Sanitize filename to prevent path traversal
$bilde_fil = basename($bilde_fil);
//set $bilde_fil to "server document root"/$images/$bilde_fil
$bilde_fil = $_SERVER["DOCUMENT_ROOT"].$images.'/'.$bilde_fil;
//font to use
$skrift = '../fonts/manuscript.ttf';
//get the mime type of the image
$mtype = mime_content_type($bilde_fil);

//if $mtype is like "image/jpeg" then create a jpeg picture from a file
if($mtype=="image/jpeg") { $bilde=@imagecreatefromjpeg("$bilde_fil");
//else if $mtype is like "image/gif" then create a gif picture from a file
} elseif ($mtype=="image/gif") { $bilde=@imagecreatefromgif("$bilde_fil");
//else if $mtype is like "image/png" then create a png picture from a file 
} elseif ($mtype=="image/png") {$bilde=@imagecreatefrompng("$bilde_fil");
//else
} else {
	//print out "Ukjent bilde format and exit
	print "Ukjent bilde format!";
	return 0;
}
//define the thumbnail width
define('thumbnailWidth', "250");
$thumbX = thumbnailWidth;    
$imageX = imagesx($bilde);
$imageY = imagesy($bilde);    
$thumbY = (int)(($thumbX*$imageY) / $imageX );
$dest  = imagecreatetruecolor($thumbX, $thumbY);
imagecopyresampled ($dest, $bilde, 0, 0, 0, 0, $thumbX, $thumbY, $imageX, $imageY);

$x=imagesx($dest);
$y=imagesy($dest);
$storrelse=$x/20;
$storrelse=floor($storrelse);
if($storrelse<10) $storrelse=10;

$svart = imagecolorallocate($dest, 0, 0, 0);
$graa = imagecolorallocate($dest, 128, 128, 128);
$roed = imagecolorallocate($dest, 255, 0, 0);
$gul = imagecolorallocate($dest, 255, 255, 0);

imagettftext($dest, 12, 0, 12, $y-7, $svart, $skrift, $pagename);
imagettftext($dest, 12, 0, 10, $y-8, $roed, $skrift, $pagename);

if($mtype=="image/gif") 
{
header("Content-type: image/gif");
imagegif($dest);
}
elseif($mtype=="image/png")
{
header("Content-type: image/png");
imagepng($dest);
}
else
{
header("Content-type: image/jpeg");
imagejpeg($dest);
}
imagedestroy($dest);
imagedestroy($bilde);
?>
