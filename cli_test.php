<?php

use Four026\Otherspace\Otherspace;

require_once(__DIR__ . '/vendor/autoload.php');

$otherspace = new Otherspace(rand(-90000, 90000) / 1000, rand(-180000, 180000) / 1000);
$output = $otherspace->jsonSerialize();

echo str_replace(array('<p>', '</p>'), array('', "\n\n"), $output['locationName']);
echo str_replace(array('<p>', '</p>'), array('', "\n\n"), $output['locationText']);
echo str_replace(array('<p>', '</p>'), array('', "\n\n"), $output['timeText']);