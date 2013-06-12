<?php

namespace CabJourney;

\Phar::mapPhar();

// Auto-loading for PHAR.
spl_autoload_register(function ($className) {

    $pharPath   = 'phar://CabJourney.phar/dist/libs/%s.php';
    $className  = str_replace(__NAMESPACE__, null, $className);
    $className  = ltrim($className, '\\');

    include (sprintf($pharPath, $className));
});

include 'phar://CabJourney.phar/dist/Default.php';

__HALT_COMPILER();