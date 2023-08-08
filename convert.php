<?php
// Include the PhpSpreadsheet library
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if a file was uploaded successfully
    if (isset($_FILES['excel_file']) && $_FILES['excel_file']['error'] === UPLOAD_ERR_OK) {
        $inputFile = $_FILES['excel_file']['tmp_name'];

        // Load the Excel file
        $spreadsheet = IOFactory::load($inputFile);

        // Get the first sheet (index 0)
        $sheet = $spreadsheet->getActiveSheet();

        // Generate a random name for the CSV file to avoid collisions
        $outputFile = uniqid('output_', true) . '.csv';

        // Open the output file in write mode
        $fileHandle = fopen($outputFile, 'w');

        // Loop through each row in the Excel sheet and write to the CSV file
        foreach ($sheet->getRowIterator() as $row) {
            $rowData = [];
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE);

            foreach ($cellIterator as $cell) {
                $cellValue = $cell->getValue();

                // Check if the cell contains a date or time value
                if (Date::isDateTime($cell)) {
                    // Convert the date/time value to a human-readable format
                    $cellValue = Date::excelToDateTimeObject($cellValue)->format('Y-m-d H:i:s');
                }

                $rowData[] = $cellValue;
            }

            fputcsv($fileHandle, $rowData);
        }

        // Close the CSV file
        fclose($fileHandle);

        // Set the appropriate headers to force download
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . basename($outputFile) . '"');
        header('Content-Length: ' . filesize($outputFile));
        readfile($outputFile);

        // Remove the temporary CSV file
        unlink($outputFile);
    } else {
        echo "Error uploading the file. Please try again.";
    }
}
?>
