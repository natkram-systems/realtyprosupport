<?php
session_start();
require_once 'config.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.html');
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($name) && !empty($email)) {
        $sql = "UPDATE users SET name = ?, email = ?";
        $params = [$name, $email];

        if (!empty($password)) {
            $sql .= ", password = ?";
            $params[] = password_hash($password, PASSWORD_DEFAULT);
        }

        $sql .= " WHERE user_id = ?";
        $params[] = $user_id;

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(str_repeat("s", count($params) - 1) . "i", ...$params);

        if ($stmt->execute()) {
            $message = "Account updated successfully.";
            $_SESSION['name'] = $name;
        } else {
            $message = "Error updating account.";
        }
    } else {
        $message = "Name and email are required.";
    }
}

// Fetch current user info
$stmt = $conn->prepare("SELECT name, email FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Account</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f4f4f4;
        }
        .container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            margin: 0.5rem 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 0.75rem;
            width: 100%;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .message {
            margin-top: 1rem;
            color: #333;
            text-align: center;
        }
        .back-link {
            display: block;
            margin-top: 1rem;
            text-align: center;
            text-decoration: none;
            color: #4CAF50;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Update Account</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
        <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        <input type="password" name="password" placeholder="New Password (optional)">
        <button type="submit">Update</button>
        <div class="message"><?php echo $message; ?></div>
    </form>
    <a class="back-link" href="dashboard.php">&larr; Back to Dashboard</a>
</div>
</body>
</html>
