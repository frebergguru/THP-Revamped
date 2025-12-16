# Assets Directory Structure

This document outlines the organization of static assets within The Hypnotize Project.

## Global Assets
There is no global `assets` folder. Assets are distributed within the `Hypnotize` (User), `Hypnotize-admin` (Admin), and `Docs` directories.

## Documentation (`Docs/`)

### CSS (`Docs/css/`)
Stylesheets for the documentation files.
*   `Database.css` - Styles for the database overview (`Database.html`).

## User Interface (`Hypnotize/`)

### Images (`Hypnotize/images/`)
General images for the public site theme and content.
*   `dvd/` - Images related to the DVD module (e.g., dice ratings).
*   `smilies/` - Smilies for guestbook/comments.
*   `Hypnotize.jpg`, `linux.jpg`, `php.jpg` - Theme graphics.

### CSS (`Hypnotize/css/`)
*Contains the stylesheets for the public frontend.* (Note: Check actual directory if distinct from root).

## Admin Interface (`Hypnotize-admin/`)

### Images (`Hypnotize-admin/images/`)
Images specific to the administration backend.
*   `hex.gif` - Color picker or UI element.
*   `smilies/` - Admin-side smilies.
*   Shared theme graphics (`apache.jpg`, `mysql.jpg`, etc.).

### CSS (`Hypnotize-admin/css/`)
Stylesheets for the admin panel themes.
*   `admin.css` - Core admin styles.
*   `admin-menu.css` - Navigation menu styles.
*   **Themes:**
    *   `black.css`
    *   `red.css`
    *   `gray.css`
    *   `default.css`
    *   `m-server.css`

### Fonts (`Hypnotize-admin/fonts/`)
*   `manuscript.ttf` - Custom font file used in specific admin views or generated images.
