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

\
<?php
declare(strict_types=1);

/*
 * PHP-Nuke CE (Community Edition / Custom Edition)
 * Project name in-code: nukeCE
 */

require_once __DIR__ . '/../src/Core/Model.php';

use NukeCE\Core\Model;

$pdo = Model::db();
$tn = fn(string $t) => Model::tn($t);

$queries = [];

$queries[] = "CREATE TABLE IF NOT EXISTS `{$tn('users')}` (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  username VARCHAR(60) NOT NULL,
  email VARCHAR(190) NOT NULL,
  pass_hash VARCHAR(255) NOT NULL,
  role ENUM('member','editor','admin') NOT NULL DEFAULT 'member',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  last_login DATETIME NULL,
  UNIQUE KEY uq_username (username),
  UNIQUE KEY uq_email (email),
  KEY idx_role (role),
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

$ok = 0; $errs = [];
foreach ($queries as $sql) {
  try { $pdo->exec($sql); $ok++; }
  catch (Throwable $e) { $errs[] = $e->getMessage(); }
}

header('Content-Type: text/plain; charset=utf-8');
echo "Users/roles setup complete. OK statements: {$ok}/" . count($queries) . "\n";
if ($errs) echo "\nErrors:\n- " . implode("\n- ", $errs) . "\n";
