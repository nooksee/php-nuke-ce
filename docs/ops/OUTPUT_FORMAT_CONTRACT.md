# Output Format Contract (Canonical)

Purpose: eliminate ambiguity between “explanation” text and “verbatim copy/paste” payloads.
If a response violates this contract, treat it as non-authoritative and request a corrected output.

---

## Non-negotiables (repo + operator)

- No direct pushes to `main`.
- Work happens only on `work/<topic>-YYYY-MM-DD` branches.
- PR-only merges.
- repo-gates must pass before merge.
- `upstream/` is read-only donor reference.
- If canon/governance changes, update `STATE_OF_PLAY.md` in the same PR.
- Operator is visual-first: NetBeans is the Truth Cockpit.
- Terminal paste can auto-run: commands must be provided in small, labeled blocks; pause after each and request the output.
- Warn when a command may take time or look “stuck”.

---

## Required response structure (every time)

### A) What/Why (explainer)
Human explanation. Not meant to be pasted. Can include rationale, sequencing, and risk notes.

### B) COPY/PASTE (verbatim)
Everything in this section must be safe to paste exactly as-is.
If it contains commands, they must be presented as either:
- a single command line, or
- a small block (max ~3–5 lines), clearly labeled (Block 1, Block 2, etc.)

---

## Marker rules (hard requirement)

All verbatim payloads MUST be wrapped like this:

COPY EVERYTHING BETWEEN THE LINES
<exact payload>
STOP COPYING

No other text may appear inside the markers.

---

## Terminal command rules (Operator safety profile)

When giving terminal commands:
- Provide one small block at a time.
- After each block: explicitly request the output before continuing.
- Prefer “type, don’t paste” when the command is risky or easy to mistype.
- Include an “it may take a moment” warning for scripts that can run 30–90 seconds.
- Never provide huge mystery blobs.

Emergency controls to mention when relevant:
- Ctrl+C stops a running command
- Ctrl+U clears the current command line

---

## File naming note (Daily Cockpit exports)

When generating/exporting the daily operating plan, use:
- Title: `nukeCE Daily Cockpit — YYYY-MM-DD`
- If archived in-repo later: prefer `docs/ops/log/YYYY-MM-DD.md` (log) while canon stays in stable docs.

