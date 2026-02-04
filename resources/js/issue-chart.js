document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('issueChart');
    if (!canvas) return;

    const labels = JSON.parse(canvas.dataset.labels);
    const dataPoints = JSON.parse(canvas.dataset.data);

    if (labels.length === 0) return;

    const ctx = canvas.getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Aantal storingen',
                data: dataPoints,
                borderColor: 'rgb(220, 38, 38)',
                backgroundColor: 'rgba(220, 38, 38, 0.1)',
                tension: 0.3
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });
});
