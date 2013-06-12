<?php

include 'Bootstrap.php';

class DistanceTest extends PHPUnit_Framework_TestCase {

    private $_distance;

    public function setUp() {

        $this->_distance   = new \CabJourney\Distance();
        $this->_rows       = array(
            (object) array('timestamp' => '1326378723', 'latitude' => '51.498405862027', 'longitude' => '-0.16040688237893'),
            (object) array('timestamp' => '1326378728', 'latitude' => '51.497405862050', 'longitude' => '-0.16040688237899'),
            (object) array('timestamp' => '1326378739', 'latitude' => '52.498714933833', 'longitude' => '-0.16011779913771'),

            (object) array('timestamp' => '1326380277', 'latitude' => '51.52604328', 'longitude' => '-0.134107499'),
            (object) array('timestamp' => '1326380295', 'latitude' => '51.52465902', 'longitude' => '-0.127673149'),
            (object) array('timestamp' => '1326380305', 'latitude' => '51.52611605', 'longitude' => '-0.133932187'),
        );

    }

    /**
     * @method testEarthRadiusIsCorrect
     * Test that the earth's radius has not been changed.
     */
    public function testEarthRadiusIsCorrect() {
        $this->assertEquals(\CabJourney\Distance::EARTH_RADIUS_MILES, 3959);
    }

    /**
     * @method testThatAPlausibleSpeedIsValid
     * Test that if a plausible speed for the distance covered is valid.
     */
    public function testThatAPlausibleSpeedIsValid() {

        $currentRow     = $this->_rows[1];
        $previousRow    = $this->_rows[0];

        // Won't be filtered out.
        $this->assertTrue($this->_distance->filter($currentRow, $previousRow, null));

    }

    /**
     * @method testDetectionOfAGPSAnomalie
     * Test to find anomalies in the GPS coordinates.
     */
    public function testDetectionOfAGPSAnomalie() {

        $currentRow     = $this->_rows[4];
        $previousRow    = $this->_rows[3];
        $nextRow        = $this->_rows[5];

        // Won't be filtered out.
        $this->assertFalse($this->_distance->filter($currentRow, $previousRow, $nextRow));

    }

    /**
     * @method testDetectionOfAGPSAnomalie
     * Test that if an implausible speed for the distance covered is invalid.
     */
    public function testThatAImplausibleSpeedIsInvalid() {

        $currentRow     = $this->_rows[2];
        $previousRow    = $this->_rows[1];

        // Will be filtered out.
        $this->assertFalse($this->_distance->filter($currentRow, $previousRow, null));

    }

}