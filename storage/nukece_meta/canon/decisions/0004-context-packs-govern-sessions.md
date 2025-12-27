# D-0004 — Context Packs govern sessions

**Status:** ratified  
**Effective:** 2025-12-25

## Decision
Every working session runs under an explicit **Context Pack** that defines:
- active campaign/module scope
- binding constraints
- canon snapshot pointers
- working set (open loops + active artifacts)

## Rationale
Enables continuity via structure (not memory) and prevents drift in fresh chats.

## Implications
- A “Control Room” session starts by loading a Context Pack
- Retrieval is scoped by the pack’s policy (token budget, rank weights, evidence rules)

## Evidence (transcript pointers)
See reference node: `reference/nodes/context-pack.md`
