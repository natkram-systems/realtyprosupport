<?php
require 'config.php'; // DB connection file
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($name) || empty($email) || empty($password)) {
        die("Please fill out all fields.");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $user_id = uniqid('user_');

    $stmt = $conn->prepare("INSERT INTO users (user_id, name, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $user_id, $name, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "Registration successful. <a href='index.php'>Login</a>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
