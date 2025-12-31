# nukeCE Writable Dirs (v15)

Generated: 2025-12-27T00:36:03.552613Z

## Canonical writable dirs (webroot)

These directories are created under `public_html/` for runtime writes in default deployments:

- `public_html/uploads/` (HTTP readable, **PHP execution denied**)
- `public_html/cache/` (HTTP denied)
- `public_html/tmp/` (HTTP denied)
- `public_html/logs/` (HTTP denied)

## Configuration keys
Defined in `public_html/config/config.php`:

- `uploads_dir`
- `cache_dir`
- `tmp_dir`
- `logs_dir`

Each can be overridden via environment variables:

- `NUKECE_UPLOADS_DIR`
- `NUKECE_CACHE_DIR`
- `NUKECE_TMP_DIR`
- `NUKECE_LOGS_DIR`

## Security notes
- `.htaccess` rules assume Apache with AllowOverride enabled.
- For Nginx, replicate the same restrictions in server config.
