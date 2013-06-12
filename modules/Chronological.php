<?php

namespace CabJourney;

/**
 * @class Chronological
 * @package CabJourney
 *
 * Responsible for determining if the times are in chronological order.
 */
class Chronological extends AbstractBase {

    /**
     * @method filter
     * @param object $currentRow {stdClass}
     * @param object $previousRow {stdClass}
     * @param object $nextRow {stdClass|null}
     * @return boolean
     */
    public function filter($currentRow, $previousRow, $nextRow) {

        $currentTimestamp   = (int) $currentRow->timestamp;
        $previousTimestamp  = (int) $previousRow->timestamp;

        // Ensure the current timestamp comes after the previous timestamp.
        return ($currentTimestamp > $previousTimestamp);

    }

}