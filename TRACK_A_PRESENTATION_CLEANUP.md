# Repository presentation cleanup notes

These notes describe a one-time cleanup that made the repo safe to publish and easier to navigate.
They are intentionally **timeless** (no machine names, no local paths, no version-number archaeology).

## What changed
- Consolidated release notes under `public_html/docs/releases/` (kept as documentation, not “build artifacts”)
- Added core repo-truth documents at repo root (`CANONICAL_TREE.md`, `PROJECT_TRUTH.md`, `PROJECT_MAP.md`, etc.)
- Tightened `.gitignore` to keep writable/runtime surfaces and build artifacts out of Git
- Removed embedded release ZIP artifacts from `releases/` (those belong in external releases, not committed to the repo)
- Removed upstream reference dumps from the published bundle (keep externally if needed)
- Emptied `storage/` leaving `.keep` only

## Removed paths (pattern-level)
- `public_html/_upstream/`
- `releases/**/public_html_*.zip` (and similar embedded build artifacts)
