<?php

try {
    require __DIR__.'/../public/index.php';
} catch (\Throwable $e) {
    header('Content-Type: text/plain');
    http_response_code(500);
    echo get_class($e) . ': ' . $e->getMessage() . "\n";
    echo $e->getFile() . ':' . $e->getLine() . "\n";
}
