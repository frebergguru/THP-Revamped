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

if (isset($_POST['submit_login'])) {
    $u = mysqli_real_escape_string($mlink, $_POST['username']);
    $p = $_POST['password'];

    $res = mysqli_query($mlink, "SELECT * FROM users WHERE username='$u' LIMIT 1");
    if ($row = mysqli_fetch_array($res)) {
        if (password_verify($p, $row['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_user'] = $row['username'];
            header("Location: index.php");
            exit;
        } else {
            $login_error = "Feil brukernavn eller passord";
        }
    } else {
        $login_error = "Feil brukernavn eller passord";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="css/default.css">
<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
<div class="login-box">
    <h2>Hypnotize Admin Login</h2>
    <?php if(isset($login_error)) { echo '<div class="error">'.$login_error.'</div>'; } ?>
    <form method="post" action="index.php">
        <strong>Brukernavn:</strong><br>
        <input type="text" name="username" required><br><br>
        <strong>Passord:</strong><br>
        <input type="password" name="password" required><br><br>
        <input type="submit" name="submit_login" value="Logg inn">
    </form>
</div>
</body>
</html>
