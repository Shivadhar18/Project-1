<?php

// Function for displaying and error
function displayError($message) {
    echo "<div class=\"alert alert-danger\">".$message."</div>";
}

// Function for checking if given string ends with some other string
function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
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

    <div class="container">
        <div class="form-input">
            <form action="#" method="post" enctype="multipart/form-data">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="csvFileID"><strong>Please upload CSV file:</strong></label>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        // Checking if form is submited
                        if ( isset($_POST["submit"]) ) {
                            // Checking if file is uploaded
                            if ( isset($_FILES["csvFile"])) {

                                $file = $_FILES["csvFile"];
                                // Checking that file is not empty
                                if(empty($file))
                                    displayError("No file selected.");
                                // It must end with .csv
                                else if(!endsWith($file['name'], ".csv"))
                                    displayError("Not a CSV file.");
                                else {
                                    // Creating a unique name for the file
                                    $newName = uniqid() . '.csv';
                                    // If file with same name already exists, find new one
                                    while (file_exists("upload/" . $newName)) {
                                        $newName = uniqid() . '.csv';
                                    }

                                    //Store file in directory "upload"
                                    move_uploaded_file($file["tmp_name"], "upload/" . $newName);

                                    // Forward user to table view
                                    header('Location: view.php?filename='.$newName);

                                }

                            }
                            // If csvFile field is not set, show error message
                            else
                                displayError("No file selected.");
                        }

                        ?>

                        <div class="col-lg-9">
                            <input type="file" class="form-control-file" id="csvFileID" name="csvFile" required/>
                        </div>
                        <div class="col-lg-3">
                            <input type="submit" name="submit" id="uploadBtn" class="btn btn-primary" value="Upload">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div> <!-- /container -->

    <!-- Bootstrap Core JavaScript -->
    <script src="js/jquery-3.2.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>