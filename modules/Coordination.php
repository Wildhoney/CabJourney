<?php

namespace CabJourney;
/**
 * @class Coordination
 * @package CabJourney
 *
 * Responsible for ensuring that the latitude/longitude values change
 * from the previous row.
 */
class Coordination extends AbstractBase {

    /**
     * @method filter
     * @param object $currentRow {stdClass}
     * @param object $previousRow {stdClass}
     * @param null $nextRow {stdClass|null}
     * @return boolean
     */
    public function filter($currentRow, $previousRow, $nextRow) {

        $sameLatitude   = ($currentRow->latitude === $previousRow->latitude);
        $sameLongitude  = ($currentRow->longitude === $previousRow->longitude);

        return !($sameLatitude && $sameLongitude);

    }

}