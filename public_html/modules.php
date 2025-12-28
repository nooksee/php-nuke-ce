<?php
declare(strict_types=1);

/**
 * Legacy name redirects (PHP-Nuke compatibility)
 * Keep old URLs alive while nukeCE modernizes internals.
 */
$legacy = [
    'weblinks'      => 'links',
    'Web_Links'     => 'links',
    'WebLinks'      => 'links',
    'encyclopedia'  => 'reference',
    'Encyclopedia'  => 'reference',
    'journal'       => 'blog',     // if you want journal -> blog to be canonical
];

$name = $_GET['name'] ?? $_GET['module'] ?? null;
if (is_string($name)) {
    $name = trim($name);
    if ($name !== '' && isset($legacy[$name])) {
        header('Location: /modules.php?name=' . $legacy[$name], true, 301);
        exit;
    }
}


/**
 * Legacy compatibility bridge:
 * - supports PHP-Nuke style: modules.php?name=links
 * - supports newer style:    index.php?module=links
 */

if (!isset($_GET['module']) && isset($_GET['name'])) {
    $_GET['module'] = $_GET['name'];
}

require_once __DIR__ . '/index.php';
