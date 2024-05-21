<?php
include ("../conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update the category
    $id = $_POST['id'];
    $name = $conn->real_escape_string($_POST['name']);

    $sql = "UPDATE categories SET name='$name' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Category updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    header("Location: list-categorie.php");
    exit;
} else {
    // Fetch the category details
    $id = $_GET['id'];
    $sql = "SELECT id, name FROM categories WHERE id='$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anatomy AMS | تعديل فئة </title>
</head>

<body>
    <a href="/../absences-homepage.php">العودة الى القائمة الرئيسية</a>
    <h1>Modify Category</h1>
    <form action="modify-category.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label for="name">Category Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required>
        <button type="submit">Update Category</button>
    </form>
</body>

</html>