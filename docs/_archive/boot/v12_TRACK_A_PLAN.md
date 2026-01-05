# nukeCE v12 — Track A Batch Plan (Coherence + Security Hardening)
Generated: 2025-12-27T00:03:45.664034Z

## Inputs
- `docs/triage/_archive/SUBSYSTEM_MAP_v11.md`
- `docs/triage/_archive/ADMIN_MODULE_AUDIT_v11.md`
- `docs/triage/_archive/SECURITY_SURFACE_SWEEP_v11.md`

## Goals (acceptance criteria)
1. **Module loadability:** every module directory under `public_html/modules/` has a `*Module.php` file matching ModuleManager expectations.
2. **Admin coherence:** admin subsystems remain `modules/admin_*` and routing stays explicit.
3. **Security boundary hardening:** common sensitive paths have HTTP deny guardrails (install/config/includes).
4. **No surprise legacy:** legacy components are either removed from active surfaces or clearly quarantined.

## Planned changes
### A) Fix module filename mismatches (stubs where needed)
- Add missing module entrypoint classes for modules flagged in v11 audit.
- Keep implementations minimal: render a placeholder page or enforce admin gating.

### B) HTTP deny guardrails for sensitive directories
- Add `.htaccess` deny rules in `install/`, `config/`, and `includes/`.
- This affects HTTP access only (does not break PHP includes).

### C) Documentation embedding
- Keep triage docs in `docs/triage/_archive/`.
- Add v12 plan + release notes.
