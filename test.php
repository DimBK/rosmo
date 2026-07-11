<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$items = \App\Models\ServiceRequirement::whereNull('parent_id')->get()->toArray();
echo json_encode($items, JSON_PRETTY_PRINT);
