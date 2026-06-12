
import './bootstrap';

// SweetAlert2
import Swal from 'sweetalert2';

// Toastr
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
import TomSelect from 'tom-select';
import 'tom-select/dist/css/tom-select.css';

// ---------------------------
// TOASTR
// ---------------------------
toastr.options = {
    closeButton: true,
    progressBar: true,
    positionClass: 'toast-top-right',
    timeOut: 4000
};

window.toastr = toastr;

document.addEventListener('DOMContentLoaded', function () {

    // ---------------------------
    // SWEETALERT2 -  delete
    // ---------------------------
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const id = this.dataset.id;

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        });
    });

    // ---------------------------
    // CHARTJS - Line chart
    // ---------------------------
    const lineChartEl = document.getElementById("chartjs-dashboard-line");
    if (lineChartEl && typeof Chart !== 'undefined') {
        var ctx = lineChartEl.getContext("2d");
        var gradient = ctx.createLinearGradient(0, 0, 0, 225);
        gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
        gradient.addColorStop(1, "rgba(215, 227, 244, 0)");

        new Chart(lineChartEl, {
            type: "line",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Sales ($)",
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: window.theme?.primary || "#0d6efd",
                    data: [2115, 1562, 1584, 1892, 1587, 1923, 2566, 2448, 2805, 3438, 2917, 3327]
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: { legend: { display: false }, filler: { propagate: false } },
                scales: {
                    x: { grid: { color: "rgba(0,0,0,0.0)" } },
                    y: { ticks: { stepSize: 1000 }, grid: { color: "rgba(0,0,0,0.0)" } }
                }
            }
        });
    }

    // ---------------------------
    // CHARTJS - Pie chart
    // ---------------------------
    const pieChartEl = document.getElementById("chartjs-dashboard-pie");
    if (pieChartEl && typeof Chart !== 'undefined') {
        new Chart(pieChartEl, {
            type: "pie",
            data: {
                labels: ["Chrome", "Firefox", "IE"],
                datasets: [{
                    data: [4306, 3801, 1689],
                    backgroundColor: [
                        window.theme?.primary || "#0d6efd",
                        window.theme?.warning || "#ffc107",
                        window.theme?.danger || "#dc3545"
                    ],
                    borderWidth: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                cutout: "75%"
            }
        });
    }

    // ---------------------------
    // CHARTJS - Bar chart
    // ---------------------------
    const barChartEl = document.getElementById("chartjs-dashboard-bar");
    if (barChartEl && typeof Chart !== 'undefined') {
        new Chart(barChartEl, {
            type: "bar",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "This year",
                    backgroundColor: window.theme?.primary || "#0d6efd",
                    borderColor: window.theme?.primary || "#0d6efd",
                    data: [54, 67, 41, 55, 62, 45, 55, 73, 60, 76, 48, 79],
                    barPercentage: 0.75,
                    categoryPercentage: 0.5
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { ticks: { stepSize: 20 }, grid: { display: false } },
                    x: { grid: { color: "transparent" } }
                }
            }
        });
    }

    // ---------------------------
    // JS VECTOR MAP
    // ---------------------------
    const mapEl = document.getElementById("world_map");
    if (mapEl && typeof jsVectorMap !== 'undefined') {
        const markers = [
            { coords: [31.230391, 121.473701], name: "Shanghai" },
            { coords: [28.704060, 77.102493], name: "Delhi" },
            { coords: [6.524379, 3.379206], name: "Lagos" },
            { coords: [35.689487, 139.691711], name: "Tokyo" },
            { coords: [23.129110, 113.264381], name: "Guangzhou" },
            { coords: [40.7127837, -74.0059413], name: "New York" },
            { coords: [34.052235, -118.243683], name: "Los Angeles" },
            { coords: [41.878113, -87.629799], name: "Chicago" },
            { coords: [51.507351, -0.127758], name: "London" },
            { coords: [40.416775, -3.703790], name: "Madrid " }
        ];

        const map = new jsVectorMap({
            map: "world",
            selector: "#world_map",
            zoomButtons: true,
            markers: markers,
            markerStyle: {
                initial: { r: 9, strokeWidth: 7, strokeOpacity: 0.4, fill: window.theme?.primary || "#0d6efd" },
                hover: { fill: window.theme?.primary || "#0d6efd", stroke: window.theme?.primary || "#0d6efd" }
            },
            zoomOnScroll: false
        });

        window.addEventListener("resize", () => map.updateSize());
    }

    // ---------------------------
    // FLATPICKR - dashboard
    // ---------------------------
    const datepickerEl = document.getElementById("datetimepicker-dashboard");
    if (datepickerEl && typeof flatpickr !== 'undefined') {
        var date = new Date(Date.now() - 5 * 24 * 60 * 60 * 1000);
        var defaultDate = date.getUTCFullYear() + "-" + (date.getUTCMonth() + 1) + "-" + date.getUTCDate();

        flatpickr(datepickerEl, {
            inline: true,
            prevArrow: "<span title=\"Previous month\">&laquo;</span>",
            nextArrow: "<span title=\"Next month\">&raquo;</span>",
            defaultDate: defaultDate
        });
    }

    // ---------------------------
    // TOASTR
    // ---------------------------
    const flashSuccess = document.getElementById('flash-success');
    if (flashSuccess?.value) {
        toastr.success(flashSuccess.value);
    }

    const flashError = document.getElementById('flash-error');
    if (flashError?.value) {
        toastr.error(flashError.value);
    }


    document.querySelectorAll('.tom-select-ajax').forEach(el => {
        const url = el.getAttribute('data-url');
        const labelField = el.getAttribute('data-label') || 'name';
        const searchField = el.getAttribute('data-search') || 'name';

        new TomSelect(el, {
            valueField: 'id',
            labelField: labelField,
            searchField: searchField,
            loadThrottle: 300,
            preload: false,
            placeholder: el.querySelector('option')?.textContent || "Search...",
            load: function (query, callback) {
                if (!query.length) return callback();

                const separator = url.includes('?') ? '&' : '?';

                fetch(`${url}${separator}q=${encodeURIComponent(query)}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Server error');
                        return response.json();
                    })
                    .then(json => {
                        callback(json);
                    }).catch(() => {
                        callback();
                    });
            }
        });
    });
});
