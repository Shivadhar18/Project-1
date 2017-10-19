<?php

$csvData = array();

// Function for printing table columns
function displayTableColumns()
{
    global $csvData;

    if(empty($csvData)) return;

    foreach ($csvData[0] as $columnName) {
        echo "<td>" . $columnName . "</td>";
    }
}

// Function for printing table fields
function displayTableFields() {
    global $csvData;

    if(empty($csvData)) return;

    for($i=1; $i<sizeof($csvData); $i++) {
        echo "<tr>";
        displayRowValues($csvData[$i]);
        echo "</tr>";
    }
}

// Function for printing values
function displayRowValues($values) {
    foreach($values as $value) {
        echo "<td>".$value."</td>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>CSV Viewer</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="table-wrapper">
            <?php
                // Check if "filename" field is set
                if ( isset($_GET["filename"]) ) {
                    $filename = $_GET["filename"];
                    // Check if file exists
                    if ( file_exists("upload/" . $filename) ) {
                        // Get file contents as array
                        $csvData = str_getcsv(file_get_contents("upload/" . $filename), "\n");
                        foreach($csvData as &$row)
                            $row = str_getcsv($row, ",");

                    } else
                        header('Location: index.php');
                } else
                    header('Location: index.php');
            ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <?php displayTableColumns() ?>
                    </tr>
                </thead>
                <tbody>
                    <?php displayTableFields() ?>
                </tbody>
            </table>
        </div>
    </div> <!-- /container -->
    <!-- Bootstrap Core JavaScript -->
    <script src="js/jquery-3.2.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>