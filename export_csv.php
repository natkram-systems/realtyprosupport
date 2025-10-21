<?php
$host = 'sql111.cpanelfree.com';
$db = 'cpfr_38871729_ims_cloud';
$user = 'cpfr_38871729';
$pass = 'Kbl@0205';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=sales_export.csv');
    $output = fopen('php://output', 'w');

    // Adjust these column headers to match your table structure
    fputcsv($output, ['Contract Number', 'Balance', 'Amount Paid', 'Last Amount Paid', 'Contract Status', 'Date']);

    // Replace 'sales_table' with your actual table name
    $sql = "SELECT contract_number, balance, amount_paid, last_amount_paid, contract_status, date_last_transaction FROM land_sales";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
                fputcsv($output, $row);
                    }
                    }
                    fclose($output);
                    $conn->close();
                    ?>