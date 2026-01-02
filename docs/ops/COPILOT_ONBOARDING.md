# Copilot Onboarding (Junior Implementer) — YYYY-MM-DD

## Role
Copilot is a drafting engine. It proposes diffs and small PR slices.
Kevin reviews visually in NetBeans and merges via PR only.

## Non-negotiables (repo truth)
- No direct pushes to `main`.
- Work happens on `work/<topic>-YYYY-MM-DD`.
- PR-only merges.
- `repo-gates` must be green.
- If a change affects canon/governance docs, update `STATE_OF_PLAY.md` in the same PR.

## Workflow (safe)
1) Copilot proposes a *small* change set (1 purpose).
2) Kevin reviews in NetBeans (diff + tree impact).
3) Run repo-gates (CI) via PR.
4) Merge only when green.

## PR slicing rules
- Prefer 1–3 file touches per PR when possible.
- Separate “rename/move” PRs from “behavior change” PRs.
- Documentation/governance PRs must say so clearly.

## Copilot output format
Copilot should always output:
- Proposed change summary
- Files touched (list)
- Risks / collisions
- Suggested PR title

