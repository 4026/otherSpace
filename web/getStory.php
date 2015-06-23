<?php
/**
 * Endpoint that returns the story for a provided geohash.
 */

use Four026\Otherspace\Otherspace;

require_once(__DIR__ . '/../vendor/autoload.php');

if (!isset($_POST['lat']) || !isset($_POST['long'])) {
    http_response_code(400);
    die();
}

$otherspace = new Otherspace(floatval($_POST['lat']), floatval($_POST['long']));
?>
<p><?php echo str_replace("\n\n", "</p><p>", $otherspace->getText()); ?></p>