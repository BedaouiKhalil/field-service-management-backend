export function initLineChart() {
    const ctx = document.getElementById("chartjs-dashboard-line");
    if (!ctx) return;

    const gradient = ctx.getContext("2d").createLinearGradient(0, 0, 0, 225);
    gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
    gradient.addColorStop(1, "rgba(215, 227, 244, 0)");

    new Chart(ctx, {
        type: "line",
        data: {
            labels: ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
            datasets: [{
                label: "Sales ($)",
                fill: true,
                backgroundColor: gradient,
                borderColor: window.theme.primary,
                data: [2115,1562,1584,1892,1587,1923,2566,2448,2805,3438,2917,3327]
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: { filler: { propagate: false } },
            scales: {
                x: { grid: { color: "transparent" } },
                y: { ticks: { stepSize: 1000 }, grid: { color: "transparent" } }
            }
        }
    });
}

export function initPieChart() {
    const ctx = document.getElementById("chartjs-dashboard-pie");
    if (!ctx) return;

    new Chart(ctx, {
        type: "pie",
        data: {
            labels: ["Chrome", "Firefox", "IE"],
            datasets: [{
                data: [4306, 3801, 1689],
                backgroundColor: [window.theme.primary, window.theme.warning, window.theme.danger],
                borderWidth: 5
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, cutout: "75%" }
    });
}

export function initBarChart() {
    const ctx = document.getElementById("chartjs-dashboard-bar");
    if (!ctx) return;

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
            datasets: [{
                label: "This year",
                backgroundColor: window.theme.primary,
                borderColor: window.theme.primary,
                data: [54,67,41,55,62,45,55,73,60,76,48,79],
                barPercentage: 0.75,
                categoryPercentage: 0.5
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: { ticks: { stepSize: 20 }, grid: { display: false } },
                x: { grid: { color: "transparent" } }
            }
        }
    });
}
