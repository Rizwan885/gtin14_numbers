<?php
/**
 * Index Page (Demo)
 *
 * PHP Version 8.1
 *
 * @category SGLMS_Library
 * @package  GS1GTIN
 * @author   Jaime C. Rubin-de-Celis <james@sglms.com>
 * @license  MIT (https://sglms.com/license)
 * @link     https://sglms.com
 **/

use Sglms\Gs1Gtin\Gtin;
use Sglms\Gs1Gtin\Gtin8;
use Sglms\Gs1Gtin\Gtin12;
use Sglms\Gs1Gtin\Gs1;

require_once 'vendor/autoload.php';

// Function to generate a random GTIN number
function generateRandomGtin()
{
    return Gtin::create(rand())->number;
}

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the range limit is provided
    if (isset($_POST['range_limit'])) {
        $rangeLimit = $_POST['range_limit'];

        // Validate the range limit
        if (is_numeric($rangeLimit) && $rangeLimit > 0) {
            $gtinNumbers = [];

            // Generate the random GTIN numbers
            for ($i = 0; $i < $rangeLimit; $i++) {
                $gtinNumbers[] = generateRandomGtin();
            }

            $csvFilePath = 'gtin_numbers.csv';

            // Remove the existing file if it exists
            if (file_exists($csvFilePath)) {
                unlink($csvFilePath);
            }

            $csvFile = fopen($csvFilePath, 'a');
            if ($csvFile === false) {
                echo 'Failed to open CSV file for writing.';
            } else {
                foreach ($gtinNumbers as $gtin) {
                    fputcsv($csvFile, [$gtin]);
                }

                fclose($csvFile);

                echo 'GTIN numbers generated and saved to ' . $csvFilePath;
            }
        } else {
            echo 'Invalid range limit. Please provide a positive numeric value.';
        }
    } else {
        echo 'Range limit not provided.';
    }
}
?>

<html>
    <body>
        <h2>Generate GTIN Numbers</h2>
        <form method="POST" action="">
            <label for="range_limit">Range Limit:</label>
            <input type="number" id="range_limit" name="range_limit" min="1" required>
            <button type="submit">Generate and Save</button>
        </form>
    </body>
</html>
