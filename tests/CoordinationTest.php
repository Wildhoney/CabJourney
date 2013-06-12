<?php

include 'Bootstrap.php';

class CoordinationTest extends PHPUnit_Framework_TestCase {

    private $_coordination;

    public function setUp() {

        $this->_coordination    = new \CabJourney\Coordination();
        $this->_rows            = array(
            (object) array('latitude' => '51.498405862027', 'longitude' => '-0.16040688237893'),
            (object) array('latitude' => '51.498405862027', 'longitude' => '-0.16040688237893'),
            (object) array('latitude' => '51.498714933833', 'longitude' => '-0.16011779913771'),
            (object) array('latitude' => '51.498714933834', 'longitude' => '-0.16011779913771'),
            (object) array('latitude' => '51.498714933834', 'longitude' => '-0.16011779913772')
        );

    }

    /**
     * @method testThatUniqueLatitudeAndLongitudeIsValid
     * Tests that a unique latitude/longitude is valid.
     */
    public function testThatUniqueLatitudeAndLongitudeIsValid() {

        $currentRow     = $this->_rows[2];
        $previousRow    = $this->_rows[1];

        // Won't be filtered out.
        $this->assertTrue($this->_coordination->filter($currentRow, $previousRow, null));

    }

    /**
     * @method testThatUniqueLatitudeIsValid
     * Tests that a unique latitude is valid.
     */
    public function testThatUniqueLatitudeIsValid() {

        $currentRow     = $this->_rows[2];
        $previousRow    = $this->_rows[3];

        // Won't be filtered out.
        $this->assertTrue($this->_coordination->filter($currentRow, $previousRow, null));

    }

    /**
     * @method testThatUniqueLongitudeIsValid
     * Tests that a unique longitude is valid.
     */
    public function testThatUniqueLongitudeIsValid() {

        $currentRow     = $this->_rows[3];
        $previousRow    = $this->_rows[4];

        // Won't be filtered out.
        $this->assertTrue($this->_coordination->filter($currentRow, $previousRow, null));

    }

    /**
     * @method testThatDuplicateLatitudeAndLongitudeIsInvalid
     * Tests that a duplicate latitude/longitude is invalid.
     */
    public function testThatDuplicateLatitudeAndLongitudeIsInvalid() {

        $currentRow   = $this->_rows[1];
        $previousRow  = $this->_rows[0];

        // Won't be filtered out.
        $this->assertFalse($this->_coordination->filter($currentRow, $previousRow, null));

    }

}