<?php

$files = ['database/seeders/ServiceSeeder.php', 'database/seeders/ProjectSeeder.php'];

foreach ($files as $f) {
    $content = file_get_contents($f);
    $content = str_replace(['<p>', '</p>'], '', $content);
    file_put_contents($f, $content);
}

echo "Done\n";
