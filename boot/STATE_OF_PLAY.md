# STATE_OF_PLAY — nukeCE
Date: 2025-12-28
Branch: develop

Policing: If this file is older than the last meaningful code change, the assistant must halt and require an update
before proceeding.

## 1. Last Known Good State
- Router is canonical: supports ?module= and /<module>/... paths.
- Canonical core modules: links, reference, blog, downloads, forums.
- Legacy stubs/quarantine pattern established (modules/_legacy + thin stubs).
- Addons strategy: repo-root /addons (not webroot).

## 2. Completed Since Last Update
- Added PROJECT_MAP + STATE_OF_PLAY living documents (Memento memory surfaces).
- v30: addons separation (faq, surveys, statistics, top, recommend) by moving source to /addons/optional and leaving stubs in public_html/modules.
- Hardened legacy redirects to match Router (?module= / path routing) instead of older name= routing.
- Moved addon packages out of webroot: public_html/addons/modules → addons/modules and denied web access to public_html/addons.

## 3. Active Issues / Friction
- Need forensic merge pass: reconcile “missing work” (editor rewrite, AI strategy surfaces) across historical bundles vs current repo.
- Need Memento-style tooling: one-command report to classify modules and detect ghosts/case conflicts.

## 4. Current Track
Track C — Addons Separation + Memento Forensics

## 5. Next Actions (Priority Order)
1. Build tools/inventory_memento.sh report and use it to drive cleanup decisions.
2. Forensic diff: compare historical bundles (phase2/omnibus) against current repo and selectively import missing, canon-consistent improvements.
3. Update active_loops.json with concrete tasks + IDs for the above.

## 6. Notes for Next Session
- Do not resurrect weblinks/encyclopedia/journal/avantgo as live modules; they are legacy stubs only.
- When uncertain, prefer evidence pointers (paths + diffs) over memory.
