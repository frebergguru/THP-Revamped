# Contributing

We welcome contributions to The Hypnotize Project!

## Rules & Guidelines

### 1. Layout Integrity
**CRITICAL:** Do NOT change the layout structure. The project relies on a specific Flexbox and CSS implementation. Adding functionality should happen *within* existing containers, not by reshaping the page.

### 2. Code Style
*   **PHP:** Use standard PHP tags `<?php`.
*   **Output:** Always sanitize output with `htmlspecialchars` to prevent XSS.
*   **Database:** Use `mysqli`. Do not use deprecated `mysql_*` functions.
*   **Variables:** Initialize variables before use to avoid `Undefined variable` warnings.

### 3. Compatibility
*   Ensure code works on standard LAMP stacks.
*   Avoid adding hard dependencies on specific PHP extensions if a fallback can be written (e.g., `curl` vs `stream_context`).

### 4. Submission Process
1.  Make your changes.
2.  Test thoroughly.
3.  Submit a Pull Request with a clear description of the feature or fix.
