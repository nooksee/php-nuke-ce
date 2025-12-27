# nukeCE Patch System — Gold Process (Release Train)

We use a release train:
- batch work during a sprint
- ship a full public_html + boot bundle release (v10, v11...)
- keep patch clutter minimal

Core rule:
Never edit history. Always patch forward (in the sprint queue), then cut a release bundle.

Structure:
- patches/queue/              temporary sprint patches only (keep small)
- patches/releases/v10/       archived patches used for the v10 cut (optional)

Most of the time you will ship full bundles; patches exist only when needed for
renames/deletes/migrations that cannot be expressed safely as simple overlays.
