# nukeCE v13 — Track A Hardening Plan
Generated: 2025-12-27T00:21:58.569932Z

## Scope
- Module naming normalization + legacy redirects
- Webroot hardening: deny sensitive paths and disable PHP execution in upload-like dirs
- Baseline security headers
- Installer lock guard

## Implemented in this release
- Rename `modules/Links/` → `modules/links/`: **True**
- Legacy route mapping: `module=Links` → `module=links`
- Upload-like dirs found: 18 (images)
- Sensitive dirs denied (data/_meta): data, _meta
- Installer lock added: False
