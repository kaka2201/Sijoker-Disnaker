@extends('layouts.adminapp')

@section('title', 'Edit Pelatihan')

@section('content')
<div class="container">
    <h1>Edit Pelatihan</h1>

    <form action="{{ route('trainings.update', $training->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Judul Pelatihan</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $training->title }}" required>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea class="form-control" id="description" name="description">{{ $training->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="start_date">Tanggal Mulai</label>
            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $training->start_date }}" required>
        </div>

        <div class="form-group">
            <label for="start_time">Waktu Mulai</label>
            <input type="time" class="form-control" id="start_time" name="start_time" value="{{ $training->start_time }}" required>
        </div>

        <div class="form-group">
            <label for="end_date">Tanggal Selesai</label>
            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $training->end_date }}">
        </div>

        <div class="form-group">
            <label for="end_time">Waktu Selesai</label>
            <input type="time" class="form-control" id="end_time" name="end_time" value="{{ $training->end_time }}">
        </div>

        <div class="form-group">
            <label for="capacity">Kapasitas</label>
            <input type="number" class="form-control" id="capacity" name="capacity" value="{{ $training->capacity }}" required>
        </div>

        <div class="form-group">
            <label for="location">Lokasi</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ $training->location }}" required>
        </div>

        <!-- Menampilkan gambar thumbnail yang sudah ada jika ada -->
        @if($training->image)
            <div class="form-group">
                <label>Thumbnail Sekarang:</label>
                <div>
                    <img src="{{ asset('storage/' . $training->image) }}" alt="{{ $training->title }}" width="150">
                </div>
            </div>
        @endif

        <!-- Input untuk upload gambar baru -->
        <div class="form-group">
            <label for="image">Upload Gambar Thumbnail Baru (opsional) Maks : 5Mb</label>
            <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
    </form>
</div>
@endsection
