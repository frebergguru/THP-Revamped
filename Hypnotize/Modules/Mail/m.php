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
$from = (string) ($_POST["from"] ?? ''); //get the from address
$message = (string) ($_POST["message"] ?? ''); //get the message
$subject = (string) ($_POST["subject"] ?? ''); //get the subject
//if $from and $messages and $subject not is empty then
if(empty($from) || empty($message) || empty($subject)){
//print out the "Send a mail box"
print '<div class="flex-table">
    <div class="flex-header">
        <font face="Arial" size="2">
        <strong>Mail::Admin</strong><br>
        <font size="1"><strong>Skriv meldingen du vil sende under!:)</strong></font>
        </font>
    </div>
    <div class="flex-content">
        <form action="'.rtrim($siteurl, '/').'/?site='.$site.'&amp;style='.$style.'" method="post">
        <strong>Din e-mail adresse:</strong><br>
        <input type="text" name="from" size="50"><br>
        <strong>Emne:</strong><br>
        <input type="text" name="subject" size="50"><br>
        <strong>Melding:</strong><br>
        <textarea name="message" rows="6" cols="43"></textarea><br>
        <br>
        <input type="submit" value="Send"> || <input type="reset" value="Nullstill">
        </form>
    </div>
</div>
<br>';
}else{ //else send the mail
//mail ($to, $subject, $message,"From: $from");
require_once(__DIR__ . '/../../includes/SMTPClient.php');

// Fetch SMTP configuration from database
$config_result = mysqli_query($mlink, "SELECT * FROM config LIMIT 1");
$config_row = mysqli_fetch_array($config_result);

$smtp_host = $config_row['smtp_host'] ?? '';
$smtp_port = $config_row['smtp_port'] ?? 25;
$smtp_user = $config_row['smtp_user'] ?? '';
$smtp_pass = $config_row['smtp_pass'] ?? '';
$smtp_encryption = $config_row['smtp_encryption'] ?? '';
$admin_email = $config_row['admin_email'] ?? '';

// Fallback if admin_email is not set in config
$to_address = !empty($admin_email) ? $admin_email : 'admin@localhost';

try {
    $smtp = new SMTPClient($smtp_host, $smtp_port, $smtp_user, $smtp_pass, $smtp_encryption);
    $smtp->send($to_address, $from, $subject, $message);
    $success = true;
} catch (Exception $e) {
    echo "Error sending mail: " . $e->getMessage();
    $success = false;
}

if ($success) {
//print out the "message is sendt box
print '<div class="flex-table">
    <div class="flex-header">
        <font face="Arial" size="2">
        <strong>Meldingen er n&aring; sendt!:)</strong>
        </font>
    </div>
    <div class="flex-content">
        <font face="Arial" size="1">
        <strong>Til:</strong> Admin<br>
        <strong>Din e-mail adresse:</strong> '.chchar($from).'<br>
        <strong>Emne:</strong> '.chchar($subject).'<br>
        <strong>Melding:</strong> '.chchar($message).'
        </font>
    </div>
</div>
<br>';
}
};
?>
