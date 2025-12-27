<?php
declare(strict_types=1);

/*
 * PHP-Nuke CE (Community Edition / Custom Edition)
 * Project name in-code: nukeCE
 */

namespace NukeCE\Modules\AdminModeration;

use NukeCE\Core\ModuleInterface;
use NukeCE\Core\AdminLayout;
use NukeCE\Security\AuthGate;
use NukeCE\Security\Csrf;
use NukeCE\Security\NukeSecurity;
use NukeCE\Moderation\ModerationQueue;

final class AdminModerationModule implements ModuleInterface
{
    public function getName(): string { return 'admin_moderation'; }

    public function handle(array $params): void
    {
        AuthGate::requireAdmin();

        $ok = '';
        $err = '';

        if (isset($_POST['set_status'])) {
            $token = $_POST['_csrf'] ?? null;
            if (!Csrf::validate(is_string($token) ? $token : null)) {
                $err = 'CSRF validation failed.';
            } else {
                $id = (int)($_POST['id'] ?? 0);
                $status = (string)($_POST['status'] ?? 'open');
                $note = (string)($_POST['note'] ?? '');
                $actor = AuthGate::adminUsername();
                if ($id > 0 && in_array($status, ['open','reviewing','resolved','dismissed'], true)) {
                    if (ModerationQueue::setStatus($id, $status, $actor, $note)) {
                        NukeSecurity::log('moderation.status_changed', ['id'=>$id,'status'=>$status,'note'=>$note,'actor'=>$actor]);
                        $ok = 'Updated.';
                    } else $err = 'Update failed.';
                } else $err = 'Invalid input.';
            }
        }

        $filters = [
            'status' => (string)($_GET['status'] ?? ''),
            'type' => (string)($_GET['type'] ?? ''),
            'severity' => (string)($_GET['severity'] ?? ''),
        ];
        $rows = ModerationQueue::list($filters, 200);

        AdminLayout::header('Moderation');
        echo "<h1>Moderation / Triage</h1>";
        echo "<p class='muted'>Unified queue for Forums, Messages, Reference proposals, and security flags. AI assists triage only; humans decide.</p>";

        if ($ok) echo "<div class='ok'>" . htmlspecialchars($ok,ENT_QUOTES,'UTF-8') . "</div>";
        if ($err) echo "<div class='err'>" . htmlspecialchars($err,ENT_QUOTES,'UTF-8') . "</div>";

        echo "<div class='card' style='padding:14px;max-width:1100px'>";
        echo "<form method='get' style='display:flex;gap:10px;flex-wrap:wrap;align-items:end'>";
        echo "<input type='hidden' name='module' value='admin_moderation'>";
        $this->select('Status','status', $filters['status'], [''=>'All','open'=>'Open','reviewing'=>'Reviewing','resolved'=>'Resolved','dismissed'=>'Dismissed']);
        $this->select('Type','type', $filters['type'], [''=>'All','forum_report'=>'Forum report','message_report'=>'Message report','reference_proposal'=>'Reference proposal','security_flag'=>'Security flag']);
        $this->select('Severity','severity', $filters['severity'], [''=>'All','low'=>'Low','medium'=>'Medium','high'=>'High']);
        echo "<button class='btn2' type='submit'>Filter</button>";
        echo "</form></div>";

        echo "<form method='post' class='card' style='padding:0;overflow:hidden;max-width:1100px;margin-top:12px'>";
        echo Csrf::field();
        echo "<table style='width:100%;border-collapse:collapse'>";
        echo "<thead><tr style='background:#f6f7fa'><th style='text-align:left;padding:10px'>ID</th><th style='text-align:left;padding:10px'>Type</th><th style='text-align:left;padding:10px'>Source</th><th style='text-align:left;padding:10px'>Status</th><th style='text-align:left;padding:10px'>Severity</th><th style='text-align:left;padding:10px'>Action</th></tr></thead><tbody>";

        foreach ($rows as $r) {
            $id = (int)($r['id'] ?? 0);
            $type = htmlspecialchars((string)($r['queue_type'] ?? ''), ENT_QUOTES,'UTF-8');
            $srcm = htmlspecialchars((string)($r['source_module'] ?? ''), ENT_QUOTES,'UTF-8');
            $srci = htmlspecialchars((string)($r['source_id'] ?? ''), ENT_QUOTES,'UTF-8');
            $st = htmlspecialchars((string)($r['status'] ?? ''), ENT_QUOTES,'UTF-8');
            $sev = htmlspecialchars((string)($r['severity'] ?? ''), ENT_QUOTES,'UTF-8');
            echo "<tr>";
            echo "<td style='padding:10px;border-top:1px solid #eee'>{$id}</td>";
            echo "<td style='padding:10px;border-top:1px solid #eee'><code>{$type}</code></td>";
            echo "<td style='padding:10px;border-top:1px solid #eee'>{$srcm} #{$srci}</td>";
            echo "<td style='padding:10px;border-top:1px solid #eee'><span class='badge'>{$st}</span></td>";
            echo "<td style='padding:10px;border-top:1px solid #eee'><span class='badge'>{$sev}</span></td>";
            echo "<td style='padding:10px;border-top:1px solid #eee'>";
            echo "<input type='hidden' name='id' value='{$id}'>";
            echo "<select name='status' style='padding:8px;border-radius:10px;border:1px solid #ccc'>";
            foreach (['open','reviewing','resolved','dismissed'] as $s) {
                $sel = $st === $s ? " selected" : "";
                echo "<option value='{$s}'{$sel}>{$s}</option>";
            }
            echo "</select> ";
            echo "<input name='note' placeholder='note' style='padding:8px;border-radius:10px;border:1px solid #ccc;width:200px'> ";
            echo "<button class='btn2' type='submit' name='set_status' value='1'>Update</button>";
            echo "</td></tr>";
        }
        if (!$rows) echo "<tr><td colspan='6' style='padding:12px'>Queue is empty.</td></tr>";
        echo "</tbody></table></form>";

        AdminLayout::footer();
    }

    private function select(string $label, string $name, string $cur, array $opts): void
    {
        echo "<label><span class='muted'>".htmlspecialchars($label,ENT_QUOTES,'UTF-8')."</span><br>";
        echo "<select name='".htmlspecialchars($name,ENT_QUOTES,'UTF-8')."' style='padding:10px;border-radius:12px;border:1px solid #ccc;min-width:180px'>";
        foreach ($opts as $v=>$l) {
            $sel = $cur === $v ? " selected" : "";
            echo "<option value='".htmlspecialchars($v,ENT_QUOTES,'UTF-8')."'{$sel}>".htmlspecialchars($l,ENT_QUOTES,'UTF-8')."</option>";
        }
        echo "</select></label>";
    }
}
