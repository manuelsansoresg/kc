import axios from 'axios';

function getMonthLabels() {
    const months = [
        'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
        'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'
    ];
    const now = new Date();
    let labels = [];
    for (let i = 5; i >= 0; i--) {
        let d = new Date(now.getFullYear(), now.getMonth() - i, 1);
        if (i === 0) {
            labels.push('Mes actual');
        } else {
            labels.push(`Mes -${i}`);
        }
    }
    return labels;
}

async function fetchIngresosData(investorId) {
    try {
        const response = await axios.get(`/panel/inversionista/${investorId}/ingresos-mensuales`);
        return response.data;
    } catch (error) {
        return [0, 0, 0, 0, 0, 0];
    }
}

async function renderBarChartIngresos() {
    const chartEl = document.getElementById('barChartIngresos');
    if (!chartEl) return;
    const investorId = document.getElementById('investorId')?.value;
    if (!investorId) return;
    const labels = getMonthLabels();
    const data = await fetchIngresosData(investorId);
    const ctx = chartEl.getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Ingresos',
                data: data,
                backgroundColor: 'rgba(255,0,0,0)',
                borderColor: '#d11a1a',
                borderWidth: 2,
                hoverBackgroundColor: 'rgba(255,0,0,0.1)',
            }]
        },
        options: {
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `$${context.parsed.y}`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#d11a1a' }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#f2dede' },
                    ticks: { color: '#d11a1a' }
                }
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', renderBarChartIngresos);
