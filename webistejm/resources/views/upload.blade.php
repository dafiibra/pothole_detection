@extends('layouts.upload_page')

@section('title', 'Upload Pothole Report')

@section('content')
    
    <div class="mb-3">
        <label for="formFileMultiple" class="form-label">Input Gambar</label>
        <input class="form-control" type="file" id="formFileMultiple" multiple>
      </div>
    <div class="row g-2 pb-3">
        <div class="col-md">
            <div class="form-floating">
                <input type="email" class="form-control" id="floatingInputGrid" placeholder="name@example.com"
                    value="">
                <label for="floatingInputGrid">Longitude</label>
            </div>
        </div>
        <div class="col-md">
            <div class="col-md">
                <div class="form-floating">
                    <input type="email" class="form-control" id="floatingInputGrid" placeholder="name@example.com"
                        value="">
                    <label for="floatingInputGrid">Latitude</label>
                </div>
            </div>
        </div>
    </div>
    <div class="form-floating">
        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
        <label for="floatingTextarea">Comment</label>
    </div>
    <div class="mybtns">
        <button type="button" class="btn btn-primary">Save</button>
        <button onclick="close_box()" type="button" class="btn btn-outline-dark">Close</button>
    </div>
</div>
  
@endsection