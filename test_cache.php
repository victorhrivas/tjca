<?php
$path = __DIR__ . '/bootstrap/cache';

echo "is_dir: ";
var_dump(is_dir($path));

echo "\nis_writable: ";
var_dump(is_writable($path));
