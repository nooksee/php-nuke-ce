<?php
declare(strict_types=1);


/*
 * PHP-Nuke CE (Community Edition / Custom Edition)
 * Project name in-code: nukeCE
 */

namespace NukeCE\Core;

final class AdminLayout
{
    public static function header(string $title = 'Admin'): void
    {
        echo "<!doctype html><html lang='en'><head><meta charset='utf-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1'>";
        echo "<title>" . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . "</title>";
        echo "<style>
            body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;margin:0;background:#f6f6f6;color:#111}
            .top{display:flex;justify-content:space-between;align-items:center;padding:14px 18px;background:#111;color:#fff}
            .top a{color:#fff;text-decoration:none;opacity:.9}
            .wrap{max-width:1100px;margin:18px auto;padding:0 14px}
            .card{background:#fff;border:1px solid #e2e2e2;border-radius:14px;padding:14px}
            .grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px}
            textarea,input{box-sizing:border-box}
            code{background:#f1f1f1;padding:2px 6px;border-radius:8px}
            .ico{width:18px;height:18px;vertical-align:-3px;margin-right:8px;opacity:.92}
            .ico-fallback{display:inline-block;width:18px;height:18px;text-align:center;margin-right:8px;opacity:.55}
            .h1{display:flex;align-items:center;gap:8px}
            .btn{padding:10px 14px;border:1px solid #111;border-radius:12px;background:#111;color:#fff;cursor:pointer}
            .btn2{padding:10px 14px;border:1px solid #ccc;border-radius:12px;background:#fff;color:#111;cursor:pointer}
            .ok{padding:10px;border:1px solid #8c8;border-radius:12px;background:#efe}
            .err{padding:10px;border:1px solid #c88;border-radius:12px;background:#fee}
            .badge{display:inline-block;padding:3px 8px;border-radius:999px;border:1px solid #ccc;background:#f6f6f6;font-size:12px}
            .badge.ok{border-color:#8c8;background:#efe}
            .badge.bad{border-color:#c88;background:#fee}
        </style></head><body>";
        echo "<div class='top'><div><b>nukeCE</b> &nbsp;|&nbsp; Admin</div><div style='display:flex;gap:12px;align-items:center;'>
                <a href='/index.php'>Site</a>
                <a href='/index.php?module=admin_forums'>Forums Admin</a>
                <a href='/index.php?module=admin_content'>Pages Admin</a>
                <a href='/index.php?module=admin_reference'>Knowledge Base</a>
                <a href='/index.php?module=admin_blocks'>Blocks</a>
                <a href='/index.php?module=admin_nukesecurity'>NukeSecurity</a>
                <a href='/index.php?module=admin_themes'>Themes</a>
                <a href='/index.php?module=admin_users'>Users &amp; Roles</a>
                <a href='/index.php?module=admin_login&logout=1'>Logout</a>
              </div></div>";
        echo "<div class='wrap'>";
    }

    

public static function icon(string $key, string $alt = ''): string
{
    // Prefer remastered system icon library when available.
    $safe = preg_replace('/[^a-z0-9_\-]/i', '', $key) ?? $key;
    $candidates = [
        "/assets/images/originals/system/src_images/$safe.png",
        "/assets/images/originals/system/src_images/$safe.gif",
        "/assets/images/originals/system/src_images/$safe.jpg",
        "/assets/images/originals/system/legacy_images/$safe.png",
        "/assets/images/originals/system/legacy_images/$safe.gif",
        "/assets/images/originals/system/legacy_images/$safe.jpg",
        // classic fallbacks (if present in old paths)
        "/images/$safe.png",
        "/images/$safe.gif",
    ];

    foreach ($candidates as $url) {
        $fs = dirname(__DIR__, 2) . $url;
        if (is_file($fs)) {
            $a = $alt !== '' ? $alt : $safe;
            return "<img class='ico' src='" . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . "' alt='" . htmlspecialchars($a, ENT_QUOTES, 'UTF-8') . "'>";
        }
    }
    return "<span class='ico ico-fallback' aria-hidden='true'>●</span>";
}

    public static function footer(): void
    {
        echo "</div></body></html>";
    }
}
