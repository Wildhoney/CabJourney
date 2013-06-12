<?php

namespace CabJourney;

/**
 * @class CSVProcessor
 * @package CabJourney
 *
 * Responsible for parsing a CSV, based on the CSV's path, and an array of headers.
 */
class CSVProcessor {

    /**
     * @constant DOCUMENT_SEPARATOR
     * @type string
     */
    const DOCUMENT_SEPARATOR = ',';

    /**
     * @method read
     * @param array $headers
     * @param string $documentPath
     * @throws \Exception
     * @return array $lines
     */
    public function read($headers, $documentPath) {

        $lines = array();

        if (!file_exists($documentPath)) {
            // If we can't find the CSV document, then let's throw an error!
            throw new \Exception(sprintf('Unable to find CSV in path: %s', $documentPath));
        }

        // Open the CSV document in readable mode.
        if (($handle = fopen($documentPath, 'r')) !== false) {

            // Iterate over the CSV document, processing one line at a time.
            while (($data = fgetcsv($handle, 1024, self::DOCUMENT_SEPARATOR)) !== false) {

                $line = array();

                // Iterate over each column in the line, and finding the relevant header
                // from the $header array.
                for ($index = 0, $columns = count($data); $index < $columns; $index++) {
                    $line[$headers[$index]] = $data[$index];
                }

                // Voila! We can now push it into the array.
                array_push($lines, $line);

            }

            fclose($handle);

        }

        return $lines;

    }

    /**
     * @method write
     * @param array $headers
     * @param array $rows
     * @param string $documentPath
     * @return string
     * @throws \Exception
     */
    public function write(array $headers, array $rows, $documentPath) {

        // Gather a list of the headers.
        $lines = array(join(self::DOCUMENT_SEPARATOR, $headers));

        foreach ($rows as $row) {
            // Iterate over each row, and join each column by `DOCUMENT_SEPARATOR`.
            array_push($lines, join(self::DOCUMENT_SEPARATOR, $row));
        }

        // Join all the lines by line ending characters.
        $data = join("\n", $lines);

        // Ensure the directory is writable.
        if (!is_writable(pathinfo($documentPath, PATHINFO_DIRNAME))) {
            $message = sprintf('Output directory (%s) is not writable.', $documentPath);
            throw new \Exception($message);
        }

        // Finally we can open the document, and write the output.
        $handle = fopen($documentPath, 'w');
        fwrite($handle, $data, strlen($data));

        // Let everybody know the path to it.
        return $documentPath;

    }

}