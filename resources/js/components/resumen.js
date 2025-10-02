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
        labels.push(months[d.getMonth()]);
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
    const rawData = await fetchIngresosData(investorId);
    const data = Array.isArray(rawData) ? rawData.map(v => Number(v) || 0) : [];
    const ctx = chartEl.getContext('2d');
    if (window.barChartIngresosInstance) {
        window.barChartIngresosInstance.destroy();
    }
    window.barChartIngresosInstance = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: '', // vacío para evitar leyenda
                data: data,
                backgroundColor: '#9cabff', // igual que example-chart.js
                borderWidth: 2,
                borderColor: 'transparent',
                hoverBorderColor: 'transparent',
                borderSkipped: 'bottom',
                barPercentage: 0.6,
                categoryPercentage: 0.7
            }]
        },
        options: {
            plugins: {
                legend: { display: false }, // Chart.js v3+
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const val = context.parsed.y || 0;
                            return new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(val);
                        }
                    },
                    backgroundColor: '#eff6ff',
                    titleFont: { size: 13 },
                    titleColor: '#6783b8',
                    titleMarginBottom: 6,
                    bodyColor: '#9eaecf',
                    bodyFont: { size: 12 },
                    bodySpacing: 4,
                    padding: 10,
                    footerMarginTop: 0,
                    displayColors: false
                }
            },
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#9eaecf',
                        font: { size: 12 },
                        padding: 5,
                        callback: function(value) {
                            return new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(value);
                        }
                    },
                    grid: { color: 'rgba(82,100,132,0.2)', tickLength: 0, drawTicks: false }
                },
                x: {
                    ticks: { color: '#9eaecf', font: { size: 12 }, padding: 5 },
                    grid: { color: 'transparent', tickLength: 10, drawTicks: false }
                }
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', renderBarChartIngresos);
