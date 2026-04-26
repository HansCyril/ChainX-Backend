<?php

try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    header('HTTP/1.1 500 Internal Server Error');
    echo "<h1>500 Internal Server Error</h1>";
    echo "<pre>";
    echo "Message: " . $e->getMessage() . "\n\n";
    echo "Stack Trace:\n" . $e->getTraceAsString();
    echo "</pre>";
    exit;
}
