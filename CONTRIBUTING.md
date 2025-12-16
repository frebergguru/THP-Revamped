# Bidra

Vi ønsker bidrag til The Hypnotize Project velkommen!

## Regler & Retningslinjer

### 1. Layout Integritet
**KRITISK:** IKKE endre layoutstrukturen. Prosjektet avhenger av en spesifikk Flexbox- og CSS-implementasjon.
Ny funksjonalitet bør skje *innenfor* eksisterende containere, ikke ved å gjøre om på designet til siden.

### 2. Kodestil
*   **PHP:** Bruk standard PHP-tagger `<?php`.
*   **Utdata:** Saner alltid utdata med `htmlspecialchars` for å forhindre XSS.
*   **Database:** Bruk `mysqli`. Ikke bruk utdaterte `mysql_*`-funksjoner.
*   **Variabler:** Initialiser variabler før bruk for å unngå `Undefined variable`-advarsler.

### 3. Kompatibilitet
*   Sørg for at koden fungerer med både LAMP og LEMP.
*   Unngå å legge til harde avhengigheter til spesifikke PHP-utvidelser, hvis en reserveløsning kan skrives (f.eks. `curl` vs `stream_context`).

### 4. Innleveringsprosess
1.  # Bidra

Vi ønsker bidrag til The Hypnotize Project velkommen!

## Regler & Retningslinjer

### 1. Layout Integritet
**KRITISK:** IKKE endre layoutstrukturen. Prosjektet avhenger av en spesifikk Flexbox- og CSS-implementasjon. Å legge til funksjonalitet bør skje *innenfor* eksisterende containere, ikke ved å gjøre om på designet til siden.

### 2. Kodestil
*   **PHP:** Bruk standard PHP-tagger `<?php`.
*   **Utdata:** Saner alltid utdata med `htmlspecialchars` for å forhindre XSS.
*   **Database:** Bruk `mysqli`. Ikke bruk utdaterte `mysql_*`-funksjoner.
*   **Variabler:** Initialiser variabler før bruk for å unngå `Undefined variable`-advarsler.

### 3. Kompatibilitet
*   Sørg for at koden fungerer på standard LAMP-stakker.
*   Unngå å legge til harde avhengigheter til spesifikke PHP-utvidelser, hvis en reserveløsning kan skrives (f.eks. `curl` vs `stream_context`).

### 4. Innleveringsprosess
1.  Skriv endringene.
2.  Test grundig.
3.  Send inn en Pull Request med en tydelig beskrivelse av funksjonen eller rettelsen.Gjør endringene dine.
2.  Test grundig.
3.  Send inn en Pull Request med en tydelig beskrivelse av funksjonen eller rettelsen.
