<?php

include 'Bootstrap.php';

class CSVProcessorTest extends PHPUnit_Framework_TestCase {

    private $_csvProcessor;

    public function setUp() {
        $this->_csvProcessor = new \CabJourney\CSVProcessor();
    }

    /**
     * @method testThatCSVProcessorCanParseACSVDocument
     * Tests that the CSV process can parse a CSV document.
     */
    public function testThatCSVProcessorCanParseACSVDocument() {
        $this->assertEquals(count($this->_csvProcessor->read(array('name', 'attribute'), dirname(__FILE__) . '/mock/alice.csv')), 5);
    }

    /**
     * @method testThatAnInvalidFileThrowsException
     * @expectedException \Exception
     * Tests that an exception of type \Exception is thrown.
     */
    public function testThatAnInvalidFileThrowsException() {
        $this->_csvProcessor->read(array('name', 'attribute'), 'an-invalid-file.csv');
    }

}