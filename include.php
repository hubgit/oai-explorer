<?php

ini_set('display_errors', true);

$config = parse_ini_file(__DIR__ . '/config.ini');

function h($text) {
	print htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

