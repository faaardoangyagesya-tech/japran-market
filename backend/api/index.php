<?php

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

try {
    // Test what providers are configured
    $providers = $app->make('config')->get('app.providers', []);
    header('Content-Type: text/plain');
    echo "Configured providers:\n";
    foreach ($providers as $p) {
        echo "  - $p\n";
    }
    echo "\nHas view binding: " . ($app->has('view') ? 'yes' : 'no') . "\n";
    exit;
} catch (\Throwable $e) {
    header('Content-Type: text/plain');
    http_response_code(500);
    echo get_class($e) . ': ' . $e->getMessage() . "\n";
    echo $e->getFile() . ':' . $e->getLine() . "\n";
}
