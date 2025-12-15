# The Hypnotize Project - Revamped

The Hypnotize Project (THP) er et publiseringssystem (CMS) designet for å hjelpe deg med å enkelt lage og administrere ditt eget nettsted.

Dette depotet representerer en oppusset versjon av det originale prosjektet, med fokus på å modernisere kodebasen samtidig som den klassiske funksjonaliteten bevares.

## Viktige endringer i Revamped
*   **Moderne PHP-støtte:** Erstattet foreldede `mysql_*`-funksjoner med `mysqli_*`.
*   **Sikkerhetsforbedringer:** Adressert diverse sikkerhetssårbarheter (XSS, SQL Injection).
*   **Layout-modernisering:** Erstattet gamle tabellbaserte layouter med CSS Flexbox og laget den mobilvennlig.
*   **Nye Funksjoner:** Lagt til IMDb-integrasjon for DVD-modulen.

## Funksjoner
*   **Modulær Arkitektur:** Inkluderer moduler for DVD-samling, Gjestebok, Linker, og mer.
*   **Dobbelt Grensesnitt:**
    *   **Bruker UI:** Ligger i `Hypnotize/` - Det offentlige nettstedet.
    *   **Admin UI:** Ligger i `Hypnotize-admin/` - Administrasjonsportalen.
*   **DVD-håndtering:** En spesialisert modul for katalogisering av DVD-er med automatisk henting av IMDb-data.
*   **Tilpassbar:** Støtter temaer og tilpassede konfigurasjoner.

## Kom i Gang

Se [INSTALL.md](INSTALL.md) for detaljerte installasjons- og oppsettsinstruksjoner.

### Standardlegitimasjon
*   **URL:** `/Hypnotize-admin/`
*   **Brukernavn:** `admin`
*   **Passord:** `password`

## Dokumentasjon
*   [INSTALL.md](INSTALL.md) - Installasjonsguide.
*   [AGENTS.md](AGENTS.md) - Utviklerretningslinjer og kodebasekontekst på engelsk.
*   [ASSETS.md](ASSETS.md) - Oversikt over statiske ressurser (Bilder, CSS, Fonter).
*   [CONTRIBUTING.md](CONTRIBUTING.md) - Hvordan bidra til prosjektet.
