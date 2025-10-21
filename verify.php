
<?php
$host = 'sql111.cpanelfree.com';
$db = 'cpfr_38871729_ims_cloud';
$user = 'cpfr_38871729';
$pass = 'Kbl@0205';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
