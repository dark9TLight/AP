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

<script src="ap_script.js"></script>
</head>
<script>
function validateForm() {
        // Get the selected file
        var fileInput = document.getElementById('upstock');
        var file = fileInput.files[0];
        
        // Check if a file is selected
        if (!file) {
            alert('Please select a file to import.');
            return false; // Prevent form submission
        }
        
        // // Check if the file is in csv format
        // var fileName = file.name;
        // var fileExtension = fileName.split('.').pop().toLowerCase();
        // if (fileExtension !== 'CSV') {
            // alert('Please select a csv file to import.');
            // return false; // Prevent form submission
        // }
        
        return true; // Allow form submission
    }
	    document.addEventListener("DOMContentLoaded", function() {
        var dragDropArea = document.getElementById("dragDropArea");
        var fileInput = document.getElementById("upstock");

        dragDropArea.addEventListener("dragover", function(e) {
            e.preventDefault();
            dragDropArea.style.backgroundColor = "#f2f2f2";
        });

        dragDropArea.addEventListener("dragleave", function(e) {
            e.preventDefault();
            dragDropArea.style.backgroundColor = "transparent";
        });

        dragDropArea.addEventListener("drop", function(e) {
            e.preventDefault();
            dragDropArea.style.backgroundColor = "#008000";
            fileInput.files = e.dataTransfer.files;
        });

        dragDropArea.addEventListener("click", function() {
            fileInput.click();
        });

        fileInput.addEventListener("change", function() {
            dragDropArea.style.backgroundColor = "transparent";
        });
    });
</script>
<body>
    <link rel="stylesheet" href="new 1.css">
    <link rel="stylesheet" href="style.css">
    <title>AutoJIT Pivot</title>
    <script src="jquery-3.6.0.min.js"></script> 
</head>
<body>
<style>
    body { 
        background-color: black; /* default background color black */
            color: white; /* default font white */
    }
    .table-cell { 
        border: 1px solid white; /* cell border white */
        text-align: center; /* text inside cell center */
    }
    h1 {
        color: white;
    }
    body.dark-mode { /* if user click 'Dark Mode' background will switch from default dark background to white background and font vice versa */
        background-color: #fff; /* white */
        color: #000; /* black */
    }
     
    #darkModeButton { /* 'Dark Mode' Btn size */
        width: 90px; 
        height: 30px; 
    }
    
    #planlotBtn { /* planlot Btn size */
        width: 90px; 
        height: 50px;
    }
    

    #ImportAutoJITBtn { /* Upload AutoJit Btn size */
        width: 137px; 
        height: 50px; 
    }

    #upstock { /* choose Btn size */
        width: 900px; 
        height: 20px; 
    }
    
	#sharedfolder { /* 'To access SOP user's manual, ...' position  */
    position: relative;
    top: -370px; 
    margin-left: -4px;
    }
    #sharedfolderaddress { /* SOP link position  */
        position: relative;
        top: -360px; 
        margin-left: -1138px;
    }
    #copylinkposition { /* 'Copy Link' Btn position  */
        position: relative;
        top: -412px; 
        margin-left: 187px;
    }
    #copylinkbtn{ /* 'Copy Link' Btn size  */
        width: 75px; 
        height: 30px; 
    }

        #chooseFileBtnContainer { /* drag & drop position */
        position: relative;
        top: -65px;
        margin-left: 468px;
        /* margin-left: 400px; */
        }

        #ImportAutoJITBtnContainer { /* Upload AutoJit Btn position */
        position: relative;
        top: -60px; 
        margin-left: 873px;
        }

        #planlotBtnContainer { /* planlot Btn position */
        position: relative;
        top: -765px; 
        margin-left: 1620px;
        }

        #myInput { /* planlot textbox position & size */
        position: relative;
        top: -715px; 
        margin-left: 1070px;
        width: 540px;
        height: 45px; 
        }

        #AutoJITPivotBtnContainer { /* AutoJIT Pivot (AP) title position */
        position: relative;
        top: -45px; 
        margin-left: 200px;
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
        <h1><b><?php ?></b>AutoJIT Pivot (AP)</h1>
    </div>  

    <form method="post" action="ap_insert_stk.php" enctype="multipart/form-data" onsubmit="return validateForm()">
        <br>
        <?php 
            $sql = mysqli_query($conn, "SELECT DISTINCT mrp_whs FROM `ap_master`");
            $data = mysqli_fetch_assoc($sql);
        ?>
        <br>
        <div id="chooseFileBtnContainer">
            <input id="upstock" type="file" name="stk" value="Import" style="display: none;">
            <div id="dragDropArea" style="border: 2px dashed #ccc; padding: 20px; text-align: center; cursor: pointer; width: 900px; height: 480px">
                <br><br><br><br><br><br><br><br><br><br><p>Drag and drop or click to select a .xls file</p>
            </div>
        </div>
        <div id="ImportAutoJITBtnContainer">
            <button id="ImportAutoJITBtn" type="submit" name="import_stk">Upload</button>
        </div>
    </form>

    <form method="post" action="ap_master_display.php" enctype="multipart/form-data">
        <div>
            <input type="text" id="myInput" name="planlotValue" onkeyup="searchPlanlotMaster()" placeholder="Filter Planlot | Eg:23311047 | key slash / to redirect here" style="font-weight: bold; font-size: 1.2em;"/>
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
if (isset($_SESSION['uploaded_file'])) {
    $fileName = $_SESSION['uploaded_file'];

    // Truncate the table
    $sql = "TRUNCATE TABLE ap_excel_name";
    
    if (mysqli_query($conn, $sql)) {
    } else {
    }
    
    // Prepare the SQL statement to insert the value into the database table
    $sql = "INSERT INTO ap_excel_name (ap_name) VALUES ('$fileName')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Don't forget to unset or clear the session variable if you don't need it anymore
    unset($_SESSION['uploaded_file']);
}

// Step 2: Execute a query to retrieve the desired value from the table
$sql = "SELECT ap_name FROM ap_excel_name";

$result = $conn->query($sql);

// Step 3: Fetch the result of the query
if ($result->num_rows > 0) {
    // Assuming there's only one row returned, you can use fetch_assoc() or fetch_row() for multiple rows.
    $row = $result->fetch_assoc();

    // Step 4: Assign the fetched value to the variable $fileNameimap
    $fileName = $row['ap_name'];
} else {
    // Handle the case where no rows were found
    $fileName = "No data found";
}

//echo $fileName;
?>
    <style>
        /* CSS style to adjust position using pixels */
        #fileNameAutoJIT {
            margin-top: -268px; /* Adjust the top position in pixels */
            margin-left: 488px; /* You can adjust the value as needed */
        }
    </style>

    <div id="fileNameAutoJIT">
        <p><?php echo $fileName; ?></p>
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
        $worksheet->setTitle('AutoJIT_'.$worksheetName);
    
        // Create a new sheet and set the data
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'MRP WHS');
        $sheet->setCellValue('B1', 'Reference');
        $sheet->setCellValue('C1', 'Part No');
        $sheet->setCellValue('D1', 'Part Description');
        $sheet->setCellValue('E1', 'Dely Pattern');
        $sheet->setCellValue('F1', 'Supplier');
        $sheet->setCellValue('G1', 'Po Number');
        $sheet->setCellValue('H1', 'Delivery Qty');
        $sheet->setCellValue('I1', 'WS CD');
        $sheet->setCellValue('J1', 'Ship To Location');
        $sheet->setCellValue('K1', 'Date & ETA');
        $sheet->setCellValue('L1', 'Trans DT');
        $sheet->setCellValue('M1', 'Process DT');
        $sheet->setCellValue('N1', 'Rcv DT');
        $sheet->setCellValue('O1', 'RCV Qty');
        $sheet->setCellValue('P1', 'JOC No');
        $sheet->setCellValue('Q1', 'Outstanding Qty');
        $sheet->setCellValue('R1', 'Rcv Status');
        $sheet->setCellValue('S1', 'Batch ID');
        $sheet->setCellValue('T1', 'Buyer_Name');
        $sheet->setCellValue('U1', 'Export Date');
    
        // Fetch the data from the database and populate the Excel sheet
        $query = "SELECT * FROM ap_master WHERE joc_no = '$filterValue'";
        $result = mysqli_query($conn, $query);
        $rowIndex = 2; // Start from row 2 for data
        while ($row = mysqli_fetch_assoc($result)) {
    
            $sheet->setCellValue('A' . $rowIndex, $row['mrp_whs']);
            $sheet->setCellValue('B' . $rowIndex, $row['reference']);
            $sheet->setCellValue('C' . $rowIndex, $row['partno']);
            $sheet->setCellValue('D' . $rowIndex, $row['partdesc']);
            $sheet->setCellValue('E' . $rowIndex, $row['delypattern']);
            $sheet->setCellValue('F' . $rowIndex, $row['supplier']);
            $sheet->setCellValue('G' . $rowIndex, $row['pono']);
            $sheet->setCellValue('H' . $rowIndex, $row['deliverqty']);
            $sheet->setCellValue('I' . $rowIndex, $row['ws_cd']);
            $sheet->setCellValue('J' . $rowIndex, $row['shiptolocation']);
            $sheet->setCellValue('K' . $rowIndex, $row['dateeta']);
            $sheet->setCellValue('L' . $rowIndex, $row['transdt']);
            $sheet->setCellValue('M' . $rowIndex, $row['processdt']);
            $sheet->setCellValue('N' . $rowIndex, $row['rcvdt']);
            $sheet->setCellValue('O' . $rowIndex, $row['rcvqty']);
            $sheet->setCellValue('P' . $rowIndex, $row['joc_no']);
            $sheet->setCellValue('Q' . $rowIndex, $row['outstandingqty']);
            $sheet->setCellValue('R' . $rowIndex, $row['rcvstat']);
            $sheet->setCellValue('S' . $rowIndex, $row['batch_id']);
            $sheet->setCellValue('T' . $rowIndex, $row['buyer_name']);
            $sheet->setCellValue('U' . $rowIndex, $row['export_date']);
    
            $rowIndex++;
        }

        // Create a new sheet for the pivot table
        $pivotSheet = $spreadsheet->createSheet();
        $pivotSheet->setTitle('AutoJIT_PIV');

        // Hide row number 2 in the "PIV" sheet
        $pivotSheet->getRowDimension(2)->setVisible(false);

        // Define the range of data for the pivot table
        $dataRange = 'A1:U' . ($rowIndex - 1); // Assuming the data range is from A1 to U(rowIndex-1)

        // Define the pivot table structure
        $rowField = 'D';    // Part Description
        $columnField = 'C'; // Part No
        $supplierField = 'F'; // supplier
        $dataField = 'H';   // Delivery Qty
        $dateEtaField = 'K'; // Date & ETA field

        // Set up the layout of the pivot table
        $pivotSheet->setCellValue('A1', 'Part Description');
        $pivotSheet->setCellValue('B1', 'Part No');
        $pivotSheet->setCellValue('C1', 'Supplier');

        // Calculate the summarized values
        $data = $sheet->rangeToArray($dataRange, null, true, true, true); // Get the data from the original sheet
        $pivotData = array(); // Array to hold the pivot table data

        foreach ($data as $row) {
            $rowData = array();
            $rowValue = $row[$rowField];
            $columnValue = $row[$columnField];
            $supplierValue = $row[$supplierField];
            $dataValue = $row[$dataField];
            $dateEtaValue = $row[$dateEtaField];

            // Check if the row and column combination already exists in the pivot table data
            if (isset($pivotData[$rowValue][$columnValue][$supplierValue][$dateEtaValue])) {
                $pivotData[$rowValue][$columnValue][$supplierValue][$dateEtaValue] += $dataValue;
            } else {
                $pivotData[$rowValue][$columnValue][$supplierValue][$dateEtaValue] = $dataValue;
            }
        }

        // Populate the pivot table
        $columnIndex = 4; // Start column index for Date & ETA values

        // Set the unique Date & ETA values in columns
        $uniqueDateEtaValues = array();
        foreach ($pivotData as $rowValue => $rowData) {
            foreach ($rowData as $columnValue => $data) {
                foreach ($data as $supplierValue => $supplierData) {
                    foreach ($supplierData as $dateEtaValue => $dataValue) {
                        if (!in_array($dateEtaValue, $uniqueDateEtaValues)) {
                            $uniqueDateEtaValues[] = $dateEtaValue;
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
        foreach ($uniqueDateEtaValues as $dateEtaValue) {
            $pivotSheet->setCellValueByColumnAndRow($columnIndex, 1, $dateEtaValue);
            $columnIndex++;
        }

        $rowIndex = 2;
        foreach ($pivotData as $rowValue => $rowData) {
            foreach ($rowData as $columnValue => $data) {
                foreach ($data as $supplierValue => $supplierData) {            
                $pivotSheet->setCellValue('A' . $rowIndex, $rowValue);
                $pivotSheet->setCellValue('B' . $rowIndex, $columnValue);
                $pivotSheet->setCellValue('C' . $rowIndex, $supplierValue);

                $columnIndex = 4; // Reset column index for Date & ETA values
                foreach ($uniqueDateEtaValues as $dateEtaValue) {
                    if (isset($supplierData[$dateEtaValue])) {
                        $pivotSheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $supplierData[$dateEtaValue]);
                    }
                    $columnIndex++;
                }
                $rowIndex++;
                }
            }
        }
        
        $grandTotalColumn = count($uniqueDateEtaValues) + 4; // Calculate the column index for the grand total column
        $grandTotalRow = $rowIndex;

        // Add grand total column header
        $pivotSheet->setCellValueByColumnAndRow($grandTotalColumn, 1, 'Grand Total');

                // Calculate the sum for each row of Part No
                $rowIndex = 2;
                foreach ($pivotData as $rowValue => $rowData) {
                    $rowTotal = 0;
                    foreach ($rowData as $columnValue => $data) { 
                        foreach ($data as $supplierValue => $supplierData) {
                           foreach($supplierData as $dateEtaValue => $dataValuee){
                                if (isset($supplierData[$dateEtaValue])) {
                                    $rowTotal += intval($supplierData[$dateEtaValue]); // Convert the data value to an integer using intval()
                                }
                            }
                        }
                    }
                    $pivotSheet->setCellValueByColumnAndRow($grandTotalColumn, $rowIndex, $rowTotal);
                    $rowIndex++;
                }        

        // Calculate the sum for each column of Date & ETA
        $columnIndex = 4;
        foreach ($uniqueDateEtaValues as $dateEtaValue) {
            $columnTotal = 0;
            foreach ($pivotData as $rowValue => $rowData) {
                foreach ($rowData as $columnValue => $data) {
                    foreach ($data as $supplierValue => $supplierData) {
                        if (isset($supplierData[$dateEtaValue])) {
                            $columnTotal += intval($supplierData[$dateEtaValue]); // Convert the data value to an integer using intval()
                        }
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
                foreach ($data as $supplierValue => $supplierData) {
                    foreach ($supplierData as $dateEtaValue => $dataValuee) {
                        if (isset($supplierData[$dateEtaValue])) {
                            $grandTotal += intval($supplierData[$dateEtaValue]); // Convert the data value to an integer using intval()
                        }
                    }
                }
            }
        }
        $pivotSheet->setCellValueByColumnAndRow($grandTotalColumn, $grandTotalRow, $grandTotal);

        // Add "Grand Total" label to the last row at the bottom
        $pivotSheet->setCellValue('A' . $grandTotalRow, 'Grand Total');

        // Adjust column widths to fit content perfectly and set specific widths if desired
        $columnWidths = [
          'A' => 25,  // Example: Set column A width to 15
          'B' => 10,  // Example: Set column B width to 20
          'C' => 0,
          'D' => 0,
        ];  // Add more columns and widths as needed

        // Set column width
        foreach ($columnWidths as $columnLetter => $width) {
          $columnIndex = Coordinate::columnIndexFromString($columnLetter);
          $columnDimension = $pivotSheet->getColumnDimensionByColumn($columnIndex);

          if ($columnLetter === 'D' || $columnLetter !== 'D') {
              $columnLetter == $columnDimension->setWidth($width);
          }

          if ($columnLetter === 'D') {
            $pivotSheet->removeColumnByIndex($columnIndex);
          }
        }

        // Autofit column width
        foreach (range('A', $pivotSheet->getHighestColumn()) as $columnLetter) {
          $columnIndex = Coordinate::columnIndexFromString($columnLetter);
          $columnDimension = $pivotSheet->getColumnDimensionByColumn($columnIndex);

          if ($columnLetter === 'D' || $columnLetter !== 'D') {
              $columnLetter = $columnDimension->setAutoSize(true);
          }

          if ($columnLetter === 'D') {
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
      }    

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

/*$result = mysqli_query($conn, "SELECT * FROM ap_master");
$numRows = mysqli_num_rows($result);

if ($numRows > 0) {
    echo '<table id="amdata" style="border: 1px solid black; position: absolute; top: 25%; transform: translate(-0%, -0%);">';
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
}*/
ob_end_flush();
?>
</body>
</html>


