<?php
// Database connection settings.
// Values are read from the environment so the app runs against the local
// development MySQL service (see docker-compose.base44.yml). The fallbacks match
// that service so a plain `php -S` run also connects.
$host = getenv('DB_HOST') ?: '127.0.0.1';
$db   = getenv('DB_NAME') ?: 'ims_cloud';
$user = getenv('DB_USER') ?: 'mmj';
$pass = getenv('DB_PASS') ?: 'mmj_dev_pw';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
