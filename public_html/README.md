# nukeCE CMS (so far)

Minimal "CMS in action" baseline:
- PDO DB connector
- Installer creates users/sessions tables + admin user
- Admin login/logout/session gate + dashboard
- Pages: migrate + list + create/edit + public render

Default admin credentials (change immediately):
- admin / admin123

## Setup
1. Edit `includes/config.php` to match your MariaDB credentials.
2. Visit `/admin/install.php` once.
3. Visit `/admin/login.php` and log in.
4. Visit `/admin/migrate_pages.php` once.
5. Use `/admin/pages.php` to create content, view via `/page.php?slug=...`

## Security
After install:
- rename/delete `admin/install.php`
- rename/delete `admin/migrate_pages.php` (or protect them)
