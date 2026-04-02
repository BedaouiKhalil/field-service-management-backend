import { initDeleteButtons } from './delete.js';
import { initLineChart, initPieChart, initBarChart } from './charts.js';
import { initWorldMap } from './map.js';
import { initFlatpickr } from './flatpickr.js';

document.addEventListener('DOMContentLoaded', function() {
    initDeleteButtons();
    initLineChart();
    initPieChart();
    initBarChart();
    initWorldMap();
    initFlatpickr();
});
