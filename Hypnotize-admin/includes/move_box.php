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

function move_box($mlink, $id, $direction, $catid, $position) {
    // Get the current box's sort_id
    $result = mysqli_query($mlink, "SELECT sort_id FROM boxes WHERE id='$id'");
    if (!$result || mysqli_num_rows($result) == 0) {
        return;
    }
    $row = mysqli_fetch_array($result);
    $current_sort_id = $row['sort_id'];

    if ($direction == 'up') {
        // Move up means swapping with the one having the next higher sort_id (since we display DESC)
        // Find the box with the smallest sort_id that is greater than current_sort_id
        $query = "SELECT id, sort_id FROM boxes WHERE catid='$catid' AND position='$position' AND sort_id > '$current_sort_id' ORDER BY sort_id ASC LIMIT 1";
    } elseif ($direction == 'down') {
        // Move down means swapping with the one having the next lower sort_id
        // Find the box with the largest sort_id that is less than current_sort_id
        $query = "SELECT id, sort_id FROM boxes WHERE catid='$catid' AND position='$position' AND sort_id < '$current_sort_id' ORDER BY sort_id DESC LIMIT 1";
    } else {
        return;
    }

    $result = mysqli_query($mlink, $query);
    if ($other_row = mysqli_fetch_array($result)) {
        $other_id = $other_row['id'];
        $other_sort_id = $other_row['sort_id'];

        // Swap sort_ids
        mysqli_query($mlink, "UPDATE boxes SET sort_id='$other_sort_id' WHERE id='$id'");
        mysqli_query($mlink, "UPDATE boxes SET sort_id='$current_sort_id' WHERE id='$other_id'");
    }
}
?>
