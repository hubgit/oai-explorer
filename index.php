<?php
require __DIR__ . '/include.php';
$parts = array_filter(explode('/', $_GET['_path']));
if (!$parts) $parts[0] = 'forms';
require $parts[0] . '/index.php';
