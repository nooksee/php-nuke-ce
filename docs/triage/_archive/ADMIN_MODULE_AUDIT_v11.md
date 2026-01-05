# nukeCE Admin Module Audit (v11)
Generated: 2025-12-26T23:50:06.996525Z

## Current routing pattern (binding)
- Admin subsystems are **modules named `admin_*`** under `public_html/modules/`.
- `admin.php` maps `op=` values to admin modules.

## admin.php op → module map
- `(default)` → `admin_settings`
- `dashboard` → `admin_settings`
- `settings` → `admin_settings`
- `ai` → `admin_ai`
- `reference` → `admin_reference`
- `clubs` → `admin_clubs`
- `moderation` → `admin_moderation`
- `themes` → `admin_themes`
- `blocks` → `admin_blocks`
- `forums` → `admin_forums`
- `security` → `admin_nukesecurity`
- `mobile` → `admin_mobile`
- `logout` → `__logout__`

## Admin modules present (modules/admin_*)
- `admin_ai`: expected `AdminAiModule.php` → **MISMATCH**; files: index.php
- `admin_blocks`: expected `AdminBlocksModule.php` → **OK**; files: AdminBlocksModule.php, index.php
- `admin_clubs`: expected `AdminClubsModule.php` → **MISMATCH**; files: index.php
- `admin_content`: expected `AdminContentModule.php` → **OK**; files: AdminContentModule.php
- `admin_dashboard`: expected `AdminDashboardModule.php` → **MISMATCH**; files: index.php
- `admin_downloads`: expected `AdminDownloadsModule.php` → **OK**; files: AdminDownloadsModule.php
- `admin_forums`: expected `AdminForumsModule.php` → **OK**; files: AdminForumsModule.php, index.php
- `admin_links`: expected `AdminLinksModule.php` → **MISMATCH**; files: index.php
- `admin_login`: expected `AdminLoginModule.php` → **OK**; files: AdminLoginModule.php
- `admin_maintenance`: expected `AdminMaintenanceModule.php` → **MISMATCH**; files: index.php
- `admin_mobile`: expected `AdminMobileModule.php` → **OK**; files: AdminMobileModule.php
- `admin_moderation`: expected `AdminModerationModule.php` → **OK**; files: AdminModerationModule.php, index.php
- `admin_nukesecurity`: expected `AdminNukesecurityModule.php` → **OK**; files: AdminNukesecurityModule.php, datafeeds.php
- `admin_reference`: expected `AdminReferenceModule.php` → **OK**; files: AdminReferenceModule.php, index.php
- `admin_settings`: expected `AdminSettingsModule.php` → **OK**; files: AdminSettingsModule.new.php, AdminSettingsModule.php, index.php
- `admin_themes`: expected `AdminThemesModule.php` → **OK**; files: AdminThemesModule.php, index.php
- `admin_users`: expected `AdminUsersModule.php` → **OK**; files: AdminUsersModule.php
- `admin_weblinks`: expected `AdminWeblinksModule.php` → **MISMATCH**; files: AdminWebLinksModule.php

## Findings (actionable)
Modules whose main class file name does not match ModuleManager expectations (likely placeholders or legacy):
- `admin_ai` (has 1 PHP file(s): index.php)
- `admin_clubs` (has 1 PHP file(s): index.php)
- `admin_dashboard` (has 1 PHP file(s): index.php)
- `admin_links` (has 1 PHP file(s): index.php)
- `admin_maintenance` (has 1 PHP file(s): index.php)
- `admin_weblinks` (has 1 PHP file(s): AdminWebLinksModule.php)

**Recommendation (Track A):** standardize each admin module to contain a proper `*Module.php` class matching the directory name, even if it just renders a stub page.
