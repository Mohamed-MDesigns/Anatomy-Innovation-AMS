<?php
session_start();
// Include database connection
include('conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Prepare SQL statement to insert user data with 'user' role
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'user')");
    $stmt->bind_param("ss", $username, $password);

    // Execute the statement
    if ($stmt->execute()) {
        // Set session variables
        $_SESSION['username'] = $username;
        $_SESSION['role'] = 'user'; // Set the role to 'user' for new registrations

        // Redirect to login page
        header("Location: index.php");
        exit();
    } else {
        echo "Error: Registration failed. Please try again.";
    }
}
?>
