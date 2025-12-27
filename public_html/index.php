<?php
/*
 * PHP-Nuke CE (Community Edition / Custom Edition)
 * Project name in-code: nukeCE
 */
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    @session_start();
}


define('NUKECE_ROOT', __DIR__);
\1
require_once NUKECE_ROOT . '/includes/security_gate.php';

use NukeCE\Core\ModuleManager;
use NukeCE\Core\Router;

$env = getenv('NUKECE_ENV') ?: 'prod';
if ($env !== 'prod') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
    ini_set('display_errors', '0');
}

$manager = new ModuleManager(NUKECE_ROOT . '/modules');
$router = new Router($manager);
$router->dispatch();
