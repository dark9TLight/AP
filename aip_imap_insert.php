
<?php
//ini_set("memory_limit","-1");
include 'connection.php';
require 'vendor/autoload.php';
$fileDIR = $_FILES['stk']['tmp_name'];
//echo $fileDIR;

// Start the session (if not already started)
session_start();

$fileNameimap = $_FILES['stk']['name'];

// Store $fileName in a session variable
$_SESSION['uploaded_file_imap'] = $fileNameimap;

/********************READ IMPORT PART EXCEL FROM IMPORTED EXCEL FILE *************************/
//set reader object
$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
		
// set reader to load all sheet in Excel File
$reader -> setLoadAllSheets();
			
// load the Excel file
$spreadsheet = $reader->load("$fileDIR");
			
//get the panel worksheet in Excel FIle
$worksheet = $spreadsheet->getActiveSheet();
		
$highestRow = $worksheet->getHighestRow();	
//echo $highestRow;

$sql = 'INSERT INTO imap_master (mrp_whs_grp, ws_cd, joc_cd, vendor_cd, vendor_desc, disb_charge_cd, item_no, item_desc, whs_cd, std_pack, plan_lot_size, usage_qty, plan_lot_usage_qty, supply_qty, open_qty, parent_item_desc, start_ecn_accum_qty, end_ecn_accum_qty) VALUES ';

for ($row = 4; $row <= $highestRow; $row++) {
	
    $MRP_WHS_GRP = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
    $WS_CD = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
	$JOC_CD = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	$VENDOR_CD = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
	$VENDOR_DESC = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
	$DISB_CHARGE_CD = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
	$ITEM_NO = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
	$ITEM_DESC = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
	$WHS_CD = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
	$STD_PACK = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
	$PLAN_LOT_SIZE = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
	$USAGE_QTY = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
	$PLAN_LOT_USAGE_QTY = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
	$SUPPLY_QTY = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
	$OPEN_QTY = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
	$PARENT_ITEM_DESC = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
	$START_ECN_ACCUM_QTY = $worksheet->getCellByColumnAndRow(17, $row)->getValue();
	$END_ECN_ACCUM_QTY = $worksheet->getCellByColumnAndRow(18, $row)->getValue();

	$sql.= "('$MRP_WHS_GRP', '$WS_CD', '$JOC_CD', '$VENDOR_CD', '$VENDOR_DESC', '$DISB_CHARGE_CD', '$ITEM_NO', '$ITEM_DESC', '$WHS_CD', '$STD_PACK', '$PLAN_LOT_SIZE', '$USAGE_QTY', '$PLAN_LOT_USAGE_QTY', '$SUPPLY_QTY', '$OPEN_QTY', '$PARENT_ITEM_DESC', '$START_ECN_ACCUM_QTY', '$END_ECN_ACCUM_QTY'),";
}
		
$sql = rtrim($sql, ',');
//$sql = str_replace(",", "");
//echo $sql;	
if (mysqli_query($conn, "TRUNCATE TABLE imap_master")){
	if (mysqli_query($conn,$sql)){
		header('Location:aip_imap_master.php');
	}
	else {
		echo 'MYSQL ERROR WHILE INSERTING DATA. PLEASE CHECK SQL INSERT QUERY<br>ERROR:'.mysqli_error($conn);
	}
}
else {
	echo 'MYSQL ERROR. PLEASE CHECK SQL QUERY<br>ERROR:'.mysqli_error($conn);
}
// Redirect to another script
header("Location: aip_imap_master.php");
exit();
?>