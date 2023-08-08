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

<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="aip_styles.css">
<script src="aip_scripts.js"></script>
</head>
<style>
        #planlotBtnContainer { /* 'Planlot' Btn position */
        position: relative;
        top: -1175px; 
        margin-left: 1620px;
        }
		
        #myInput { /* planlot textbox Input position & size */
        position: relative;
        top: -1130px; 
        margin-left: 965px;
        width: 645px;
        height: 40px; 
        }

        #chooseFileBtnContainerautojit { /* 'drag & drop' AutoJit Btn position */
        position: relative;
        top: -560px; 
        margin-left: 968px;
        }

        #buttonContainer { /* 'Dark Mode' Btn position */
        position: relative;
        top: 5px;
        margin-right: 1700px;
        }

        /* Styling for the section header */
        .section-header {
            display: flex;
            justify-content: center;
            background-color: #f2f2f2;
            padding: 20px 0;
        }

        /* Styling for individual links */
        .section-link {
            font-size: 18px;
            font-weight: bold;
            margin: 0 20px;
            text-decoration: none;
            color: #333;
            border-bottom: 2px solid transparent;
            transition: border-color 0.3s ease;
        }

        /* Styling for the links on hover */
        .section-link:hover {
            border-color: #333;
        }
</style>
<script>
function validateFormds() { 
    // Get the selected file
    var fileInput2 = document.getElementById('upstockautojit');
    var file2 = fileInput2.files[0];
    
    // Check if a file is selected
    if (!file2) {
        alert('Please select a file to import.');
        return false; // Prevent form submission
    }
    
    // Check if the file is in xls format
    var fileName2 = file2.name;
    var fileExtension2 = fileName2.split('.').pop().toLowerCase();
    if (fileExtension2 !== 'xls') {
        alert('Please select a xls file to import.');
        return false; // Prevent form submission
    }
    return true; // Allow form submission
}
</script>
<body>
    <title>AutoJIT iMap Pivot</title>
    <script src="jquery-3.6.0.min.js"></script> 
</head>
<body>
    <div class="section-header">
        <?php
        // Define an associative array with section names and their corresponding URLs
        $sections = array(
            "Admin AutoJIT Pivot (AP)" => "ap_master_display.php",
            "Admin AutoJIT iMap Pivot (AIP)" => "aip_imap_master.php",
            "Pivot Extra Part (PEP)" => "pep_master_display.php",
            "AutoJIT Disb Charge (ADC)" => "ab_master_display.php",
			"User AutoJIT Pivot (AP)" => "ap_master_display_user.php",
			"User AutoJIT iMap Pivot (AIP)" => "aip_imap_master_user.php",
            // Add more sections and URLs as needed
        );

        // Loop through the array to generate the links
        foreach ($sections as $sectionName => $sectionURL) {
            echo '<a href="' . $sectionURL . '" class="section-link">' . $sectionName . '</a>';
        }
        ?>
    </div>
    <div id="buttonContainer" style = 'flex:1; text-align:right;'>
        <button id="darkModeButton" onclick="toggleDarkMode()">Dark Mode</button>
    </div>
    <div id="AutoJITPivotBtnContainer">
        <h1><b><?php ?></b>AutoJIT iMap Pivot (AIP)</h1>
    </div>  

    <form method="post" action="aip_imap_insert.php" enctype="multipart/form-data" onsubmit="return validateForm()">
        <br>
        <?php 
            $sql = mysqli_query($conn, "SELECT DISTINCT mrp_whs_grp FROM `imap_master`");
            $data = mysqli_fetch_assoc($sql);
        ?>
        <br>
        <div id="chooseFileBtnContainer">
            <input id="upstock" type="file" name="stk" value="Import" style="display: none;">
            <div id="dragDropArea" style="border: 2px dashed #ccc; padding: 20px; text-align: center; cursor: pointer; width: 700px; height: 400px">
                <br><p>Drag and drop or click to select .csv file</p><br><br><br>
                <h1><p>iMap</p></h1>
            </div>
        </div>
        <div id="ImportAutoJITBtnContainer">
            <button id="ImportAutoJITBtn" type="submit" name="import_stk">Upload</button>
            <!-- <label for="autojitLabel">CSV (Comma delimited)</label> -->
        </div>
    </form>

	<style>
        #ImportAutoJITBtnContainerautojit { /* 'Upload' AutoJit Btn */
        position: relative;
        top: -550px; 
        margin-left: 1310px;
        }
        
        #chooseFileBtnContainerautojit { /* 'drag & drop' AutoJit position */
        position: relative;
        top: -565px; 
        margin-left: 968px;
        }
	</style>
		
    <form method="post" action="aip_autojit_insert.php" enctype="multipart/form-data" onsubmit="return validateFormds()">
        <br>
        <?php 
            $sql = mysqli_query($conn, "SELECT DISTINCT mrp_whs FROM `autojit_master`");
            $data = mysqli_fetch_assoc($sql);
        ?>
        <br>
        <div id="chooseFileBtnContainerautojit">
            <input id="upstockautojit" type="file" name="stkautojit" value="Import" style="display: none;">
            <div id="dragDropArea2" style="border: 2px dashed #ccc; padding: 20px; text-align: center; cursor: pointer; width: 700px; height: 400px">
                <br><p>Drag and drop or click to select .xls file</p><br><br><br>
                <h1><p>AutoJIT</p></h1>
            </div>
        </div>
        <div id="ImportAutoJITBtnContainerautojit">
            <button id="ImportAutoJITBtnautojit" type="submit" name="import_stk">Upload</button>
        </div>
    </form>

    <form method="post" action="" enctype="multipart/form-data">
        <div>
            <input type="text" id="myInput" name="planlotValue" onkeyup="searchPlanlotMaster()" placeholder="Filter Planlot | Eg:23311047 | press slash / key to redirect here" style="font-weight: bold; font-size: 1.2em;"/>
            <div id="planlotBtnContainer">
                <button type="submit" id="planlotBtn" name="submitplanlot" onclick="checkPlanlot()">Planlot</button>
            </div>    
        </div>
    </form>

<!-- <div id="sharedfolder">
	<p>To access SOP user's manual, click 'Copy then paste path into your file explorer:</p>
</div> -->

<div id="sharedfolderaddress">
    <center><a href="file://43.74.45.15/Driver/Irfan%20Intern%20Trainee%202023/[AP][AIP][PEP]SOP/" target="_blank" style="color: white;"></a></center>
</div>

<!-- <div id="copylinkposition">
    <button id="copylinkbtn" onclick="copyLink()">Copy Link</button>
</div> -->

                    <!-- construction -->
<?php 
// Retrieve the $fileName from the session variable
if (isset($_SESSION['uploaded_file_imap'])) {
    $fileNameimap = $_SESSION['uploaded_file_imap'];
    
        // Truncate the table
        $sql = "TRUNCATE TABLE imap_excel_name";
    
        if (mysqli_query($conn, $sql)) {
        } else {
        }

        // Prepare the SQL statement to insert the value into the database table
        $sql = "INSERT INTO imap_excel_name (imap_name) VALUES ('$fileNameimap')";

        // Execute the query
        if ($conn->query($sql) === TRUE) {
            echo "";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

    // Don't forget to unset or clear the session variable if you don't need it anymore
    unset($_SESSION['uploaded_file_imap']);
}
// Step 2: Execute a query to retrieve the desired value from the table
$sql = "SELECT imap_name FROM imap_excel_name";

$result = $conn->query($sql);

// Step 3: Fetch the result of the query
if ($result->num_rows > 0) {
    // Assuming there's only one row returned, you can use fetch_assoc() or fetch_row() for multiple rows.
    $row = $result->fetch_assoc();

    // Step 4: Assign the fetched value to the variable $fileNameimap
    $fileNameimap = $row['imap_name'];
} else {
    // Handle the case where no rows were found
    $fileNameimap = "No data found";
}

//echo $fileName;
?>
    <style>
        /* CSS style to adjust position using pixels */
        #fileNameAutoJIT {
            margin-top: -750px; /* Adjust the top position in pixels */
            margin-left: 120px; /* You can adjust the value as needed */
        }
    </style>

    <div id="fileNameAutoJIT">
        <p><?php echo $fileNameimap; ?></p>
    </div>          <!-- construction -->


                    <!-- construction -->
<?php 
// Retrieve the $fileName from the session variable
if (isset($_SESSION['uploaded_file_autojitt'])) {
    $fileNameautojitt = $_SESSION['uploaded_file_autojitt'];
    
    // Truncate the table
    $sql = "TRUNCATE TABLE autojit_excel_name";
    
    if (mysqli_query($conn, $sql)) {
    } else {
    }

    // Prepare the SQL statement to insert the value into the database table
    $sql = "INSERT INTO autojit_excel_name (autojit_name) VALUES ('$fileNameautojitt')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    // Don't forget to unset or clear the session variable if you don't need it anymore
    unset($_SESSION['uploaded_file_autojitt']);
}

// Step 2: Execute a query to retrieve the desired value from the table
$sql = "SELECT autojit_name FROM autojit_excel_name";

$result = $conn->query($sql);

// Step 3: Fetch the result of the query
if ($result->num_rows > 0) {
    // Assuming there's only one row returned, you can use fetch_assoc() or fetch_row() for multiple rows.
    $row = $result->fetch_assoc();

    // Step 4: Assign the fetched value to the variable $fileNameimap
    $fileNameautojitt = $row['autojit_name'];
} else {
    // Handle the case where no rows were found
    $fileNameautojitt = "No data found";
}

//echo $fileName;
?>
    <style>
        /* CSS style to adjust position using pixels */
        #fileNameAutoJITT {
            margin-top: -35.0px; /* Adjust the top position in pixels */
            margin-left: 990px; /* You can adjust the value as needed */
        }
    </style>


    <div id="fileNameAutoJITT">
        <p><?php echo $fileNameautojitt; ?></p>
    </div>          <!-- construction -->
	
<?php 
    if (isset($_POST['submitplanlot'])) {

        // Process the import logic here
        $filterValue = $_POST['planlotValue'];
    
        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();

       // Get the default worksheet (index 0)
        $worksheet = $spreadsheet->getSheet(0);

        // Set a dynamic name for the worksheet using a variable
        $worksheetName = $filterValue;
        $worksheet->setTitle($worksheetName . ' iMap');
    
        // Create a new sheet and set the data
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'MRP WHS GRP');
        $sheet->setCellValue('B1', 'WS CD');
        $sheet->setCellValue('C1', 'JOC CD');
        $sheet->setCellValue('D1', 'Vendor CD');
        $sheet->setCellValue('E1', 'Vendor Desc');
        $sheet->setCellValue('F1', 'Disb Charge CD');
        $sheet->setCellValue('G1', 'Item No');
        $sheet->setCellValue('H1', 'Item Desc');
        $sheet->setCellValue('I1', 'WHS CD');
        $sheet->setCellValue('J1', 'Std Pack');
        $sheet->setCellValue('K1', 'Plan Lot Size');
        $sheet->setCellValue('L1', 'Usage Qty');
        $sheet->setCellValue('M1', 'Planlot Usage Qty');
        $sheet->setCellValue('N1', 'Supply Qty');
        $sheet->setCellValue('O1', 'Open Qty');
        $sheet->setCellValue('P1', 'Parent Item Desc');
        $sheet->setCellValue('Q1', 'Start ECN Accum Qty');
        $sheet->setCellValue('R1', 'End ECN Accum Qty');
    
        // Fetch the data from the database and populate the Excel sheet
        $query = "SELECT * FROM imap_master WHERE joc_cd = '$filterValue'";
        $result = mysqli_query($conn, $query);
        $rowIndex = 2; // Start from row 2 for data
        while ($row = mysqli_fetch_assoc($result)) {
    
            $sheet->setCellValue('A' . $rowIndex, $row['mrp_whs_grp']);
            $sheet->setCellValue('B' . $rowIndex, $row['ws_cd']);
            $sheet->setCellValue('C' . $rowIndex, $row['joc_cd']);
            $sheet->setCellValue('D' . $rowIndex, $row['vendor_cd']);
            $sheet->setCellValue('E' . $rowIndex, $row['vendor_desc']);
            $sheet->setCellValue('F' . $rowIndex, $row['disb_charge_cd']);
            $sheet->setCellValue('G' . $rowIndex, $row['item_no']);
            $sheet->setCellValue('H' . $rowIndex, $row['item_desc']);
            $sheet->setCellValue('I' . $rowIndex, $row['whs_cd']);
            $sheet->setCellValue('J' . $rowIndex, $row['std_pack']);
            $sheet->setCellValue('K' . $rowIndex, $row['plan_lot_size']);
            $sheet->setCellValue('L' . $rowIndex, $row['usage_qty']);
            $sheet->setCellValue('M' . $rowIndex, $row['plan_lot_usage_qty']);
            $sheet->setCellValue('N' . $rowIndex, $row['supply_qty']);
            $sheet->setCellValue('O' . $rowIndex, $row['open_qty']);
            $sheet->setCellValue('P' . $rowIndex, $row['parent_item_desc']);
            $sheet->setCellValue('Q' . $rowIndex, $row['start_ecn_accum_qty']);
            $sheet->setCellValue('R' . $rowIndex, $row['end_ecn_accum_qty']);
    
            $rowIndex++;
        }
        // Create a new sheet and set the data
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle($worksheetName . ' AutoJIT');
        
        // Set the headers for the second sheet
        $sheet2->setCellValue('A1', 'MRP WHS');
        $sheet2->setCellValue('B1', 'Reference');
        $sheet2->setCellValue('C1', 'Part No');
        $sheet2->setCellValue('D1', 'Part Description');
        $sheet2->setCellValue('E1', 'Dely Pattern');
        $sheet2->setCellValue('F1', 'Supplier');
        $sheet2->setCellValue('G1', 'Po Number');
        $sheet2->setCellValue('H1', 'Delivery Qty');
        $sheet2->setCellValue('I1', 'WS CD');
        $sheet2->setCellValue('J1', 'Ship To Location');
        $sheet2->setCellValue('K1', 'Date & ETA');
        $sheet2->setCellValue('L1', 'Trans DT');
        $sheet2->setCellValue('M1', 'Process DT');
        $sheet2->setCellValue('N1', 'Rcv DT');
        $sheet2->setCellValue('O1', 'RCV Qty');
        $sheet2->setCellValue('P1', 'JOC No');
        $sheet2->setCellValue('Q1', 'Outstanding Qty');
        $sheet2->setCellValue('R1', 'Rcv Status');
        $sheet2->setCellValue('S1', 'Batch ID');
        $sheet2->setCellValue('T1', 'Buyer_Name');
        $sheet2->setCellValue('U1', 'Export Date');

        // Fetch the data for the second sheet from the database and populate the Excel sheet
        $query2 = "SELECT * FROM autojit_master WHERE joc_no = '$filterValue'";
        $result2 = mysqli_query($conn, $query2);
        $rowIndex2 = 2; // Start from row 2 for data
        while ($row2 = mysqli_fetch_assoc($result2)) {
            $sheet2->setCellValue('A' . $rowIndex2, $row2['mrp_whs']);
            $sheet2->setCellValue('B' . $rowIndex2, $row2['reference']);
            $sheet2->setCellValue('C' . $rowIndex2, $row2['partno']);
            $sheet2->setCellValue('D' . $rowIndex2, $row2['partdesc']);
            $sheet2->setCellValue('E' . $rowIndex2, $row2['delypattern']);
            $sheet2->setCellValue('F' . $rowIndex2, $row2['supplier']);
            $sheet2->setCellValue('G' . $rowIndex2, $row2['pono']);
            $sheet2->setCellValue('H' . $rowIndex2, $row2['deliverqty']);
            $sheet2->setCellValue('I' . $rowIndex2, $row2['ws_cd']);
            $sheet2->setCellValue('J' . $rowIndex2, $row2['shiptolocation']);
            $sheet2->setCellValue('K' . $rowIndex2, $row2['dateeta']);
            $sheet2->setCellValue('L' . $rowIndex2, $row2['transdt']);
            $sheet2->setCellValue('M' . $rowIndex2, $row2['processdt']);
            $sheet2->setCellValue('N' . $rowIndex2, $row2['rcvdt']);
            $sheet2->setCellValue('O' . $rowIndex2, $row2['rcvqty']);
            $sheet2->setCellValue('P' . $rowIndex2, $row2['joc_no']);
            $sheet2->setCellValue('Q' . $rowIndex2, $row2['outstandingqty']);
            $sheet2->setCellValue('R' . $rowIndex2, $row2['rcvstat']);
            $sheet2->setCellValue('S' . $rowIndex2, $row2['batch_id']);
            $sheet2->setCellValue('T' . $rowIndex2, $row2['buyer_name']);
            $sheet2->setCellValue('U' . $rowIndex2, $row2['export_date']);

        $rowIndex2++;
        }

        // Create a new sheet for the pivot table
        $pivotSheet = $spreadsheet->createSheet();
        $pivotSheet->setTitle('PIV Comparison');

        // Hide row number 2 in the "PIV" sheet
        $pivotSheet->getRowDimension(3)->setVisible(false);

        // Define the range of data for the pivot table
        $dataRange = 'A1:U' . ($rowIndex - 1); // Assuming the data range is from A1 to U(rowIndex-1)

        // Define the pivot table structure
        $rowField = 'G';    // Item No
        $columnField = 'H'; // Item Desc
        $dataField = 'M';   // Planlot Usage Qty
        //$dateEtaField = 'K'; // Date & ETA field

        // Set up the layout of the pivot table
        //$pivotSheet->setCellValue('A1', 'iMaps');
        $pivotSheet->setCellValue('A2', 'Item No');
        $pivotSheet->setCellValue('B2', 'Item Description');

        // Calculate the summarized values
        $data = $sheet->rangeToArray($dataRange, null, true, true, true); // Get the data from the original sheet
        $pivotData = array(); // Array to hold the pivot table data

        foreach ($data as $row) {
            $rowData = array();
            $rowValue = $row[$rowField];
            $columnValue = $row[$columnField];
            $dataValue = $row[$dataField];
            //$dateEtaValue = $row[$dateEtaField];

            // Check if the row and column combination already exists in the pivot table data
            if (isset($pivotData[$rowValue][$columnValue][$dateEtaValue])) {
                $pivotData[$rowValue][$columnValue][$dateEtaValue] += $dataValue;
            } else {
                $pivotData[$rowValue][$columnValue][$dateEtaValue] = $dataValue;
            }
        }

        // Populate the pivot table
        $columnIndex = 3; // Start column index for Date & ETA values

        // Set the unique Date & ETA values in columns
        $uniqueDateEtaValues = array();
        foreach ($pivotData as $rowValue => $rowData) {
            foreach ($rowData as $columnValue => $data) {
                        foreach ($data as $dateEtaValue => $dataValue) {
                            if (!in_array($dateEtaValue, $uniqueDateEtaValues)) {
                                $uniqueDateEtaValues[] = $dateEtaValue;
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
        foreach ($uniqueDateEtaValues as $dateEtaValue) {
            $pivotSheet->setCellValueByColumnAndRow($columnIndex, 1, $dateEtaValue);
            $columnIndex++;
        }
        $rowIndex = 3;
        foreach ($pivotData as $rowValue => $rowData) {
            foreach ($rowData as $columnValue => $data) {
                        $pivotSheet->setCellValue('A' . $rowIndex, $rowValue);
                        $pivotSheet->setCellValue('B' . $rowIndex, $columnValue);
        
                        $columnIndex = 6; // Reset column index for Date & ETA values
                        foreach ($uniqueDateEtaValues as $dateEtaValue) {
                            if (isset($data[$dateEtaValue])) {
                                $pivotSheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $data[$dateEtaValue]);
                            }
                            $columnIndex++;
                        }
                        $rowIndex++;
                    }
                }      
        $grandTotalColumn = count($uniqueDateEtaValues) + 5; // Calculate the column index for the grand total column
        $grandTotalRow = $rowIndex;

        // Add grand total column header
        $pivotSheet->setCellValueByColumnAndRow($grandTotalColumn, 2, 'P/Lot Usage Qty');

        // Calculate the sum for each row of Part No
        $rowIndex = 3;
        foreach ($pivotData as $rowValue => $rowData) {
            $rowTotal = 0;
            foreach ($rowData as $columnValue => $data) {
                        foreach ($data as $dateEtaValue => $dataValue) {
                            if (isset($data[$dateEtaValue])) {
                                $rowTotal += intval($data[$dateEtaValue]); // Convert the data value to an integer using intval()
                            }
                        }
                    }
            $pivotSheet->setCellValueByColumnAndRow($grandTotalColumn, $rowIndex, $rowTotal);
            $rowIndex++;
        }
        // Calculate the sum for each column of Date & ETA
        $columnIndex = 6;
        foreach ($uniqueDateEtaValues as $dateEtaValue) {
            $columnTotal = 0;
            foreach ($pivotData as $rowValue => $rowData) {
                foreach ($rowData as $columnValue => $data) {
                            if (isset($data[$dateEtaValue])) {
                                $columnTotal += intval($data[$dateEtaValue]); // Convert the data value to an integer using intval()
                            }
                        }
                    } 
            $pivotSheet->setCellValueByColumnAndRow($columnIndex, $grandTotalRow, $columnTotal);
            $columnIndex++;
        }
        // Calculate the grand total
        $grandTotal = 0;
        foreach ($pivotData as $rowValue => $rowData) {
            foreach ($rowData as $columnValue => $data) {
                        foreach ($data as $dateEtaValue => $dataValue) {
                            if (isset($data[$dateEtaValue])) {
                                $grandTotal += intval($data[$dateEtaValue]); // Convert the data value to an integer using intval()
                            }
                        }
                    }
                }
        $pivotSheet->setCellValueByColumnAndRow($grandTotalColumn, $grandTotalRow, $grandTotal);

        // Add "Grand Total" label to the last row at the bottom
        $pivotSheet->setCellValue('A' . $grandTotalRow, 'Grand Total');
        $pivotSheet->getRowDimension($grandTotalRow)->setVisible(false);

        // Adjust column widths to fit content perfectly and set specific widths if desired
        $columnWidths = [
          'A' => 25,  // Example: Set column A width to 15
          'B' => 10,  // Example: Set column B width to 20
          'C' => 0,
        ];  // Add more columns and widths as needed

        // Set column width
        foreach ($columnWidths as $columnLetter => $width) {
          $columnIndex = Coordinate::columnIndexFromString($columnLetter);
          $columnDimension = $pivotSheet->getColumnDimensionByColumn($columnIndex);

          if ($columnLetter === 'C' || $columnLetter !== 'C') {
              $columnLetter == $columnDimension->setWidth($width);
          }
          if ($columnLetter === 'C') {
            $pivotSheet->removeColumnByIndex($columnIndex);
          }
        }
        // Autofit column width
        foreach (range('A', $pivotSheet->getHighestColumn()) as $columnLetter) {
          $columnIndex = Coordinate::columnIndexFromString($columnLetter);
          $columnDimension = $pivotSheet->getColumnDimensionByColumn($columnIndex);

          if ($columnLetter === 'C' || $columnLetter !== 'C') {
              $columnLetter = $columnDimension->setAutoSize(true);
          }
          if ($columnLetter === 'C') {
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
        $pivotSheet->getRowDimension(3)->setVisible(false);

// Define the range of data for the pivot table
$dataRange2 = 'A1:U' . ($rowIndex2 - 1); // Assuming the data range is from A1 to U(rowIndex-1)

// Define the pivot table structure
$rowField2 = 'D';    // Part Description
$columnField2 = 'C'; // Part No
$supplierField = 'F'; // supplier
$rcvstatField = 'R'; // rcvstat
$dataField2 = 'H';   // Delivery Qty
//$dateEtaField = 'K'; // Date & ETA field

// Set up the layout of the pivot table
$pivotSheet->setCellValue('K1', 'AutoJit');
$pivotSheet->setCellValue('K2', 'Part Description');
$pivotSheet->setCellValue('L2', 'Part No');
$pivotSheet->setCellValue('M2', 'Supplier');
$pivotSheet->setCellValue('N2', 'Rcv Status');

$pivotSheet->setCellValue('C2', 'Supplier');
$pivotSheet->setCellValue('D2', 'Rcv Status');
$pivotSheet->setCellValue('E1', 'Sum of');
$pivotSheet->setCellValue('F1', 'Sum of');
$pivotSheet->setCellValue('F2', 'Delivery Qty');
$pivotSheet->setCellValue('G2', 'Extra / Shortage');

// Calculate the summarized values
$data2 = $sheet2->rangeToArray($dataRange2, null, true, true, true); // Get the data from the original sheet
$pivotData2 = array(); // Array to hold the pivot table data

foreach ($data2 as $row2) {
    $rowData2 = array();
    $rowValue2 = $row2[$rowField2];
    $columnValue2 = $row2[$columnField2];
    $supplierValue = $row2[$supplierField];
    $rcvstatValue = $row2[$rcvstatField];
    $dataValue2 = $row2[$dataField2];
    $dateEtaValue2 = $row2[$dateEtaField];

    // Check if the row and column combination already exists in the pivot table data
    if (isset($pivotData2[$rowValue2][$columnValue2][$supplierValue][$rcvstatValue][$dateEtaValue2])) {
        $pivotData2[$rowValue2][$columnValue2][$supplierValue][$rcvstatValue][$dateEtaValue2] += $dataValue2;
    } else {
        $pivotData2[$rowValue2][$columnValue2][$supplierValue][$rcvstatValue][$dateEtaValue2] = $dataValue2;
    }
}
// Populate the pivot table
$columnIndex2 = 9; // Start column index for Date & ETA values

// Set the unique Date & ETA values in columns
$uniqueDateEtaValues2 = array();
foreach ($pivotData2 as $rowValue2 => $rowData2) {
    foreach ($rowData2 as $columnValue2 => $data2) {
        foreach ($data2 as $supplierValue => $supplierData){
            foreach ($supplierData as $rcvstatValue => $rcvstatData){
                foreach ($rcvstatData as $dateEtaValue2 => $dataValue2) {
                    if (!in_array($dateEtaValue2, $uniqueDateEtaValues2)) {
                        $uniqueDateEtaValues2[] = $dateEtaValue2;
                    }
                }
            }
        }
    }
}
// Sort the unique Date & ETA values based on time (AM to PM)
usort($uniqueDateEtaValues2, function($a, $b) {
    $aTime = strtotime($a);
    $bTime = strtotime($b);
    return $aTime <=> $bTime;
});

// Set the sorted Date & ETA values in columns
foreach ($uniqueDateEtaValues2 as $dateEtaValue2) {
    $pivotSheet->setCellValueByColumnAndRow($columnIndex2, 1, $dateEtaValue2);
    $columnIndex2++;
}
$rowIndex2 = 3;
foreach ($pivotData2 as $rowValue2 => $rowData2) {
    foreach ($rowData2 as $columnValue2 => $data2) {
        foreach ($data2 as $supplierValue => $supplierData){
            foreach ($supplierData as $rcvstatValue => $rcvstatData){
                $pivotSheet->setCellValue('K' . $rowIndex2, $rowValue2);
                $pivotSheet->setCellValue('L' . $rowIndex2, $columnValue2);
                $pivotSheet->setCellValue('M' . $rowIndex2, $supplierValue);
                $pivotSheet->setCellValue('N' . $rowIndex2, $rcvstatValue);

                $columnIndex2 = 15; // Reset column index for Date & ETA values
                foreach ($uniqueDateEtaValues2 as $dateEtaValue2) {
                    if (isset($rcvstatData[$dateEtaValue2])) {
                        $pivotSheet->setCellValueByColumnAndRow($columnIndex2, $rowIndex2, $rcvstatData[$dateEtaValue2]);
                    }
                    $columnIndex2++;
                }
                $rowIndex2++;
            }
        }
    }
}
$grandTotalColumn2 = count($uniqueDateEtaValues2) + 14; // Calculate the column index for the grand total column
$grandTotalRow2 = $rowIndex2;

// Add grand total column header
$pivotSheet->setCellValueByColumnAndRow($grandTotalColumn2, 2, 'Sum of Delivery Qty');

// Calculate the sum for each row of Part No
$rowIndex2 = 3;
foreach ($pivotData2 as $rowValue2 => $rowData2) {
    $rowTotal2 = 0;
    foreach ($rowData2 as $columnValue2 => $data2) {
        foreach ($data2 as $supplierValue => $supplierData){
            foreach ($supplierData as $rcvstatValue => $rcvstatData){
                foreach ($rcvstatData as $dateEtaValue2 => $dataValue2) {
                    if (isset($rcvstatData[$dateEtaValue2])) {
                        $rowTotal2 += intval($rcvstatData[$dateEtaValue2]); // Convert the data value to an integer using intval()
                    }
                }
            }
        }
    }
    $pivotSheet->setCellValueByColumnAndRow($grandTotalColumn2, $rowIndex2, $rowTotal2);
    $rowIndex2++;
}
// Calculate the sum for each column of Date & ETA
$columnIndex2 = 15;
foreach ($uniqueDateEtaValues2 as $dateEtaValue2) {
    $columnTotal2 = 0;
    foreach ($pivotData2 as $rowValue2 => $rowData2) {
        foreach ($rowData2 as $columnValue2 => $data2) {
            foreach ($data2 as $supplierValue => $supplierData){
                foreach ($supplierData as $rcvstatValue => $rcvstatData){
                    if (isset($rcvstatData[$dateEtaValue2])) {
                        $columnTotal2 += intval($rcvstatData[$dateEtaValue2]); // Convert the data value to an integer using intval()
                    }
                }
            } 
        }
    }
    $pivotSheet->setCellValueByColumnAndRow($columnIndex2, $grandTotalRow2, $columnTotal2);
    $columnIndex2++;
}
// Calculate the grand total
$grandTotal2 = 0;
foreach ($pivotData2 as $rowValue2 => $rowData2) {
    foreach ($rowData2 as $columnValue2 => $data2) {
        foreach ($data2 as $supplierValue => $supplierData){
            foreach ($supplierData as $rcvstatValue => $rcvstatData){
                foreach ($rcvstatData as $dateEtaValue2 => $dataValue2) {
                    if (isset($rcvstatData[$dateEtaValue2])) {
                        $grandTotal2 += intval($rcvstatData[$dateEtaValue2]); // Convert the data value to an integer using intval()
                    }
                }
            }
        }
    }
}
$pivotSheet->setCellValueByColumnAndRow($grandTotalColumn2, $grandTotalRow2, $grandTotal2);

// Add "Grand Total" label to the last row at the bottom
$pivotSheet->setCellValue('K' . $grandTotalRow2, 'Grand Total');

// Adjust column widths to fit content perfectly and set specific widths if desired
$columnWidths = [
  'A' => 25,  // Example: Set column A width to 15
  'B' => 10,  // Example: Set column B width to 20
  'C' => 0,
];  // Add more columns and widths as needed

// Set column width
foreach ($columnWidths as $columnLetter => $width) {
  $columnIndex2 = Coordinate::columnIndexFromString($columnLetter);
  $columnDimension = $pivotSheet->getColumnDimensionByColumn($columnIndex2);

  if ($columnLetter === 'K' || $columnLetter !== 'K') {
      $columnLetter == $columnDimension->setWidth($width);
  }
  if ($columnLetter === 'K') {
    $pivotSheet->removeColumnByIndex($columnIndex2);
  }
}
// Autofit column width
foreach (range('A', $pivotSheet->getHighestColumn()) as $columnLetter) {
  $columnIndex2 = Coordinate::columnIndexFromString($columnLetter);
  $columnDimension = $pivotSheet->getColumnDimensionByColumn($columnIndex2);

  if ($columnLetter === 'K' || $columnLetter !== 'K') {
      $columnLetter = $columnDimension->setAutoSize(true);
  }
  if ($columnLetter === 'K') {
    $pivotSheet->removeColumnByIndex($columnIndex2);
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
for ($columnIndex2 = 1; $columnIndex2 <= $lastColumnIndex; $columnIndex2++) {
    $columnLetter = Coordinate::stringFromColumnIndex($columnIndex2);
    $range = $columnLetter . '1:' . $columnLetter . $lastRowIndex;
    $pivotSheet->getStyle($range)->applyFromArray($styleArray);
}
        $lastRow = $rowIndex;
        for ($row = 4; $row <= $lastRow; $row++){
            $valueL = $pivotSheet->getCell('L' . $row)->getValue(); // part no autojit
            $valueO = $pivotSheet->getCell('O' . $row)->getValue(); // int autojit
        
            for($rowj = 4; $rowj <= $lastRow; $rowj++){
                $valueA = $pivotSheet->getCell('A' . $rowj)->getValue(); // part imap
                $valueE = $pivotSheet->getCell('E' . $rowj)->getValue(); // int imap
                $valueB = $pivotSheet->getCell('B' . $rowj)->getValue(); // desc imap

                // check if part no are the same
                if ($valueL == $valueA){
                    // Perform the subtraction
                    $result = $valueO - $valueE;

                    // Display the result
                    $pivotSheet->setCellValue('P' . $row, $result);                  
                } 
            }
        }
        $pivotSheet->setCellValue('P2', 'Extra / Shortage');

        $lastRow = $rowIndex;
        for ($row = 4; $row < $lastRow; $row++){
            $valueA = $pivotSheet->getCell('A' . $row)->getValue(); // part no imap
            $valueB = $pivotSheet->getCell('B' . $row)->getValue(); // desc imap
            $valueE = $pivotSheet->getCell('E' . $row)->getValue(); // int imap
        
            for($rowj = $row; $rowj < $lastRow; $rowj++){
                $valueL = $pivotSheet->getCell('L' . $rowj)->getValue(); // part no autojit
                $valueK = $pivotSheet->getCell('K' . $rowj)->getValue(); // desc autojit
                // check if part no and desc same
   
                if ($valueA != $valueL){
                    $zero = 0;
                    $result = $zero - $valueE;
                    // Display the result
                    $pivotSheet->setCellValue('G' . $rowj, $result);
                }
            }
        }
        $lastRow = $rowIndex;
        for ($row = 4; $row <= $lastRow; $row++){
            $valueA = $pivotSheet->getCell('A' . $row)->getValue(); // part imap
            $valueG = $pivotSheet->getCell('G' . $row)->getValue(); // int imap -

            for($rowj = 4; $rowj <= $lastRow; $rowj++){
                $valueL = $pivotSheet->getCell('L' . $rowj)->getValue(); // part no autojit
                $valueO = $pivotSheet->getCell('O' . $rowj)->getValue(); // int autojit
                $valueM = $pivotSheet->getCell('M' . $rowj)->getValue(); // autojit supplier
                $valueN = $pivotSheet->getCell('N' . $rowj)->getValue(); // autojit rcvstat
                $valueO = $pivotSheet->getCell('O' . $rowj)->getValue(); // autojit sum delivery qty

                // check if part no are the same
                if ($valueA == $valueL){
                    // Perform the subtraction
                    $result = $valueG + $valueO;

                    // Display the result
                    $pivotSheet->setCellValue('C' . $row, $valueM);
                    $pivotSheet->setCellValue('D' . $row, $valueN);
                    $pivotSheet->setCellValue('F' . $row, $valueO);
                    $pivotSheet->setCellValue('G' . $row, $result);
                } 
            }
        }
        $lastRow = $rowIndex;
        for ($row = 4; $row < $lastRow; $row++){
            $valueF = $pivotSheet->getCell('F' . $row)->getValue(); // int autojit
            $valueE = $pivotSheet->getCell('E' . $row)->getValue(); // int imap
            $valueG = $pivotSheet->getCell('G' . $row)->getValue(); // ex/short

            if ($valueF === NULL) {
                // $valueF does not exist
                $zero = 0;
                $pivotSheet->setCellValue('F' . $row, $zero);
            } else {
                // $valueF exists
                $checkminus = $valueF - $valueE;

                if ($checkminus != $valueG){
                    //$valueG is false
                    $pivotSheet->setCellValue('G' . $row, $checkminus);
                }
                else{
                    //$valueG is true
                }
            }
        }
        $pivotSheet->getColumnDimension('K')->setVisible(false);
        $pivotSheet->getColumnDimension('L')->setVisible(false);
        $pivotSheet->getColumnDimension('M')->setVisible(false);
        $pivotSheet->getColumnDimension('N')->setVisible(false);
        $pivotSheet->getColumnDimension('O')->setVisible(false);
        $pivotSheet->getColumnDimension('P')->setVisible(false);

        // Save the Excel file to planlot_Pivot
        $writer = new Xlsx($spreadsheet);
        $filename = 'amd_Pivot_Comparison.xlsx';
        $excelPivot = $filterValue;
        $filename = str_replace('amd', $excelPivot, $filename);
        $saveDirectory = 'C:/xampp/htdocs/AP/aip_savedFile/planlot_Pivot/';
        $filePath = $saveDirectory . $filename;
        $writer->save($filePath);
        
        // Redirect to the new Excel file
        $redirectPath = 'aip_savedFile/planlot_Pivot/' . $filename;
        header('Location: ' . $redirectPath);
        exit();
      }        
   
        $directory = 'C:/xampp/htdocs/AP/aip_savedFile/planlot_Pivot/';

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
		
/*$result = mysqli_query($conn, "SELECT * FROM autojit_master");
$numRows = mysqli_num_rows($result);

if ($numRows > 0) {
    echo '<table id="amdata" style="border: 1px solid black; position: absolute; top: 5%; transform: translate(-0%, -0%);">';
    echo '<tr>
            <th>MRP WHS</th>
            <th>Reference</th>
            <th>Part No</th>
            <th>Part Description</th>
            <th>Dely Pattern</th>
            <th>Supplier</th>
            <th>Po Number</th>
            <th>Delivery Qty</th>
            <th>WS CD</th>
            <th>Ship To Location</th>
            <th>Date & ETA</th>
            <th>Trans DT</th>
            <th>Process DT</th>
            <th>Rcv DT</th>
            <th>RCV Qty</th>
            <th>JOC No</th>
            <th>Outstanding Qty</th>
            <th>Rcv Status</th>
            <th>Batch ID</th>
            <th>Buyer_Name</th>
            <th>Export Date</th>
            </tr>';

    while ($row = mysqli_fetch_assoc($result)) {
        $joc_no = $row['joc_no'];
        $dateeta = $row['dateeta'];
        echo '<tr>';
        echo '<td class="table-cell">' . $row['mrp_whs'] . '</td>';
        echo '<td class="table-cell">' . $row['reference'] . '</td>';
        echo '<td class="table-cell">' . $row['partno'] . '</td>';
        echo '<td class="table-cell">' . $row['partdesc'] . '</td>';
        echo '<td class="table-cell">' . $row['delypattern'] . '</td>';
        echo '<td class="table-cell">' . $row['supplier'] . '</td>';
        echo '<td class="table-cell">' . $row['pono'] . '</td>';
        echo '<td class="table-cell">' . $row['deliverqty'] . '</td>';
        echo '<td class="table-cell">' . $row['ws_cd'] . '</td>';
        echo '<td class="table-cell">' . $row['shiptolocation'] . '</td>';
        echo '<td class="table-cell">' . $row['dateeta'] . '</td>';
        echo '<td class="table-cell">' . $row['transdt'] . '</td>';
        echo '<td class="table-cell">' . $row['processdt'] . '</td>';
        echo '<td class="table-cell">' . $row['rcvdt'] . '</td>';
        echo '<td class="table-cell">' . $row['rcvqty'] . '</td>';
        echo '<td class="table-cell">' . $row['joc_no'] . '</td>';
        echo '<td class="table-cell">' . $row['outstandingqty'] . '</td>';
        echo '<td class="table-cell">' . $row['rcvstat'] . '</td>';
        echo '<td class="table-cell">' . $row['batch_id'] . '</td>';
        echo '<td class="table-cell">' . $row['buyer_name'] . '</td>';
        echo '<td class="table-cell">' . $row['export_date'] . '</td>';
        echo '</tr>';
   }
  echo '</table>';
} else {
  echo 'No data found.';
}

$result = mysqli_query($conn, "SELECT * FROM imap_master");
$numRows = mysqli_num_rows($result);

if ($numRows > 0) {
    echo '<table id="imdata" style="border: 1px solid black; position: absolute; top: 5%; transform: translate(-0%, -0%);">';
    echo '<tr>
            <th>MRP WHS GRP</th>
            <th>WS CD</th>
            <th>JOC CD</th>
            <th>Vendor CD</th>
            <th>Vendor Description</th>
            <th>Disb Charge CD</th>
            <th>Item No</th>
            <th>Item Description</th>
            <th>WHS CD</th>
            <th>Std Pack</th>
            <th>Planlot Size</th>
            <th>Usage Qty</th>
            <th>Planlot Usage Qty</th>
            <th>Supply Qty</th>
            <th>Open Qty</th>
            <th>Parent Item Description</th>
            <th>Start ECN Accum Qty</th>
            <th>End ECN Accum Qty</th>
            </tr>';

    while ($row = mysqli_fetch_assoc($result)) {
        $joc_cd = $row['joc_cd'];
        echo '<tr>';
        echo '<td class="table-cell">' . $row['mrp_whs_grp'] . '</td>';
        echo '<td class="table-cell">' . $row['ws_cd'] . '</td>';
        echo '<td class="table-cell">' . $row['joc_cd'] . '</td>';
        echo '<td class="table-cell">' . $row['vendor_cd'] . '</td>';
        echo '<td class="table-cell">' . $row['vendor_desc'] . '</td>';
        echo '<td class="table-cell">' . $row['disb_charge_cd'] . '</td>';
        echo '<td class="table-cell">' . $row['item_no'] . '</td>';
        echo '<td class="table-cell">' . $row['item_desc'] . '</td>';
        echo '<td class="table-cell">' . $row['whs_cd'] . '</td>';
        echo '<td class="table-cell">' . $row['std_pack'] . '</td>';
        echo '<td class="table-cell">' . $row['plan_lot_size'] . '</td>';
        echo '<td class="table-cell">' . $row['usage_qty'] . '</td>';
        echo '<td class="table-cell">' . $row['plan_lot_usage_qty'] . '</td>';
        echo '<td class="table-cell">' . $row['supply_qty'] . '</td>';
        echo '<td class="table-cell">' . $row['open_qty'] . '</td>';
        echo '<td class="table-cell">' . $row['parent_item_desc'] . '</td>';
        echo '<td class="table-cell">' . $row['start_ecn_accum_qty'] . '</td>';
        echo '<td class="table-cell">' . $row['end_ecn_accum_qty'] . '</td>';
        echo '</tr>';
   }
  echo '</table>';
} else {
  echo 'No data found.';
}*/
ob_end_flush();
?>
</body>
</html>