# AI Context Sync (SSOT “save game”)

> Purpose: a single file Kevin can paste to Copilot/Gemini/ChatGPT to rehydrate context fast.

## Legend
- 🆕 New today
- 🧱 Carry-over (unchanged; referenced by ID)
- ✅ Done (move to Completed)
- ❗ Blocker

## Date
2026-01-02

## Rehydration (source of truth)
Any fresh AI can rehydrate from:
1) PROJECT_TRUTH.md
2) STATE_OF_PLAY.md
3) PROJECT_MAP.md
4) docs/00-INDEX.md
…plus this file as the “save game”.

**Optional:** Rehydration drill is a *test*, not a ritual. Run it only when onboarding a new AI surface or debugging drift.

## Daily cockpit (not the truth ledger)
docs/ops/DAILY_COCKPIT.md is the operating rhythm checklist.
No project truth should live only in a cockpit. If something becomes policy/structure, promote it into the truth-layer docs above.

## Current deliverable PR
`work/docs-canon-coherency-2026-01-01` → merge into `main`

## Active items (ID-based)
- 🧱 [T-001] Merge the docs-canon-coherency PR (repo-gates green → merge).
- 🆕 [T-002] Thicken PROJECT_MAP.md with: docs/ops/, upstream/, .github/workflows/ locations.
- 🆕 [T-003] Copilot “first contact” PR: doc-only improvements (no runtime changes).

## Blockers
- ❗ [B-001] repo-gates (FAIL-mode) blocking PR until STATE_OF_PLAY update is committed + pushed.

## Repo rules (non-negotiable)
- No direct pushes to `main`
- Work branches only: `work/*`
- PR-only merges
- repo-gates must pass

## Contractor briefing request phrase
When Kevin says: **“Prepare a briefing for the contractor”**
- respond with a concise impact-aware briefing suitable to paste into Gemini (full-repo auditor)

## Deferred ideas (explicitly NOT doing now)
- Daily cockpit archiving/logging: not implementing right now.
  (If ever revisited later, it should be summaries only — never canonical truth.)
