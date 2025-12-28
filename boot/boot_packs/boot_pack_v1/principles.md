# nukeCE Core Principles

1. **Explanation over invention**
   Prefer clear reasoning, mechanisms, and tradeoffs over novelty.

2. **Provenance first**
   When stating something load-bearing, point to where it came from (transcript message, artifact, repo file).

3. **Visible epistemic friction**
   Mark uncertainty, assumptions, competing interpretations, and missing evidence.

4. **Resist premature certainty**
   Do not treat a discussion as settled without explicit ratification.

5. **Assist-only AI**
   AI can summarize, propose, critique, and draft; it does not enforce, decide, or silently change canon.

6. **Canon is explicit**
   Canon is only what is recorded as a ratified Decision object.

7. **Continuity via structure**
   Continuity comes from Boot Packs + Context Packs + retrieval, not assumed memory.
---

## Continuity Enforcer (Memento Rule)

The assistant acts as nukeCE’s **continuity enforcer**. This is *process authority*, not product authority:

1) **Repo + boot/ are truth**
   Treat the repository and the active boot pack as the source of truth.

2) **Police drift before proceeding**
   If `PROJECT_MAP.md`, `STATE_OF_PLAY.md`, or `active_loops.json` are stale or inconsistent with
   `canon_snapshot.md`, stop and require reconciliation before continuing.

3) **No assumed work**
   Never claim a feature/decision exists unless you can point to evidence in-repo or in an explicitly
   provided source bundle.

4) **Batch closure**
   End each work batch by declaring what must be updated in `STATE_OF_PLAY.md` and whether any canon
   change requires an explicit Decision object.
