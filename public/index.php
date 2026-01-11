<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../app/Core/Autoloader.php';

use App\Core\App;
use App\Core\Autoloader;

Autoloader::register();

$app = new App();
$app->run();