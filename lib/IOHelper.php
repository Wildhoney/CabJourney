<?php

namespace CabJourney;

/**
 * @class IOHelper
 * @package CabJourney
 *
 * Responsible for outputting messages to the CLI.
 */
class IOHelper {

    /**
     * @method write
     * @param string $message
     * @return void
     */
    public static function write($message) {
        printf("%s - %s\r\n", date('H:i:s'), $message);
    }

}