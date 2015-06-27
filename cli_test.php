<?php

use Four026\Otherspace\Otherspace;

require_once(__DIR__ . '/vendor/autoload.php');

$otherspace = new Otherspace(rand(-90000, 90000) / 1000, rand(-180000, 180000) / 1000);
$output = $otherspace->jsonSerialize();

echo implode("\n\n", $output['locationText']);
echo PHP_EOL.PHP_EOL;
echo implode("\n\n", $output['timeText']);