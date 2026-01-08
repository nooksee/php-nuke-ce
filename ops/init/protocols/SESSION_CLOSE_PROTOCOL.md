# Session Close Protocol

## Purpose
Define when the session snapshot artifact must be produced for pause or close.

## Scope
Applies to OCL sessions that pause or close, producing a canonical, operator-facing snapshot.

## Triggers (MUST produce a snapshot)
- Operator explicitly says: "pause", "close", "snapshot", or "save this".
- Operator fatigue or interruption is detected or stated.

## Conduct
- Explicitly forbidden: nagging.
- Explicitly forbidden: over-verbosity.
- Use calm terminal status language, e.g.: "Session safely paused. No drift. No loss."

## Verification
- Not run (operator): confirm trigger coverage and posture.

## Risk+Rollback
- Risk: missed pause/close snapshots reduce resumability.
- Rollback: reinforce triggers and regenerate the snapshot artifact.

## Canon Links
- ops/init/icl/SESSION_SNAPSHOT_OVERVIEW.md
- ops/init/protocols/SNAPSHOT_PROTOCOL.md
- ops/templates/SESSION_SNAPSHOT_TEMPLATE.md
