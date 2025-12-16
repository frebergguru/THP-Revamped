# Ressurskatalogstruktur

Dette dokumentet beskriver organiseringen av statiske ressurser i The Hypnotize Project.

## Globale Ressurser
Det finnes ingen global `assets`-mappe. Ressurser er distribuert innenfor `Hypnotize` (Bruker), `Hypnotize-admin` (Admin), og `Docs`-katalogene.

## Dokumentasjon (`Docs/`)

### CSS (`Docs/css/`)
Stilark for dokumentasjonsfilene.
*   `Database.css` - Stiler for databaseoversikten (`Database.html`).
*   `Funksjoner.css` - Stiler for utvikler funksjoner oversikten (`Funksjoner.html`).

## Brukergrensesnitt (`Hypnotize/`)

### Bilder (`Hypnotize/images/`)
Generelle bilder for det offentlige nettstedets tema og innhold.
*   `dvd/` - Bilder relatert til DVD-modulen (f.eks. terningkast).
*   `smilies/` - Smileansikt for gjestebok/kommentarer.
*   `Hypnotize.jpg`, `linux.jpg`, `php.jpg` - Temagrafikk.

### CSS (`Hypnotize/css/`)
*Inneholder stilarkene for den offentlige frontend-en.*

## Admin Grensesnitt (`Hypnotize-admin/`)

### Bilder (`Hypnotize-admin/images/`)
Bilder spesifikke for administrasjons-backend.
*   `smilies/` - Admin-side smilefjes.
*   Delt temagrafikk (`apache.jpg`, `mysql.jpg`, osv.).

### CSS (`Hypnotize-admin/css/`)
Stilark for adminpanel-temaene.
*   `admin.css` - Kjerne admin-stiler.
*   `admin-menu.css` - Navigasjonsmeny-stiler.
*   **Temaer:**
    *   `black.css`
    *   `red.css`
    *   `gray.css`
    *   `default.css`
    *   `m-server.css`

### Skriftfiler (`Hypnotize-admin/fonts/`)
*   `manuscript.ttf` - Skriftfil brukt i vannmerker.
