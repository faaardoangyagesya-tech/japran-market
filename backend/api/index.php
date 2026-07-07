<?php

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

try {
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    )->send();

    $kernel->terminate($request, $response);
} catch (\Throwable $e) {
    header('Content-Type: text/plain');
    http_response_code(500);
    echo get_class($e) . ': ' . $e->getMessage() . "\n";
    echo $e->getFile() . ':' . $e->getLine() . "\n";
    echo "\n\nRegistered providers:\n";
    foreach ($app->getLoadedProviders() as $provider => $loaded) {
        echo ($loaded ? '[x]' : '[ ]') . " $provider\n";
    }
}