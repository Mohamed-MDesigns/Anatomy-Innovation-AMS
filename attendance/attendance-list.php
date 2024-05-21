<?php
require_once('../conn.php'); // Database connection

// Fetch categories for the dropdown
$categories = $conn->query("SELECT * FROM `categories` ORDER BY `name` ASC");

// Handle form submission to fetch attendance data
$attendance_records = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categorie_id = $_POST['categorie_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $attendance_records = $conn->query("
        SELECT s.first_name, s.last_name, a.class_date, a.status 
        FROM `attendance_tbl` a
        INNER JOIN `students_tbl` s ON a.student_id = s.id
        WHERE s.categorie_id = '{$categorie_id}' 
        AND a.class_date BETWEEN '{$start_date}' AND '{$end_date}'
        ORDER BY s.first_name ASC, s.last_name ASC, a.class_date ASC
    ");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance List</title>
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
        <h1>Attendance List</h1>
        <a href="../absences-homepage.php" class="btn btn-secondary">Return to Homepage</a>
    </div>

    <form method="POST" class="mb-4">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="categorie_id">Select Category</label>
                <select name="categorie_id" id="categorie_id" class="form-control" required>
                    <option value="" selected disabled>Choose...</option>
                    <?php while ($category = $categories->fetch_assoc()): ?>
                        <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="start_date">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control" required>
            </div>
            <div class="form-group col-md-4">
                <label for="end_date">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <?php if ($attendance_records && $attendance_records->num_rows > 0): ?>
        <div class="print-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($record = $attendance_records->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($record['first_name'] . ' ' . $record['last_name']) ?></td>
                            <td><?= htmlspecialchars($record['class_date']) ?></td>
                            <td>
                                <?php
                                switch ($record['status']) {
                                    case 1:
                                        echo 'Present';
                                        break;
                                    case 2:
                                        echo 'Late';
                                        break;
                                    case 3:
                                        echo 'Absent';
                                        break;
                                    case 4:
                                        echo 'Holiday';
                                        break;
                                    case 5:
                                        echo 'Justification';
                                        break;
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <button class="btn btn-primary" onclick="window.print()">Print</button>
    <?php else: ?>
        <div class="alert alert-warning">No attendance records found for the selected category and date range.</div>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
