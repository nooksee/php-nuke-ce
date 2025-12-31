# nukeCE Daily Cockpit Plan

This is the **NetBeans-first** operating rhythm for nukeCE.

Terminal is allowed, but it’s the *gate button*, not the steering wheel.

## Prime directive

- **No direct pushes to `main`.**
- Work happens on `work/*` branches → PR → **repo-gates green** → merge.
- If anything feels unclear: stop, screenshot, and review visually in NetBeans.

## 0) Pre-flight (2 minutes)

1. **Confirm branch** (top-left project title):
   - You should *not* be editing on `main`.

2. **Pull latest `main`** (safe):
   - NetBeans: `Team → Remote → Pull…`
   - (Terminal alternative): `git pull --ff-only`

3. **Open your changes view**
   - NetBeans: `Team → Show Changes` (this is the reliable “Local Changes” view)

### Terminal safety habit (every time)

Commands can take **30–90 seconds**. If there’s no prompt, it’s still running.

- `Ctrl+C` stops a running command.
- `Ctrl+U` clears the current command line (before Enter).

**Copy/paste rule (use every time):**
1. Paste into a scratch editor tab first ✅
2. Eyeball it ✅
3. Copy → paste into terminal, confirm it’s one line, then press Enter ✅

## 1) Start work (NetBeans-first)

### Create a work branch

- `Team → Git → Branch → Create Branch…`
- Naming: `work/<topic>-YYYY-MM-DD`
- ✅ Checkout branch

### Edit normally

- Keep changes small and focused.
- Prefer editing only what the PR is about.

### Review diffs

- Whole project: `Team → Show Changes`
- One file: right-click file → `Git → Diff`

## 2) Commit (small, descriptive)

- `Team → Commit…`
- Stage only what belongs in this PR.
- Message format:
  - `docs: ...`
  - `ci: ...`
  - `chore: ...`
  - `feat: ...`
  - `fix: ...`

## 3) Run gates (local)

Run these from repo root (NetBeans terminal tab is fine):

- `bash tools/verify_tree.sh`
- `bash tools/repo/lint_truth.sh`

If a gate fails: do not “force it”. Fix the issue, re-run, then commit.

## 4) Push + PR

### Push

- `Team → Remote → Push…`
- Choose the **current `work/*` branch** only.

If NetBeans asks to “set up remote tracking”: choose **Yes**.

### Open PR on GitHub

- GitHub usually shows **“Compare & pull request”**
- Title: short and specific
- Description: what changed + why + how to verify

Wait for **repo-gates** to go green, then merge.

## 5) Post-merge hygiene

- Switch to `main`
- Pull latest `main`
- Close any stale work branches (local + remote) when safe

## Optional: include paths (NetBeans)

nukeCE’s deployable webroot is `public_html/`. For PHP code completion, include paths typically point to subfolders like:

- `public_html/includes`
- `public_html/modules`
- `public_html/admin`

Avoid adding `public_html/` itself as an include path if NetBeans warns it’s already part of the project.
