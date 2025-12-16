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

//START MSG FUNCTION
function msg($headline,$text) {
print '<div class="flex-table">
    <div class="flex-header">
        <font size="2" face="Arial"><strong>'.$headline.'</strong></font>
    </div>
    <div class="flex-content">
        '.$text.'
    </div>
</div>
<br>';
};
//STOP MSG FUNCTION

//START ERROR FUNCTION
function error($msg) {
    msg("Feil", $msg);
}
//STOP ERROR FUNCTION

//START INFO FUNCTION
function info($msg) {
    msg("Informasjon", $msg);
}
//STOP INFO FUNCTION

//START MYSQLDIE FUNCTION
function mysqldie($message) {
	global $mlink;
	//Get the MySQL error message
	$mysqlerror = mysqli_error($mlink);
	//If the MySQL link is active then
	if (!empty($mlink)) {
		//close the connection
		mysqli_close($mlink);
	}
	//die with a message and the MySQL error
	die($message.' - '.$mysqlerror);
};
//STOP MYSQLDIE FUNCTION

//START CHCHAR FUNCTION
function chchar($string) {
    // Escape the string for security (XSS prevention)
    $string = htmlspecialchars($string, ENT_QUOTES, 'ISO-8859-1');
//Change some special chars with html chars from $string
	$string = str_replace("æ","&aelig;",$string);
	$string = str_replace("ø","&oslash;",$string);
	$string = str_replace("å","&aring;",$string);
	$string = str_replace("Æ","&AElig;",$string);
	$string = str_replace("Ø","&Oslash;",$string);
	$string = str_replace("Å","&Aring;",$string);
	$string = str_replace("\n","<br>",$string);
	return $string;
}
//STOP CHCHAR FUNCTION

//START SMILIES FUNCTION - adds smileys to the text
function smilies($text) {
	$imgdir = "./images/smilies/";
	//Put the smilies in a array
	$code = array(":)",":D",":O",":P",";)",":(",":|","(H)",":@");
	//if $text not is empty then
	if ($text) {
		//go trough the texts characthers one by one, if $code is like $b then
		foreach ($code as $b => $r) {
			//replace the character with a image
			$text = str_replace($r, "<img src=\"$imgdir$b.gif\" border=\"0\" alt=\"$b\">", $text);
		}
		return $text;
	}
}
//START PARSEURLS FUNCTION - A function that parse the input string (file) for urls and makes a valid html url of the url
function parseurls($string){
        $pattern_preg1 = '#(^|\s)(www|WWW)\.([^\s<>\.]+)\.([^\s\n<>]+)#sm';
        $replace_preg1 = '\\1<a href="http://\\2.\\3.\\4" target="_blank">\\2.\\3.\\4</a>';
        $pattern_preg2 = '#(^|[^\"=\]]{1})(http|HTTP|https|HTTPS|ftp)(s|S)?://([^\s<>\.]+)\.([^\s<>]+)#sm';
        $replace_preg2 = '\\1<a href="\\2\\3://\\4.\\5" target="_blank">\\2\\3://\\4.\\5</a>';
        $string = preg_replace($pattern_preg1, $replace_preg1, $string);
        $string = preg_replace($pattern_preg2, $replace_preg2, $string);
        return $string;
}
//STOP PARSEURLS FUNCTION

//START RETURN_BYTES FUNCTION
function return_bytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    $val = (int)$val;
    switch($last) {
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }
    return $val;
}
//STOP RETURN_BYTES FUNCTION

//START GET_MAX_UPLOAD_LIMIT FUNCTION
function get_max_upload_limit() {
    $max_upload = return_bytes(ini_get('upload_max_filesize'));
    $max_post = return_bytes(ini_get('post_max_size'));
    return min($max_upload, $max_post);
}
//STOP GET_MAX_UPLOAD_LIMIT FUNCTION

//START FORMAT_BYTES FUNCTION
function format_bytes($size) {
    $units = array(' B', ' KB', ' MB', ' GB', ' TB');
    for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
    return round($size, 2).$units[$i];
}
//STOP FORMAT_BYTES FUNCTION

//START CHECK_FILE_SIZE FUNCTION
function check_file_size($file, $max_size = null) {
    if ($max_size === null) {
        $max_size = get_max_upload_limit();
    }
    // Check if PHP already flagged it as too large
    if (isset($file['error']) && ($file['error'] == UPLOAD_ERR_INI_SIZE || $file['error'] == UPLOAD_ERR_FORM_SIZE)) {
        return false;
    }
    if ($file["size"] > $max_size) {
        return false;
    }
    return true;
}
//STOP CHECK_FILE_SIZE FUNCTION

//START CHECK_POST_MAX_SIZE_EXCEEDED FUNCTION
function check_post_max_size_exceeded() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST) && empty($_FILES) && isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH'] > 0) {
        $max_post = return_bytes(ini_get('post_max_size'));
        if ($_SERVER['CONTENT_LENGTH'] > $max_post) {
            error('Filen er for stor. Maksimum total opplastingsstørrelse er '.format_bytes($max_post).'.');
            return true;
        }
    }
    return false;
}
//STOP CHECK_POST_MAX_SIZE_EXCEEDED FUNCTION
?>
