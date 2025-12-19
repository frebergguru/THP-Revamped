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

$action = isset($_GET["action"]) ? $_GET["action"] : '';
$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;

// Check and fix sort_id if needed
$chk = mysqli_query($mlink, "SELECT count(*) as c FROM menu WHERE sort_id = 0");
$row = mysqli_fetch_array($chk);
if ($row['c'] > 0) {
    // Re-index
    $res = mysqli_query($mlink, "SELECT id FROM menu ORDER BY id ASC");
    $i = 1;
    while($r = mysqli_fetch_array($res)) {
        mysqli_query($mlink, "UPDATE menu SET sort_id=$i WHERE id=".$r['id']);
        $i++;
    }
}

// Handle Move
if (($action == "moveleft" || $action == "moveright") && $id > 0) {
    $res = mysqli_query($mlink, "SELECT sort_id FROM menu WHERE id='$id'");
    if ($r = mysqli_fetch_array($res)) {
        $cur_sort = $r['sort_id'];
        if ($action == "moveleft") {
            // Find one with sort_id < cur_sort, closest
            $res2 = mysqli_query($mlink, "SELECT id, sort_id FROM menu WHERE sort_id < '$cur_sort' ORDER BY sort_id DESC LIMIT 1");
        } else {
            // Find one with sort_id > cur_sort, closest
            $res2 = mysqli_query($mlink, "SELECT id, sort_id FROM menu WHERE sort_id > '$cur_sort' ORDER BY sort_id ASC LIMIT 1");
        }
        if ($r2 = mysqli_fetch_array($res2)) {
            $other_id = $r2['id'];
            $other_sort = $r2['sort_id'];
            // Swap
            mysqli_query($mlink, "UPDATE menu SET sort_id='$other_sort' WHERE id='$id'");
            mysqli_query($mlink, "UPDATE menu SET sort_id='$cur_sort' WHERE id='$other_id'");
        }
    }
}

// Handle Update
if ($action == "update" && $id > 0) {
    $cat = isset($_POST["cat"]) ? (string) mysqli_real_escape_string($mlink, $_POST["cat"]) : '';
    $url = isset($_POST["url"]) ? (string) mysqli_real_escape_string($mlink, $_POST["url"]) : '';
    $break = isset($_POST["break"]) ? 1 : 0;
    $hidden = isset($_POST["hidden"]) ? 1 : 0;
    
    if (!empty($cat)) {
        // Check for duplicate name (excluding self)
        $dup_check = mysqli_query($mlink, "SELECT id FROM menu WHERE sitename='$cat' AND id != '$id'");
        if (mysqli_num_rows($dup_check) > 0) {
             error('Det finnes allerede en side med navnet "'.chchar($cat).'"');
        } else {
             $query = "UPDATE menu SET sitename='$cat', link='$url', `break`='$break', hidden='$hidden' WHERE id='$id'";
             mysqli_query($mlink, $query) or mysqldie("Kan ikke oppdatere $database.menu");
             info('Siden "'.chchar($cat).'" er oppdatert!');
        }
    } else {
        error("Sidenavn kan ikke være tomt.");
    }
}

// Show Edit Form if ID is selected
if ($id > 0) {
    $result = mysqli_query($mlink, "SELECT * FROM menu WHERE id='$id'") or mysqldie("Kan ikke lese fra $database.menu");
    $row = mysqli_fetch_array($result);
    if ($row) {
        $sitename_esc = htmlspecialchars($row["sitename"], ENT_QUOTES, 'ISO-8859-1');
        $link_esc = htmlspecialchars($row["link"], ENT_QUOTES, 'ISO-8859-1');
        $break_checked = ($row["break"] == 1) ? 'checked' : '';
        $hidden_checked = ($row["hidden"] == 1) ? 'checked' : '';
        
        print '<div class="flex-table">
            <div class="flex-header">
                <font size="2" face="Arial"><strong>Rediger side</strong></font>
            </div>
            <div class="flex-content">
                <form name="Category" action="index.php?site='.$site.'&amp;action=update&amp;id='.$id.'" method="post">
                <strong>Side navn:</strong><br>
                <input type="text" name="cat" size="30" value="'.$sitename_esc.'"><br>
                <strong>Ekstern URL (valgfritt):</strong><br>
                <input type="text" name="url" size="30" value="'.$link_esc.'"><br>
                <strong>Ny linje etter denne?</strong>
                <input type="checkbox" name="break" value="1" '.$break_checked.'><br>
                <strong>Skjul fra meny?</strong>
                <input type="checkbox" name="hidden" value="1" '.$hidden_checked.'><br>
                <br>
                <input type="submit" value="Oppdater"> || <input type="button" value="Avbryt" onclick="window.location.href=\'index.php?site='.$site.'\'">
                </form>
            </div>
        </div>
        <br>';
    }
}

// List Pages
print '<div class="flex-table">
    <div class="flex-header">
        <font size="2" face="Arial"><strong>Velg side &aring; redigere</strong></font>
    </div>
    <div class="flex-content">';
    $result=mysqli_query($mlink, "SELECT * FROM menu ORDER BY sort_id") or mysqldie("Kan ikke lese fra $database.menu");
    $numres=mysqli_num_rows($result);
    if ($numres == 0){print "Det finnes ingen sider!";};
    while ($row = mysqli_fetch_array($result))
    {
        $sitename = stripslashes(chchar($row["sitename"]));
        $pid = $row["id"];
        // Bold the currently selected page
        if ($pid == $id) {
            print '<strong>'.$sitename.'</strong>';
        } else {
            print '<a href="?site='.$site.'&amp;id='.$pid.'">'.$sitename.'</a>';
        }
        print ' <font size="1">Flytt til: [ <strong><a href="?site='.$site.'&amp;action=moveleft&amp;id='.$pid.'">Venstre</a></strong> ] [ <strong><a href="?site='.$site.'&amp;action=moveright&amp;id='.$pid.'">H&oslash;yre</a></strong> ]</font><br><br>';
    };
    print '</div>
</div>
<br>';
?>
