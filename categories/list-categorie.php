<?php
include("../conn.php");

$search = "";
$search_date = "";
$search_type = "";

if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
}

if (isset($_GET['search_date'])) {
    $search_date = $conn->real_escape_string($_GET['search_date']);
}

if (isset($_GET['search_type'])) {
    $search_type = $conn->real_escape_string($_GET['search_type']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anatomy AMS | قائمة الفئات</title>
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <br><a href="/../absences-homepage.php" class="no-print">العودة الى القائمة الرئيسية</a>
    <h1>Category List</h1>
    <a href="add-categorie.php" class="no-print"> اضافة فئة جديدة </a><br><br>

    <!-- Search form -->
    <form action="list-categorie.php" method="GET" class="no-print">
        <label for="search">Search Categories:</label>
        <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($search); ?>">
        
        <label for="search_date">Creation Date:</label>
        <input type="date" id="search_date" name="search_date" value="<?php echo htmlspecialchars($search_date); ?>">
        
        <label for="search_type">Category Type:</label>
        <select id="search_type" name="search_type">
            <option value="">Select Type</option>
            <option value="تمهين" <?php if ($search_type == "تمهين") echo 'selected'; ?>>تمهين</option>
            <option value="حضوري" <?php if ($search_type == "حضوري") echo 'selected'; ?>>حضوري</option>
        </select>
        
        <button type="submit">Search</button>
    </form>
    <button onclick="window.print()" class="no-print">Print</button>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Type</th>
            <th>Created At</th>
            <th class="no-print">Actions</th>
        </tr>
        <?php
        // Fetch categories from the database with optional search filters
        $sql = "SELECT id, name, type, created_at FROM categories WHERE 1=1";
        
        if (!empty($search)) {
            $sql .= " AND name LIKE '%$search%'";
        }
        
        if (!empty($search_date)) {
            $sql .= " AND DATE(created_at) = '$search_date'";
        }

        if (!empty($search_type)) {
            $sql .= " AND type = '$search_type'";
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["type"] . "</td>";
                echo "<td>" . $row["created_at"] . "</td>";
                echo "<td class='no-print'>";
                echo "<a href='modify-category.php?id=" . $row["id"] . "'>Modify</a> | ";
                echo "<a href='delete-category.php?id=" . $row["id"] . "'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No categories found</td></tr>";
        }

        $conn->close();
        ?>
    </table>
</body>
</html>
