# StoragePaths helper (v19)

Generated: 2025-12-27T01:58:49.427791Z

## Purpose
Centralize filesystem paths derived from AppConfig and provide safe path joining.

## Class
- `public_html/src/Core/StoragePaths.php`

## Provides
- `uploadsDir()`, `cacheDir()`, `tmpDir()`, `logsDir()`, `dataDir()`
- `join(base, ...parts)` (sanitizes parts; prevents traversal)
- `ensureDir(dir)`

## Adopted by (v19)
- NukeSecurity log path
- NukeSecurity threats block log path
- Admin Downloads upload destination
- Admin Maintenance writable-dir panel
