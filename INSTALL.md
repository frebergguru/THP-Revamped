# Installation Guide

## System Requirements
To run The Hypnotize Project, you need a standard LAMP/LEMP stack with the following extensions:

*   **PHP:** 8.0 or higher
*   **Extensions:**
    *   `php-mysqli` (Required for database connection)
    *   `php-gd` (Required for image processing)
    *   `php-curl` (Recommended for IMDb fetching, fallback available)
*   **Database:** MySQL / MariaDB
*   **Web Server:** Apache or Nginx (Must support PHP)

### Installation on Ubuntu/Debian
```bash
sudo apt-get update
sudo apt-get install -y apache2 php php-cli php-fpm php-mysql php-gd php-curl mysql-server libapache2-mod-php
```

## Setup Instructions

### 1. Web Server Configuration
Configure your web server (Apache/Nginx) to serve the project files.
*   **Document Root:** Point your web server's document root to the directory containing the project files (e.g., `/var/www/html/TheHypnotizeProject`).
*   **Permissions:** Ensure the web server user (usually `www-data`) has read permissions for all files and write permissions for the `images/` directory.

### 2. Run Installer
1.  Open your web browser and navigate to `http://your-server/setup.php`.
2.  Fill in the required information:
    *   **Database Connection:** Host, Username, Password, Database Name.
    *   **Admin Account:** Create your administrator username and password.
    *   **Site Configuration:** URLs, Titles, and feature toggles.
3.  Click "Install Database".

The script will automatically create the database, import the schema, and insert your initial configuration.

### 3. Finalize Installation
For security reasons, the installer cannot create PHP files directly. You must do this manually:
1.  The installer will generate code blocks for two configuration files.
2.  Create `Hypnotize/includes/config.php` and paste the first block of code.
3.  Create `Hypnotize-admin/includes/config.php` and paste the second block of code.
4.  **Important:** Delete `setup.php` from the server to prevent unauthorized reconfiguration.

Access the application at:
*   **Public Site:** `http://your-server/Hypnotize/`
*   **Admin Panel:** `http://your-server/Hypnotize-admin/`
