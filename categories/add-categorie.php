<?php
include ("../conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $type = $conn->real_escape_string($_POST['type']);

    $sql = "INSERT INTO categories (name, type) VALUES ('$name', '$type')";

    if ($conn->query($sql) === TRUE) {
        echo "New category created successfully <br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anatomy AMS | اضافة فئة</title>
</head>

<body>
    <br><a href="/../absences-homepage.php">العودة الى القائمة الرئيسية</a>
    <h1>اضافة فئة جديدة</h1>
    <form action="add-categorie.php" method="POST">
        <label for="name">اسم الفئة:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="type">نوع الفئة:</label>
        <select id="type" name="type" required>
            <option value="حضوري">حضوري</option>
            <option value="تمهين">تمهين</option>
        </select><br><br>

        <button type="submit">اضافة الفئة</button>
    </form>
</body>

</html>