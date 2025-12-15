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

//The ip adress or hostname to the mysql server
$hostname = 'localhost';

//The username that it will use when it connects to the mysql server
$username = '';

//The password that it will use when it connects to the mysql server
$password = '';

//The database The Hypnotize Project will use
$database = 'THP';

$mlink = mysqli_connect($hostname, $username, $password, $database);
if (!$mlink) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
