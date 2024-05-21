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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Anatomy AMS | اضافة طلاب و متربصين</title>
</head>
<body>
<br><a href="/../absences-homepage.php">العودة الى القائمة الرئيسية</a>
    <div class="container">
        <h1>اضافة طلاب و متربصين</h1>
        <form action="import-students.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="category" class="form-label">اختر الفئة</label>
                <select id="category" name="category" class="form-select" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="file" class="form-label">اختر ملف CSV</label>
                <input type="file" id="file" name="file" class="form-control" accept=".csv" required>
            </div>
            <button type="submit" class="btn btn-primary">رفع الملف</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
