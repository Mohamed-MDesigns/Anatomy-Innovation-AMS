<?php
include("../conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_id = intval($_POST['category']);

    // Check if file was uploaded without errors
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
        $file = $_FILES["file"]["tmp_name"];

        if (($handle = fopen($file, "r")) !== FALSE) {
            // Skip the first row if it contains headers
            fgetcsv($handle, 1000, ",");

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $first_name = $conn->real_escape_string($data[0]);
                $last_name = $conn->real_escape_string($data[1]);

                $sql = "INSERT INTO students_tbl (categorie_id, first_name, last_name) VALUES ('$category_id', '$first_name', '$last_name')";
                $conn->query($sql);
            }
            fclose($handle);
            echo 'Students have been successfully imported. <br><a href="/../absences-homepage.php">العودة الى القائمة الرئيسية</a>';
        } else {
            echo "Error opening the file.";
        }
    } else {
        echo "Error: " . $_FILES["file"]["error"];
    }

    $conn->close();
}
?>
