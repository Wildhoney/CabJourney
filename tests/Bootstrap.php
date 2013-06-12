<?php

// Only declare the Bootstrap again if it hasn't been defined already.
// This is useful for when you're running the tests in a batch.
if (!class_exists('\CabJourney\Bootstrap')) {

    // Discover the relative path for the default bootstrap file.
    $relativePath = DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'Bootstrap.php';

    // Attempt to include the Bootstrap.php file, and run the bootstrap process.
    include_once dirname(dirname(__FILE__)) . $relativePath;
    \CabJourney\Bootstrap::setUp();

}