<?php

require_once(__DIR__ . '/vendor/autoload.php');

$grammar = new \Four026\Phable\Grammar('location_text.json');
$trace = new \Four026\Phable\Trace($grammar);

echo $trace->getText();