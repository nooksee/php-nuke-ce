# Triage Inbox (allowed to be messy)

Purpose: Capture ideas fast without losing them or polluting canon.
Rule: If it’s not linked from an index OR listed here, it’s drift.

## How to use
- Add new ideas here immediately.
- Each entry must have: why it exists + next action + status.
- Promote to canon only when you deliberately “graduate” it:
  - move into the right docs/ area
  - link it from docs/00-INDEX.md and the relevant sub-index
  - log it in STATE_OF_PLAY.md

## Status values
- INBOX (new)
- PROMOTE (ready to become canon)
- PROTOTYPE (try it in code/docs first)
- ARCHIVE (keep but out of the way)
- DELETE (not worth keeping)

---

## Entry template
- Title:
  - Why:
  - Status: INBOX
  - Next action:
  - Owner:
  - Last touched: YYYY-MM-DD
  - Links:

---

## Inbox items
- (none yet)

## Doctrine: Guerrilla Metadata Surfaces (always-on)

**Rule:** If a field exists, we fill it — minimally but meaningfully.  
**Goal:** faster work, less re-explaining, stronger repo narrative, better future-us.

### Surfaces we always use
- GitHub PR: Title + Description (Markdown)
- GitHub PR sidebar: Assignee = self; Labels (if available)
- GitHub merge dialog: Commit message + Extended description (never blank)
- GitHub PR comment: “Merge note” (Markdown) on merge
- IDE dialogs (NetBeans): branch names, commit messages, etc. (never blank)

### Default Markdown structure (use everywhere)
Purpose / What shipped / Verification / Risk + Rollback  
Even tiny PRs get a short version.
