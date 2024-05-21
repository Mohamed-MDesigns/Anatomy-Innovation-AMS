<?php
include("../conn.php");

if (isset($_GET['id'])) {
    $student_id = intval($_GET['id']);
    $sql = "DELETE FROM students_tbl WHERE id = $student_id";

    if ($conn->query($sql) === TRUE) {
        echo "Student deleted successfully.";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    header("Location: list-students.php?category=" . intval($_GET['category']));
    exit;
} else {
    echo "Invalid request.";
}
?>
