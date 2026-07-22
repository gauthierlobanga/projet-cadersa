<?php
require __DIR__ . "/vendor/autoload.php";
$app = require __DIR__ . "/bootstrap/app.php";
$app->loadEnvironmentFrom(".env.testing");
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->call("migrate", ["--force" => true]);
$kernel->call("db:seed", ["--force" => true]);
echo "migrated\n";
