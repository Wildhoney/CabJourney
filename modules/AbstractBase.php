<?php

namespace CabJourney;

/**
 * @abstract AbstractBase
 * @package CabJourney
 *
 * Responsible for enforcing the `filter` method, and centralising the filtering logic in the `disregardErroneous` method
 * for iterating over the rows, and allowing each module to decide whether to keep or remove the current row.
 */
abstract class AbstractBase {

    /**
     * @method filter
     * @param object $currentRow {stdClass}
     * @param object $previousRow {stdClass}
     * @param object $nextRow {stdClass|null}
     * @return boolean
     * @abstract
     */
    abstract function filter($currentRow, $previousRow, $nextRow);

    /**
     * @disregardErroneous
     * @param array $rows
     * @param string [$name = null]
     * @return array
     */
    public function disregardErroneous($rows, $name = null) {

        $currentRowNumber = 0;

        // Iterate over the rows to determine if they're valid or not.
        $filtered = \array_filter($rows, function(array &$row) use ($rows, &$currentRowNumber, $name) {

            if ($currentRowNumber === 0) {
                // If it's zero then we can't perform any calculations, therefore by
                // default the first row is always valid.
                $currentRowNumber++;
                return true;
            }

            // Find the previous row based on the `rowNumber` in the array.
            $previousRow    = (object) $rows[$currentRowNumber - 1];
            $nextRow        = array_key_exists($currentRowNumber + 1, $rows) ? (object) $rows[$currentRowNumber + 1] : null;

            // Increment the current row number by one.
            $currentRowNumber++;

            // Finally we can let the responsible class decide whether the current row is valid.
            $result = $this->filter((object) $row, $previousRow, $nextRow);

            // If the result is false, and we have a class for writing to the CLI, then let's!
            if (!$result && class_exists('\CabJourney\IOHelper')) {
                // Output why it's being removed to the CLI.
                IOHelper::write(sprintf('%s Removed #%d', ($name ?: get_class($this)), $currentRowNumber));
            }

            // We're done with this iteration!
            return $result;

        });

        // Fill in the index gaps that appear after removing items.
        $filtered = array_values($filtered);

        // Voila!
        return $filtered;

    }

}