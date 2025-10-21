<?php
header('Content-Type: application/json');

$host = 'sql111.cpanelfree.com';
$db = 'cpfr_38871729_ims_cloud';
$user = 'cpfr_38871729';
$pass = 'Kbl@0205';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(["error" => "DB connection failed: " . $conn->connect_error]);
    exit;
}

$response = ["daily" => [], "weekly" => [], "monthly" => [], "summary" => []];

$daily = "SELECT DATE(date_sold) as period, SUM(amount_paid) as total FROM land_sales GROUP BY DATE(date_sold)";
$weekly = "SELECT YEARWEEK(date_sold) as period, SUM(amount_paid) as total FROM land_sales GROUP BY YEARWEEK(date_sold)";
$monthly = "SELECT DATE_FORMAT(date_sold, '%Y-%m') as period, SUM(amount_paid) as total FROM land_sales GROUP BY DATE_FORMAT(date_sold, '%Y-%m')";
$summary = "SELECT contract_number, amount_paid, balance, contract_status FROM land_sales ORDER BY date_sold DESC LIMIT 10";

foreach (["daily"=>$daily, "weekly"=>$weekly, "monthly"=>$monthly, "summary"=>$summary] as $key => $query) {
  $res = $conn->query($query);
  if ($res && $res->num_rows > 0) {
    while($row = $res->fetch_assoc()) $response[$key][] = $row;
  }
}

$conn->close();
echo json_encode($response);
?>
