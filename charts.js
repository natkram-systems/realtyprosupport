
fetch('fetch_sales.php')
  .then(response => response.json())
  .then(data => {
    // Assume API returns { daily: [...], weekly: [...], monthly: [...], rows: [...] }
    new Chart(document.getElementById('dailyChart'), {
      type: 'bar',
      data: {
        labels: data.labels.daily,
        datasets: [{ label: '₱ Sales', data: data.daily, backgroundColor: '#66bb6a' }]
      }
    });

    new Chart(document.getElementById('weeklyChart'), {
      type: 'line',
      data: {
        labels: data.labels.weekly,
        datasets: [{ label: '₱ Sales', data: data.weekly, borderColor: '#388e3c', fill: false }]
      }
    });

    new Chart(document.getElementById('monthlyChart'), {
      type: 'pie',
      data: {
        labels: data.labels.monthly,
        datasets: [{ label: '₱ Sales', data: data.monthly, backgroundColor: ['#a5d6a7', '#81c784', '#66bb6a', '#4caf50'] }]
      }
    });

    const tbody = document.getElementById('salesDataBody');
    data.rows.forEach(row => {
      const tr = document.createElement('tr');
      row.forEach(cell => {
        const td = document.createElement('td');
        td.textContent = cell;
        tr.appendChild(td);
      });
      tbody.appendChild(tr);
    });
  });
