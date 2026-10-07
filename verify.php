
<?php
require_once 'config.php';

$code = $_GET['code'] ?? '';

$sql = "UPDATE users SET verified = 1 WHERE verify_code = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $code);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Account verified. <a href='index.html'>Login here</a>";
} else {
    echo "Invalid or already used verification link.";
}

$stmt->close();
$conn->close();
?>
