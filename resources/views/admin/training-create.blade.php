@extends('layouts.adminapp')

@section('title', 'Tambah Pelatihan')

@section('content')
<div class="container">
    <h1>Tambah Pelatihan</h1>

    <form action="{{ route('trainings.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="title">Judul Pelatihan</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="start_date">Tanggal Mulai</label>
            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
        </div>

        <div class="form-group">
            <label for="start_time">Waktu Mulai</label>
            <input type="time" class="form-control" id="start_time" name="start_time" value="{{ old('start_time') }}" required>
        </div>

        <div class="form-group">
            <label for="end_date">Tanggal Selesai</label>
            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}">
        </div>

        <div class="form-group">
            <label for="end_time">Waktu Selesai</label>
            <input type="time" class="form-control" id="end_time" name="end_time" value="{{ old('end_time') }}">
        </div>

        <div class="form-group">
            <label for="capacity">Kapasitas</label>
            <input type="number" class="form-control" id="capacity" name="capacity" value="{{ old('capacity') }}" required>
        </div>

        <div class="form-group">
            <label for="location">Lokasi</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}" required>
        </div>

        <!-- Input untuk upload gambar thumbnail -->
        <div class="form-group">
            <label for="image">Upload Gambar Thumbnail Maks : 5Mb</label>
            <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
</div>
@endsection
