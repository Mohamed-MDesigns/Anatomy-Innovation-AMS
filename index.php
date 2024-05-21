<?php
include('conn.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anatomy AMS | تسجيل الدخول</title>
</head>
<body lang="ar">
    <div class="container">
        <div class="main-title">
            <h1>تسجيل الدخول</h1>
        </div>
        <?php
        if (isset($_GET["error"]) && $_GET["error"] == 1) {
            echo '<p style="font-size: 26px; color:red;font-weight: 600;">اسم المستخدم أو كلمة السر خاطئة</p>';
        }
        ?>
        <div class="main-links">
            <h2>تسجيل الدخول</h2>
            <form action="login_process.php" method="post">
                <label for="username">اسم المستخدم:</label>
                <input type="text" id="username" name="username" required><br><br>

                <label for="password">كلمة المرور:</label>
                <input type="password" id="password" name="password" required><br><br>

                <input type="submit" value="تسجيل دخول">
                <a href="register.php">تسجيل حساب جديد</a>
            </form>
        </div>
    </div>
</body>
</html>
