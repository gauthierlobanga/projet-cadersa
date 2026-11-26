import Chart from "chart.js/auto";

const chartColors = ["#047857", "#475569", "#2dd4bf"];

function decodeChartData(encodedData) {
    const binary = window.atob(encodedData);
    const bytes = Uint8Array.from(binary, (character) => character.charCodeAt(0));

    return JSON.parse(new TextDecoder().decode(bytes));
}

function isDarkMode() {
    return document.documentElement.classList.contains("dark");
}

function chartOptions(kind) {
    const textColor = isDarkMode() ? "#cbd5e1" : "#475569";
    const gridColor = isDarkMode() ? "rgba(148, 163, 184, .16)" : "rgba(100, 116, 139, .14)";
    const isDoughnut = kind === "formats";

    return {
        responsive: true,
        maintainAspectRatio: false,
        animation: false,
        color: textColor,
        interaction: {
            intersect: false,
            mode: "index",
        },
        plugins: {
            legend: {
                display: true,
                position: "bottom",
                labels: {
                    color: textColor,
                    usePointStyle: true,
                    pointStyle: "circle",
                    boxWidth: 8,
                    padding: 18,
                },
            },
            tooltip: {
                enabled: true,
                backgroundColor: isDarkMode() ? "#0f172a" : "#0f172a",
                titleColor: "#f8fafc",
                bodyColor: "#e2e8f0",
                borderColor: isDarkMode() ? "#334155" : "#1e293b",
                borderWidth: 1,
                padding: 10,
                displayColors: true,
            },
        },
        ...(isDoughnut
            ? {
                  cutout: "72%",
                  plugins: {
                      legend: {
                          display: true,
                          position: "bottom",
                          labels: {
                              color: textColor,
                              usePointStyle: true,
                              pointStyle: "circle",
                              boxWidth: 8,
                              padding: 18,
                          },
                      },
                      tooltip: {
                          enabled: true,
                          backgroundColor: "#0f172a",
                          titleColor: "#f8fafc",
                          bodyColor: "#e2e8f0",
                          borderColor: isDarkMode() ? "#334155" : "#1e293b",
                          borderWidth: 1,
                          padding: 10,
                      },
                  },
              }
            : {
                  scales: {
                      x: {
                          stacked: kind === "monthly",
                          grid: { display: false },
                          ticks: { color: textColor },
                      },
                      y: {
                          stacked: kind === "monthly",
                          beginAtZero: true,
                          ticks: { color: textColor, precision: 0 },
                          grid: { color: gridColor, drawBorder: false },
                      },
                  },
              }),
    };
}

function normalizeDatasets(kind, datasets) {
    if (kind === "formats") {
        return datasets.map((dataset) => ({
            ...dataset,
            backgroundColor: chartColors,
            borderColor: isDarkMode() ? "#0f172a" : "#ffffff",
            borderWidth: 3,
            hoverOffset: 5,
        }));
    }

    return datasets.map((dataset, index) => ({
        ...dataset,
        backgroundColor:
            kind === "trend"
                ? "rgba(16, 185, 129, .14)"
                : chartColors[index % chartColors.length],
        borderColor: chartColors[index % chartColors.length],
        borderWidth: kind === "trend" ? 2.5 : 0,
        borderRadius: 4,
        fill: kind === "trend",
        tension: kind === "trend" ? 0.35 : 0,
        pointRadius: kind === "trend" ? 3 : 0,
        pointHoverRadius: kind === "trend" ? 5 : 0,
        pointBackgroundColor: chartColors[index % chartColors.length],
    }));
}

function refreshReportCharts(root = document) {
    const canvases = [];

    if (root instanceof HTMLCanvasElement && root.matches("canvas[data-report-chart]")) {
        canvases.push(root);
    }

    if (typeof root.querySelectorAll === "function") {
        canvases.push(...root.querySelectorAll("canvas[data-report-chart]"));
    }

    for (const canvas of canvases) {
        if (!canvas.isConnected || !canvas.dataset.chartData) {
            continue;
        }

        const kind = canvas.dataset.reportChart;
        const type = kind === "formats" ? "doughnut" : kind === "trend" ? "line" : "bar";
        const data = decodeChartData(canvas.dataset.chartData);
        data.datasets = normalizeDatasets(kind, data.datasets);

        const existingChart = Chart.getChart(canvas);

        if (existingChart) {
            existingChart.data = data;
            existingChart.options = chartOptions(kind);
            existingChart.update("none");
            continue;
        }

        new Chart(canvas, {
            type,
            data,
            options: chartOptions(kind),
        });
    }
}

function refreshAllReportCharts() {
    refreshReportCharts(document);
}

document.addEventListener("DOMContentLoaded", refreshAllReportCharts, { once: true });
document.addEventListener("livewire:navigated", refreshAllReportCharts);
document.addEventListener("livewire:init", () => {
    window.Livewire?.hook("morphed", ({ el }) => refreshReportCharts(el));
});

new MutationObserver((mutations) => {
    if (mutations.some((mutation) => mutation.attributeName === "class")) {
        for (const canvas of document.querySelectorAll("canvas[data-report-chart]")) {
            const chart = Chart.getChart(canvas);

            if (chart) {
                chart.options = chartOptions(canvas.dataset.reportChart);
                chart.update("none");
            }
        }
    }
}).observe(document.documentElement, { attributes: true, attributeFilter: ["class"] });

refreshAllReportCharts();
