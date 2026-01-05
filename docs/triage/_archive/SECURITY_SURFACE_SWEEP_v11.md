# nukeCE Security Surface Sweep (v11)
Generated: 2025-12-26T23:50:06.997318Z

## Goal
Reduce risk by making the webroot boundary obvious and verifying that sensitive material is either:
- configuration via environment variables, or
- stored outside webroot (`storage/`), or
- explicitly marked as sample.

## Key boundary rule
- Only `public_html/` is deployable.
- `storage/` must remain non-public.

## Potentially sensitive files detected in webroot
- `nbproject/private/config.properties`
- `nbproject/private/private.properties`
- `nbproject/private/private.xml`
- `assets/images/originals/system/src_images/admin/backup.gif`
- `assets/images/originals/system/legacy_images/admin/backup.gif`
- `config/config.php`
- `config/config.php.sample`
- `includes/config.php`
- `install/datafeeds.sql`
- `install/sql/links.sql`
- `src/Core/SiteConfig.php`
- `src/Core/AppConfig.php`
- `src/Security/NukeSecurityConfig.php`
- `src/Forums/PrivateMessages/PrivateMessagesBridge.php`
- `themes/nukegold/assets/images/originals/images/topics/mysql.jpg`
- `themes/x-halo/assets/images/originals/images/admin/backup.gif`

## Notes
- `config/config.php` appears to be environment-variable driven (good). It still **must** be treated as sensitive.
- `includes/config.php` exists and should be checked for overlap/conflict with `config/config.php`.
- `install/*.sql` should not be accessible in production; consider deployment checklist to remove/deny `install/`.

## Recommended hardening checklist (Track A)
- Ensure web server denies direct access to:
  - `install/`
  - `config/` (except safe bootstrap if needed)
  - `includes/` for non-entrypoint PHP where appropriate
- Ensure secrets are loaded via env vars and never committed.
- Confirm `storage/` is outside `public_html/` in the structured bundle (it is, in v11 bundle).
