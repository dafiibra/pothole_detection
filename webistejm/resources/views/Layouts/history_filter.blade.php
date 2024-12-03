<!-- Filter -->
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="filter-container p-3 pb-0 bg-white shadow-sm rounded">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="form-group w-100">
                            <label for="from_date" class="form-label fw-bold">Start Date</label>
                            <input type="date" name="from_date" id="from_date" class="form-control"/>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="form-group w-100">
                            <label for="to_date" class="form-label fw-bold">End Date</label>
                            <input type="date" name="to_date" id="to_date" class="form-control"/>
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <div class="form-group w-100">
                            <label for="area" class="form-label fw-bold">Area</label>
                            <select name="area" id="area" class="form-select">
                                <option value="">Choose</option>
                                <option value="All">All</option>
                                @foreach($areas as $area)
                                <option value="{{$area}}">{{$area}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                      <div class="form-group w-100">
                        <label for="repair_progress" class="form-label fw-bold">Penanganan</label>
                        <select name="repair_progress" id="repair_progress" class="form-select">
                            <option value="">Choose</option>
                            <option value="All">All</option>
                            <option value="0">0%</option>
                            <option value="50">50%</option>
                            <option value="100">100%</option>
                        </select>
                      </div>
                    </div>
                    <div class="col d-flex align-items-end mb-3 pb-3">
                        <button type="button" name="filter" id="filter" class="me-2 btn text-white" style="background-color: #3f58b4;">
                          Filter
                        </button>
                        <button type="button" name="refresh" id="refresh" class="btn" style="color: #283978;">
                          <i class="bi bi-x mr-1" style="padding-right:0px;"></i>
                          Clear
                        </button>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('filter').addEventListener('click', function() {
        // Log activity when validation filter button is clicked
        axios.post('{{ route('log.activity') }}', {
                activity_name: 'History Filter Button Clicked',
                _token: "{{ csrf_token() }}"
            })
            .then(response => {
                console.log('Activity logged successfully');
            })
            .catch(error => {
                console.error('Error logging activity:', error);
            });
    });

    document.getElementById('refresh').addEventListener('click', function() {
        // Log activity when validation clear button is clicked
        axios.post('{{ route('log.activity') }}', {
                activity_name: 'History Clear Button Clicked',
                _token: "{{ csrf_token() }}"
            })
            .then(response => {
                console.log('Activity logged successfully');
            })
            .catch(error => {
                console.error('Error logging activity:', error);
            });
    });
});
</script>