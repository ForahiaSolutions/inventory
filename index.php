<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 1. Maintenance Mode
if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// 2. Autoloader (Fixed path: no longer using ../)
require __DIR__.'/vendor/autoload.php';

// 3. Bootstrap (Fixed path: no longer using ../)
/** @var Application $app */
$app = require_once __DIR__.'/bootstrap/app.php';

// Temporary debug utility to clear Laravel route/config cache in production
if (isset($_GET['clear_cache']) && $_GET['clear_cache'] === 'forahia123') {
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $status = $kernel->call('optimize:clear');
    echo "Stale Cache Cleared! Status: " . $status;
    exit;
}

// 4. Handle Request
$app->handleRequest(Request::capture());
