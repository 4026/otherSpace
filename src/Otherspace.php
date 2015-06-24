<?php
namespace Four026\Otherspace;

use Four026\Phable\Grammar;
use Four026\Phable\Node;
use Four026\Phable\Trace;

class Otherspace implements \JsonSerializable
{
    const LOCATION_NAME_GRAMMAR = '/../location_name.json';
    const LOCATION_TEXT_GRAMMAR = '/../location_text.json';
    const TIME_TEXT_GRAMMAR = '/../time_text.json';

    // The difference in degrees between the latitude of the top of the tile and the bottom of the tile.
    const TILE_HEIGHT_DEG = 0.005;

    /**
     * @var int
     */
    private $location_digest;
    /**
     * @var int
     */
    private $time_digest;
    /**
     * @var string
     */
    private $location_name;
    /**
     * @var array
     */
    private $location_bounds;
    /**
     * @var array
     */
    private $location;

    public function __construct($latitude, $longitude)
    {
        $this->location = ['lat' => $latitude, 'long' => $longitude];

        $tile_width = self::TILE_HEIGHT_DEG / cos(deg2rad($latitude));
        $this->location_bounds = [];
        $this->location_bounds[] = [
            'lat' => floor($latitude / self::TILE_HEIGHT_DEG) * self::TILE_HEIGHT_DEG,
            'long' => floor($longitude / $tile_width) * $tile_width
        ];
        $this->location_bounds[] = [
            'lat' => $this->location_bounds[0]['lat'] + self::TILE_HEIGHT_DEG,
            'long' => $this->location_bounds[0]['long'] + $tile_width
        ];

        $this->location_digest = intval(
            (floor($longitude / $tile_width) % 10000) * 10000
            + floor($latitude / self::TILE_HEIGHT_DEG) % 10000
        );
        $this->time_digest = intval(floor(time() / 3600)) + $this->location_digest;
    }

    /**
     * @return string
     */
    public function getLocationName()
    {
        if (!isset($this->location_name)) {
            $grammar = new Grammar(__DIR__ . self::LOCATION_NAME_GRAMMAR);
            $trace = new Trace($grammar);
            $trace->setSeed($this->location_digest);

            $this->location_name = $trace->getText();
        }

        return $this->location_name;
    }

    /**
     * @return string
     */
    public function getLocationText()
    {
        $grammar = new Grammar(__DIR__ . self::LOCATION_TEXT_GRAMMAR);
        $trace = new Trace($grammar);
        $trace->setSeed($this->location_digest);

        return $trace->getText();
    }
    /**
     * @return string
     */
    public function getTimeText()
    {
        $grammar = new Grammar(__DIR__ . self::TIME_TEXT_GRAMMAR);
        $grammar->addNode('regionName', new Node($this->location_name));
        $trace = new Trace($grammar);
        $trace->setSeed($this->time_digest);

        return $trace->getText();
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     *
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     *       which is a value of any type other than a resource.
     */
    function jsonSerialize()
    {
        return [
            'location' => $this->location,
            'location_bounds' => $this->location_bounds,
            'locationName' => '<p>Your current location in the real world corresponds to the otherspace region that roughly translates as '.$this->getLocationName().'.</p>',
            'locationText' => '<p>'.str_replace("\n\n", "</p><p>", $this->getLocationText()).'</p>',
            'timeText' => '<p>'.$this->getTimeText().'</p>'
        ];
    }
}
