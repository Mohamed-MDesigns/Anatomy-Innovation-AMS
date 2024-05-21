<?php
require_once('../conn.php'); // Database connection

// Fetch categories for the dropdown
$categories = $conn->query("SELECT * FROM `categories` ORDER BY `name` ASC");

$students = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categorie_id = $_POST['categorie_id'];

    // Fetch students in the selected category
    $students = $conn->query("
        SELECT s.id, s.first_name, s.last_name, 
        SUM(CASE WHEN a.status = 3 THEN 1 ELSE 0 END) AS total_absences,
        SUM(CASE WHEN a.status = 5 THEN 1 ELSE 0 END) AS total_justifications
        FROM `students_tbl` s
        LEFT JOIN `attendance_tbl` a ON s.id = a.student_id
        WHERE s.categorie_id = '{$categorie_id}'
        GROUP BY s.id
        HAVING total_absences >= 2
        ORDER BY s.first_name ASC, s.last_name ASC
    ");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Report</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .print-container, .print-container * {
                visibility: visible;
            }
            .print-container {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between mb-3">
        <h1>Attendance Report</h1>
        <a href="../absences-homepage.php" class="btn btn-secondary">Return to Homepage</a>
    </div>

    <form method="POST" class="mb-4">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="categorie_id">Select Category</label>
                <select name="categorie_id" id="categorie_id" class="form-control" required>
                    <option value="" selected disabled>Choose...</option>
                    <?php while ($category = $categories->fetch_assoc()): ?>
                        <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <?php if ($students && $students->num_rows > 0): ?>
        <div class="print-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Total Absences</th>
                        <th>Total Justifications</th>
                        <th>Warnings/Rebukes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($student = $students->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></td>
                            <td><?= htmlspecialchars($student['total_absences']) ?></td>
                            <td><?= htmlspecialchars($student['total_justifications']) ?></td>
                            <td>
                                <?php
                                $warnings = floor($student['total_absences'] / 2);
                                $rebukes = floor($warnings / 3);
                                echo "Warnings: $warnings, Rebukes: $rebukes";
                                ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <button class="btn btn-primary" onclick="window.print()">Print</button>
    <?php else: ?>
        <div class="alert alert-warning">No students found with significant absences for the selected category.</div>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
