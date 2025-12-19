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

ini_set('display_errors', 1);

// Step 1: Check if already installed via config file existence (User must copy to this file to complete the install)
if (file_exists('Hypnotize/includes/config.php')) {
    include 'Hypnotize/includes/config.php';
    if (!empty($mlink) && mysqli_ping($mlink)) {
        // Try to check if tables exist
        $res = mysqli_query($mlink, "SHOW TABLES LIKE 'config'");
        if (mysqli_num_rows($res) > 0) {
             die("Installasjonen ser ut til å være fullført (config.php eksisterer og DB er tilgjengelig). Vennligst slett 'config.php', eller tøm databasen for å installere på nytt.");
        }
    }
}

$message = "";
$success = false;
$show_config_code = false;
$config_code_user = "";
$config_code_admin = "";

// Default values
$db_host = $_POST['db_host'] ?? 'localhost';
$db_user = $_POST['db_user'] ?? 'root';
$db_pass = $_POST['db_pass'] ?? '';
$db_name = $_POST['db_name'] ?? 'THP';
$admin_user = $_POST['admin_user'] ?? 'admin';
$admin_pass = $_POST['admin_pass'] ?? '';

// Site Configs
$site_title = $_POST['site_title'] ?? 'The Hypnotize Project';
$page_name  = $_POST['page_name'] ?? 'The Hypnotize Project';
$site_url   = $_POST['site_url'] ?? 'https://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . '/';
$image_path = $_POST['image_path'] ?? '/images';
$backend_lang = $_POST['backend_lang'] ?? 'no-bokmaal';
$backend_desc = $_POST['backend_desc'] ?? 'The Hypnotize Project - RSS';

// Toggles
$dguestbook = isset($_POST['dguestbook']) ? 1 : 0;
$dlinks     = isset($_POST['dlinks']) ? 1 : 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $watermark = isset($_POST['watermark']) ? 1 : 0;
} else {
    $watermark = 1;
}

// SMTP Configs
$smtp_host = $_POST['smtp_host'] ?? '';
$smtp_port = $_POST['smtp_port'] ?? 25;
$smtp_user = $_POST['smtp_user'] ?? '';
$smtp_pass = $_POST['smtp_pass'] ?? '';
$smtp_encryption = $_POST['smtp_encryption'] ?? '';
$admin_email = $_POST['admin_email'] ?? '';


// Try to auto-detect image path if not posted
if (!isset($_POST['image_path'])) {
    if (file_exists(__DIR__ . '/Hypnotize/images')) {
        $image_path = '/Hypnotize/images';
    } elseif (file_exists(__DIR__ . '/images')) {
        $image_path = '/images';
    }
}

// Check permissions
$abs_image_path = __DIR__ . $image_path;
$perm_error = "";
if (file_exists($abs_image_path)) {
    if (!is_writable($abs_image_path) || !is_readable($abs_image_path)) {
        $perm_error = "Feil: Bilde-mappen ($abs_image_path) er ikke lesbar eller skrivbar. Vennligst fiks rettighetene (f.eks. chmod 777 eller chown) og prøv igjen.";
    }
} else {
    // If it doesn't exist, we can't check permissions, but maybe we should warn
    $perm_error = "Advarsel: Bilde-mappen ($abs_image_path) finnes ikke.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($perm_error)) {
    // Connect to MySQL
    $conn = @mysqli_connect($db_host, $db_user, $db_pass);
    if (!$conn) {
        $message = "Tilkobling mislyktes: " . mysqli_connect_error();
    } else {
        // Create Database
        $db_name_escaped = mysqli_real_escape_string($conn, $db_name);
        mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS `$db_name_escaped`");
        
        $should_install = true;

        if (!mysqli_select_db($conn, $db_name)) {
             $message = "Kunne ikke velge database: " . mysqli_error($conn);
             $should_install = false;
        } else {
            // Check if installed (by checking if tables exist) to prevent overwrite
            // User requested "only can be run once". We check 'users' table.
            $res = mysqli_query($conn, "SHOW TABLES LIKE 'users'");
            if (mysqli_num_rows($res) > 0) {
                 // Check if it has data
                 $res2 = mysqli_query($conn, "SELECT count(*) as c FROM users");
                 $row2 = mysqli_fetch_array($res2);
                 if ($row2['c'] > 0 && !isset($_POST['force_install'])) {
                     $message = "Databasen ser ut til å være i bruk. Installasjonen ble avbrutt for å forhindre overskriving.";
                     $success = false;
                     $should_install = false;
                 }
            }
        }

        if ($should_install) {
            // Import SQL
            $sql_file = 'Docs/Hypnotize-stable.sql';
            if (file_exists($sql_file)) {
                $lines = file($sql_file);
                $query = '';
                foreach ($lines as $line) {
                    $line = trim($line);
                    if (!$line || substr($line, 0, 2) == '--' || substr($line, 0, 1) == '#') continue;
                    $query .= $line;
                    if (substr(trim($line), -1) == ';') {
                        mysqli_query($conn, $query);
                        $query = '';
                    }
                }

                // Escape variables for Config Table
                $site_title_esc = mysqli_real_escape_string($conn, $site_title);
                $page_name_esc = mysqli_real_escape_string($conn, $page_name);
                $site_url_esc = mysqli_real_escape_string($conn, $site_url);
                $image_path_esc = mysqli_real_escape_string($conn, $image_path);
                $backend_lang_esc = mysqli_real_escape_string($conn, $backend_lang);
                $backend_desc_esc = mysqli_real_escape_string($conn, $backend_desc);

                $smtp_host_esc = mysqli_real_escape_string($conn, $smtp_host);
                $smtp_port_int = (int)$smtp_port;
                $smtp_user_esc = mysqli_real_escape_string($conn, $smtp_user);
                $smtp_pass_esc = mysqli_real_escape_string($conn, $smtp_pass);
                $smtp_enc_esc = mysqli_real_escape_string($conn, $smtp_encryption);
                $admin_email_esc = mysqli_real_escape_string($conn, $admin_email);

                $maintenance = 0; // Default off
                $dguestbook_int = (int)$dguestbook;
                $dlinks_int = (int)$dlinks;
                $style = 'default';

                // Check if row 1 exists (from SQL dump), if not insert, else update
                $check = mysqli_query($conn, "SELECT id FROM config WHERE id=1");
                if (mysqli_num_rows($check) == 0) {
                     $sql = "INSERT INTO config (id, title, pagename, siteurl, images, maintenance, dguestbook, dlinks, backend_language, backend_description, style, smtp_host, smtp_port, smtp_user, smtp_pass, smtp_encryption, admin_email, watermark)
                             VALUES (1, '$site_title_esc', '$page_name_esc', '$site_url_esc', '$image_path_esc', 0, $dguestbook_int, $dlinks_int, '$backend_lang_esc', '$backend_desc_esc', '$style', '$smtp_host_esc', $smtp_port_int, '$smtp_user_esc', '$smtp_pass_esc', '$smtp_enc_esc', '$admin_email_esc', $watermark)";
                     mysqli_query($conn, $sql) or $message .= "Config Insert Error: " . mysqli_error($conn);
                } else {
                     $sql = "UPDATE config SET
                             title='$site_title_esc',
                             pagename='$page_name_esc',
                             siteurl='$site_url_esc',
                             images='$image_path_esc',
                             dguestbook=$dguestbook_int,
                             dlinks=$dlinks_int,
                             backend_language='$backend_lang_esc',
                             backend_description='$backend_desc_esc',
                             smtp_host='$smtp_host_esc',
                             smtp_port=$smtp_port_int,
                             smtp_user='$smtp_user_esc',
                             smtp_pass='$smtp_pass_esc',
                             smtp_encryption='$smtp_enc_esc',
                             admin_email='$admin_email_esc',
                             watermark=$watermark
                             WHERE id=1";
                     mysqli_query($conn, $sql) or $message .= "Config Update Error: " . mysqli_error($conn);
                }

                // Create/Update Admin User
                $admin_user_esc = mysqli_real_escape_string($conn, $admin_user);
                $admin_pass_hash = password_hash($admin_pass, PASSWORD_DEFAULT);
                $admin_pass_esc = mysqli_real_escape_string($conn, $admin_pass_hash);

                mysqli_query($conn, "TRUNCATE TABLE users");
                mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$admin_user_esc', '$admin_pass_esc')");

                // Generate Config Content
                $config_code_user = "<?php\n" .
                                  "//The ip adress or hostname to the mysql server\n" .
                                  "\$hostname = '" . addslashes($db_host) . "';\n\n" .
                                  "//The username that it will use when it connects to the mysql server\n" .
                                  "\$username = '" . addslashes($db_user) . "';\n\n" .
                                  "//The password that it will use when it connects to the mysql server\n" .
                                  "\$password = '" . addslashes($db_pass) . "';\n\n" .
                                  "//The database The Hypnotize Project will use\n" .
                                  "\$database = '" . addslashes($db_name) . "';\n\n" .
                                  "\$mlink = mysqli_connect(\$hostname, \$username, \$password, \$database);\n" .
                                  "if (!\$mlink) {\n" .
                                  "    die(\"Connection failed: \" . mysqli_connect_error());\n" .
                                  "}\n" .
                                  "?>";

                $config_code_admin = $config_code_user; // Same for both currently

                $message = "Databaseoppsett fullført!";
                $success = true;
                $show_config_code = true;
            } else {
                $message = "Feil: Docs/Hypnotize-stable.sql ble ikke funnet.";
            }
        }
        mysqli_close($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>The Hypnotize Project - Installasjon</title>
    <link rel="stylesheet" type="text/css" href="css/setup.css">
    <script src="js/setup.js"></script>
</head>
<body>
<div class="container">
    <h2>The Hypnotize Project Installasjon</h2>

    <?php if (!empty($message)) { echo "<p class='" . ($success ? "success" : "error") . "'>$message</p>"; } ?>
    <?php if (!empty($perm_error)) { echo "<p class='error'>$perm_error</p>"; } ?>

    <?php if ($show_config_code) { ?>
        <div class="instruction">
            <h3>Database installasjonen var vellykket, men du må sette opp config.php filene manuelt.</h3>
            <p>Av sikkerhetsmessige årsaker oppretter <strong>ikke</strong> denne installasjonsprogramvaren konfigurasjonsfilene automatisk. Du må manuelt opprette de to filene nedenfor og lime inn koden i dem.</p>
        </div>

        <label>1. Fil: <code>Hypnotize/includes/config.php</code></label>
        <textarea readonly onclick="selectText(this)"><?php echo htmlspecialchars($config_code_user); ?></textarea>

        <label>2. Fil: <code>Hypnotize-admin/includes/config.php</code></label>
        <textarea readonly onclick="selectText(this)"><?php echo htmlspecialchars($config_code_admin); ?></textarea>

        <div class="btn-wrapper">
            <a href="Hypnotize-admin/" target="_blank" class="btn-admin">Gå til Adminpanel</a>
            <a href="Hypnotize/" target="_blank" class="btn-public">Gå til Offentlig Side</a>
        </div>
        <p class="warning-text">VIKTIG: Vennligst slett <code>setup.php</code> nå!</p>

    <?php } else { ?>

    <form method="post" action="">
        <div class="row">
            <div class="col">
                <h3>Databasetilkobling</h3>
                <label>Vert:</label>
                <input type="text" name="db_host" value="<?php echo htmlspecialchars($db_host); ?>" required>

                <label>Bruker:</label>
                <input type="text" name="db_user" value="<?php echo htmlspecialchars($db_user); ?>" required>

                <label>Passord:</label>
                <input type="password" name="db_pass" value="<?php echo htmlspecialchars($db_pass); ?>">

                <label>Databasenavn:</label>
                <input type="text" name="db_name" value="<?php echo htmlspecialchars($db_name); ?>" required>
            </div>
            <div class="col">
                <h3>Adminkonto</h3>
                <label>Brukernavn:</label>
                <input type="text" name="admin_user" value="<?php echo htmlspecialchars($admin_user); ?>" required>

                <label>Passord:</label>
                <input type="password" name="admin_pass" required>
            </div>
        </div>

        <h3>Sidekonfigurasjon</h3>
        <div class="row">
            <div class="col">
                <label>Sidetittel:</label>
                <input type="text" name="site_title" value="<?php echo htmlspecialchars($site_title); ?>">

                <label>Sidenavn:</label>
                <input type="text" name="page_name" value="<?php echo htmlspecialchars($page_name); ?>">

                <label>Side URL (HTTPS):</label>
                <input type="text" name="site_url" value="<?php echo htmlspecialchars($site_url); ?>">

                <label>Bildestil (relativ):</label>
                <input type="text" name="image_path" value="<?php echo htmlspecialchars($image_path); ?>">
                <small>Rettigheter vil bli sjekket.</small>
            </div>
            <div class="col">
                <label>Backend Beskrivelse (RSS):</label>
                <input type="text" name="backend_desc" value="<?php echo htmlspecialchars($backend_desc); ?>">

                <label>Backend Språk:</label>
                <input type="text" name="backend_lang" value="<?php echo htmlspecialchars($backend_lang); ?>">

                <div class="checkbox-wrapper">
                    <label class="checkbox-label">
                        <input type="checkbox" name="dguestbook" <?php if($dguestbook) echo 'checked'; ?>> Deaktiver Gjestebok
                    </label>
                    <br>
                    <label class="checkbox-label">
                        <input type="checkbox" name="dlinks" <?php if($dlinks) echo 'checked'; ?>> Deaktiver Linker
                    </label>
                    <br>
                    <label class="checkbox-label">
                        <input type="checkbox" name="watermark" <?php if($watermark) echo 'checked'; ?>> Aktiver Vannmerke
                    </label>
                </div>
            </div>
        </div>

        <h3>E-postinnstillinger (SMTP)</h3>
        <div class="row">
            <div class="col">
                <label>SMTP Vert:</label>
                <input type="text" name="smtp_host" value="<?php echo htmlspecialchars($smtp_host); ?>">

                <label>SMTP Port:</label>
                <input type="number" name="smtp_port" value="<?php echo htmlspecialchars($smtp_port); ?>">

                <label>Kryptering:</label>
                <select name="smtp_encryption">
                    <option value="" <?php if($smtp_encryption=='') echo 'selected'; ?>>Ingen</option>
                    <option value="tls" <?php if($smtp_encryption=='tls') echo 'selected'; ?>>TLS</option>
                    <option value="ssl" <?php if($smtp_encryption=='ssl') echo 'selected'; ?>>SSL</option>
                </select>
            </div>
            <div class="col">
                <label>SMTP Bruker:</label>
                <input type="text" name="smtp_user" value="<?php echo htmlspecialchars($smtp_user); ?>">

                <label>SMTP Passord:</label>
                <input type="password" name="smtp_pass" value="<?php echo htmlspecialchars($smtp_pass); ?>">

                <label>Admin E-post (Til):</label>
                <input type="text" name="admin_email" value="<?php echo htmlspecialchars($admin_email); ?>">
            </div>
        </div>

        <input type="submit" value="Installer Database">
    </form>
    <?php } ?>
</div>
</body>
</html>
