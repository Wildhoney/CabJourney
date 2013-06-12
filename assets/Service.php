<?php

namespace CabJourney;

/**
 * @class Service
 * @package CabJourney
 */
class Service {

    /**
     * @var $_modules;
     * @type array
     * Maintains a mapped array of loaded modules, so that new ones can be added and/or remove
     * with ease.
     * @private
     */
    private $_modules;

    /**
     * @method run
     * Begins the inspection process of CSV document.
     * @param $configuration {stdClass}
     * @return \CabJourney\Service
     */
    public function run($configuration) {

        try {

            // Parse the CSV document.
            $csvProcessor   = new CSVProcessor();
            $headers        = array('latitude', 'longitude', 'timestamp');
            $rows           = $csvProcessor->read($headers, $configuration->input);

            // Iterate over all of the modules, removing them in a subtractive fashion.
            foreach ($this->getModules() as $name => $module) {
                $rows = $module->disregardErroneous($rows, $name);
            }

            // We've got our list of valid coordinates!
            $documentPath = $csvProcessor->write($headers, $rows, $configuration->output);

            if ($this->_cliWritable()) {

                // We're all done!
                IOHelper::write(sprintf('Cleaned CSV Created: %s', $documentPath));
                IOHelper::write('Finished!');

            }

        } catch (\Exception $exception) {

            if ($this->_cliWritable()) {

                // An exception occurred, so we need to throw an error if we can.
                IOHelper::write(sprintf('An Error Occurred: %s', $exception->getMessage()));

            }

        }

    }

    /**
     * @method getModules
     * Acquires a list of modules that have been loaded into the class.
     * @return array
     */
    public function getModules() {
        return $this->_modules;
    }

    /**
     * @method addModule
     * @param string $name
     * @param AbstractBase $moduleInstance
     * Loads a module into the mix.
     * @return void
     */
    public function addModule($name, AbstractBase $moduleInstance) {
        $this->_modules[$name] = $moduleInstance;
    }

    /**
     * @method _cliWritable
     * Simple wrapper for checking whether we have the `IOHelper` for writing to the CLI.
     * @return boolean
     * @private
     */
    private function _cliWritable() {
        return (class_exists('\CabJourney\IOHelper'));
    }

}