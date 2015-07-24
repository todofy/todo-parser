<?php
$SECURE = true;

include __DIR__ .'/../parser.php';

if (!isset($argv[1])) {
	echo "Usage: php <script path> <todo string>";
	exit;
}

$p = new parser($argv[1]);
var_dump($p);