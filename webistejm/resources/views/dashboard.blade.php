@extends('layouts.app_dashboard')

@section('content')
<div class="col-12 col-md-4 mb-3">
    <div class="card text-black">
        <div class="card-body text-center">
            <h5 class="mb-2 fw-bold">Total Laporan</h5>
            <p class="card-text display-4" id="totalLaporan">{{ $data['totalLaporan'] }}</p>
        </div>
    </div>
</div>
<div class="col-12 col-md-4 mb-3">
    <div class="card text-black">
        <div class="card-body text-center">
            <h5 class="mb-2 fw-bold">Laporan Approved</h5>
            <p class="card-text display-4" id="laporanApproved">{{ $data['laporanDiterima'] }}</p>
        </div>
    </div>
</div>
<div class="col-12 col-md-4 mb-3">
    <div class="card text-black">
        <div class="card-body text-center">
            <h5 class="mb-2 fw-bold">Persentase Laporan Approved</h5>
            <p class="card-text display-4" id="prctgLaporanApproved">{{ $data['persentaseLaporanDiterima'] }}%</p>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-bold">Jumlah Temuan Model</h5>
            <canvas id="temuanChart"></canvas>
        </div>
    </div>
</div>
{{-- <div class="col-md-6">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-bold">Evaluation Metrics</h5>
            <canvas id="metricsChart"></canvas>
        </div>
    </div>
</div> --}}

<!-- JS Libraries -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let temuanChart;
        let metricsChart;

        // Initialize Charts
        function initializeCharts() {
            const ctxTemuan = document.getElementById('temuanChart').getContext('2d');
            // const ctxMetrics = document.getElementById('metricsChart').getContext('2d');

            temuanChart = new Chart(ctxTemuan, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Total Laporan',
                        data: [],
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Approved',
                        data: [],
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // metricsChart = new Chart(ctxMetrics, {
            //     type: 'line',
            //     data: {
            //         labels: [],
            //         datasets: [{
            //             label: 'Accuracy',
            //             data: [],
            //             backgroundColor: 'rgba(255, 99, 132, 0.2)',
            //             borderColor: 'rgba(255, 99, 132, 1)',
            //             fill: false,
            //             radius: 5,
            //             pointHoverRadius: 7
            //         }, {
            //             label: 'Precision',
            //             data: [],
            //             backgroundColor: 'rgba(54, 162, 235, 0.2)',
            //             borderColor: 'rgba(54, 162, 235, 1)',
            //             fill: false,
            //             radius: 5,
            //             pointHoverRadius: 7
            //         }, {
            //             label: 'Recall',
            //             data: [],
            //             borderColor: 'rgb(75, 192, 192, 1)',
            //             backgroundColor: 'rgb(75, 192, 192, 0.2)',
            //             fill: false,
            //             radius: 5,
            //             pointHoverRadius: 7
            //         }]
            //     },
            //     options: {
            //         responsive: true,
            //         scales: {
            //             y: {
            //                 beginAtZero: true,
            //                 max: 100
            //             }
            //         }
            //     }
            // });

            console.log('Charts initialized:', temuanChart, metricsChart);
        }

        // Fetch Current Year Data
        function fetchCurrentYearData() {
            axios.get('{{ route('dashboard.filter') }}', {
                params: {
                    start_date: '{{ now()->startOfYear()->toDateString() }}',
                    end_date: '{{ now()->endOfYear()->toDateString() }}',
                    area: 'All'
                }
            })
                .then(response => {
                    updateCharts(response.data);
                })
                .catch(error => {
                    console.error('Error fetching initial data:', error);
                });
        }

        // Sanitize Data Array
        function sanitizeDataArray(dataArray) {
            if (!Array.isArray(dataArray)) {
                return [];
            }
            return dataArray.filter(item => typeof item === 'number' || typeof item === 'string');
        }

        // Validate and Sanitize Data
        function validateAndSanitizeData(data) {
            return {
                months: sanitizeDataArray(data.months),
                totalTemuan: sanitizeDataArray(data.totalTemuan),
                verified: sanitizeDataArray(data.verified),
                accuracy: sanitizeDataArray(data.accuracy),
                precision: sanitizeDataArray(data.precision),
                recall: sanitizeDataArray(data.recall),
                totalTemuanModel: data.totalTemuanModel,
                truePothole: data.truePothole,
                akurasiModel: data.akurasiModel
            };
        }

        // Update Charts
        function updateCharts(data) {
            console.log('Updating charts with data:', data);

            const sanitizedData = validateAndSanitizeData(data);

            if (temuanChart) {
                console.log('Updating temuanChart');
                temuanChart.data.labels = sanitizedData.months;
                temuanChart.data.datasets[0].data = sanitizedData.totalTemuan;
                temuanChart.data.datasets[1].data = sanitizedData.verified;
                temuanChart.update();
            } else {
                console.error("temuanChart is not defined.");
            }

            if (metricsChart) {
                console.log('Updating metricsChart');
                metricsChart.data.labels = sanitizedData.months;
                metricsChart.data.datasets[0].data = sanitizedData.accuracy;
                metricsChart.data.datasets[1].data = sanitizedData.precision;
                metricsChart.data.datasets[2].data = sanitizedData.recall;
                metricsChart.update();
            } else {
                console.error("metricsChart is not defined.");
            }

            document.getElementById('totalTemuanModel').innerText = sanitizedData.totalTemuanModel;
            document.getElementById('truePothole').innerText = sanitizedData.truePothole;
            document.getElementById('akurasiModel').innerText = sanitizedData.akurasiModel + '%';
        }

        initializeCharts();
        fetchCurrentYearData();

        document.getElementById('filterButton').addEventListener('click', function () {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;
            const area = document.getElementById('area').value;

            if (!startDate || !endDate || area === '') {
                alert('Please fill in all filter fields.');
                return;
            }

            axios.get('{{ route('dashboard.filter') }}', {
                params: {
                    start_date: startDate,
                    end_date: endDate,
                    area: area
                }
            })
                .then(response => {
                    updateCharts(response.data);
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        });

        document.getElementById('clearButton').addEventListener('click', function () {
            document.getElementById('start_date').value = '';
            document.getElementById('end_date').value = '';
            document.getElementById('area').value = '';

            fetchCurrentYearData();
        });
    });
</script>
@endsection
