<?php
include("../conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Delete the category
    $id = $_POST['id'];

    $sql = "DELETE FROM categories WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Category deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    header("Location: list-categorie.php");
    exit;
} else {
    // Fetch the category details for confirmation
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
    <title>Anatomy AMS | حذف فئة </title>
</head>
<body>
    <a href="/../absences-homepage.php">العودة الى القائمة الرئيسية</a>
    <h1>Delete Category</h1>

    <p>Are you sure you want to delete the category: <?php echo $row['name']; ?>?</p>
    <form action="delete-category.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <button type="submit">Yes, Delete</button>
        <a href="list-categorie.php">No, Cancel</a>
    </form>
</body>
</html>
