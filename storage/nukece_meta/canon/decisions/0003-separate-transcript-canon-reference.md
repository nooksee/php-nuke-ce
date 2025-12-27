# D-0003 — Separate transcript, canon, and reference

**Status:** ratified  
**Effective:** 2025-12-25

## Decision
Maintain structural separation between:
- **Transcripts** (raw evidence, append-only)
- **Canon** (ratified decisions)
- **Reference** (curated explanatory knowledge objects)

## Rationale
Prevents contamination, preserves provenance, and supports long-term auditability.

## Implications
- Transcripts are immutable
- Reference nodes must cite transcript/artifact sources
- Canon changes only through Decisions

## Evidence (transcript pointers)
See reference node: `reference/nodes/knowledge-layers.md`
