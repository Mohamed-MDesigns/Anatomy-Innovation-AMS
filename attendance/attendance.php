<?php
require_once('../conn.php'); // Database connection

// Handle form submission to save attendance
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_attendance'])) {
    $categorie_id = $_POST['categorie_id'];
    $class_date = $_POST['class_date'];
    $student_ids = $_POST['student_id'];
    $statuses = $_POST['status'];

    foreach ($student_ids as $index => $student_id) {
        $status = $statuses[$index];
        $check = $conn->query("SELECT id FROM `attendance_tbl` WHERE `student_id` = '{$student_id}' AND `class_date` = '{$class_date}'");
        if ($check->num_rows > 0) {
            $result = $check->fetch_assoc();
            $att_id = $result['id'];
            $conn->query("UPDATE `attendance_tbl` SET `status` = '{$status}' WHERE `id` = '{$att_id}'");
        } else {
            $conn->query("INSERT INTO `attendance_tbl` (`student_id`, `class_date`, `status`) VALUES ('{$student_id}', '{$class_date}', '{$status}')");
        }
    }

    header("Location: attendance.php?success=1");
    exit();
}

// Fetch categories for the dropdown
$categories = $conn->query("SELECT * FROM `categories` ORDER BY `name` ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>قائمة الطلاب</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between mb-3">
        <h1>قائمة الطلاب</h1>
        <a href="../absences-homepage.php" class="btn btn-secondary">Return to Homepage</a>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Attendance has been saved successfully!</div>
    <?php endif; ?>

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
                <label for="class_date">Select Date</label>
                <input type="date" name="class_date" id="class_date" class="form-control" required>
            </div>
        </div>
        <button type="submit" name="search" class="btn btn-primary">Search</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])):
        $categorie_id = $_POST['categorie_id'];
        $class_date = $_POST['class_date'];
        $students = $conn->query("SELECT * FROM `students_tbl` WHERE `categorie_id` = '{$categorie_id}' ORDER BY `first_name` ASC, `last_name` ASC");
        if ($students->num_rows > 0):
    ?>
        <form method="POST">
            <input type="hidden" name="categorie_id" value="<?= $categorie_id ?>">
            <input type="hidden" name="class_date" value="<?= $class_date ?>">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Attendance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($student = $students->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></td>
                            <td>
                                <select name="status[]" class="form-control" required>
                                    <option value="1">Present</option>
                                    <option value="2">Late</option>
                                    <option value="3">Absent</option>
                                    <option value="4">Holiday</option>
                                    <option value="5">Justification</option>
                                </select>
                                <input type="hidden" name="student_id[]" value="<?= $student['id'] ?>">
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <button type="submit" name="save_attendance" class="btn btn-success">Submit</button>
        </form>
    <?php else: ?>
        <div class="alert alert-warning">No students found for the selected category.</div>
    <?php endif; endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
