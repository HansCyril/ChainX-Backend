<?php
try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    http_response_code(500);
    echo '<pre>Caught Exception in Vercel API Bridge: ' . (string) $e . '</pre>';
}
