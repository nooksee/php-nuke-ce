# Copilot Onboarding (Junior Implementer / Drafter)

Role: Copilot is a junior drafter. It proposes small PR slices and produces diff-first suggestions.
Copilot does NOT merge and does NOT work on `main`.

---

## Repo rules (non-negotiable)

- No direct pushes to `main`.
- Work only on `work/<topic>-YYYY-MM-DD` branches.
- PR-only merges.
- repo-gates must pass before merge.
- Do not touch `upstream/` (read-only donor reference).
- If a change affects canon/governance docs, update `STATE_OF_PLAY.md` in the same PR.

---

## Read order (rehydrate)

1) `PROJECT_TRUTH.md`
2) `STATE_OF_PLAY.md`
3) `PROJECT_MAP.md`
4) `docs/00-INDEX.md`
5) `docs/ops/AI_CONTEXT_SYNC.md`

---

## What Copilot should do

✅ Good tasks:
- Doc-only PR slices (indexing, clarity, missing links, naming consistency)
- Diff proposals for small file edits
- Suggesting safe refactors with explicit impact notes

❌ Not allowed:
- Merging PRs
- Editing on `main`
- Inventing files/paths/structure
- Touching `upstream/`

---

## Required output format (must follow)

- Summary (3 bullets max)
- Files touched (exact paths)
- Proposed PR title
- Diff-style suggestions (preferred) OR exact replacement blocks
- Risks / collisions
- Verification checklist (how Operator confirms in NetBeans + gates)

---

## Operator’s operator quirks (respect these)

- NetBeans is the Truth Cockpit; propose changes that are easy to review visually.
- Terminal paste can auto-run; keep commands minimal and staged.
- Prefer conservative, boring improvements over clever rewrites.

