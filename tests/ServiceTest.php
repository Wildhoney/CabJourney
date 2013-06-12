<?php

include 'Bootstrap.php';

class ServiceTest extends PHPUnit_Framework_TestCase {

    private $_service;

    public function setUp() {
        $this->_service = new \CabJourney\Service();
    }

    /**
     * @method testAbilityToAddModulesToService
     * Tests whether the service accepts modules to be added to it.
     */
    public function testAbilityToAddModulesToService() {

        $this->_service->addModule('Coordination', new \CabJourney\Coordination());
        $this->assertEquals(count($this->_service->getModules()), 1);

    }

    /**
     * @method testNameIsSetAsTheKey
     * Tests that the name for adding a module is set as the key.
     */
    public function testNameIsSetAsTheKey() {

        $this->_service->addModule('Distance', new \CabJourney\Distance());
        $modules = $this->_service->getModules();
        $this->assertEquals(key($modules), 'Distance');

    }

}