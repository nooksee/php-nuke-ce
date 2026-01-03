# Contractor Brief — YYYY-MM-DD

## Objective (1–2 sentences)
- 

## Proposed change (bullet outline)
- 

## Files / areas likely touched (best guess)
- 
- 

## Constraints (must not break)
- Legacy compatibility constraints:
  - 
- Governance constraints:
  - PR-only, repo-gates must pass, no direct pushes to main

## Questions for the Librarian (Gemini)
1. Find all dependencies / call sites impacted by this change.
2. Identify legacy patterns that will collide (globals, hooks, includes, session behavior).
3. Recommend the safest “middle path” if the clean approach breaks modules.

## Deliverable requested from Gemini
- Impact Analysis: affected files + why
- Risk list: what could break + severity
- Suggested implementation order (small PR sequence)

