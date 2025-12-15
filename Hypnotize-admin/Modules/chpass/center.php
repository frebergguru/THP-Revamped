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

if (isset($_POST['submit_chpass'])) {
    $old = $_POST['old_password'];
    $new = $_POST['new_password'];
    $conf = $_POST['confirm_password'];
    $user = $_SESSION['admin_user'] ?? '';
    $user = mysqli_real_escape_string($mlink, $user);

    if ($new !== $conf) {
        error("Nytt passord og bekreftelse stemmer ikke overens.");
    } else {
        $res = mysqli_query($mlink, "SELECT * FROM users WHERE username='$user' LIMIT 1");
        if ($row = mysqli_fetch_array($res)) {
            if (password_verify($old, $row['password'])) {
                $new_hash = password_hash($new, PASSWORD_DEFAULT);
                $new_hash = mysqli_real_escape_string($mlink, $new_hash);
                mysqli_query($mlink, "UPDATE users SET password='$new_hash' WHERE username='$user'");
                info("Passordet er endret.");
            } else {
                error("Gammelt passord er feil.");
            }
        } else {
            error("Fant ikke bruker.");
        }
    }
}

print '<div class="flex-table">
    <div class="flex-header">
        <font size="2" face="Arial"><strong>Bytt Passord</strong></font>
    </div>
    <div class="flex-content">
        <form method="post" action="index.php?site=chpass">
        <strong>Gammelt passord:</strong><br>
        <input type="password" name="old_password" required><br><br>
        <strong>Nytt passord:</strong><br>
        <input type="password" name="new_password" required><br><br>
        <strong>Bekreft nytt passord:</strong><br>
        <input type="password" name="confirm_password" required><br><br>
        <input type="submit" name="submit_chpass" value="Endre passord">
        </form>
    </div>
</div>
<br>';
?>
