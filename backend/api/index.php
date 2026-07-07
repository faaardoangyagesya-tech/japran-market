<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('log_errors', '1');

register_shutdown_function(function () {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        header('Content-Type: text/plain');
        http_response_code(500);
        echo "Fatal Error: " . $error['message'] . "\n";
        echo "File: " . $error['file'] . ":" . $error['line'] . "\n";
    }
});

set_error_handler(function ($severity, $message, $file, $line) {
    header('Content-Type: text/plain');
    http_response_code(500);
    echo "Error [$severity]: $message in $file:$line\n";
    return true;
});

try {
    require __DIR__.'/../public/index.php';
} catch (\Throwable $e) {
    if (!headers_sent()) {
        header('Content-Type: text/plain');
        http_response_code(500);
    }
    echo "Exception: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo $e->getTraceAsString() . "\n";
}
