<?php
include("../conn.php");

if (isset($_GET['id'])) {
    $student_id = intval($_GET['id']);
    $sql = "SELECT first_name, last_name FROM students_tbl WHERE id = $student_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        echo "Student not found.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = intval($_POST['id']);
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);

    $sql = "UPDATE students_tbl SET first_name = '$first_name', last_name = '$last_name' WHERE id = $student_id";
    if ($conn->query($sql) === TRUE) {
        header("Location: list-students.php?category=" . intval($_POST['category_id']));
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Student</title>
</head>
<body>
<br><a href="/../absences-homepage.php">العودة الى القائمة الرئيسية</a>
    <h1>Modify Student</h1>
    <form action="modify-student.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $student_id; ?>">
        <input type="hidden" name="category_id" value="<?php echo isset($_GET['category']) ? intval($_GET['category']) : ''; ?>">
        <div>
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($student['first_name']); ?>" required>
        </div>
        <div>
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($student['last_name']); ?>" required>
        </div>
        <button type="submit">Save</button>
    </form>
</body>
</html>
