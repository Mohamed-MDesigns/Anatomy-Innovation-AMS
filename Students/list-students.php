<?php
include("../conn.php");

// Fetch categories for the dropdown
$sql = "SELECT id, name FROM categories";
$result = $conn->query($sql);
$categories = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

$students = [];
if (isset($_GET['category'])) {
    $category_id = intval($_GET['category']);
    $sql = "SELECT id, first_name, last_name FROM students_tbl WHERE categorie_id = $category_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Anatomy AMS | قائمة الطلاب</title>
    <style>
        @media print {
            .no-print {
                display: none;
            }
            @page {
                margin: 0;
                size: auto;
            }
            body {
                margin: 1cm;
            }
            header, footer {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
    <br><a href="/../absences-homepage.php">العودة الى القائمة الرئيسية</a>
        <h1 class="no-print">قائمة الطلاب</h1>
        <form action="list-students.php" method="GET" class="no-print">
            <div class="mb-3">
                <label for="category" class="form-label">اختر الفئة</label>
                <select id="category" name="category" class="form-select" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">عرض الطلاب</button>
        </form>
        <br>
        <?php if (!empty($students)): ?>
            <button class="btn btn-secondary no-print" onclick="window.print()">طباعة القائمة</button>
            <br><br>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>الاسم الأول</th>
                        <th>الاسم الأخير</th>
                        <th class="no-print">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo $student['first_name']; ?></td>
                            <td><?php echo $student['last_name']; ?></td>
                            <td class="no-print">
                                <a class="btn btn-success" href="modify-student.php?id=<?php echo $student['id']; ?>">Modify</a> | 
                                <a class="btn btn-danger" href="delete-student.php?id=<?php echo $student['id']; ?>" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif (isset($_GET['category'])): ?>
            <p>لا يوجد طلاب في هذه الفئة.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
