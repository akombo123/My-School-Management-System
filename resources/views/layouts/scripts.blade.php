<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
@yield('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
<script src="{{ asset('js/adminlte.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector('.sidebar-wrapper');
        if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
            OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                scrollbars: {
                    theme: 'os-theme-light',
                    autoHide: 'leave',
                    clickScroll: true,
                },
            });
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"
        crossorigin="anonymous"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const connectedSortables = document.querySelectorAll('.connectedSortable');
        connectedSortables.forEach((connectedSortable) => {
            new Sortable(connectedSortable, {
                group: 'shared',
                handle: '.card-header',
            });
        });

        document.querySelectorAll('.connectedSortable .card-header').forEach((cardHeader) => {
            cardHeader.style.cursor = 'move';
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
        crossorigin="anonymous"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const revenueChartElement = document.querySelector('#revenue-chart');
        if (revenueChartElement) {
            const salesChart = new ApexCharts(revenueChartElement, {
                series: [
                    { name: 'Digital Goods', data: [28, 48, 40, 19, 86, 27, 90] },
                    { name: 'Electronics', data: [65, 59, 80, 81, 56, 55, 40] }
                ],
                chart: { height: 300, type: 'area', toolbar: { show: false } },
                legend: { show: false },
                colors: ['#0d6efd', '#20c997'],
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth' },
                xaxis: {
                    type: 'datetime',
                    categories: ['2023-01-01', '2023-02-01', '2023-03-01', '2023-04-01', '2023-05-01', '2023-06-01', '2023-07-01'],
                },
                tooltip: { x: { format: 'MMMM yyyy' } },
            });
            salesChart.render();
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js"
        crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js"
        crossorigin="anonymous"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (document.querySelector('#world-map')) {
            new jsVectorMap({ selector: '#world-map', map: 'world' });
        }
        [['#sparkline-1', [1000, 1200, 920, 927, 931, 1027, 819, 930, 1021]],
         ['#sparkline-2', [515, 519, 520, 522, 652, 810, 370, 627, 319, 630, 921]],
         ['#sparkline-3', [15, 19, 20, 22, 33, 27, 31, 27, 19, 30, 21]]]
        .forEach(([selector, data]) => {
            const element = document.querySelector(selector);
            if (element) {
                new ApexCharts(element, {
                    series: [{ data }],
                    chart: { type: 'area', height: 50, sparkline: { enabled: true } },
                    stroke: { curve: 'straight' },
                    fill: { opacity: 0.3 },
                    yaxis: { min: 0 },
                    colors: ['#DCE6EC'],
                }).render();
            }
        });
    });
</script>
