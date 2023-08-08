<?php
ob_start();
include ('connection.php');
session_start(); 

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
// use PhpOffice\PhpSpreadsheet\Worksheet\ColumnDimension;
// use PhpOffice\PhpSpreadsheet\Worksheet\RowDimension;
// use PhpOffice\PhpSpreadsheet\PivotTable\DataConsolidateFunction;
// use PhpOffice\PhpSpreadsheet\PivotTable\PivotField;
// use PhpOffice\PhpSpreadsheet\PivotTable\PivotTable;
// use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
// use PhpOffice\PhpSpreadsheet\Worksheet\AutoFilter\Column;
// use PhpOffice\PhpSpreadsheet\Style\Border;
// use PhpOffice\PhpSpreadsheet\Style\Fill;
// use PhpOffice\PhpSpreadsheet\Style\Font;

require 'vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Spreadsheet.php';
require 'vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Writer/Xlsx.php';
require 'vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Writer/Xls.php';
require 'vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Worksheet/Worksheet.php';
require 'vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Worksheet/Protection.php';
require 'vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Calculation/Calculation.php';
?>

<?php
// Process the import logic here
//$filterValue = $_POST['planlotValue'];
    
// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();

// Get the default worksheet (index 0)
$worksheet = $spreadsheet->getSheet(0);

// Set a dynamic name for the worksheet using a variable
//$worksheetName = $filterValue;
//$worksheet->setTitle('AutoJIT_'.$worksheetName);

// Create a new sheet and set the data
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'id');
$sheet->setCellValue('B1', 'MRP WHS');
$sheet->setCellValue('C1', 'Reference');
$sheet->setCellValue('D1', 'Part No');
$sheet->setCellValue('E1', 'Part Description');
$sheet->setCellValue('F1', 'Dely Pattern');
$sheet->setCellValue('G1', 'Supplier');
$sheet->setCellValue('H1', 'Po Number');
$sheet->setCellValue('I1', 'Delivery Qty');
$sheet->setCellValue('J1', 'WS CD');
$sheet->setCellValue('K1', 'Ship To Location');
$sheet->setCellValue('L1', 'Date & ETA');
$sheet->setCellValue('M1', 'ETA');
$sheet->setCellValue('N1', 'Trans DT');
$sheet->setCellValue('O1', 'Process DT');
$sheet->setCellValue('P1', 'Rcv DT');
$sheet->setCellValue('Q1', 'RCV Qty');
$sheet->setCellValue('R1', 'JOC No');
$sheet->setCellValue('S1', 'Outstanding Qty');
$sheet->setCellValue('T1', 'Rcv Status');
$sheet->setCellValue('U1', 'Batch ID');
$sheet->setCellValue('V1', 'Buyer_Name');
$sheet->setCellValue('W1', 'Export Date');
$sheet->setCellValue('X1', 'D.CHARGE');

// Fetch the data from the database and populate the Excel sheet
$query = "SELECT * FROM ab_master_upgrade ORDER BY ws_cd";
$result = mysqli_query($conn, $query);
$rowIndex = 2; // Start from row 2 for data
$counter = 1; // Counter for the ID values
while ($row = mysqli_fetch_assoc($result)) {

    $sheet->setCellValue('A' . $rowIndex, $counter); // Set the ID value
    $sheet->setCellValue('B' . $rowIndex, $row['mrp_whs']);
    $sheet->setCellValue('C' . $rowIndex, $row['reference']);
    $sheet->setCellValue('D' . $rowIndex, $row['part_no']);
    $sheet->setCellValue('E' . $rowIndex, $row['part_description']);
    $sheet->setCellValue('F' . $rowIndex, $row['dely_pattern']);
    $sheet->setCellValue('G' . $rowIndex, $row['supplier']);
    $sheet->setCellValue('H' . $rowIndex, $row['po_number']);
    $sheet->setCellValue('I' . $rowIndex, $row['delivery_qty']);
    $sheet->setCellValue('J' . $rowIndex, $row['ws_cd']);
    $sheet->setCellValue('K' . $rowIndex, $row['ship_to_location']);
    $sheet->setCellValue('L' . $rowIndex, $row['dateeta']);
    $sheet->setCellValue('M' . $rowIndex, $row['eta']);
    $sheet->setCellValue('N' . $rowIndex, $row['transdt']);
    $sheet->setCellValue('O' . $rowIndex, $row['processdt']);
    $sheet->setCellValue('P' . $rowIndex, $row['rcvdt']);
    $sheet->setCellValue('Q' . $rowIndex, $row['rcvqty']);
    $sheet->setCellValue('R' . $rowIndex, $row['jocno']);
    $sheet->setCellValue('S' . $rowIndex, $row['outstanding_qty']);
    $sheet->setCellValue('T' . $rowIndex, $row['rcv_status']);
    $sheet->setCellValue('U' . $rowIndex, $row['batch_id']);
    $sheet->setCellValue('V' . $rowIndex, $row['buyer_name']);
    $sheet->setCellValue('W' . $rowIndex, $row['export_date']);
    $sheet->setCellValue('X' . $rowIndex, $row['disb_charge_upgrade']);

    $counter++; // Increment the counter
    $rowIndex++;
}

// Create a new sheet for the pivot table
$pivotSheet = $spreadsheet->createSheet();
$pivotSheet->setTitle('AutoJIT_PIV');

// Hide row number 2 in the "PIV" sheet
//$pivotSheet->getRowDimension(2)->setVisible(false);

// Define the range of data for the pivot table
$dataRange = 'A1:X' . ($rowIndex - 1); // Assuming the data range is from A1 to W(rowIndex-1)

// Define the pivot table structure
$idField = 'A'; // id
$wscdField = 'J'; // WS CD
$jocnoField = 'R'; // joc No
$disbField = 'X'; // Disb Charge
$partField = 'D'; // Part No
$supplierField = 'G'; // supplier

//$rowField = 'D';    // Part Description
$dataField = 'I';   // Delivery Qty
$dateEtaField = 'L'; // Date & ETA field
$etaField = 'M'; // ETA AM

// Set up the layout of the pivot table
$pivotSheet->setCellValue('A3', 'id');
$pivotSheet->setCellValue('B3', 'WS CD');
$pivotSheet->setCellValue('C3', 'JOC No');
$pivotSheet->setCellValue('D3', 'D.CHARGE');
$pivotSheet->setCellValue('E3', 'Part No');
$pivotSheet->setCellValue('F3', 'Supplier');

// Calculate the summarized values
$data = $sheet->rangeToArray($dataRange, null, true, true, true); // Get the data from the original sheet
$pivotData = array(); // Array to hold the pivot table data

foreach ($data as $row) {
    $rowData = array();
    //$wsValue = $row[$rowField];
    $idValue = $row[$idField]; // id
    $wsValue = $row[$wscdField]; // WS CD
    $jocValue = $row[$jocnoField]; // joc No
    $disbValue = $row[$disbField]; // Disb Charge
    $partValue = $row[$partField]; // Part No
    $supplierValue = $row[$supplierField]; // supplier

    $dataValue = $row[$dataField]; // Delivery Qtyx
    $dateEtaValue = $row[$dateEtaField]; // Date & ETA field
    $etaValue = $row[$etaField]; // eta AM field

    // Check if the row and column combination already exists in the pivot table data
    if (isset($pivotData[$idValue][$wsValue][$jocValue][$disbValue][$partValue][$supplierValue][$etaValue])) {
        $pivotData[$idValue][$wsValue][$jocValue][$disbValue][$partValue][$supplierValue][$etaValue] += $dataValue;
    } else {
        $pivotData[$idValue][$wsValue][$jocValue][$disbValue][$partValue][$supplierValue][$etaValue] = $dataValue;
    }
}

// Populate the pivot table
$columnIndex = 6; // Start column index for Date & ETA values

// Set the unique Date & ETA values in columns
$uniqueDateEtaValues = array();
foreach ($pivotData as $idValue => $rowData) {
    foreach ($rowData as $wsValue => $wsData) {
        foreach ($wsData as $jocValue => $jocData) {
            foreach ($jocData as $disbValue => $disbData) {
                foreach ($disbData as $partValue => $data) {
                    foreach ($data as $supplierValue => $supplierData) {
                        foreach ($supplierData as $etaValue => $dataValue) {
                            if (!in_array($etaValue, $uniqueDateEtaValues)) {
                                $uniqueDateEtaValues[] = $etaValue;
                            }
                        }
                    }
                }
            }
        }
    }
}

// Sort the unique Date & ETA values based on time (AM to PM)
usort($uniqueDateEtaValues, function($a, $b) {
    $aTime = strtotime($a);
    $bTime = strtotime($b);
    return $aTime <=> $bTime;
});

// Set the sorted Date & ETA values in columns
foreach ($uniqueDateEtaValues as $etaValue) {
    $pivotSheet->setCellValueByColumnAndRow($columnIndex, 3, $etaValue);
    $columnIndex++;
}

$rowIndex = 3;
foreach ($pivotData as $idValue => $rowData) {
    foreach ($rowData as $wsValue => $wsData) {
        foreach ($wsData as $jocValue => $jocData) {
            foreach ($jocData as $disbValue => $disbData) {
                foreach ($disbData as $partValue => $data) {
                    foreach ($data as $supplierValue => $supplierData) {        
                    $pivotSheet->setCellValue('A' . $rowIndex, $idValue);
                    $pivotSheet->setCellValue('B' . $rowIndex, $wsValue);
                    $pivotSheet->setCellValue('C' . $rowIndex, $jocValue);
                    $pivotSheet->setCellValue('D' . $rowIndex, $disbValue);
                    $pivotSheet->setCellValue('E' . $rowIndex, $partValue);
                    $pivotSheet->setCellValue('F' . $rowIndex, $supplierValue);

                    $columnIndex = 6; // Reset column index for Date & ETA values
                    foreach ($uniqueDateEtaValues as $etaValue) {
                        if (isset($supplierData[$etaValue])) {
                            $pivotSheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $supplierData[$etaValue]);
                        }
                        $columnIndex++;
                    }
                    $rowIndex++;
                    }
                }
            }
        }
    }
}

$grandTotalColumn = count($uniqueDateEtaValues) + 6; // Calculate the column index for the grand total column
$grandTotalRow = $rowIndex;

        // Calculate the sum for each row of Part No
        $rowIndex = 3;
        foreach ($pivotData as $idValue => $rowData) { // id
            $rowTotal = 0;
            foreach ($rowData as $wsValue => $wsData) { // WS CD
                foreach ($wsData as $jocValue => $jocData) { //joc no
                    foreach ($jocData as $disbValue => $disbData) { //disb
                        foreach ($disbData as $partValue => $data) { //part no
                            foreach ($data as $supplierValue => $supplierData) {
                                foreach($supplierData as $etaValue => $dataValue){
                                    if (isset($supplierData[$etaValue])) {
                                        $rowTotal += intval($supplierData[$etaValue]); // Convert the data value to an integer using intval()
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $pivotSheet->setCellValueByColumnAndRow($grandTotalColumn, $rowIndex, $rowTotal);
            $rowIndex++;
        }        
// Add grand total column header
$pivotSheet->setCellValueByColumnAndRow($grandTotalColumn, 3, 'Grand Total');

// Calculate the sum for each column of Date & ETA
$columnIndex = 6;
foreach ($uniqueDateEtaValues as $etaValue) {
    $columnTotal = 0;
    foreach ($pivotData as $idValue => $rowData) {
        foreach ($rowData as $wsValue => $wsData) {
            foreach ($wsData as $jocValue => $jocData) {
                foreach ($jocData as $disbValue => $disbData) {
                    foreach ($disbData as $partValue => $data) {
                        foreach ($data as $supplierValue => $supplierData) {
                            if (isset($supplierData[$etaValue])) {
                                // Convert the data value to an integer using intval()
                                $columnTotal += intval($supplierData[$etaValue]);
                            }
                        }
                    }
                }
            }
        }
    }
    $pivotSheet->setCellValueByColumnAndRow($columnIndex, $grandTotalRow, $columnTotal);
    $columnIndex++;
}


// Calculate the grand total
$grandTotal = 0;
foreach ($pivotData as $idValue => $rowData) {
    foreach ($rowData as $wsValue => $wsData) {
        foreach ($wsData as $jocValue => $jocData) {
            foreach ($jocData as $disbValue => $disbData) {
                foreach ($disbData as $partValue => $data) {
                    foreach ($data as $supplierValue => $supplierData) {
                        foreach ($supplierData as $etaValue => $dataValue) {
                            if (isset($supplierData[$etaValue])) {
                                $grandTotal += intval($supplierData[$etaValue]); // Convert the data value to an integer using intval()
                            }
                        }
                    }
                }
            }
        }
    }
}
$pivotSheet->setCellValueByColumnAndRow($grandTotalColumn, $grandTotalRow, $grandTotal);

// Add "Grand Total" label to the last row at the bottom
$pivotSheet->setCellValue('F' . $grandTotalRow, 'Grand Total');

// Adjust column widths to fit content perfectly and set specific widths if desired
$columnWidths = [
  'A' => 5,  // Example: Set column A width to 15
  'B' => 10,  // Example: Set column B width to 20
  'C' => 10,
  //'D' => 10,
];  // Add more columns and widths as needed

// Set column width
foreach ($columnWidths as $columnLetter => $width) {
  $columnIndex = Coordinate::columnIndexFromString($columnLetter);
  $columnDimension = $pivotSheet->getColumnDimensionByColumn($columnIndex);

  if ($columnLetter === 'G' || $columnLetter !== 'G') {
      $columnLetter == $columnDimension->setWidth($width);
  }

  if ($columnLetter === 'G') {
    $pivotSheet->removeColumnByIndex($columnIndex);
  }
}

// Autofit column width
foreach (range('A', $pivotSheet->getHighestColumn()) as $columnLetter) {
  $columnIndex = Coordinate::columnIndexFromString($columnLetter);
  $columnDimension = $pivotSheet->getColumnDimensionByColumn($columnIndex);

  if ($columnLetter === 'G' || $columnLetter !== 'G') {
      $columnLetter = $columnDimension->setAutoSize(true);
  }

  if ($columnLetter === 'G') {
    $pivotSheet->removeColumnByIndex($columnIndex);
  }
}

// Autofit row height
foreach ($pivotSheet->getRowDimensions() as $rowDimension) {
  $rowDimension->setRowHeight(-1);
}

// Center align columns
$lastColumnIndex = Coordinate::columnIndexFromString($pivotSheet->getHighestColumn());
$lastRowIndex = $pivotSheet->getHighestRow();
$styleArray = [
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
];

for ($columnIndex = 1; $columnIndex <= $lastColumnIndex; $columnIndex++) {
    $columnLetter = Coordinate::stringFromColumnIndex($columnIndex);
    $range = $columnLetter . '1:' . $columnLetter . $lastRowIndex;
    $pivotSheet->getStyle($range)->applyFromArray($styleArray);
}

// Save the Excel file to planlot_Pivot
$writer = new Xlsx($spreadsheet);
$filename = 'amd_AutoJIT_Pivot.xlsx';
$excelPivot = $filterValue;
$filename = str_replace('amd', $excelPivot, $filename);
$saveDirectory = 'C:/xampp/htdocs/AP/ap_savedFile/planlot_Pivot/';
$filePath = $saveDirectory . $filename;
$writer->save($filePath);

// Redirect to the new Excel file
$redirectPath = 'ap_savedFile/planlot_Pivot/' . $filename;
header('Location: ' . $redirectPath);
exit();


$directory = 'C:/xampp/htdocs/AP/ap_savedFile/planlot_Pivot/';

// Get all files and folders within the directory
$files = glob($directory . '*');

// Loop through each file and folder
foreach ($files as $file) {
    if (is_file($file)) {
        // Delete the file
        unlink($file);
    } elseif (is_dir($file)) {
        // Delete the directory and its contents recursively
        array_map('unlink', glob($file . '/*'));
        rmdir($file);
    }
}

// Redirect to another script
header("Location: ab_master_display.php");
exit();
?>