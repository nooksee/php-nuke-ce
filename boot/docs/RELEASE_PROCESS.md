# Release process (clean version)

nukeCE ships in **batches**, not a drip of tiny patches.

## Normal workflow
1. Work on `work/*`
2. Open PR
3. `repo-gates` must pass
4. Merge to `main`

## Release train
- Collect merged PRs into a release batch.
- Produce a complete bundle (webroot + boot bundle).
- Keep patch clutter minimal; use a patch queue only when necessary.

See also:
- `docs/releases/00-index.md`
