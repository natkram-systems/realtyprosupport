<?php
include 'db.php';

function getTotal($conn, $interval) {
    $sql = "SELECT SUM(price) as total FROM land_sales WHERE date_sold >= DATE_SUB(CURDATE(), INTERVAL $interval)";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return (float)$row['total'];
}

$data = [
    'daily' => getTotal($conn, '1 DAY'),
    'weekly' => getTotal($conn, '1 WEEK'),
    'monthly' => getTotal($conn, '1 MONTH')
];

header('Content-Type: application/json');
echo json_encode($data);
$conn->close();
?>
