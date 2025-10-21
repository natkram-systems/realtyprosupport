<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['name'])) {
       header('Location: index.php');
    exit();
}

// Block access for "Guest" users
if (isset($_SESSION['name']) && $_SESSION['name'] === 'Guest') {
    echo "<h2 style='text-align:center; margin-top:50px;'>Access Denied: Guest users are not allowed to view this page.</h2>";
    exit();
}


// Database configuration
$host = "sql111.cpanelfree.com";
$user = "cpfr_38871729";
$pass = "Kbl@0205";
$db   = "cpfr_38871729_ims_cloud";

// Connect to MySQL
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Fetch sales data
$sql = "SELECT DATE(date_sold) as sale_date, 
               SUM(amount_paid) as total_sales
        FROM land_sales
        GROUP BY sale_date
        ORDER BY sale_date DESC LIMIT 30";
$result = $conn->query($sql);

$sales_data = [];
while ($row = $result->fetch_assoc()) {
    $sales_data[] = $row;
}
// Summary queries
$summary = [
    'total_contracts' => 0,
    'active_contracts' => 0,
    'total_balance' => 0.00,
];

if (!$conn->connect_error) {
    $result = $conn->query("SELECT COUNT(*) AS total FROM land_sales");
    if ($row = $result->fetch_assoc()) {
        $summary['total_contracts'] = $row['total'];
    }

    $result = $conn->query("SELECT COUNT(*) AS active FROM land_sales WHERE contract_status = 'Active'");
    if ($row = $result->fetch_assoc()) {
        $summary['active_contracts'] = $row['active'];
    }

    $result = $conn->query("SELECT SUM(balance) AS balance_sum FROM land_sales");
    if ($row = $result->fetch_assoc()) {
        $summary['total_balance'] = $row['balance_sum'];
    }

   
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>MMJ GREENLAND Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      background: url('images/land_bg.jpg') no-repeat center center fixed;
      background-size: cover;
    }
    .card {
      background-color: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    footer {
      background: rgba(0, 0, 0, 0.7);
      color: white;
      padding: 10px;
      text-align: center;
      position: fixed;
      bottom: 0;
      width: 100%;
    }
    .sidebar {
      background-color: #1d4d1f;
      min-height: 100vh;
      color: white;
      padding: 20px;
    }
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-md-2 sidebar">
        <h4>MMJ GREENLAND</h4>
        <p><strong>User:</strong> 
        <?php echo isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : 'Guest'; ?></p>
        <div class="dropdown">
          <button class="btn btn-light dropdown-toggle w-100 mb-2" type="button" data-bs-toggle="dropdown">
            Menu
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            <li><a class="dropdown-item" href="update_account.php">Account Management</a></li>
            <li><a class="dropdown-item" href="export_csv.php">Export Report</a></li>
          </ul>
        </div>
      </div>

      <!-- Main Content -->
      <div class="col-md-10 p-4">
        <div class="row">
          <!-- Chart Card -->
          <div class="col-md-6 mb-4">
            <div class="card p-3">
              <h5>Sales - Last 30 Days</h5>
              <canvas id="salesChart"></canvas>
            </div>
          </div>
          <!-- Static Summary -->
          <div class="col-md-6 mb-4">
            <div class="card p-3">
             <h5>Sales Summary</h5>
<ul class="list-unstyled">
  <li><strong>Total Contracts:</strong> <?php echo $summary['total_contracts']; ?></li>
  <li><strong>Active Contracts:</strong> <?php echo $summary['active_contracts']; ?></li>
  <li><strong>Total Balance Remaining:</strong> ₱<?php echo number_format($summary['total_balance'], 2); ?></li>
</ul>

            </div>
          </div>
        </div>
        <div class="row">
          <!-- Sales Data Table -->
          <div class="col-12">
            <div class="card p-3">
              <h5>Sales Table</h5>
              <table class="table table-sm">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Amount Paid</th>
                    <th>Last Payment</th>
                    <th>Balance</th>
                     <th>Last Trn.</th>
                  </tr>
                </thead>
               <tbody>
<?php
// Reconnect for table data (or reuse earlier connection if kept open)
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo "<tr><td colspan='5'>Database connection failed</td></tr>";
} else {
    $sql = "SELECT buyer_name, contract_status, price, last_amount_paid, balance, date_last_transaction FROM land_sales ORDER BY date_sold DESC LIMIT 50";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['buyer_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['contract_status']) . "</td>";
            echo "<td>₱" . number_format($row['price'], 2) . "</td>";
            echo "<td>₱" . number_format($row['last_amount_paid'], 2) . "</td>";
            echo "<td>₱" . number_format($row['balance'], 2) . "</td>";
            echo "<td>" . htmlspecialchars($row['date_last_transaction']) . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No sales data found</td></tr>";
    }

    $conn->close();
}
?>
</tbody>

              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer>
    <p>Page rendered in <span id="render-time"></span> seconds | 
       <span id="current-time"></span></p>
    <p>Powered by <strong>Natkram-Systems</strong></p>
  </footer>

  <script>
    const currentTime = new Date().toLocaleString();
    document.getElementById('current-time').textContent = currentTime;

    window.onload = function() {
      const renderTime = (performance.now() / 1000).toFixed(3);
      document.getElementById('render-time').textContent = renderTime;
    };

    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesData = {
      labels: <?php echo json_encode(array_column($sales_data, 'sale_date')); ?>,
      datasets: [{
        label: 'Daily Sales (₱)',
        data: <?php echo json_encode(array_column($sales_data, 'total_sales')); ?>,
        borderColor: 'green',
        backgroundColor: 'rgba(34, 139, 34, 0.2)',
        fill: true
      }]
    };
    const salesChart = new Chart(ctx, {
      type: 'line',
      data: salesData
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
