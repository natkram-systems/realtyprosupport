
function loadData(period) {
    fetch('fetch_sales.php?period=' + period)
        .then(response => response.json())
        .then(data => {
            updateTable(data);
            updateChart(data);
            updatePieChart(data);
        });
}

function updateTable(data) {
    const tbody = document.getElementById("salesData");
    tbody.innerHTML = "";
    data.forEach(row => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
            <td>${row.lot_id}</td>
            <td>${row.buyer_name}</td>
            <td>₱${parseFloat(row.price).toLocaleString()}</td>
            <td>₱${parseFloat(row.amount_paid).toLocaleString()}</td>
            <td>₱${parseFloat(row.balance).toLocaleString()}</td>
            <td>₱${parseFloat(row.last_amount_paid).toLocaleString()}</td>
            <td>${row.contract_number}</td>
            <td>${row.contract_status}</td>
            <td>${row.date_sold}</td>
        `;
        tbody.appendChild(tr);
    });
}

let chart, pieChart;
function updateChart(data) {
    const ctx = document.getElementById("salesChart").getContext("2d");
    const labels = data.map(d => d.date_sold);
    const values = data.map(d => d.amount_paid);

    if (chart) chart.destroy();

    chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Amount Paid (PHP)',
                data: values,
                backgroundColor: 'rgba(75, 192, 75, 0.6)',
                borderColor: 'green',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
}

function updatePieChart(data) {
    const ctx = document.getElementById("statusChart").getContext("2d");
    const statusCount = {};
    data.forEach(d => {
        statusCount[d.contract_status] = (statusCount[d.contract_status] || 0) + 1;
    });

    if (pieChart) pieChart.destroy();

    pieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: Object.keys(statusCount),
            datasets: [{
                label: 'Contract Status',
                data: Object.values(statusCount),
                backgroundColor: ['green', 'orange', 'red', 'blue']
            }]
        },
        options: { responsive: true }
    });
}

function exportToCSV() {
    window.location.href = 'export_csv.php';
}

loadData('all');
