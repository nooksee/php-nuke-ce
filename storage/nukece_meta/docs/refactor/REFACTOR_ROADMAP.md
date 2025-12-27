# Refactor Roadmap (from Integrity Report)

This roadmap is derived from `docs/integrity/INTEGRITY_REPORT_PUBLIC_HTML.*` and is designed to be **low-risk**:
- No large rewrites
- No behavior changes unless explicitly called out
- Focus on dedupe, separation of concerns, and guardrails

## A. Safe deletions / dedupe candidates (low risk if verified)

These are *candidates*, not automatic deletes. The integrity scan shows many identical assets duplicated across themes and legacy folders.

### A1) Pixel/spacer/blank GIF duplicates
**Why safe-ish:** These are typically 1×1 or spacer images with identical content, duplicated dozens of times.
**What to do:**
1. Pick a single canonical location (e.g. `public_html/assets/images/common/`)
2. Update references gradually (theme templates first)
3. Only then remove duplicates

**Evidence:** Largest duplicate cluster includes `spacer.gif`, `pixel.gif`, `blackpixel.gif`, etc. (see duplicate clusters).

### A2) Repeated admin SVG icon sets in `assets/originals/admin/*`
**Why safe-ish:** Identical icons repeated in multiple variant paths.
**What to do:** Keep one set under `public_html/assets/icons/admin/` and point all callers there.

### A3) Theme “originals” image mirrors
`public_html/themes/*/assets/images/originals/**` contains repeated assets across themes (same hashes).
**What to do:** Do *not* delete yet. Instead:
- inventory which themes are active
- for inactive themes, archive their originals outside `public_html` first
- then remove only after a smoke test

### A4) Legacy image mirrors under `assets/images/originals/system/legacy_images/*`
Likely historic compatibility assets.
**What to do:** Keep until you confirm no hardcoded references remain. If you want to shrink, prefer moving to `nukece_meta/archives/` rather than deleting.

---

## B. High-risk legacy hot zones (touch last)

These areas are high-coupling, security-sensitive, or historically brittle.

### B1) Forum integration / phpBB bridge
Paths often include `phpbb`, `forums`, and admin forum modules.
**Risk:** authentication/session coupling, path assumptions, DB coupling, old globals.
**Safe move:** add logging + integration tests before touching.

### B2) Admin modules
`public_html/admin/*` and `public_html/modules/admin_*`
**Risk:** privileged surfaces, older permission checks, common injection targets.
**Safe move:** add guardrails (headers, CSRF checks if not already), tighten allowlists, improve audit logging.

### B3) Core includes / bootstrap
`public_html/includes/*` (and any `mainfile.php`-style bootstrap if present)
**Risk:** everything depends on it; small changes have huge blast radius.
**Safe move:** only refactor behind compatibility wrappers.

### B4) Themes and templating glue
`public_html/themes/*`
**Risk:** enormous file count + scattered references; easy to break rendering by small path changes.
**Safe move:** start by deduping assets via *additive* paths, not removal.

---

## C. First 5 modernization wins (low risk, no site break)

These are “wins” you can ship without changing runtime behavior.

### 1) Add a public_html-only integrity + inventory script (read-only)
- Generates file list + hashes + duplicate clusters
- Stores outputs in `nukece_meta/docs/integrity/`
**Why:** future changes have baselines; prevents accidental loss.

### 2) Introduce a config boundary (no behavior change)
- Define a single `config/` loader (or wrapper) that reads existing constants
- Start moving *new* settings there; leave legacy untouched
**Why:** reduces future refactor pain without breaking anything.

### 3) Add security headers at the webroot (additive)
- Content-Type sniffing off, clickjacking protection, basic CSP in report-only mode
**Why:** immediate risk reduction; minimal compatibility issues if conservative.

### 4) Establish a “single canonical assets path” (additive)
- Add `public_html/assets/images/common/` and start migrating only the obvious duplicates (spacer/pixel)
**Why:** shrinks duplication without breaking old paths.

### 5) Add a lightweight request/exception log channel (additive)
- A single file logger for admin + auth + integration surfaces
**Why:** when you refactor the hot zones later, you’ll have visibility.

---

## D. Suggested sequence (2–3 sessions)

1. **Baseline:** keep `INTEGRITY_REPORT_PUBLIC_HTML` updated
2. **Additive assets:** introduce canonical common assets + migrate spacer/pixel references
3. **Guardrails:** security headers + logging
4. **Only then:** begin structural refactors in themes, then forums/admin last

---

## Notes on your clarification (“everything in public_html”)
Interpreted as: **integrity check coverage**, not relocating meta assets into webroot.
This roadmap is based strictly on `public_html` scope.
