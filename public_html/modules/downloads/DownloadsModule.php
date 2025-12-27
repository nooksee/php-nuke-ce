<?php
/*
 * PHP-Nuke CE (Community Edition / Custom Edition)
 * Project name in-code: nukeCE
 */

namespace NukeCE\Modules\Downloads;

use NukeCE\Core\ModuleInterface;
use NukeCE\Core\Model;
use PDO;

/**
 * Downloads module lists files for users to download. In the future it
 * could support categories, ratings and submission forms.
 */
class DownloadsModule extends Model implements ModuleInterface
{
    public function getName(): string
    {
        return 'downloads';
    }

    public function handle(array $params): void
    {
        $pdo = $this->getConnection();
        $stmt = $pdo->query('SELECT id, title, description, url FROM downloads ORDER BY id DESC');
        $files = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Downloads</title></head><body>';
        echo '<h1>Downloads</h1>';
        if ($files) {
            echo '<ul>';
            foreach ($files as $file) {
                $title = htmlspecialchars($file['title']);
                $desc = htmlspecialchars($file['description']);
                $url = htmlspecialchars($file['url']);
                echo '<li><a href="' . $url . '" target="_blank">' . $title . '</a><br><small>' . $desc . '</small></li>';
            }
            echo '</ul>';
        } else {
            echo '<p>No downloads available.</p>';
        }
        echo '<p><a href="/index.php">Back to home</a></p>';
        echo '</body></html>';
    }
}