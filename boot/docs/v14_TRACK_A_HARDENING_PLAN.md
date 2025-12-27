# nukeCE v14 — Track A Hardening Plan

Generated: 2025-12-27T00:30:56.841591Z

## Scope
- Installer lock guard for all install scripts
- Scan for writable directories and deny PHP execution
- Introduce optional-module gating (default-off) for selected legacy-style modules

## Optional modules (default-off)
your_account, weblinks, stats, projects, polls, newsletter, members, faq

Enable by copying:
- `public_html/config/ENABLED_OPTIONAL_MODULES.example.php` → `ENABLED_OPTIONAL_MODULES.php`
and listing modules to enable.
