<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
try {
    \Illuminate\Support\Facades\Artisan::call('route:list', ['--name' => 'admin.service_requirements']);
} catch (\Throwable $e) {
    file_put_contents('error.log', $e->getMessage() . "\n" . $e->getFile() . "\n" . $e->getTraceAsString());
}
