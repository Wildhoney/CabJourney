<?php

date_default_timezone_set('Europe/London');
error_reporting(0);

if (file_exists('assets/Bootstrap.php')) {
    // Bootstrap the application.
    include 'assets/Bootstrap.php';
    \CabJourney\Bootstrap::setUp();
}

$config = \CabJourney\Configuration::getConfiguration((isset($argv) ? $argv : array()));

// Begin the process!
$service = new \CabJourney\Service($config);
$service->addModule('Coordination', new \CabJourney\Coordination());
$service->addModule('Chronological', new \CabJourney\Chronological());
$service->addModule('Distance', new \CabJourney\Distance());
$service->run($config);