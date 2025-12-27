<?php
declare(strict_types=1);

/*
 * PHP-Nuke CE (Community Edition / Custom Edition)
 * Project name in-code: nukeCE
 */

namespace NukeCE\Modules\AdminSettings;

use NukeCE\Core\ModuleInterface;
use NukeCE\Core\AdminLayout;
use NukeCE\Security\AuthGate;
use NukeCE\Security\Csrf;
use NukeCE\Security\NukeSecurity;
use NukeCE\Core\SiteConfig;

final class AdminSettingsModule implements ModuleInterface
{
    public function getName(): string { return 'admin_settings'; }

    public function handle(array $params): void
    {
        AuthGate::requireAdmin();

        $tab = (string)($_GET['tab'] ?? 'general');
        $ok = '';
        $err = '';

        if (isset($_POST['save_settings'])) {
            $token = $_POST['_csrf'] ?? null;
            if (!Csrf::validate(is_string($token) ? $token : null)) {
                $err = 'CSRF validation failed.';
            } else {
                $actor = AuthGate::adminUsername();
                try {
                    $changes = $this->applyPost($tab, $actor);
                    foreach ($changes as $c) {
                        NukeSecurity::log('settings.changed', $c + ['actor'=>$actor]);
                    }
                    $ok = $changes ? 'Saved.' : 'No changes.';
                } catch (\Throwable $e) {
                    $err = 'Save failed: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
                }
            }
        }

        if ($tab === 'audit' && isset($_POST['rollback_id'])) {
            $token = $_POST['_csrf'] ?? null;
            if (!Csrf::validate(is_string($token) ? $token : null)) {
                $err = 'CSRF validation failed.';
            } else {
                $id = (int)($_POST['rollback_id'] ?? 0);
                $actor = AuthGate::adminUsername();
                if ($id > 0 && SiteConfig::rollback($id, $actor)) {
                    NukeSecurity::log('settings.rolled_back', ['id'=>$id,'actor'=>$actor]);
                    $ok = 'Rolled back.';
                } else $err = 'Rollback failed.';
            }
        }

        AdminLayout::header('Admin Settings');

        echo "<h1>Settings</h1>";
        echo "<div style='display:flex;gap:10px;flex-wrap:wrap;margin:10px 0 14px'>";
        echo $this->tabLink('general','General',$tab);
        echo $this->tabLink('theme','Theme & UX',$tab);
        echo $this->tabLink('modules','Modules',$tab);
        echo $this->tabLink('email','Email',$tab);
        echo $this->tabLink('security','Security',$tab);
        echo $this->tabLink('caching','Caching',$tab);
        echo $this->tabLink('labels','Labels',$tab);
        echo $this->tabLink('audit','Audit',$tab);
        echo "</div>";

        if ($ok) echo "<div class='ok'>" . htmlspecialchars($ok,ENT_QUOTES,'UTF-8') . "</div>";
        if ($err) echo "<div class='err'>" . htmlspecialchars($err,ENT_QUOTES,'UTF-8') . "</div>";

        echo "<form method='post' class='card' style='padding:14px;max-width:980px'>";
        echo Csrf::field();

        if ($tab === 'audit') { $this->renderAudit(); AdminLayout::footer(); return; }
        if ($tab === 'labels') { $this->renderLabels(); AdminLayout::footer(); return; }

        if ($tab === 'general') $this->renderGeneral();
        elseif ($tab === 'theme') $this->renderTheme();
        elseif ($tab === 'modules') $this->renderModules();
        elseif ($tab === 'email') $this->renderEmail();
        elseif ($tab === 'security') $this->renderSecurity();
        elseif ($tab === 'caching') $this->renderCaching();
        else $this->renderGeneral();

        echo "<div style='margin-top:14px;display:flex;gap:10px;align-items:center'>";
        echo "<button class='btn' type='submit' name='save_settings' value='1'>Save</button>";
        echo "<span class='muted'>Secrets live in <code>config/config.php</code> or environment variables.</span>";
        echo "</div>";
        echo "</form>";

        AdminLayout::footer();
    }

    private function tabLink(string $t, string $label, string $active): string
    {
        $cls = $t === $active ? "btn" : "btn2";
        return "<a class='{$cls}' href='/index.php?module=admin_settings&tab={$t}'>" . htmlspecialchars($label,ENT_QUOTES,'UTF-8') . "</a>";
    }

    /** @return list<array{key:string,old:mixed,new:mixed,type:string}> */
    private function applyPost(string $tab, string $actor): array
    {
        $changes = [];
        $map = $this->fieldMap($tab);
        foreach ($map as $key => $m) {
            $type = $m['type'];
            $post = $m['post'];
            $def = $m['default'];

            if ($type === 'bool') $new = isset($_POST[$post]) && $_POST[$post] === '1';
            elseif ($type === 'int') $new = (int)($_POST[$post] ?? (string)$def);
            else $new = (string)($_POST[$post] ?? (string)$def);

            $old = SiteConfig::get($key, $def);
            if ($old !== $new) {
                SiteConfig::set($key, $new, $type, $actor);
                $changes[] = ['key'=>$key,'old'=>$old,'new'=>$new,'type'=>$type];
            }
        }

        // Locked maintenance behavior: posting is disabled when maintenance enabled
        if (SiteConfig::get('site.maintenance.enabled', false)) {
            SiteConfig::set('site.maintenance.readonly_posting', true, 'bool', $actor, 'locked');
        }

        return $changes;
    }

    private function fieldMap(string $tab): array
    {
        return match ($tab) {
            'general' => [
                'site.name' => ['post'=>'site_name','type'=>'string','default'=>'nukeCE'],
                'site.slogan' => ['post'=>'site_slogan','type'=>'string','default'=>''],
                'site.base_url' => ['post'=>'site_base_url','type'=>'string','default'=>''],
                'site.timezone' => ['post'=>'site_timezone','type'=>'string','default'=>'UTC'],
                'site.language' => ['post'=>'site_language','type'=>'string','default'=>'en'],
                'site.maintenance.enabled' => ['post'=>'maint_enabled','type'=>'bool','default'=>false],
                'site.maintenance.message' => ['post'=>'maint_message','type'=>'string','default'=>'Maintenance in progress.'],
            ],
            'theme' => [
                'theme.default' => ['post'=>'theme_default','type'=>'string','default'=>'nukegold'],
                'theme.allow_user_select' => ['post'=>'theme_allow_user','type'=>'bool','default'=>true],
                'theme.ticker.enabled' => ['post'=>'theme_ticker_enabled','type'=>'bool','default'=>false],
                'theme.ticker.source' => ['post'=>'theme_ticker_source','type'=>'string','default'=>''],
            ],
            'modules' => [
                'modules.forums.enabled' => ['post'=>'mod_forums','type'=>'bool','default'=>true],
                'modules.messages.enabled' => ['post'=>'mod_messages','type'=>'bool','default'=>true],
                'modules.editor.enabled' => ['post'=>'mod_editor','type'=>'bool','default'=>true],
            ],
            'email' => [
                'email.from_name' => ['post'=>'email_from_name','type'=>'string','default'=>'nukeCE'],
                'email.from_address' => ['post'=>'email_from_address','type'=>'string','default'=>''],
                'email.smtp.host' => ['post'=>'email_smtp_host','type'=>'string','default'=>''],
                'email.smtp.port' => ['post'=>'email_smtp_port','type'=>'int','default'=>587],
                'email.smtp.user' => ['post'=>'email_smtp_user','type'=>'string','default'=>''],
            ],
            'security' => [
                'security.mode' => ['post'=>'security_mode','type'=>'string','default'=>'log_only'],
                'security.alert.email' => ['post'=>'security_alert_email','type'=>'string','default'=>''],
                'security.alert.webhook' => ['post'=>'security_alert_webhook','type'=>'string','default'=>''],
            ],
            'caching' => [
                'cache.blocks.ttl' => ['post'=>'cache_blocks_ttl','type'=>'int','default'=>300],
                'cache.force_refresh_roles' => ['post'=>'cache_force_roles','type'=>'bool','default'=>false],
            ],
            default => [],
        };
    }

    private function renderGeneral(): void
    {
        echo "<h2>General</h2>";
        $this->text('Site name','site_name', (string)SiteConfig::get('site.name','nukeCE'));
        $this->text('Slogan','site_slogan', (string)SiteConfig::get('site.slogan',''));
        $this->text('Base URL','site_base_url', (string)SiteConfig::get('site.base_url',''));
        $this->text('Timezone','site_timezone', (string)SiteConfig::get('site.timezone','UTC'));
        $this->text('Language','site_language', (string)SiteConfig::get('site.language','en'));
        $this->checkbox('Maintenance mode (read-only posting)','maint_enabled', (bool)SiteConfig::get('site.maintenance.enabled',false));
        $this->text('Maintenance message','maint_message', (string)SiteConfig::get('site.maintenance.message','Maintenance in progress.'));
    }

    private function renderTheme(): void
    {
        echo "<h2>Theme & UX (Policy)</h2>";
        $this->text('Default theme','theme_default', (string)SiteConfig::get('theme.default','nukegold'));
        $this->checkbox('Allow user theme selection','theme_allow_user', (bool)SiteConfig::get('theme.allow_user_select',true));
        $this->checkbox('Header ticker enabled','theme_ticker_enabled', (bool)SiteConfig::get('theme.ticker.enabled',false));
        $this->text('Ticker source (text)','theme_ticker_source', (string)SiteConfig::get('theme.ticker.source',''));
        echo "<p class='muted'>Theme inventory and diagnostics live in Themes Admin.</p>";
    }

    private function renderModules(): void
    {
        echo "<h2>Modules</h2>";
        $this->checkbox('Forums','mod_forums', (bool)SiteConfig::get('modules.forums.enabled',true));
        $this->checkbox('Messages','mod_messages', (bool)SiteConfig::get('modules.messages.enabled',true));
        $this->checkbox('Editor layer','mod_editor', (bool)SiteConfig::get('modules.editor.enabled',true));
    }

    private function renderEmail(): void
    {
        echo "<h2>Email</h2>";
        $this->text('From name','email_from_name', (string)SiteConfig::get('email.from_name','nukeCE'));
        $this->text('From address','email_from_address', (string)SiteConfig::get('email.from_address',''));
        $this->text('SMTP host','email_smtp_host', (string)SiteConfig::get('email.smtp.host',''));
        $this->text('SMTP port','email_smtp_port', (string)SiteConfig::get('email.smtp.port','587'));
        $this->text('SMTP user','email_smtp_user', (string)SiteConfig::get('email.smtp.user',''));
        echo "<p class='muted'>SMTP password is configured via env/config and never shown.</p>";
    }

    private function renderSecurity(): void
    {
        echo "<h2>Security</h2>";
        $cur = (string)SiteConfig::get('security.mode','log_only');
        echo "<label style='display:block;margin-top:12px'><span class='muted'>Mode</span><br>";
        echo "<select name='security_mode' style='padding:10px;border-radius:12px;border:1px solid #ccc;width:100%;max-width:420px'>";
        foreach (['log_only'=>'Log only','mitigate'=>'Mitigate'] as $v=>$l) {
            $sel = $cur === $v ? " selected" : "";
            echo "<option value='".htmlspecialchars($v,ENT_QUOTES,'UTF-8')."'{$sel}>".htmlspecialchars($l,ENT_QUOTES,'UTF-8')."</option>";
        }
        echo "</select></label>";
        $this->text('Alert email','security_alert_email', (string)SiteConfig::get('security.alert.email',''));
        $this->text('Alert webhook','security_alert_webhook', (string)SiteConfig::get('security.alert.webhook',''));
    }

    private function renderCaching(): void
    {
        echo "<h2>Caching</h2>";
        $this->text('Block cache TTL (seconds)','cache_blocks_ttl', (string)SiteConfig::get('cache.blocks.ttl','300'));
        $this->checkbox('Force refresh roles into Forums cache','cache_force_roles', (bool)SiteConfig::get('cache.force_refresh_roles',false));
    }

    private function renderAudit(): void
    {
        $rows = SiteConfig::history(50);
        echo "<h2>Audit & Rollback</h2>";
        echo "<form method='post' class='card' style='padding:0;overflow:hidden;max-width:980px'>";
        echo Csrf::field();
        echo "<table style='width:100%;border-collapse:collapse'>";
        echo "<thead><tr style='background:#f6f7fa'><th style='text-align:left;padding:10px'>When</th><th style='text-align:left;padding:10px'>Key</th><th style='text-align:left;padding:10px'>By</th><th style='text-align:left;padding:10px'>Action</th></tr></thead><tbody>";
        foreach ($rows as $r) {
            $id = (int)($r['id'] ?? 0);
            $when = htmlspecialchars((string)($r['changed_at'] ?? ''), ENT_QUOTES,'UTF-8');
            $key = htmlspecialchars((string)($r['config_key'] ?? ''), ENT_QUOTES,'UTF-8');
            $by = htmlspecialchars((string)($r['changed_by'] ?? ''), ENT_QUOTES,'UTF-8');
            echo "<tr><td style='padding:10px;border-top:1px solid #eee'>{$when}</td><td style='padding:10px;border-top:1px solid #eee'><code>{$key}</code></td><td style='padding:10px;border-top:1px solid #eee'>{$by}</td>";
            echo "<td style='padding:10px;border-top:1px solid #eee'><button class='btn2' type='submit' name='rollback_id' value='{$id}'>Rollback</button></td></tr>";
        }
        if (!$rows) echo "<tr><td colspan='4' style='padding:12px'>No changes yet.</td></tr>";
        echo "</tbody></table></form>";
    }

    private function text(string $label, string $name, string $value): void
    {
        $v = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        echo "<label style='display:block;margin-top:12px'><span class='muted'>".htmlspecialchars($label,ENT_QUOTES,'UTF-8')."</span><br>";
        echo "<input name='".htmlspecialchars($name,ENT_QUOTES,'UTF-8')."' value='{$v}' style='padding:10px;border-radius:12px;border:1px solid #ccc;width:100%'></label>";
    }

    private function checkbox(string $label, string $name, bool $checked): void
    {
        $c = $checked ? " checked" : "";
        echo "<label style='display:block;margin-top:12px'><input type='hidden' name='".htmlspecialchars($name,ENT_QUOTES,'UTF-8')."' value='0'>";
        echo "<input type='checkbox' name='".htmlspecialchars($name,ENT_QUOTES,'UTF-8')."' value='1'{$c}> ";
        echo htmlspecialchars($label,ENT_QUOTES,'UTF-8') . "</label>";
    }

private function applyLabels(string $actor, array &$changes): void
{
    $map = [
        'label_clubs' => 'label.clubs',
        'label_memberships' => 'label.memberships',
        'label_supporters' => 'label.supporters',
    ];
    foreach ($map as $postKey => $cfgKey) {
        if (!array_key_exists($postKey, $_POST)) continue;
        $val = trim((string)($_POST[$postKey] ?? ''));
        SiteConfig::set($cfgKey, $val, 'string', $actor, 'Admin UI label');
        $changes[] = ['key'=>$cfgKey,'value'=>$val];
    }
}

}
