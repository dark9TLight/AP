<?php
ob_start();
include ('connection.php');
session_start(); 

require 'vendor/autoload.php';
require 'vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Spreadsheet.php';
require 'vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Writer/Xlsx.php';
require 'vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Writer/Xls.php';
require 'vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Worksheet/Worksheet.php';
require 'vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Worksheet/Protection.php';
require 'vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Calculation/Calculation.php';

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
?>
<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="pep_style.css">
<script src="pep_script.js"></script>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <link rel="stylesheet" href="new 1.css">
    <link rel="stylesheet" href="pep_style.css">
    <title>Pivot Extra Part</title>
    <script src="jquery-3.6.0.min.js"></script> 
</head>
<body>
<style>
        #buttonContainer { /* 'Dark Mode' Btn position */
        position: relative;
        top: 5px;
        margin-right: 1700px;
        } 
        #AutoJITPivotBtnContainer { /* 'Pivot Extra Part (PEP)' title position */
        position: relative;
        top: -45px; 
        margin-left: 200px;
        }
        #chooseFileBtnContainer { /* drag & drop position */
        position: relative;
        top: -45px; 
        margin-left: 400px;
        }
        #sharedfolder { /* 'To access shared folder, ...' position  */
        position: relative;
        top: -728px; 
        margin-left: 1196.39px;
        }
        #copylinkposition { /* 'Copy Link' ExtraQty position  */
            position: relative;
            top: -769px; 
            margin-left: 1387.0px;
        }
        #sharedfolder2 { /* 'To access SOP user's manual, ...' position  */
            position: relative;
            top: -308px; 
            margin-left: 1267px;
        }
        #sharedfolderaddress2 { /* SOP link position */
            position: relative;
            top: -360px; 
            margin-left: -1138px;
        }
        #copylinkposition2 { /* 'Copy Link' SOP position  */
            position: relative;
            top: -350px; 
            margin-left: 1458px;
        }
        #copylinkbtn2{ /* 'Copy Link' SOP size */
            width: 75px; 
            height: 30px; 
        }
        #planlotBtnContainer { /* Choose Date position */
            position: relative;
            top: -631px; 
            margin-left: 837.54px;
        }
            #csvconvert { /* 'Excel Converter' Btn position  */
            position: relative;
            top: -300px; 
            margin-left: 1207.5px;
        }
            #trunk { /* Truncate position & size Btn */
            position: relative;
            top: -92.5px; 
            margin-left: 436px;
            width: 137px; 
            height: 50px; 
        }
            #ImportAutoJITBtnContainer { /* 'Upload' Btn position */
            position: relative;
            top: -40px; 
            margin-left: 805px;
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
        <h1><b><?php ?></b>Pivot Extra Part (PEP)</h1>
    </div>  

<form method="post" action="pep_insert_stk.php" enctype="multipart/form-data" onsubmit="return validateForm()">
    <br>
    <?php 
        $sql = mysqli_query($conn, "SELECT DISTINCT datee FROM `total_extra_parts`");
        $data = mysqli_fetch_assoc($sql);
    ?>
    <br>
    <div id="chooseFileBtnContainer">
        <input id="upstock" type="file" name="stk[]" value="Import" style="display: none;" multiple>
        <div id="dragDropArea" style="border: 2px dashed #ccc; padding: 20px; text-align: center; cursor: pointer; width: 900px; height: 460px">
            <br><br><br><br><br><br><br><br><br><p>Drag and drop or click to select a .xls file</p>
        </div>
    </div>
    <div id="ImportAutoJITBtnContainer">
        <button id="ImportAutoJITBtn" type="submit" name="import_stk">Upload</button>
    </div>
</form>

<div class = "choose_date">
	<form method = "post">
        <div id="planlotBtnContainer">
            <label>Choose Date 1: <label>
            <input type = "date" name = "date1" required>
            <label>Choose Date 2: <label>
            <input type = "date" name = "date2" required>
            <input type = "submit" class = "button1" name = 'submitdate'>
        </div>
	</form>
</div>

<!-- HTML form with a button 
<form method="post" action="pep_master_display.php">
    <div id="trunk">
        <input type="submit" id="trunk" name="truncate" value="Truncate">
    </div>
</form>-->

<?php
// Check if the button has been clicked
if (isset($_POST['truncate'])) {
    // Truncate the table
    $sql = "TRUNCATE TABLE total_extra_parts";
    
    if (mysqli_query($conn, $sql)) {
    } else {
    }
}
?>

<div id="sharedfolder">
    <p>To access shared folder, click 'Copy Link then paste path into your file explorer:</p>
</div>

<div id="sharedfolderaddress">
<center><a href="file://43.74.45.15/Driver/Irfan%20Intern%20Trainee%202023/ExtraQty[AutoJIT]/" target="_blank" style="color: white;"></a></center>
</div>
<div id="copylinkposition">
    <button id="copylinkbtn" onclick="copyLink()">Copy Link</button>
</div>

<!-- <div id="sharedfolder2">
    <p>To access SOP user's manual, click 'Copy then paste path into your file explorer:</p>
</div> -->

<div id="sharedfolderaddress2">
    <center><a href="file://43.74.45.15/Driver/Irfan%20Intern%20Trainee%202023/[AP][AIP][PEP]SOP/" target="_blank" style="color: white;"></a></center>
</div>

<!-- <div id="copylinkposition2">
    <button id="copylinkbtn2" onclick="copyLink2()">Copy Link</button>
</div> -->

<script>
    function copyLink2() {
      var linkElement = document.getElementById("sharedfolderaddress2").getElementsByTagName("a")[0];
      var link = linkElement.href;
      
      // Create a temporary input element
      var tempInput = document.createElement("input");
      tempInput.setAttribute("value", link);
      
      // Append the input element to the body
      document.body.appendChild(tempInput);
      
      // Select and copy the link from the input element
      tempInput.select();
      document.execCommand("copy");
      
      // Remove the temporary input element
      document.body.removeChild(tempInput);
      
      //alert("Link copied to clipboard!");
    }
	
	    function validateForm() {
        // Get the selected file
        var fileInput = document.getElementById('upstock');
        var file = fileInput.files[0];
        
        // Check if a file is selected
        if (!file) {
            alert('Please select a file to import.');
            return false; // Prevent form submission
        }
        
        // Check if the file is in xls format
        var fileName = file.name;
        var fileExtension = fileName.split('.').pop().toLowerCase();
        if (fileExtension !== 'xls') {
            alert('Please select a xls file to import.');
            return false; // Prevent form submission
        }
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

<?php 
    if (isset($_POST['submitdate'])) {

        $_SESSION["date1"] = $_POST['date1'];
        $_SESSION["date2"] = $_POST['date2'];

        $date1 = date("Ymd", strtotime($_SESSION['date1']));
        $date2 = date("Ymd", strtotime($_SESSION['date2']));
    
        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();

       // Get the default worksheet (index 0)
        $worksheet = $spreadsheet->getSheet(0);

        // Set a dynamic name for the worksheet using a variable
        $worksheet->setTitle('ExtraQty AutoJIT');
    
        // Create a new sheet and set the data
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Date');
        $sheet->setCellValue('B1', 'WIP Entity Name');
        $sheet->setCellValue('C1', 'Item Number');
        $sheet->setCellValue('D1', 'Item Description');
        $sheet->setCellValue('E1', 'Vendor Code');
        $sheet->setCellValue('F1', 'Vendor Name');
        $sheet->setCellValue('G1', 'Order Status');
        $sheet->setCellValue('H1', 'Confirmdel');
        $sheet->setCellValue('I1', 'Plan Qty');
        $sheet->setCellValue('J1', 'Delivery Date');
        $sheet->setCellValue('K1', 'Delivery Time');
        $sheet->setCellValue('L1', 'Extra Qty');
        $sheet->setCellValue('M1', 'Line');
    
        // Fetch the data from the database and populate the Excel sheet
        $query = "SELECT * FROM total_extra_parts WHERE datee BETWEEN $date1 AND $date2";
        $result = mysqli_query($conn, $query);
        $rowIndex = 2; // Start from row 2 for data
        while ($row = mysqli_fetch_assoc($result)) {
    
            $sheet->setCellValue('A' . $rowIndex, $row['datee']);
            $sheet->setCellValue('B' . $rowIndex, $row['wip_entity_name']);
            $sheet->setCellValue('C' . $rowIndex, $row['item_number']);
            $sheet->setCellValue('D' . $rowIndex, $row['item_description']);
            $sheet->setCellValue('E' . $rowIndex, $row['vendor_code']);
            $sheet->setCellValue('F' . $rowIndex, $row['vendor_name']);
            $sheet->setCellValue('G' . $rowIndex, $row['order_status']);
            $sheet->setCellValue('H' . $rowIndex, $row['confirmdel']);
            $sheet->setCellValue('I' . $rowIndex, $row['plan_qty']);
            $sheet->setCellValue('J' . $rowIndex, $row['delivery_date']);
            $sheet->setCellValue('K' . $rowIndex, $row['delivery_time']);
            $sheet->setCellValue('L' . $rowIndex, $row['extraqty']);
            $sheet->setCellValue('M' . $rowIndex, $row['linee']);
    
            $rowIndex++;
        }

        // Create a new sheet for the pivot table
        $pivotSheet = $spreadsheet->createSheet();
        $pivotSheet->setTitle('ExtraQty AutoJIT PIV');

        // Hide row number 2 in the "PIV" sheet
        $pivotSheet->getRowDimension(2)->setVisible(false);

        // Define the range of data for the pivot table
        $dataRange = 'A1:U' . ($rowIndex - 1); // Assuming the data range is from A1 to U(rowIndex-1)

        // Define the pivot table structure
        $supplierField = 'F';    // Supplier
        $rowField = 'D';    // Part Description
        $columnField = 'C'; // Part No
        $wipField = 'B'; // WIP Entity Name
        $extraField = 'L'; // Extra Qty
        $dataField = 'H';   // Delivery Qty
        $dateEtaField = 'K'; // Date & ETA field

        // Set up the layout of the pivot table
        $pivotSheet->setCellValue('A1', 'Supplier');
        $pivotSheet->setCellValue('B1', 'Part Description');
        $pivotSheet->setCellValue('C1', 'Part No');
        $pivotSheet->setCellValue('D1', 'WIP Entity Name');
        $pivotSheet->setCellValue('E1', 'Extra Qty');

        // Calculate the summarized values
        $data = $sheet->rangeToArray($dataRange, null, true, true, true); // Get the data from the original sheet
        $pivotData = array(); // Array to hold the pivot table data

        foreach ($data as $row) {
            $rowData = array();
            $supplierValue = $row[$supplierField];  // Supplier
            $rowValue = $row[$rowField];  // Part Description
            $columnValue = $row[$columnField]; // Part No
            $wipValue = $row[$wipField];  // WIP Entity Name
            $extraValue = $row[$extraField];  // Extra
            //$dataValue = $row[$dataField];  // Delivery Qty
            //$dateEtaValue = $row[$dateEtaField];  // Date & ETA field

            // Check if the row and column combination already exists in the pivot table data
            if (isset($pivotData[$supplierValue][$rowValue][$columnValue][$wipValue][$extraValue][$dateEtaValue])) {
                $pivotData[$supplierValue][$rowValue][$columnValue][$wipValue][$extraValue][$dateEtaValue] += $dataValue;
            } else {
                $pivotData[$supplierValue][$rowValue][$columnValue][$wipValue][$extraValue][$dateEtaValue] = $dataValue;
            }
        }
        // Populate the pivot table
        $columnIndex = 10; // Start column index for Date & ETA values

        // Set the unique Date & ETA values in columns
        $uniqueDateEtaValues = array();
        foreach ($pivotData as $supplierValue => $supplierData) {
            foreach ($supplierData as $rowValue => $rowData) {
                foreach ($rowData as $columnValue => $columnData) {
                    foreach ($columnData as $wipValue => $wipData) {
                        foreach ($wipData as $extraValue => $data) {
                            foreach ($data as $dateEtaValue => $dataValue) {
                                if (!in_array($dateEtaValue, $uniqueDateEtaValues)) {
                                    $uniqueDateEtaValues[] = $dateEtaValue;
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
        foreach ($uniqueDateEtaValues as $dateEtaValue) {
            $pivotSheet->setCellValueByColumnAndRow($columnIndex, 1, $dateEtaValue);
            $columnIndex++;
        }

        $rowIndex = 2;
        foreach ($pivotData as $supplierValue => $supplierData) {
            foreach ($supplierData as $rowValue => $rowData) {
                foreach ($rowData as $columnValue => $columnData) {
                    foreach ($columnData as $wipValue => $wipData) {
                        foreach ($wipData as $extraValue => $data) {
                        $pivotSheet->setCellValue('A' . $rowIndex, $supplierValue);
                        $pivotSheet->setCellValue('B' . $rowIndex, $rowValue);
                        $pivotSheet->setCellValue('C' . $rowIndex, $columnValue);
                        $pivotSheet->setCellValue('D' . $rowIndex, $wipValue);
                        $pivotSheet->setCellValue('E' . $rowIndex, $extraValue);

                        $columnIndex = 10; // Reset column index for Date & ETA values
                        foreach ($uniqueDateEtaValues as $dateEtaValue) {
                            if (isset($data[$dateEtaValue])) {
                                $pivotSheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $data[$dateEtaValue]);
                            }
                            $columnIndex++;
                        }
                        $rowIndex++;
                        }
                    }
                }
            }
        }
        // Adjust column widths to fit content perfectly and set specific widths if desired
        $columnWidths = [
          'A' => 0,  // Example: Set column A width to 15
          'B' => 40,  // Example: Set column B width to 20
          'C' => 10,
          'D' => 15,
          'E' => 10,
          'F' => 0,
        ];  // Add more columns and widths as needed

        // Set column width
        foreach ($columnWidths as $columnLetter => $width) {
          $columnIndex = Coordinate::columnIndexFromString($columnLetter);
          $columnDimension = $pivotSheet->getColumnDimensionByColumn($columnIndex);

          if ($columnLetter === 'J' || $columnLetter !== 'J') {
              $columnLetter == $columnDimension->setWidth($width);
          }

          if ($columnLetter === 'J') {
            $pivotSheet->removeColumnByIndex($columnIndex);
          }
        }

        // Autofit column width
        foreach (range('A', $pivotSheet->getHighestColumn()) as $columnLetter) {
          $columnIndex = Coordinate::columnIndexFromString($columnLetter);
          $columnDimension = $pivotSheet->getColumnDimensionByColumn($columnIndex);

          if ($columnLetter === 'J' || $columnLetter !== 'J') {
              $columnLetter = $columnDimension->setAutoSize(true);
          }

          if ($columnLetter === 'J') {
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
        
        // Save the Excel file to extra_Pivot
        $writer = new Xlsx($spreadsheet);
        $filename = 'amd-hey_ExtraQty[AutoJIT].xlsx';
        //$excelPivot = $filterValue;
        $excelPivot = $date1;
        $filename = str_replace('amd', $excelPivot, $filename);
        $exceldate2name = $date2;
        $filename = str_replace('hey', $exceldate2name, $filename);
        $saveDirectory = 'C:/xampp/htdocs/AP/pep_savedFile/extra_Pivot/';
        $filePath = $saveDirectory . $filename;
        $writer->save($filePath);
        
        // Redirect to the new Excel file
        $redirectPath = 'pep_savedFile/extra_Pivot/' . $filename;
        header('Location: ' . $redirectPath);
        exit();
      }    
   //}    
   $directory = 'C:/xampp/htdocs/AP/pep_savedFile/extra_Pivot/';

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

$result = mysqli_query($conn, "SELECT * FROM total_extra_parts"); // fetch data from db
$numRows = mysqli_num_rows($result);

if ($numRows > 0) { // then display
    echo '<table id="amdata" style="border: 0px solid black; position: absolute; top: 19.8%; transform: translate(450%, -0%);">';
    // echo '<tr>
    //         <th>Date</th>
    //         <th>WIP Entity Name</th>
    //         <th>Item Number</th>
    //         <th>Item Description</th>
    //         <th>Vendor Code</th>
    //         <th>Vendor Name</th>
    //         <th>Order Status</th>
    //         <th>Confirm Del</th>
    //         <th>Plan Qty</th>
    //         <th>Delivery Date</th>
    //         <th>Delivery Time</th>
    //         <th>Extra Qty</th>
    //         <th>Line</th>
    //     </tr>';

    $prevDate = null; // Initialize a variable to store the 'datee' value of the previous row

    while ($row = mysqli_fetch_assoc($result)) {
        //echo '<tr>';

        // Check if 'datee' value in the current row is the same as the 'datee' value in the previous row
        if ($row['datee'] == $prevDate) {
            //echo '<td class="table-cell"></td>'; // Display an empty cell if the datee is the same
        } else {
            echo '<td class="table-cell">' . $row['datee'] . '</td>'; // Otherwise, display the datee value
        }

        //echo '<td class="table-cell">' . $row['datee'] . '</td>';
        // echo '<td class="table-cell">' . $row['wip_entity_name'] . '</td>';
        // echo '<td class="table-cell">' . $row['item_number'] . '</td>';
        // echo '<td class="table-cell">' . $row['item_description'] . '</td>';
        // echo '<td class="table-cell">' . $row['vendor_code'] . '</td>';
        // echo '<td class="table-cell">' . $row['vendor_name'] . '</td>';
        // echo '<td class="table-cell">' . $row['order_status'] . '</td>';
        // echo '<td class="table-cell">' . $row['confirmdel'] . '</td>';
        // echo '<td class="table-cell">' . $row['plan_qty'] . '</td>';
        // echo '<td class="table-cell">' . $row['delivery_date'] . '</td>';
        // echo '<td class="table-cell">' . $row['delivery_time'] . '</td>';
        // echo '<td class="table-cell">' . $row['extraqty'] . '</td>';
        // echo '<td class="table-cell">' . $row['linee'] . '</td>';
        echo '</tr>';
        // Update the $prevDate with the 'datee' value of the current row for the next iteration
        $prevDate = $row['datee'];
   }
  echo '</table>';
} else {
  echo '';
}
?>
<?php
ob_end_flush();
?>
</body>
</html>


