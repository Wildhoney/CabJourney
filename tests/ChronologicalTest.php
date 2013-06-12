<?php

include 'Bootstrap.php';

class ChronologicalTest extends PHPUnit_Framework_TestCase {

    private $_chronological;

    public function setUp() {

        $this->_chronological   = new \CabJourney\Chronological();
        $this->_rows            = array(
            (object) array('timestamp' => '1326378723'),
            (object) array('timestamp' => '1326378724'),
            (object) array('timestamp' => '1326378721')
        );

    }

    /**
     * @method testThatAValidSequentialDateIsValid
     * Tests that a chronological date is accepted.
     */
    public function testThatAValidSequentialDateIsValid() {

        $currentRow     = $this->_rows[1];
        $previousRow    = $this->_rows[0];

        // Won't be filtered out.
        $this->assertTrue($this->_chronological->filter($currentRow, $previousRow, null));

    }

    /**
     * @method testThatAnInvalidSequentialDateIsInvalid
     * Tests that a non-chronological date is accepted.
     */
    public function testThatAnInvalidSequentialDateIsInvalid() {

        $currentRow     = $this->_rows[2];
        $previousRow    = $this->_rows[1];

        // Will be filtered out.
        $this->assertFalse($this->_chronological->filter($currentRow, $previousRow, null));

    }

}