<?php

require_once(__DIR__ . '/vendor/autoload.php');

$grammar = new \Four026\Phable\Grammar('grammar.json');
$trace = new \Four026\Phable\Trace($grammar);

echo $trace->getText();