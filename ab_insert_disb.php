<?php
//ini_set("memory_limit","-1");
include 'connection.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

$fileDIR = $_FILES['stkdisb']['tmp_name'];
//echo $fileDIR;

// Start the session (if not already started)
session_start();

$fileName = $_FILES['stkdisb']['name'];

// Store $fileName in a session variable
$_SESSION['uploaded_file_disb'] = $fileName;

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

$sql = 'INSERT INTO ab_disb (item_no, item_description, item_type, disb_charge) VALUES ';

for ($row = 4; $row <= $highestRow; $row++) {
	
	// // If it's an empty cell or doesn't equal 'BTV', skip to the next row
	// $valueForRow1 = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
	// if ($valueForRow1 !== 'BTV') {
	// 	continue;
	// }
	
    $ITEM_NO = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
    $ITEM_DESCRIPTION = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
	$ITEM_TYPE = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	$DISB_CHARGE = $worksheet->getCellByColumnAndRow(4, $row)->getValue();

	$sql.= "('$ITEM_NO', '$ITEM_DESCRIPTION', '$ITEM_TYPE', '$DISB_CHARGE'),";
}
		
$sql = rtrim($sql, ',');
//$sql = str_replace(",", "");
//echo $sql;	
if (mysqli_query($conn, "TRUNCATE TABLE ab_disb")){
	if (mysqli_query($conn,$sql)){
		header('Location:ab_master_display.php');
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
header("Location: ab_master_display.php");
exit();
?>