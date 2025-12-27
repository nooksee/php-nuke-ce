<?php
declare(strict_types=1);


/*
 * PHP-Nuke CE (Community Edition / Custom Edition)
 * Project name in-code: nukeCE
 */

namespace NukeCE\Modules\AdminBlocks;

use NukeCE\Core\ModuleInterface;
use NukeCE\Core\AdminLayout;
use NukeCE\Blocks\BlockManager;
use NukeCE\Security\Csrf;
use NukeCE\Security\NukeSecurity;

/**
 * Blocks Admin (classic workflow, modern UX).
 * - enable/disable
 * - position left/right/center
 * - drag/drop reorder per position
 */
final class AdminBlocksModule implements ModuleInterface
{
    public function getName(): string
    {
        return 'admin_blocks';
    }

    public function handle(array $params): void
    {
        NukeSecurity::log('admin_blocks', 'view');

        $bm = new BlockManager(defined('NUKECE_ROOT') ? NUKECE_ROOT : dirname(__DIR__, 2));
        $state = $bm->getState();
        $msg = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Csrf::requireValid($_POST['_csrf'] ?? '');

            $action = (string)($_POST['action'] ?? 'save');
            if ($action === 'save') {
                $blocks = is_array($_POST['blocks'] ?? null) ? $_POST['blocks'] : [];
                $newBlocks = [];
                foreach ($blocks as $row) {
                    if (!is_array($row)) continue;
                    $id = preg_replace('/[^a-z0-9_]/i', '', (string)($row['id'] ?? ''));
                    if ($id === '') continue;
                    $pos = (string)($row['position'] ?? 'right');
                    if (!in_array($pos, ['left','right','center'], true)) $pos = 'right';
                    $disabled = !empty($row['disabled']);
                    $ttl = (int)($row['cache_ttl'] ?? 0);
                    if ($ttl < 0) $ttl = 0;

                    $newBlocks[] = ['id' => $id, 'position' => $pos, 'disabled' => $disabled];
                }

                $order = [
                    'left' => $this->parseOrder($_POST['order_left'] ?? ''),
                    'right' => $this->parseOrder($_POST['order_right'] ?? ''),
                    'center' => $this->parseOrder($_POST['order_center'] ?? ''),
                ];

                $state['blocks'] = $newBlocks;
                $state['order'] = $order;
                $bm->saveState($state);
                $state = $bm->getState();
                $msg = "<div class='ok'>Saved.</div>";
                NukeSecurity::log('admin_blocks', 'save', ['counts' => count($newBlocks)]);
            }
        }

        $csrf = Csrf::token();
        $available = $bm->listAvailableBlocks();

        // Ensure every available block appears in config at least once
        $existingIds = [];
        foreach (($state['blocks'] ?? []) as $b) if (is_array($b) && !empty($b['id'])) $existingIds[(string)$b['id']] = true;
        foreach ($available as $b) {
            $id = (string)$b['id'];
            if (!isset($existingIds[$id])) {
                $state['blocks'][] = ['id' => $id, 'position' => 'right', 'disabled' => false];
            }
        }

        AdminLayout::header('Blocks Admin');
        echo "<div class='wrap'><div class='card'>";
        echo "<h1 class='h1'><?= AdminLayout::icon('blocks','blocks') ?>Blocks Admin</h1>";
        echo "<p style='margin:0 0 12px 0;opacity:.85'>Enable/disable blocks, set positions, and drag to reorder. Classic Nuke workflow, modern convenience.</p>";
        echo $msg;

        echo "<form method='post' action='/index.php?module=admin_blocks'>";
        echo "<input type='hidden' name='_csrf' value='{$csrf}'>";
        echo "<input type='hidden' name='action' value='save'>";

        echo "<div class='grid' style='grid-template-columns:1.2fr .8fr .8fr;align-items:start'>";
        echo "<div>";
        echo "<h3 style='margin:0 0 8px 0'>Blocks</h3>";
        echo "<div id='blocksList' style='display:grid;gap:8px'>";

        $i = 0;
        foreach (($state['blocks'] ?? []) as $b) {
            if (!is_array($b)) continue;
            $id = htmlspecialchars((string)($b['id'] ?? ''), ENT_QUOTES, 'UTF-8');
            if ($id === '') continue;
            $pos = (string)($b['position'] ?? 'right');
            $dis = !empty($b['disabled']);
            $chk = $dis ? "checked" : "";
            echo "<div class='item' draggable='true' data-id='{$id}' style='border:1px solid #e2e2e2;border-radius:12px;padding:10px;background:#fff'>";
            echo "<div style='display:flex;justify-content:space-between;gap:10px;align-items:center'>";
            echo "<b>{$id}</b>";
            echo "<label style='display:flex;gap:8px;align-items:center;opacity:.9'><input type='checkbox' name='blocks[{$i}][disabled]' value='1' {$chk}>disabled</label>";
            echo "</div>";
            echo "<div style='display:flex;gap:10px;align-items:center;margin-top:8px'>";
            echo "<input type='hidden' name='blocks[{$i}][id]' value='{$id}'>";
            echo "<label>Position</label>";
            echo "<select name='blocks[{$i}][position]'>";
            foreach (['left'=>'Left','center'=>'Center','right'=>'Right'] as $k=>$lbl) {
                $sel = ($pos === $k) ? "selected" : "";
                echo "<option value='{$k}' {$sel}>{$lbl}</option>";
            }
            echo "</select>";
            echo "<span class='muted'><small>Drag to reorder</small></span>";
            echo "</div>";
            echo "</div>";
            $i++;
        }

        echo "</div></div>";

        echo "<div>";
        echo "<h3 style='margin:0 0 8px 0'>Order: Left</h3>";
        echo $this->renderOrderBox('left', $state);
        echo "<h3 style='margin:14px 0 8px 0'>Order: Center</h3>";
        echo $this->renderOrderBox('center', $state);
        echo "<h3 style='margin:14px 0 8px 0'>Order: Right</h3>";
        echo $this->renderOrderBox('right', $state);
        echo "</div>";

        echo "<div>";
        echo "<h3 style='margin:0 0 8px 0'>Notes</h3>";
        echo "<div class='muted'><small>The page layout currently renders the <b>Right</b> column blocks on user pages. Left/Center are supported and reserved for theme upgrades.</small></div>";
        echo "<div style='margin-top:12px'><button class='btn' type='submit'>Save</button> <a href='/index.php' class='btn2'>View site</a></div>";
        echo "</div>";

        echo "</div>"; // grid
        echo "</form>";

        echo "<script>
        (function(){
          const list = document.getElementById('blocksList');
          let dragEl = null;
          list.addEventListener('dragstart', (e)=>{ dragEl = e.target.closest('.item'); if(!dragEl) return; dragEl.style.opacity='0.5'; });
          list.addEventListener('dragend', (e)=>{ if(dragEl) dragEl.style.opacity='1'; dragEl=null; syncOrders(); });
          list.addEventListener('dragover', (e)=>{ e.preventDefault(); const over = e.target.closest('.item'); if(!dragEl || !over || over===dragEl) return;
              const rect = over.getBoundingClientRect(); const next = (e.clientY - rect.top) > (rect.height/2);
              list.insertBefore(dragEl, next ? over.nextSibling : over);
          });
          function syncOrders(){
            const ids = Array.from(list.querySelectorAll('.item')).map(el=>el.getAttribute('data-id'));
            // store same global order into all order boxes for now; per-position ordering can be refined later.
            document.getElementById('order_left').value = ids.join('\\n');
            document.getElementById('order_center').value = ids.join('\\n');
            document.getElementById('order_right').value = ids.join('\\n');
          }
          syncOrders();
        })();
        </script>";

        echo "</div></div>";
        AdminLayout::footer();
    }

    private function renderOrderBox(string $pos, array $state): string
    {
        $k = "order_" . $pos;
        $vals = is_array($state['order'][$pos] ?? null) ? $state['order'][$pos] : [];
        $text = htmlspecialchars(implode("\n", array_map('strval', $vals)), ENT_QUOTES, 'UTF-8');
        return "<textarea id='{$k}' name='{$k}' rows='7' style='width:100%;font-family:ui-monospace,Menlo,monospace;font-size:12px;padding:10px;border:1px solid #ccc;border-radius:12px'>{$text}</textarea>";
    }

    private function parseOrder(string $raw): array
    {
        $raw = str_replace("\r", "", (string)$raw);
        $lines = array_filter(array_map('trim', explode("\n", $raw)));
        $out = [];
        foreach ($lines as $l) {
            $id = preg_replace('/[^a-z0-9_]/i', '', $l);
            if ($id !== '') $out[] = $id;
        }
        return array_values(array_unique($out));
    }
}
