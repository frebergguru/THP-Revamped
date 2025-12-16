# The Hypnotize Project - Rebooted

The Hypnotize Project (THP) is a lightweight, classic Content Management System (CMS) designed to help you easily build and manage your own website.

This repository represents a "rebooted" version of the original project, focusing on modernizing the codebase while preserving its classic functionality.

## Key Changes in Reboot
*   **Modern PHP Support:** Replaced obsolete `mysql_*` functions with `mysqli_*`.
*   **Security Improvements:** Addressed various security vulnerabilities (XSS, SQL Injection).
*   **Layout Modernization:** Replaced old table-based layouts with CSS Flexbox.
*   **New Features:** Added IMDb integration for the DVD module.

## Features
*   **Modular Architecture:** Includes modules for DVD collection, Guestbook, Links, and more.
*   **Dual Interface:**
    *   **User UI:** Located in `Hypnotize/` - The public-facing website.
    *   **Admin UI:** Located in `Hypnotize-admin/` - The backend for content management.
*   **DVD Management:** specialized module for cataloging DVDs with automatic IMDb data fetching.
*   **Customizable:** Supports themes and custom configurations.

## Getting Started

See [INSTALL.md](INSTALL.md) for detailed installation and setup instructions.

### Default Credentials

Used if you install manually without setup.php

*   **URL:** `/Hypnotize-admin/`
*   **Username:** `admin`
*   **Password:** `password`

## Documentation
*   [INSTALL.md](INSTALL.md) - Installation guide.
*   [AGENTS.md](AGENTS.md) - Developer guidelines and codebase context.
*   [ASSETS.md](ASSETS.md) - Overview of static assets (Images, CSS, Fonts).
*   [CONTRIBUTING.md](CONTRIBUTING.md) - How to contribute to the project.
