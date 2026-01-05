# PR Description Template (canonical)

Purpose: Ensure every PR is self-documenting, reviewable, and reversible.

Use this template in:
- GitHub PR description (auto-filled via .github/pull_request_template.md)
- Any work handoff to assistants/contractors (copy/paste)

---

If a field exists, fill it minimally but meaningfully.

## Purpose
- One sentence on the goal or problem.

## What shipped
- Bullet list of concrete changes (file-level is fine).

## Scope
- Exact paths/files touched.

## Verification
- repo-gates (pass/fail + notes).
- Manual checks (if any).

## Risk+Rollback
- Risk: top risk in one line.
- Rollback: revert merge commit.

## Canon updates
- Updated `STATE_OF_PLAY.md` when doctrine/governance changes.
