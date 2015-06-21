<?php
/**
 * Endpoint that returns the story for a provided geohash.
 */

require_once(__DIR__ . '/../vendor/autoload.php');

if (!isset($_POST['geohash'])) {
    http_response_code(400);
    die();
}

$geohash = intval($_POST['geohash']);

$grammar = new \Four026\Phable\Grammar(__DIR__ . '/../grammar.json');
$trace = new \Four026\Phable\Trace($grammar);
$trace->setSeed($geohash);

?>
<p><?php echo str_replace("\n\n", "</p><p>", $trace->getText()); ?></p>