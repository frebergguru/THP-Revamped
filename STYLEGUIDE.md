# Stilguide for The Hypnotize Project - Revamped

Denne filen beskriver kodestandarder og retningslinjer for utvikling på The Hypnotize Project (THP). Alle bidragsytere forventes å følge disse reglene for å opprettholde kodekvalitet, sikkerhet og konsistens.

## 1. Generelle Prinsipper

*   **Ingen Rammeverk:** Dette er et "vanilla" PHP-prosjekt. Ikke introduser eksterne rammeverk (som Laravel, Symfony) eller pakkebehandlere (Composer) med mindre det er strengt nødvendig og godkjent.
*   **Layout Integritet:** Det er **kritisk** at du ikke endrer den visuelle strukturen eller layouten (HTML-hierarki, CSS-klasser) med mindre du har fått eksplisitt beskjed om det. Nye funksjoner skal passe inn i eksisterende containere.
*   **Bakoverkompatibilitet:** Ikke ødelegg eksisterende funksjonalitet.
*   **Språk:** Kodekommentarer og commit-meldinger kan være på engelsk, men brukerdokumentasjon (som denne filen) bør være tilgjengelig på norsk der det er etablert praksis.

## 2. PHP Kodestil

*   **Tags:** Bruk alltid fullstendige PHP-starttagger: `<?php`.
*   **Variabler:** Alle variabler må initialiseres før bruk for å unngå `Undefined variable` advarsler i loggene.
    *   *Feil:* `while ($row = ...)` uten definisjon.
    *   *Riktig:* `$i = 0; while (...)`
*   **Kompatibilitet:**
    *   Unngå harde avhengigheter til spesifikke PHP-utvidelser hvis mulig.
    *   Eksempel: Sjekk om `curl_init` finnes. Hvis ikke, bruk `file_get_contents` med `stream_context`.
*   **Shell-kommandoer:** Det er strengt forbudt å bruke funksjoner som `exec()`, `shell_exec()`, `system()`, `passthru()` eller backticks.

## 3. Database (MySQL/MariaDB)

*   **API:** Bruk `mysqli`-utvidelsen. De gamle `mysql_*`-funksjonene er fjernet og skal ikke brukes.
*   **Tilkobling:** Global tilkoblingsvariabel er vanligvis `$mlink`.
*   **Sikkerhet (SQL Injection):**
    *   Alle variabler som settes inn i en SQL-spørring **MÅ** sanitiseres med `mysqli_real_escape_string($mlink, $var)`.
*   **Motor:** Tabeller skal bruke `InnoDB`.

## 4. Sikkerhet og HTML

*   **XSS (Cross-Site Scripting):**
    *   All data som skrives ut til nettleseren (echo/print) som kommer fra brukerinput eller database, **MÅ** kjøres gjennom `htmlspecialchars($var, ENT_QUOTES)`.
*   **CSS og JS:**
    *   Ingen inline CSS (`style="..."`) eller inline JavaScript (`onclick="..."`).
    *   Bruk eksterne filer plassert i relevante `css/` eller `js/` mapper (f.eks. `Hypnotize/css/` eller `Hypnotize-admin/css/`).
    *   Oppsettet bruker Flexbox; respekter dette.

## 5. Filstruktur

*   **Hypnotize/**: Inneholder det offentlige brukergrensesnittet.
*   **Hypnotize-admin/**: Inneholder administrasjonspanelet.
*   **Docs/**: Dokumentasjon og SQL-skjemaer.

## 6. Bidrag

*   Sjekk `CONTRIBUTING.md` for detaljer om hvordan du sender inn endringer.
*   Test alltid koden din grundig før du sender inn en Pull Request.
