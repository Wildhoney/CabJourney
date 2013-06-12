<?php

namespace CabJourney;

/**
 * @class Bootstrap
 * @package CabJourney
 */
class Configuration {

    private static $_defaultConfiguration = array(
        'input'     => 'assets/input/points.csv',
        'output'    => 'assets/output/points-cleaned.csv'
    );

    /**
     * @method getConfiguration
     * @param array [$arguments = array()]
     * @return object {stdClass}
     * @static
     */
    public static function getConfiguration($arguments = array()) {

        // Define the input and output.
        $input  = null;
        $output = null;

        if ($arguments) {
            // We can process any CLI arguments to overwrite the defaults.
            list ($input, $output) = self::getArguments($arguments);
        }

        // Take the input/output from the configuration file if they weren't passed in via the arguments.
        $input  = $input ?: self::$_defaultConfiguration['input'];
        $output = $output ?: self::$_defaultConfiguration['output'];

        // We have all we need, either from the default configuration, or from the CLI arguments.
        return (object) array('input' => $input, 'output' => $output);

    }

    /**
     * @method getConfiguration
     * @param array $arguments
     * @return object {stdClass}
     * @static
     */
    public static function getArguments(array $arguments) {

        // Create the argument map that will help create the configuration.
        $argumentsMap = array('input' => '--input', 'output' => '--output');

        // Initialise the two variables.
        $input  = null;
        $output = null;

        // Iterate over all of the arguments, looking for ones that match the aforementioned map.
        foreach ($arguments as $index => $argument) {

            // Determine if the current argument is defined in the `argumentsMap`.
            if (in_array($argument, $argumentsMap) === false) {
                continue;
            }

            // Ensure the next index is in the array, otherwise the user has specified the argument, but
            // hasn't passed a value.
            if (!isset($arguments[($index + 1)])) {
                continue;
            }

            // Find the name of this argument, and set it to either `$input` or `$output`.
            $name       = array_search($argument, $argumentsMap);
            ${$name}    = $arguments[($index + 1)];

        }

        // Voila!
        return array($input, $output);

    }

}