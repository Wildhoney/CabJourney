CabJourney CSV Processor
=============
Written by Adam Timberlake &ndash; 12th June, 2013.


Background
-------------
Develop a program that, given a series of points (latitude,longitude,timestamp) for a cab journey from A-B, will disregard potentially erroneous points. Try to demonstrate a knowledge of Object Oriented concepts in your answer. Your answer must be returned as a single PHP file which can be run against the PHP 5.3 CLI. The attached dataset is provided as an example, with a png of the 'cleaned' route as a guide.


Philosophy
-------------
* Classes are loosely coupled;
* Modules extend a simple abstract;
* Each module has the same `filter` method &ndash; with the same params;
* Logic for the filtering is abstracted to the `AbstractBase`;
* Modules are added to the service &ndash; allowing for dependency injection;
* Objects are not passed around, making for easier testing and maintainability;
* Separation of concerns, with each class having one responsibility;
* All modules are tested using PHPUnit;
* No dependencies &ndash; such as Zend Framework, CodeIgniter, et cetera...
* Easy to package and distribute with <a href="http://www.phing.info/" target="_blank">Phing</a>.


Build Process
-------------
`CabJourney` has a build process, which creates a `PHAR` file.

To invoke the build process you **must**:

* Have `phing` installed using `pear install phing/phing`;
* Edited your `phar.readonly` option to `Off` in your php.ini file;

You may then begin the build process by running the command `phing` in the application's directory.

Upon build completion, a `CabJourney.phar` archive *should* appear in the `dist` directory.

**Running the PHAR file**

    php CabJourney.phar
    php CabJourney.phar --input example.csv
    php CabJourney.phar --input example.csv --output cleaned-example.csv


Validation
-------------
In addition to the tests, one can validate the resulting latitude/longitude values, with the simple Ember.JS application found in `extras/example` &ndash; which uses Leaflet.js for its visualisation.


Testing
-------------
* PHP tests are written in PHPUnit (navigate to `/tests`);

Note: JavaScript doesn't have any tests, because there's nothing much to it &ndash; with *very* minimal logic. However, you can run JSHint on the files with: `grunt jshint` (requires `npm`).


Bundled Modules
-------------
`CabJourney` comes bundled with the following modules, which each perform a unique validation on each row from the CSV. Records are filtered iteratively &ndash; ensuring simpler modules.

* `Chronological` &ndash; Ensures that timestamps follow chronologically;
* `Coordination` &ndash; Ensures latitude/longitude coordinates differ;
* `Distance` &ndash; Ensures distance travelled in purported time is realistically possible;

Each class has one responsibility, and can be added/removed from the service as necessary. For example, if you care about the waiting time for a cab driver, then you'll want to remove the `Coordination` module, which removes clusters of duplicate latitude/longitude values.


Improvements
-------------
With detailed information about the speed limit for each road, one could calculate the average speed limit for all roads travelled down, and then instead of having a constant (`MAXIMUM_VALID_SPEED`), the limit could instead be an average.


Running
-------------
To run the `CabJourney` processor, simply invoke `Default.php` from the CLI. Please ensure that the output directory is writable (default: `assets/output/points-cleaned.csv`).

**Basic execution**

    php Default.php

**Specifying the input file**

    php Default.php --input assets/input/points.csv

**Specifying the output file**

    php Default.php --output assets/output/points-cleaned.csv

**Specifying both input and output files**

    php Default.php --input assets/input/points.csv  --output assets/output/points-cleaned.csv


Configuration
-------------
CabJourney comes bundled with a default configuration to work out-of-the-box:

    private static $_defaultConfiguration = array(
        'input'     => 'assets/input/points.csv',
        'output'    => 'assets/points-cleaned.csv'
    );

Alternatively you can supply the configuration at runtime.

For example:

    php Default.php --input assets/input/points.csv --output assets/output/points-cleaned.csv

**Please note:** I highly recommend using the build process and executing the PHAR file instead &ndash; see **Build Process**.