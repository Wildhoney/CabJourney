<?php

namespace CabJourney;

/**
 * @class Distance
 * @package CabJourney
 * @reference http://www.movable-type.co.uk/scripts/latlong.html
 *
 * Responsible for determining if the speed required to cover the distance is more than
 * the `MAXIMUM_VALID_SPEED`. With more information, the `MAXIMUM_VALID_SPEED` could be a variable
 * based on the average maximum speed for the roads travelled down.
 *
 * Another responsibility that `Distance` has is that it checks the distance between the previous and next point.
 * If that distance is less than from the previous to the current, then there's a possible anomalie! We cannot
 * know for sure, because the cab driver may have taken a de-tour because of a one-way road, but without that information
 * we'll assume it was a GPS error.
 *
 * Both responsibilities come under the remit of "distance" and are therefore bundled together in one class.
 */
class Distance extends AbstractBase {

    /**
     * @constant EARTH_RADIUS_MILES
     * @type integer
     * @default 3959
     */
    const EARTH_RADIUS_MILES    = 3959;

    /**
     * @constant MAXIMUM_VALID_SPEED
     * @type integer
     * @default 40
     */
    const MAXIMUM_VALID_SPEED   = 40;

    /**
     * @method filter
     * @param object $currentRow {stdClass}
     * @param object $previousRow {stdClass}
     * @param object $nextRow {stdClass|null}
     * @return boolean
     */
    public function filter($currentRow, $previousRow, $nextRow) {

        $milesTravelled     = $this->_calculateDistanceBetween($currentRow, $previousRow);
        
        // Calculate how long it took to travel the purported distance.
        $currentTimestamp   = (int) $currentRow->timestamp;
        $previousTimestamp  = (int) $previousRow->timestamp;
        $timeTakenSeconds   = ($currentTimestamp - $previousTimestamp) / 1000;

        // If the distance travelled from the current point to the next point, is greater than the
        // distance from the previous point to the next point, then we have a possible anomalie! GPS is good at that.
        if (($nextRow) && ($milesTravelled > ($this->_calculateDistanceBetween($previousRow, $nextRow)))) {
            return false;
        }

        // Calculate the miles per hour based on the distance travelled in miles, and
        // the amount of seconds if took.
        $speed = ($milesTravelled / $timeTakenSeconds);

        // Ensure that the speed travelled at doesn't exceed the maximum sane speed.
        return ($speed <= self::MAXIMUM_VALID_SPEED);

    }

    /**
     * @method _calculateDistanceBetween
     * @param $currentRow
     * @param $previousRow
     * @return int
     */
    private function _calculateDistanceBetween($currentRow, $previousRow) {

        // Typecast all of the latitude/longitude values to a float.
        $currentLatitude        = (float) $currentRow->latitude;
        $currentLongitude       = (float) $currentRow->longitude;
        $previousLatitude       = (float) $previousRow->latitude;
        $previousLongitude      = (float) $previousRow->longitude;

        // Calculate the distance travelled in miles.
        $degreeLatitude         = deg2rad($previousLatitude - $currentLatitude);
        $degreeLongitude        = deg2rad($previousLongitude - $currentLongitude);
        $currentLatitude        = deg2rad($currentLatitude);
        $previousLatitude       = deg2rad($previousLatitude);

        $first                  = sin($degreeLatitude / 2) * sin($degreeLatitude / 2) + sin($degreeLongitude / 2) *
                                  sin($degreeLongitude / 2) * cos($currentLatitude) * cos($previousLatitude);
        $second                 = 2 * atan2(sqrt($first), sqrt(1 - $first));

        return self::EARTH_RADIUS_MILES * $second;

    }

}