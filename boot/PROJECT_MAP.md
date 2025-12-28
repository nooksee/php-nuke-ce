# PROJECT_MAP — nukeCE

Status: Canon-adjacent (assistive, not binding)
Last reviewed: 2025-12-28

Policing: If implementation changes architecture (taxonomy, routing, boundaries, new subsystems), update this file
first or file a Decision object (if canon must change).

## 0. What This Is
This document describes the *shape* of nukeCE:
- where things live
- what counts as core vs optional
- how the system is meant to be extended

If this drifts from the repo, fix the doc or file a Decision. Do not “remember” differently.

## 1. Repository Structure (Authoritative)

nukece/
  public_html/        # Web root (Apache DocumentRoot)
    index.php         # Public entrypoint
    admin.php         # Admin entrypoint (if present)
    modules/          # Core public modules ONLY
      _legacy/        # Quarantined historical code (never loaded)
      <legacy-stub>/  # Thin redirect only
      <core>/
    themes/
    blocks/
    includes/
    src/
    docs/
      releases/
  addons/             # Optional features (NOT webroot)
    modules/          # addon packages (zip + manifest)
    optional/         # extracted addon modules (source)
  boot/               # Context engineering + canon
    principles.md
    canon_snapshot.md
    PROJECT_MAP.md
    STATE_OF_PLAY.md
    active_loops.json
  tools/              # Verify/build scripts
  patches/            # Release train artifacts (if used)
  README.md

## 2. Module Taxonomy

### Core Public Modules (must live in public_html/modules/)
- home
- news / stories
- forums
- downloads
- links
- reference
- blog
- search
- users / account

### Admin Modules (admin_* naming)
- admin_dashboard
- admin_nukesecurity
- admin_maintenance
- admin_settings
- admin_users
- admin_content
- admin_blocks
- admin_themes
- admin_links
- admin_downloads
- admin_forums
- admin_reference
- admin_moderation
- admin_ai (optional)

### Addons (live in /addons/, never core)
- members (addon)
- arcade (addon)
- faq (addon)
- surveys / polls (addon)
- statistics (addon)
- top (addon)
- recommend (addon)
- newsletter (addon)
- projects (addon)
(Exact list evolves; STATE_OF_PLAY is the session truth.)

### Legacy Modules
- encyclopedia → reference
- weblinks → links
- journal → blog
- avantgo → mobile (legacy redirect)

Legacy modules must:
- contain ONLY index.php (or Module stub) in modules/
- have real code quarantined in modules/_legacy/

## 3. Routing Model (High Level)
- Single entrypoint via public_html/index.php
- Router supports:
  - ?module=<name>
  - /<module>[/action/...]
- Do not assume older PHP-Nuke routing (modules.php).

## 4. Security Boundaries
- Writable dirs explicitly enumerated and protected
- Installer locked post-install
- PHP execution denied in upload/cache surfaces
- NukeSecurity governs roles + IP intelligence surfaces

## 5. Extension Rules (Hard)
- New features start as addons unless explicitly promoted
- No new module names without updating PROJECT_MAP
- Case-sensitive filesystem: avoid duplicate names differing by case
