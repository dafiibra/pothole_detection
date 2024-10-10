@extends('layouts.history_page')

@section('title', 'Pothole Detection History')

@section('content')
  <div class="container-fluid w-100">
    <div class="row justify-content-center">
      <div class="col-lg-12">
        <div class="table-container m-0 p-3 bg-white shadow-sm rounded">
          <p class="table-title">Pothole Detection History</p>
            <div class="table-responsive">
              <table class="table table-bordered display" id="table">
                <thead>
                  <tr class="table-row">
                    <th scope="col">No.</th>
                    <th scope="col">Image</th>
                    <th scope="col">ID</th>
                    <th scope="col">latlong</th>
                    <th scope="col">Repair Progress</th>
                    <th scope="col">Repair Evidence</th>
                  </tr>
                </thead>
              </table>
            </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- update modal -->
  <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="updateForm" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Progress</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="updateId" name="id_deteksi">
                    <div class="form-group">
                      <label for="progress">Progress</label>
                      <select id="progress" name="progress" class="form-control">
                        <option value="0%">0%</option>
                        <option value="50%">50%</option>
                        <option value="100%">100%</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="image">Evidence</label>
                      <input type="file" id="image" name="image" class="form-control-file">
                      <div id="drop-area" class="text-center">
                        <div id="drop-input" class="text-center">
                          <i class="bi bi-upload" style="font-size: 3rem; color:#c0c0c0"></i>
                          <p>Drag and drop image here</p>
                        </div>
                        <div id="preview-container" class="mt-2">
                          <img class="mx-auto" id="preview-image" src="" alt="Preview Image" style="display: none; max-height: 100px;">
                          <div id="file-name"></div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
  </div>

  <!-- Datatables Scripts -->
<script>
  $(document).ready(function(){
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $('.input-daterange').datepicker({
      todayBtn: 'linked',
      format: 'yyyy-mm-dd',
      autoclose: true
    });

    fetch_data('', '', 'All', 'All');

    $('#filter').click(function(){
      var from_date = $('#from_date').val();
      var to_date = $('#to_date').val();
      var area = $('#area option:selected').val();
      var repair_progress = $('#repair_progress option:selected').val();
      fetch_data(from_date, to_date, area, repair_progress);
    });

    function fetch_data(from_date = '', to_date = '', area = '', repair_progress = '') {
      $('#table').DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        searching: false,
        responsive: true,
        ajax: {
          url: '{{ route("history.fetch_data") }}',
          data: {'from_date':from_date, 'to_date':to_date, 'area':area, 'repair_progress': repair_progress},
        },
        columns: [
          {
            data: null,
            render: function (data, type, row, meta) {
              return meta.row + meta.settings._iDisplayStart + 1;
            }
          },
          {
            data:'image_url',
            name:'image_url',
            "render": function (data, type, row, meta) {
              return '<img src="' + data + '" alt="Image">';
            }
          },
          {
            data:'id_deteksi',
            name:'id_deteksi'
          },
          {
            data:'latlong',
            name:'latlong'
          },
          {
              data: null,
              render: function (data, type, row) {
                  var progress = parseInt(data.repair_progress);

                  var progressbtn = '';
                  if (progress === 0 || progress === 50) {
                      progressbtn = '<button type="button" class="btn btn-primary btn-sm update-btn" data-id="' + row.id_deteksi + '">Update</button>';
                  }

                  var cell = '<p>' + data.repair_progress + '%</p>' +
                      '<p>' + progressbtn + '</p>';
                  return cell;
              }
          },
          {
              data: null,
              render: function (data, type, row) {
                  var progress = parseInt(data.repair_progress);
                  var image = '';

                  if (progress === 50 && row.fifty_pct_image_url) {
                      image = '<img src="' + row.fifty_pct_image_url + '" alt="50% Progress Image" style="max-height: 200px;">';
                  } else if (progress === 100 && row.onehud_pct_image_url) {
                      image = '<img src="' + row.onehud_pct_image_url + '" alt="100% Progress Image" style="max-height: 200px;">';
                  }

                  return image;
              }
          }
        ]
      });
    }

    $('#refresh').click(function(){
      $('#from_date').val('');
      $('#to_date').val('');
      $('#area').val('');
      $('#repair_progress').val('');
      fetch_data('', '', 'All', 'All');
    });


    $(document).on('click', '.update-btn', function() {
      var data = $('#table').DataTable().row($(this).closest('tr')).data(); // Get data of the clicked row
      var id_deteksi = data.id_deteksi; // Access the id_deteksi from the row data
      $('#updateId').val(id_deteksi);
      
      // Log activity when update button is clicked
      axios.post('{{ route('log.activity') }}', {
          activity_name: 'History Update Button Clicked',
          id_deteksi: id_deteksi,
          _token: csrfToken
      })
      .then(response => {
          console.log('Activity logged successfully');
      })
      .catch(error => {
          console.error('Error logging activity:', error);
      });
      
      $('#updateModal').modal('show');
    });

    $('#updateForm').on('submit', function(e) {
      e.preventDefault();
      var formData = new FormData($('#updateForm')[0]);
      var id_deteksi = $('#updateId').val();
      
      $.ajax({
        type: 'POST',
        url: '{{ route("history.update") }}',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          // Log activity when update is confirmed
          axios.post('{{ route('log.activity') }}', {
              activity_name: 'History Update Confirmed',
              id_deteksi: id_deteksi,
              _token: csrfToken
          })
          .then(response => {
              console.log('Activity logged successfully');
          })
          .catch(error => {
              console.error('Error logging activity:', error);
          });
          
          $('#updateModal').modal('hide');
          $('#table').DataTable().ajax.reload();
        },
        error: function(xhr, status, error) { // Improved error handling
          var errorMessage = xhr.responseJSON ? xhr.responseJSON.message : 'Error occurred during request';
          console.error('Error:', errorMessage);
          // Display error message to the user or take appropriate action
        }
      });
    });

    // Drag and drop functionality
    var dropArea = document.getElementById('drop-area');
    var fileInput = document.getElementById('image');
    var fileNameDiv = document.getElementById('file-name');
    var previewImage = document.getElementById('preview-image');

    function updateFileNameAndPreview() {
      var file = fileInput.files[0];
      if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
          previewImage.src = e.target.result;
          previewImage.style.display = 'block';
        }
        reader.readAsDataURL(file);
        fileNameDiv.textContent = file.name;
        $('#drop-input').addClass('hidden'); // Hide the drop area
      } else {
        resetFields();
      }
    }

    function resetFields() {
      fileInput.value = ''; // Clear the file input
      previewImage.src = '';
      previewImage.style.display = 'none';
      fileNameDiv.textContent = '';
      $('#drop-input').removeClass('hidden'); // Show the drop area
      $('#updateForm')[0].reset(); // Reset all form fields
    }

    fileInput.addEventListener('change', updateFileNameAndPreview);

    dropArea.addEventListener('dragover', function(event) {
      event.preventDefault();
      dropArea.classList.add('hover');
    });

    dropArea.addEventListener('dragleave', function(event) {
      dropArea.classList.remove('hover');
    });

    dropArea.addEventListener('drop', function(event) {
      event.preventDefault();
      dropArea.classList.remove('hover');
      var files = event.dataTransfer.files;
      fileInput.files = files;
      updateFileNameAndPreview();
    });

    $('.close, .btn-secondary').on('click', function() {
      resetFields();
      $('#updateModal').modal('hide');
    });

    $('#updateModal').on('hidden.bs.modal', function() {
      resetFields();
    });
  
  });
</script>  
@endsection