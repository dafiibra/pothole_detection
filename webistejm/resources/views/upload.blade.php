@extends('layouts.upload_page')

@section('title', 'Upload Pothole Report')

@section('content')

<form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="image" class="form-label">Input Gambar</label>
        <input class="form-control" type="file" id="image" name="image">
    </div>
    
    <div class="row text-left">
        <div class="col-md-6 mb-3">
            <label for="tanggal" class="form-label fw-bold">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" required />
        </div>
        
        <div class="col-md-6 mb-3">
            <label for="area" class="form-label fw-bold">Area</label>
            <select name="area" id="area" class="form-select" required>
                <option value="" disabled selected>Choose</option>
                <option value="All">All</option>
                @foreach($areas as $area)
                    <option value="{{ $area }}">{{ $area }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="mb-3">
        <label for="coordinate" class="form-label fw-bold">Coordinate</label>
        <input type="text" class="form-control" id="coordinate" name="coordinate" required>
    </div>

    <button class="btn btn-primary">Upload Report</button>
</form>

@endsection