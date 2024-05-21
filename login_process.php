<?php
session_start();
// Include database connection
include('conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL statement to select user data
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a row is returned
    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();

        // Set session variables
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['role'] = $user['role']; // Store the role in session

        // Redirect based on role
        if ($user['role'] == 'admin') {
            header("Location: absences-homepage.php");
        } elseif($user['role'] == 'user') {
            header("Location: waiting.php");
        }
        exit();
    } else {
        header("Location: index.php?error=1");
        exit();
    }
}
?>
