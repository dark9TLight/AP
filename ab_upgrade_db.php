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


<!-- ----------------------------------------------------------------------------------------- -->

<?php
// Replace these with your actual database credentials
$sourceHost = 'localhost';
$sourceUsername = 'root';
$sourcePassword = '';
$sourceDatabase = 'ap';

$destinationHost = 'localhost';
$destinationUsername = 'root';
$destinationPassword = '';
$destinationDatabase = 'ap';

try {
    // Connect to the source database
    $sourceDB = new PDO("mysql:host=$sourceHost;dbname=$sourceDatabase", $sourceUsername, $sourcePassword);
    $sourceDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Connect to the destination database
    $destinationDB = new PDO("mysql:host=$destinationHost;dbname=$destinationDatabase", $destinationUsername, $destinationPassword);
    $destinationDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Source table name
    $sourceTable = 'ab_master';

    // Destination table name
    $destinationTable = 'ab_master_upgrade';

    // Retrieve data from the source table
    $query = "SELECT * FROM $sourceTable";
    $stmt = $sourceDB->prepare($query);
    $stmt->execute();
    $dataRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($dataRows)) {
        // Truncate the destination table
        $truncateQuery = "TRUNCATE TABLE $destinationTable";
        $destinationDB->exec($truncateQuery);

        // Prepare the destination table for insert
        $columns = implode(", ", array_keys($dataRows[0]));
        $values = implode(", ", array_fill(0, count($dataRows[0]), '?'));

        // Insert data into the destination table
        $insertQuery = "INSERT INTO $destinationTable ($columns) VALUES ($values)";
        $insertStmt = $destinationDB->prepare($insertQuery);

        foreach ($dataRows as $data) {
            $insertStmt->execute(array_values($data));
        }

        echo "Data transfer successful!";
    } else {
        echo "Source table is empty. Nothing to transfer.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!-- ----------------------------------------------------------------------------------------- -->

<?php
// Replace these with your actual database credentials
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'ap';

try {
    // Connect to the database
    $db = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve data from the table
    $query = "SELECT dateeta FROM ab_master_upgrade";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $dataRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($dataRows)) {
        // Update the table with formatted date and time values
        $updateQuery = "UPDATE ab_master_upgrade SET dateeta = :dateeta, eta = :eta WHERE dateeta = :original_dateeta";
        $updateStmt = $db->prepare($updateQuery);

        foreach ($dataRows as $data) {
            $originalDateEta = $data['dateeta'];

            // Parse the original date and time
            $dateTimeObj = DateTime::createFromFormat('n/j/Y h:i:s A', $originalDateEta);

            // Format '8-Mar' and '12 PM'
            $formattedDateEta = $dateTimeObj->format('j-M');
            $formattedEta = $dateTimeObj->format('h A');

            // Execute the update query with formatted values
            $updateStmt->execute([
                'dateeta' => $formattedDateEta,
                'eta' => $formattedEta,
                'original_dateeta' => $originalDateEta,
            ]);
        }

        echo "Data conversion and update successful!";
    } else {
        echo "No data found in the table.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>


<!-- ----------------------------------------------------------------------------------------- -->

<?php
// Replace these with your actual database credentials
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'ap';

try {
    // Connect to the database
    $db = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve data from the 'ab_disb' table
    $query = "SELECT item_no, disb_charge FROM ab_disb";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $dataRows = $stmt->fetchAll(PDO::FETCH_ASSOC);


        // Prepare the update query for 'disb_charge_upgrade'
        $updateQuery = "UPDATE disb_charge_upgrade AS m
                        JOIN ab_disb AS d ON m.part_no = d.part_no
                        SET m.disb_charge = d.disb_charge
                        WHERE m.item_no = d.item_no";

        // Execute the update query
        $affectedRows = $db->exec($updateQuery);

        echo "Data inserted successfully into 'disb_charge_upgrade'! $affectedRows rows updated.";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!-- ----------------------------------------------------------------------------------------- -->
<?php
// Step 1: Establish a connection to the MySQL database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'ap';

// Create a connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sqlUpdate = "UPDATE ab_master_upgrade
              JOIN ab_disb ON ab_master_upgrade.part_no = ab_disb.item_no
              SET ab_master_upgrade.disb_charge_upgrade = ab_disb.disb_charge";

if (mysqli_query($conn, $sqlUpdate)) {
    echo "Data inserted successfully.";
} else {
    echo "Error inserting data: " . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn);

// Redirect to another script
header("Location: ab_algorithm.php");
exit();
?>