<!DOCTYPE html>
<html lang="en">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="filter-container p-3 bg-white shadow-sm rounded">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label for="start_date" class="form-label fw-bold">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control"/>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label for="end_date" class="form-label fw-bold">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control"/>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label for="area" class="form-label fw-bold">Area</label>
                            <select name="area" id="area" class="form-select">
                                <option value="">Choose</option>
                                <option value="All">All</option>
                                @foreach($areas as $area)
                                    <option value="{{ $area }}">{{ $area }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex align-items-end mb-3">
                        <button type="button" id="filterButton" class="btn w-100 text-white" style="background-color: #3f58b4;">
                            <i class="bi bi-filter"></i> Filter
                        </button>
                        <button type="button" id="clearButton" class="btn w-100 text-black" style="background-color: #F0F8FF;">
                            <i class="bi bi-x-lg"></i> Clear
                        </button>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>

<!-- Add necessary JS scripts -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('filterButton').addEventListener('click', function() {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;
        const area = document.getElementById('area').value;

        if (!startDate || !endDate || area === '') {
            alert('Please fill in all filter fields.');
            return;
        }

        // Log activity when filter button is clicked
        axios.post('{{ route('log.activity') }}', {
                activity_name: 'Dashboard Filter Button Clicked',
                _token: "{{ csrf_token() }}"
            })
            .then(response => {
                console.log('Activity logged successfully');
            })
            .catch(error => {
                console.error('Error logging activity:', error);
            });

        axios.get('{{ route('dashboard.filter') }}', {
                params: {
                    start_date: startDate,
                    end_date: endDate,
                    area: area
                }
            })
            .then(response => {
                const data = response.data;
                document.getElementById('totalTemuanModel').innerText = data.totalTemuanModel;
                document.getElementById('truePothole').innerText = data.truePothole;
                document.getElementById('akurasiModel').innerText = data.akurasiModel + '%';

                // Update charts with new data
                updateCharts(data);
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    });

    document.getElementById('clearButton').addEventListener('click', function() {
        document.getElementById('start_date').value = '';
        document.getElementById('end_date').value = '';
        document.getElementById('area').value = '';

        // Log activity when clear button is clicked
        axios.post('{{ route('log.activity') }}', {
                activity_name: 'Dashboard Clear Button Clicked',
                _token: "{{ csrf_token() }}"
            })
            .then(response => {
                console.log('Activity logged successfully');
            })
            .catch(error => {
                console.error('Error logging activity:', error);
            });

        // Fetch data for the current year when the clear button is clicked
        fetchCurrentYearData();
    });

    function updateCharts(data) {
        if (temuanChart && metricsChart) {
            temuanChart.data.labels = data.months;
            temuanChart.data.datasets[0].data = data.totalTemuan;
            temuanChart.data.datasets[1].data = data.verified;
            temuanChart.update();

            metricsChart.data.labels = data.months;
            metricsChart.data.datasets[0].data = data.accuracy;
            metricsChart.data.datasets[1].data = data.precision;
            metricsChart.data.datasets[2].data = data.recall;
            metricsChart.update();
        } else {
            console.error("Charts are not defined.");
        }
    }
});
</script>
</html>
