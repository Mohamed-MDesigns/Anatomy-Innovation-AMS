<?php
include("conn.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anatomy AMS | Register</title>

</head>

<body lang="ar">

    <div class="container">
        <div class="hero-section">
            <div class="register-form">
                <br>
                <h3></h3>
                <h1>تسجيل مستخدم جديد</h1><br>
                <form class="register-formulaire" action="register_process.php" method="post">
                    <label for="username" ><h3>اسم المستخدم:</h3></label>
                    <input type="text" id="username" name="username" required><br>
                    <label for="password"><h3>كلمة السر:</h3></label>
                    <input type="password" id="password" name="password" required><br>
                    <input class="btn-sucsses" type="submit" value="تسجيل"><br>
                    <a href="index.php">لديك حساب بالفعل ؟  تسجيل الدخول</a>
                </form>
            </div>
        </div>
    </div>


</body>

</html>