<?php
namespace Four026\Otherspace;

use Four026\Phable\Grammar;
use Four026\Phable\Trace;

class Otherspace
{
    /**
     * @var int
     */
    private $location_digest;

    public function __construct($latitude, $longitude)
    {
        $this->location_digest = (floor($longitude * 1000) % 10000) * 10000 + floor($latitude * 1000) % 10000;
    }

    public function getText()
    {
        $grammar = new Grammar(__DIR__ . '/../grammar.json');
        $trace = new Trace($grammar);
        $trace->setSeed($this->location_digest);

        return $trace->getText();
    }
}