<?php

namespace CabJourney;

/**
 * @class Bootstrap
 * @package CabJourney
 */
class Bootstrap {

    /**
     * @method setUp
     * Configures the SPL auto-loader, include paths, and configuration.
     * @return void
     * @static
     */
    public static function setUp() {

        include 'Configuration.php';
        include 'Service.php';

        // Find the root directory for CabJourney.
        $root = dirname(dirname(__FILE__));

        // Define the include paths.
        set_include_path(implode(PATH_SEPARATOR, array(
            realpath($root . DIRECTORY_SEPARATOR . 'lib'),
            realpath($root . DIRECTORY_SEPARATOR . 'modules'),
            get_include_path()
        )));

        // Use SPL to autoload classes.
        spl_autoload_register(function ($className) {
            $className  = str_replace(__NAMESPACE__, null, $className);
            $className  = ltrim($className, '\\');
            include (sprintf('%s.php', $className));
        });

    }

}