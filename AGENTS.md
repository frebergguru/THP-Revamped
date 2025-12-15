# Agent Guidelines & Memory

This file contains context, constraints, and learned patterns for agents (AI) working on this codebase.

## Core Constraints
1.  **Do NOT Change Layout:** The visual layout structure (CSS classes, HTML hierarchy) must be preserved unless explicitly instructed otherwise.
2.  **Backward Compatibility:** Do not break existing functionality (e.g., existing "Add" flows).
3.  **No Frameworks:** This is a vanilla PHP/MySQL project. Do not introduce Composer, Laravel, Symfony, or other frameworks.

## Project Structure
*   `Docs/` - Documentation and SQL schema.
    *   `css/` - Stylesheets for documentation (e.g., `Database.css`).
*   `Hypnotize/` - **User Interface** (Public facing).
    *   `Modules/` - Logic for individual modules (DVD, Guestbook, etc.).
*   `Hypnotize-admin/` - **Admin Interface** (Backend).
    *   `Modules/` - Admin logic for modules.

## Technical Patterns
*   **Database:** Uses `mysqli` extension. Global connection variable is `$mlink`.
*   **Sanitization:**
    *   **SQL:** Use `mysqli_real_escape_string($mlink, $var)` for all inputs.
    *   **HTML:** Use `htmlspecialchars($var, ENT_QUOTES)` for all output echoing.
*   **Environment Safety:**
    *   Do not assume extensions like `curl` are present. Check with `function_exists()` and provide fallbacks (e.g., `stream_context` for HTTP requests).
    *   Initialize loop counters (e.g., `$i = 0`) before loops to avoid warnings.

## IMDb Fetching Feature
*   **Location:** `Hypnotize-admin/Modules/DVD/DVD.php`
*   **Logic:**
    1.  User enters ID.
    2.  System requests IMDb page (sets valid User-Agent).
    3.  System parses `application/ld+json` (JSON-LD) block.
    4.  Data is normalized (e.g., Duration conversion, Array handling for Directors/Actors).
*   **Requirements:** Requires User-Agent header to avoid 403 Forbidden from IMDb.

## Database Info
*   **Default DB:** `THP`
*   **Schema:** `Docs/Hypnotize-stable.sql`
*   **Documentation:** `Docs/Database.html` (Styled with Flexbox via `Docs/css/Database.css`).
*   **Users Table:** `users` (previously `Admin` in older versions).
*   **DVD Table:** `dvd`
