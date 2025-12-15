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
//Start a session
session_start();

// Use cryptographically secure random number generator if available
if (function_exists('random_int')) {
    $rand = random_int(1000000, 9999999);
} else {
    $rand = mt_rand(1000000, 9999999);
}

//save the number in a session and encrypt it with md5 (legacy verification compatibility)
$_SESSION['image_random_value'] = md5($rand);

//create a image
$width = 120;
$height = 40;
$image = imagecreate($width, $height);

// Define colors
$bg_color = imagecolorallocate($image, 255, 255, 255); // White background
$text_color = imagecolorallocate($image, 0, 0, 0); // Black text
$noise_color = imagecolorallocate($image, 200, 200, 200); // Light gray noise
$line_color = imagecolorallocate($image, 64, 64, 64); // Dark grey lines

// Add random dots (noise)
for ($i = 0; $i < ($width * $height) / 3; $i++) {
    imagefilledellipse($image, mt_rand(0, $width), mt_rand(0, $height), 1, 1, $noise_color);
}

// Add random lines (noise)
for ($i = 0; $i < 5; $i++) {
    imageline($image, mt_rand(0, $width), mt_rand(0, $height), mt_rand(0, $width), mt_rand(0, $height), $line_color);
}

// Draw the number text slightly offset/randomized
$x = 10;
$y = 10;
// Note: imagestring uses built-in fonts (1-5). 5 is the largest.
imagestring($image, 5, $x, $y, $rand, $text_color);

//send out some expire headers etc
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

//print out the image header (image/png)
header('Content-type: image/png');

//make the image
imagepng($image);

//destroy the image 
imagedestroy($image); 
?>
