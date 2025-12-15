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
//get some information from the table and fix the output
$action = (string) ($_GET["action"] ?? '');
$id = (int) ($_GET["id"] ?? 0);
$editproducers = mysqli_real_escape_string($mlink, $_POST["producers"] ?? '');
$editdirectors = mysqli_real_escape_string($mlink, $_POST["directors"] ?? '');
$editmanufacturer = mysqli_real_escape_string($mlink, $_POST["manufacturer"] ?? '');
$editrating = mysqli_real_escape_string($mlink, $_POST["rating"] ?? '');
$editdice = mysqli_real_escape_string($mlink, $_POST["dice"] ?? '');
$editregion = mysqli_real_escape_string($mlink, $_POST["region"] ?? '');
$editformat = mysqli_real_escape_string($mlink, $_POST["format"] ?? '');
$editgenre = mysqli_real_escape_string($mlink, $_POST["genre"] ?? '');
$edittitle = mysqli_real_escape_string($mlink, $_POST["title"] ?? '');
$editactors = mysqli_real_escape_string($mlink, $_POST["actors"] ?? '');
$edityear = mysqli_real_escape_string($mlink, $_POST["year"] ?? '');
$editsubtitles = mysqli_real_escape_string($mlink, $_POST["subtitles"] ?? '');
$editscreen = mysqli_real_escape_string($mlink, $_POST["screen"] ?? '');
$editlanguages = mysqli_real_escape_string($mlink, $_POST["languages"] ?? '');
$editlength = mysqli_real_escape_string($mlink, $_POST["length"] ?? '');
$editcomment = mysqli_real_escape_string($mlink, $_POST["comment"] ?? '');

//if $action is "Added" then
if ($action=="Added") {
//Insert the "dvd" to the database table dvd
mysqli_query($mlink, "INSERT INTO `dvd` ( `producers` , `directors` , `manufacturer` , `rating` , `dice` , `region` , `format` , `genre` , `title` , `actors` , `year` , `subtitles` , `screen` , `languages` , `length` , `comment` ) VALUES ('$editproducers', '$editdirectors', '$editmanufacturer', '$editrating', '$editdice', '$editregion', '$editformat', '$editgenre', '$edittitle', '$editactors', '$edityear', '$editsubtitles', '$editscreen', '$editlanguages', '$editlength', '$editcomment')") or mysqldie("Kan ikke skrive til $database.dvd");
//else if $action is "Add" then
} elseif ($action=="Add" || $action=="FetchIMDb") {

    $title_val = "";
    $producers_val = "";
    $directors_val = "";
    $manufacturer_val = "";
    $rating_val = "";
    $genre_val = "";
    $length_val = "";
    $actors_val = "";
    $year_val = "";
    $subtitles_val = "";
    $screen_val = "";
    $languages_val = "";
    $comment_val = "";

    if ($action == "FetchIMDb") {
        $imdb_id = $_POST['imdb_id'] ?? '';
        $imdb_data = fetch_imdb_info($imdb_id);
        if ($imdb_data) {
             $title_val = $imdb_data['title'] ?? "";
             $directors_val = $imdb_data['directors'] ?? "";
             $rating_val = $imdb_data['rating'] ?? "";
             $genre_val = $imdb_data['genre'] ?? "";
             $length_val = $imdb_data['length'] ?? "";
             $actors_val = $imdb_data['actors'] ?? "";
             $year_val = $imdb_data['year'] ?? "";
             $comment_val = $imdb_data['comment'] ?? "";
        }
    }

//print out the "Add a DVD form"
print '<div class="flex-table">
    <div class="flex-header">
        <font size="2" face="Arial"><strong>Add a dvd</strong></font>
    </div>
    <div class="flex-content">
        <form method="post" action="index.php?site='.$site.'&amp;action=FetchIMDb">
            <strong>IMDb ID:</strong> <input type="text" name="imdb_id" size="15" placeholder="e.g. tt14364480">
            <input type="submit" value="Hent info">
        </form>
        <hr>
        <form name="DVD" action="index.php?site='.$site.'&amp;action=Added" method="post">
        <strong>Tittel:</strong><br>
        <input type="text" name="title" value="'.htmlspecialchars($title_val, ENT_QUOTES).'" size="30"><br>
        <strong>Produsent:</strong><br>
        <input type="text" name="producers" value="'.htmlspecialchars($producers_val, ENT_QUOTES).'" size="30"><br>
        <strong>Regis&oslash;rer:</strong><br>
        <input type="text" name="directors" value="'.htmlspecialchars($directors_val, ENT_QUOTES).'" size="30"><br>
        <strong>Utgiver:</strong><br>
        <input type="text" name="manufacturer" value="'.htmlspecialchars($manufacturer_val, ENT_QUOTES).'" size="30"><br>
        <strong>Aldersgrense / Kode:</strong><br>
        <input type="text" name="rating" value="'.htmlspecialchars($rating_val, ENT_QUOTES).'" size="30"><br>
        <strong>Ditt terningkast:</strong><br>
        <select name="dice">';
        //set $dice to 0
        $dice = 0;
        //while $dice not is 7 then
        while ($dice < 7) {
            //print out <option calue="$dice">$dice
            print '<option value="'.$dice.'">'.$dice;
            //make a counter ($dice is $dice + 1)
            $dice=$dice+1;
        };
        print '</select><br>
        <strong>Region:</strong><br>
        <select name="region">';
        //set $region to 1
        $region = 1;
        //while $region not is 10 then
        while ($region < 10) {
            //print out <option value="$region">$region
            print '<option value="'.$region.'">'.$region;
            //make a counter ($region is $region + 1)
            $region=$region+1;
        };
        print '</select><br>
        <strong>Format:</strong><br>
        <select name="format">
        <option value="NTSC">NTSC
        <option value="PAL">PAL
        <option value="SECAM">SECAM
        <option value="">N/A
        </select><br>
        <strong>Sjanger:</strong><br>
        <input type="text" name="genre" value="'.htmlspecialchars($genre_val, ENT_QUOTES).'" size="30"><br>
        <strong>Lengde:</strong><br>
        <input type="text" name="length" value="'.htmlspecialchars($length_val, ENT_QUOTES).'" size="30"><br>
        <strong>Skuespillere:</strong><br>
        <input type="text" name="actors" value="'.htmlspecialchars($actors_val, ENT_QUOTES).'" size="30"><br>
        <strong>&Aring;r:</strong><br>
        <input type="text" name="year" value="'.htmlspecialchars($year_val, ENT_QUOTES).'" size="30"><br>
        <strong>Undertekster:</strong><br>
        <input type="text" name="subtitles" value="'.htmlspecialchars($subtitles_val, ENT_QUOTES).'" size="30"><br>
        <strong>Skjerm:</strong><br>
        <input type="text" name="screen" value="'.htmlspecialchars($screen_val, ENT_QUOTES).'" size="30"><br>
        <strong>Spr&aring;k:</strong><br>
        <input type="text" name="languages" value="'.htmlspecialchars($languages_val, ENT_QUOTES).'" size="30"><br>
        <strong>Kommentar:</strong><br>
        <textarea name="comment" rows="6" cols="43">'.htmlspecialchars($comment_val, ENT_QUOTES).'</textarea><br>
        <br>
        <input type="submit" value="Legg til"> || <input type="reset" value="Nullstill">
        </form>
    </div>
</div>
<br>';
//else if $action is "Edited" then
} elseif ($action=="Edited") {
//update the table dvd with new information
mysqli_query($mlink, "UPDATE dvd SET producers='$editproducers', directors='$editdirectors', manufacturer='$editmanufacturer', rating='$editrating', dice='$editdice', region='$editregion', format='$editformat', genre='$editgenre', length='$editlength', title='$edittitle', actors='$editactors', year='$edityear', subtitles='$editsubtitles', screen='$editscreen', languages='$editlanguages', comment='$editcomment' WHERE ID like '$id'") or mysqldie("Kan ikke skrive til $database.dvd");
//else if $action is "Edit" then
} elseif ($action=="Edit") {
//Query the MySQL database and get everything from the "Admin" table where id is $id order by title, die if a error occure
$result=mysqli_query($mlink, "SELECT * FROM dvd WHERE id='$id' ORDER BY title") or mysqldie("Kan ikke lese fra $database.dvd");
//get the results
$row = mysqli_fetch_array($result);
//get some information from the table and fix the output
$producers = stripslashes($row["producers"]);
$directors = stripslashes($row["directors"]);
$manufacturer = stripslashes($row["manufacturer"]);
$rating = stripslashes($row["rating"]);
$dice = $row["dice"];
$region = $row["region"];
$format = stripslashes($row["format"]);
$genre = $row["genre"];
$length = stripslashes($row["length"]);
$title = stripslashes($row["title"]);
$actors = stripslashes($row["actors"]);
$year = $row["year"];
$subtitles = stripslashes($row["subtitles"]);
$screen = stripslashes($row["screen"]);
$languages = stripslashes($row["languages"]);
$comment = stripslashes(parseurls(smilies($row["comment"])));

//check if some of the strings is empty and change the output of the string to N/A if it is empty
if (empty($producers)){$producers="N/A";};
if (empty($directors)){$directors="N/A";};
if (empty($manufacturer)){$manufacturer="N/A";};
if (empty($region)){$region="N/A";};
if (empty($format)){$format="N/A";};
if (empty($genre)){$genre="N/A";};
if (empty($length)){$length="N/A";};
if (empty($title)){$title="N/A";};
if (empty($actors)){$actors="N/A";};
if (empty($year)){$year="N/A";};
if (empty($subtitles)){$subtitles="N/A";};
if (empty($screen)){$screen="N/A";};
if (empty($languages)){$languages="N/A";};
if (empty($comment)){$comment="N/A";};
//print out the edit box
print '<div class="flex-table">
    <div class="flex-header">
        <font size="2" face="Arial"><strong>'.$title.'</strong></font>
    </div>
    <div class="flex-content">
        <form name="DVD" action="index.php?site='.$site.'&amp;action=Edited&amp;id='.$id.'" method="post">
        <strong>Tittel:</strong><br>
        <input type="text" name="title" value="'.htmlspecialchars($title, ENT_QUOTES).'" size="30"><br>
        <strong>Produsent(er):</strong><br>
        <input type="text" name="producers" value="'.htmlspecialchars($producers, ENT_QUOTES).'" size="30"><br>
        <strong>Regis&oslash;r(er):</strong><br>
        <input type="text" name="directors" value="'.htmlspecialchars($directors, ENT_QUOTES).'" size="30"><br>
        <strong>Utgiver:</strong><br>
        <input type="text" name="manufacturer" value="'.htmlspecialchars($manufacturer, ENT_QUOTES).'" size="30"><br>
        <strong>Aldersgrense / Kode:</strong><br>
        <input type="text" name="rating" value="'.htmlspecialchars($rating, ENT_QUOTES).'" size="30"><br>
        <strong>Ditt terningkast:</strong><br>
        <select name="dice">';
        //set $dice2 to 0
        $dice2 = 0;
        //while $dice2 not is 7 then
        while ($dice2 < 7) {
            //print out "<option value="$dice2">$dice2" but if $dice is like $dice2 then print out "<option value="$dice2" selected>$dice2
            print '<option value="'.$dice2.'"';if($dice == $dice2) {print 'selected';}; print '>'.$dice2;
            //make a counter ($dice2 = $dice2 + 1)
            $dice2=$dice2+1;
        };
        print '</select><br>
        <strong>Region:</strong><br>
        <select name="region">';
        //set $region2 to 1
        $region2 = 1;
        //whil $region2 not is 10 then
        while ($region2 < 10) {
            //print out "<option value="$region2">$region2" but if $region is like $region2 then print out "<option value="$region2" selected>$region2
            print '<option value="'.$region2.'"';if($region == $region2) {print 'selected';}; print'>'.$region2;
            //make a counter ($region2 = $region2 + 1)
            $region2=$region2+1;
        };
        print '</select><br>
        <strong>Format:</strong><br>
        <select name="format">
        <option value="NTSC"'; if($format == "NTSC"){print 'selected';};print'>NTSC
        <option value="PAL"'; if($format == "PAL"){print 'selected';};print'>PAL
        <option value="SECAM"'; if($format == "SECAM"){print 'selected';};print'>SECAM
        <option value=""'; if($format == "N/A"){print 'selected';};print'>N/A
        </select><br>
        <strong>Sjanger:</strong><br>
        <input type="text" name="genre" value="'.htmlspecialchars($genre, ENT_QUOTES).'" size="30"><br>
        <strong>Lengde:</strong><br>
        <input type="text" name="length" value="'.htmlspecialchars($length, ENT_QUOTES).'" size="30"><br>
        <strong>Skuespillere:</strong><br>
        <input type="text" name="actors" value="'.htmlspecialchars($actors, ENT_QUOTES).'" size="30"><br>
        <strong>&Aring;r:</strong><br>
        <input type="text" name="year" value="'.htmlspecialchars($year, ENT_QUOTES).'" size="30"><br>
        <strong>Undertekster:</strong><br>
        <input type="text" name="subtitles" value="'.htmlspecialchars($subtitles, ENT_QUOTES).'" size="30"><br>
        <strong>Skjerm:</strong><br>
        <input type="text" name="screen" value="'.htmlspecialchars($screen, ENT_QUOTES).'" size="30"><br>
        <strong>Spr&aring;k:</strong><br>
        <input type="text" name="languages" value="'.htmlspecialchars($languages, ENT_QUOTES).'" size="30"><br>
        <strong>Kommentar:</strong><br>
        <textarea name="comment" rows="6" cols="43">'.htmlspecialchars($comment, ENT_QUOTES).'</textarea><br>
        <br>
        <input type="submit" value="Rediger"> || <input type="reset" value="Nullstill">
        </form>
    </div>
</div>
<br>';
//else if $action is "Delete" then
} elseif ($action=="Delete"){
	//delete the "dvd" from the database table dvd whte id is $id limit 1
	mysqli_query($mlink, "DELETE FROM `dvd` WHERE `id` = ".$id." LIMIT 1") or mysqldie("Kan ikke slette fra $database.dvd");
};
//if $action not is "Add" then
if ($action !="Add"){
//print out the "Add a dvd box"
print '<div class="flex-table">
    <div class="flex-header">
        <div align="center">
            <strong><a href="?site='.$site.'&amp;action=Add">Legg til en DVD</a></strong>
        </div>
    </div>
</div>
<br>';
};
////Query the MySQL database and get everything from the "dvd" table order by id desc, die if a error occure
$result=mysqli_query($mlink, "SELECT * FROM dvd ORDER BY id desc") or mysqldie("Kan ikke lese fra $database.dvd");
//while $row not is empty then
while ($row = mysqli_fetch_array($result))
{
//get some information from the table and fix the output
$id = $row["id"];
$producers = stripslashes(chchar($row["producers"]));
$directors = stripslashes(chchar($row["directors"]));
$manufacturer = stripslashes(chchar($row["manufacturer"]));
$rating = $row["rating"];
$dice = $row["dice"];
$region = stripslashes($row["region"]);
$format = stripslashes($row["format"]);
$genre = stripslashes(chchar($row["genre"]));
$length = $row["length"];
$title = stripslashes(chchar($row["title"]));
$actors = stripslashes(chchar($row["actors"]));
$year = $row["year"];
$subtitles = stripslashes(chchar($row["subtitles"]));
$screen = stripslashes(chchar($row["screen"]));
$languages = stripslashes(chchar($row["languages"]));
$comment = stripslashes(parseurls(smilies(chchar($row["comment"]))));
//check if some of the strings is empty and change the output of the string to N/A if it is empty
if (empty($producers)){$producers="N/A";};
if (empty($directors)){$directors="N/A";};
if (empty($manufacturer)){$manufacturer="N/A";};
if (empty($rating)){$rating="N/A";};
if (empty($dice)){$dice="N/A";};
if (empty($region)){$region="N/A";}elseif($region=="0"){$region="0 - No Region";}elseif($region=="1"){$region="1 - US, US territories and Canada";}elseif($region=="2"){$region="2 - UK, Europe, Japan, South Africa and Middle East";}elseif($region=="3"){$region="3 - Southeast and East Asia";}elseif($region=="4"){$region="4 - Australia, New Zealand, Central and South America";}elseif($region=="5"){$region="5 - Former Soviet Union, Indian sub-continent, Africa, North Korea and Mongolia";}elseif($region=="6"){$region="6 - China";}elseif($region=="7"){$region="7 - Reserved for future use";}elseif($region=="8"){$region="8 - International Territories (ships, planes etc)";}elseif($region=="9"){$region="9 - Expansion (often used as region free)";};
if (empty($format)){$format="N/A";};
if (empty($genre)){$genre="N/A";};
if (empty($length)){$length="N/A";};
if (empty($title)){$title="N/A";};
if (empty($actors)){$actors="N/A";};
if (empty($year)){$year="N/A";};
if (empty($subtitles)){$subtitles="N/A";};
if (empty($screen)){$screen="N/A";};
if (empty($languages)){$languages="N/A";};
if (empty($comment)){$comment="N/A";};
//print out the DVD's
print '<div class="flex-table">
    <div class="flex-content">
        <strong><a href="?site='.$site.'&amp;action=Edit&amp;id='.$id.'">Rediger</a> || <a href="?site='.$site.'&amp;action=Delete&amp;id='.$id.'">Slett</a></strong>
    </div>
    <div class="flex-header">
        <font size="2" face="Arial"><strong>'.$title.'</strong></font>
    </div>
    <div class="flex-content">
        <font size="2">
        <strong>Produsent(er):</strong> '.$producers.'<br>
        <br>
        <strong>Regis&oslash;r(er):</strong> '.$directors.'<br>
        <br>
        <strong>Utgiver:</strong> '.$manufacturer.'<br>
        <br>
        <strong>Aldersgrense / Kode:</strong> '.$rating.'<br>
        <br>
        <strong>Ditt terningkast:</strong> '.$dice.'<br>
        <br>
        <strong>Region:</strong> '.$region.'<br>
        <br>
        <strong>Format:</strong> '.$format.'<br>
        <br>
        <strong>Sjanger:</strong> '.$genre.'<br>
        <br>
        <strong>Lengde:</strong> '.$length.'<br>
        <br>
        <strong>Skuespillere:</strong> '.$actors.'<br>
        <br>
        <strong>&Aring;r:</strong> '.$year.'<br>
        <br>
        <strong>Undertekster:</strong> '.$subtitles.'<br>
        <br>
        <strong>Skjerm:</strong> '.$screen.'<br>
        <br>
        <strong>Spr&aring;k:</strong> '.$languages.'<br>
        <br>
        <strong>Kommentar:</strong> '.$comment.'
        </font>
    </div>
</div>
<br>';
};

function fetch_imdb_info($id) {
    if (empty($id)) return [];

    $url = "https://www.imdb.com/title/" . $id . "/";
    $html = "";

    if (function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $html = curl_exec($ch);
        curl_close($ch);
    } elseif (ini_get('allow_url_fopen')) {
        $options = [
            "http" => [
                "method" => "GET",
                "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36\r\n"
            ]
        ];
        $context = stream_context_create($options);
        $html = @file_get_contents($url, false, $context);
    }

    if (empty($html)) {
        return [];
    }

    if (preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/s', $html, $matches)) {
        foreach ($matches[1] as $match) {
            $json = json_decode($match, true);
            if ($json && (
                   (isset($json['@type']) && $json['@type'] == 'Movie') ||
                   (isset($json['@type']) && $json['@type'] == 'TVSeries')
               )) {
                 if (isset($json['url']) && strpos($json['url'], $id) !== false) {
                     $data = [];
                     $data['title'] = $json['name'] ?? '';
                     $data['year'] = isset($json['datePublished']) ? substr($json['datePublished'], 0, 4) : '';

                     if (isset($json['genre'])) {
                         $data['genre'] = is_array($json['genre']) ? implode(', ', $json['genre']) : $json['genre'];
                     }

                     $data['rating'] = $json['contentRating'] ?? '';

                     if (isset($json['director'])) {
                         $directors = [];
                         $d_list = isset($json['director']['name']) ? [$json['director']] : $json['director'];

                         if (is_array($d_list)) {
                             foreach ($d_list as $d) {
                                 if (isset($d['name'])) $directors[] = $d['name'];
                             }
                         }
                         $data['directors'] = implode(', ', $directors);
                     }

                     if (isset($json['actor'])) {
                         $actors = [];
                         $a_list = isset($json['actor']['name']) ? [$json['actor']] : $json['actor'];
                          if (is_array($a_list)) {
                             foreach ($a_list as $a) {
                                 if (isset($a['name'])) $actors[] = $a['name'];
                             }
                          }
                         $data['actors'] = implode(', ', $actors);
                     }

                     $data['comment'] = $json['description'] ?? '';

                     if (isset($json['duration'])) {
                         try {
                             $interval = new DateInterval($json['duration']);
                             $minutes = ($interval->h * 60) + $interval->i;
                             $data['length'] = $minutes;
                         } catch (Exception $e) {
                             $data['length'] = '';
                         }
                     }

                     return $data;
                 }
            }
        }
    }
    return [];
}
?>
