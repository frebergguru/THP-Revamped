# Installasjonsguide

## Systemkrav
For å bruke The Hypnotize Project, trenger du en standard LAMP/LEMP installasjon med følgende utvidelser:

*   **PHP:** 8.0 eller høyere
*   **Utvidelser:**
    *   `php-mysqli` (Påkrevd for databasetilkobling)
    *   `php-gd` (Påkrevd for bildebehandling / captcha)
    *   `php-curl` (Anbefalt for å hente informasjon fra IMDb, men det er lagt inn en reserveløsning også)
*   **Database:** MySQL / MariaDB
*   **Webserver:** Apache eller Nginx (Må støtte PHP)

### Installasjon på Ubuntu/Debian
```bash
sudo apt-get update
sudo apt-get install -y apache2 php php-cli php-fpm php-mysql php-gd php-curl mariadb-server libapache2-mod-php
```

## Oppsettsinstruksjoner

### 1. Webserverkonfigurasjon
Konfigurer webserveren din (Apache/Nginx) til å servere prosjektfilene.
*   **Dokumentrot:** Pek webserverens dokumentrot til katalogen som inneholder prosjektfilene (f.eks. `/var/www/html/THP`).
*   **Rettigheter:** Sørg for at webserver-brukeren (vanligvis `www-data`) har leserettigheter for alle filer og skriverettigheter til mappen `images`.

### 2. Kjør setup.php
1.  Åpne nettleseren din og naviger til `http://din-server/setup.php`.
2.  Fyll inn nødvendig informasjon:
    *   **Databasetilkobling:** Vert, Brukernavn, Passord, Databasenavn.
    *   **Adminkonto:** Opprett ditt administratorbrukernavn og passord.
    *   **Sidekonfigurasjon:** URL-er, Titler, og funksjonsbrytere.
3.  Klikk "Installer Database".

Skriptet vil automatisk opprette tabeller og resten av innholdet til databasen og legge inn konfigurasjonen din.

### 3. Fullfør Installasjon
Av sikkerhetsmessige årsaker kan ikke setup.php opprette PHP-filer direkte, så du må gjøre dette manuelt:
1.  setup.php vil generere kodeblokker for to konfigurasjonsfiler.
2.  Opprett `Hypnotize/includes/config.php` og lim inn den første kodeblokken.
3.  Opprett `Hypnotize-admin/includes/config.php` og lim inn den andre kodeblokken.
4.  **Viktig:** Slett `setup.php` fra serveren for å forhindre uautorisert rekonfigurering.

Få tilgang til THP på:
*   **Offentlig Side:** `http://din-server/Hypnotize/`
*   **Adminpanel:** `http://din-server/Hypnotize-admin/`
