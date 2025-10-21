<?php
session_start();
require 'config.php'; // database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $_SESSION['message'] = "Missing input.";
        header("Location: index.php");
        exit();
    }

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    if (!$stmt) {
        $_SESSION['message'] = "Database error.";
        header("Location: index.php");
        exit();
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['name'];
            header("Location: dashboard.php"); // or any page after login
            exit();
        } else {
            $_SESSION['message'] = "Invalid password.";
        }
    } else {
        $_SESSION['message'] = "User not found.";
    }

    $stmt->close();
} else {
    $_SESSION['message'] = "Invalid request.";
}
header("Location: index.php");
exit();
?>
