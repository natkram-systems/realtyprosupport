
<?php
$host = 'sql111.cpanelfree.com';
$db = 'cpfr_38871729_ims_cloud';
$user = 'cpfr_38871729';
$pass = 'Kbl@0205';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
