<?php
//ini_set("memory_limit","-1");
include 'connection.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

$fileDIR = $_FILES['stk']['tmp_name'];
//echo $fileDIR;

// Start the session (if not already started)
session_start();

$fileName = $_FILES['stk']['name'];

// Store $fileName in a session variable
$_SESSION['uploaded_file'] = $fileName;

// Load the Excel file
$spreadsheet = IOFactory::load($fileDIR);

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
			$cellValue = Date::excelToDateTimeObject($cellValue)->format('Y-m-d H:i');
		}

		$rowData[] = $cellValue;
	}

	fputcsv($fileHandle, $rowData);
}

/********************READ IMPORT PART EXCEL FROM IMPORTED EXCEL FILE *************************/
//set reader object
$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
//$reader->setDelimiter("\t"); // Set the delimiter to a tab character
		
// set reader to load all sheet in Excel File
$reader -> setLoadAllSheets();
			
// load the Excel file
$spreadsheet = $reader->load("$outputFile");
			
//get the panel worksheet in Excel FIle
$worksheet = $spreadsheet->getActiveSheet();
		
$highestRow = $worksheet->getHighestRow();	
//echo $highestRow;

$sql = 'INSERT INTO ap_master (mrp_whs, reference, partno, partdesc, delypattern, supplier, pono, deliverqty, ws_cd, shiptolocation, dateeta, transdt, processdt, rcvdt, rcvqty, joc_no, outstandingqty, rcvstat, batch_id, buyer_name, export_date) VALUES ';

for ($row = 1; $row <= $highestRow; $row++) {
	
	// If it's an empty cell or doesn't equal 'BTV', skip to the next row
	$valueForRow1 = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
	if ($valueForRow1 !== 'BTV') {
		continue;
	}
	
    $MRP_WHS = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
    $REFERENCE = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
	$PARTNO = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	$PARTDESC = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
	$DELYPATTERN = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
	$SUPPLIER = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
	$PONO = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
	$DELIVERQTY = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
	$WS_CD = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
	$SHIPTOLOCATION = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
	$DATEETA = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
	$TRANSDT = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
	$PROCESSDT = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
	$RCVDT = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
	$RCVQTY = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
	$JOC_NO = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
	$OUTSTANDINGQTY = $worksheet->getCellByColumnAndRow(17, $row)->getValue();
	$RCVSTAT = $worksheet->getCellByColumnAndRow(18, $row)->getValue();
	$BATCH_ID = $worksheet->getCellByColumnAndRow(19, $row)->getValue();
	$BUYER_NAME = $worksheet->getCellByColumnAndRow(20, $row)->getValue();
	$EXPORT_DATE = $worksheet->getCellByColumnAndRow(21, $row)->getValue();

	$sql.= "('$MRP_WHS', '$REFERENCE', '$PARTNO', '$PARTDESC', '$DELYPATTERN', '$SUPPLIER', '$PONO', '$DELIVERQTY', '$WS_CD', '$SHIPTOLOCATION', '$DATEETA', '$TRANSDT', '$PROCESSDT', '$RCVDT', '$RCVQTY', '$JOC_NO', '$OUTSTANDINGQTY', '$RCVSTAT', '$BATCH_ID', '$BUYER_NAME', '$EXPORT_DATE'),";
}
		
$sql = rtrim($sql, ',');
//$sql = str_replace(",", "");
//echo $sql;	
if (mysqli_query($conn, "TRUNCATE TABLE ap_master")){
	if (mysqli_query($conn,$sql)){
		header('Location:ap_master_display.php');
	}
	else {
		echo 'MYSQL ERROR WHILE INSERTING DATA. PLEASE CHECK SQL INSERT QUERY<br>ERROR:'.mysqli_error($conn);
	}
}
else {
	echo 'MYSQL ERROR. PLEASE CHECK SQL QUERY<br>ERROR:'.mysqli_error($conn);
}

// Remove the temporary CSV file
unlink($outputFile);

// Redirect to another script
header("Location: ap_master_display.php");
exit();
?>