<?php
//ini_set("memory_limit","-1");
include 'connection.php';
require 'vendor/autoload.php';

    // Truncate the table
    $sql = "TRUNCATE TABLE total_extra_parts";
    
    if (mysqli_query($conn, $sql)) {
    } else {
    }
	
$excelFiles = $_FILES['stk'];

// Sort the files based on their names in ascending order
array_multisort($excelFiles['name'], SORT_ASC, $excelFiles['tmp_name'], $excelFiles['type']);

foreach ($excelFiles['tmp_name'] as $index => $fileDIR) {
	$excelFileName = $excelFiles['name'][$index];
	$excelFileNameCut = substr($excelFileName, 15, -10);

	//echo $fileDIR;
	$excelFileNameCut = substr($excelFileName,15, -10);
	/********************READ IMPORT PART EXCEL FROM IMPORTED EXCEL FILE *************************/
	//set reader object
	$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
	$reader->setDelimiter("\t"); // Set the delimiter to a tab character
			
	// set reader to load all sheet in Excel File
	$reader -> setLoadAllSheets();
				
	// load the Excel file
	$spreadsheet = $reader->load("$fileDIR");
				
	//get the panel worksheet in Excel FIle
	$worksheet = $spreadsheet->getActiveSheet();
			
	$highestRow = $worksheet->getHighestRow();	
	//echo $highestRow;

	$sql = 'INSERT INTO total_extra_parts (datee, wip_entity_name, item_number, item_description, vendor_code, vendor_name, order_status, confirmdel, plan_qty, delivery_date, delivery_time, extraqty, linee) VALUES ';

	for ($row = 2; $row <= $highestRow; $row++) {
		
		$DATEE = $excelFileNameCut;
		$WIP_ENTITY_NAME = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
		$ITEM_NUMBER = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
		$ITEM_DESCRIPTION = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
		$VENDOR_CODE = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
		$VENDOR_NAME = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
		$ORDER_STATUS = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
		$CONFIRMDEL = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
		$PLAN_QTY = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
		$DELIVERY_DATE = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
		$DELIVERY_TIME = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
		$EXTRAQTY = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
		$WIP_ENTITY_NAME_CUT = substr($WIP_ENTITY_NAME,0, -9);
		$LINEE = $WIP_ENTITY_NAME_CUT;

		$sql.= "('$DATEE', '$WIP_ENTITY_NAME', '$ITEM_NUMBER', '$ITEM_DESCRIPTION', '$VENDOR_CODE', '$VENDOR_NAME', '$ORDER_STATUS', '$CONFIRMDEL', '$PLAN_QTY', '$DELIVERY_DATE', '$DELIVERY_TIME', '$EXTRAQTY', '$LINEE'),";
	}
			
	$sql = rtrim($sql, ',');
	//$sql = str_replace(",", "");
	//echo $sql;	
		if (mysqli_query($conn,$sql)){
			header('Location:pep_master_display.php');
		}
		else {
			echo 'MYSQL ERROR WHILE INSERTING DATA. PLEASE CHECK SQL INSERT QUERY<br>ERROR:'.mysqli_error($conn);
		}
}
?>