<?php
// nukeCE install guard: require explicit allow flag
$allow = __DIR__ . '/../config/ALLOW_INSTALL';
if (!is_file($allow)) {
    http_response_code(403);
    header('Content-Type: text/plain; charset=utf-8');
    echo "Installer is locked. To run installer, create: public_html/config/ALLOW_INSTALL\n";
    echo "Remove it immediately after installation.\n";
    exit;
}
?>

<?php
declare(strict_types=1);


/*
 * PHP-Nuke CE (Community Edition / Custom Edition)
 * Project name in-code: nukeCE
 */

define('NUKECE_ROOT', realpath(__DIR__ . '/..') ?: (__DIR__ . '/..'));

require_once NUKECE_ROOT . '/autoload.php';

use NukeCE\Security\NukeSecurityConfig;

$cfg = NukeSecurityConfig::load(NUKECE_ROOT);
NukeSecurityConfig::save(NUKECE_ROOT, $cfg);

echo "Wrote " . NukeSecurityConfig::FILE . "\n";
if (!empty($cfg['compat']['legacy_php_sources'])) echo "Legacy PHP sources: " . implode(', ', $cfg['compat']['legacy_php_sources']) . "\n";
if (!empty($cfg['compat']['legacy_db_sources'])) echo "Legacy DB sources: " . implode(', ', $cfg['compat']['legacy_db_sources']) . "\n";

if (!empty($cfg['compat']['migrated'])) {
    echo "Migrated from: " . implode(', ', (array)($cfg['compat']['migrated_from'] ?? [])) . "\n";
} else {
    echo "No legacy sources detected.\n";
}
