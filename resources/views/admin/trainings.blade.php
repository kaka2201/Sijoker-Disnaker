@extends('layouts.adminapp')

@section('title', 'Manajemen Pelatihan')

@section('content')
<div class="container">
    <h1>Manajemen Pelatihan</h1>

    <!-- Tombol untuk menambah pelatihan baru -->
    <a href="{{ route('trainings.create') }}" class="btn btn-primary mb-3">Tambah Pelatihan</a>

    <!-- Jika ada pesan sukses -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @foreach($trainings as $training)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <!-- Gambar dari database, gunakan placeholder jika tidak ada gambar -->
                    @if($training->image)
                        <!-- Pastikan menggunakan path storage yang benar -->
                        <img src="{{ asset('storage/' . $training->image) }}" class="card-img-top" alt="{{ $training->title }}" style="height: 200px; object-fit: cover;">
                    @else
                        <img src="{{ asset('images/training-default.jpg') }}" class="card-img-top" alt="{{ $training->title }}" style="height: 200px; object-fit: cover;">
                    @endif

                    <div class="card-body">
                        <!-- Judul pelatihan -->
                        <h5 class="card-title">{{ $training->title }}</h5>

                        <!-- Deskripsi pelatihan dengan batas karakter -->
                        <p class="card-text">{{ Str::limit($training->description, 100) }}</p>

                        <!-- Informasi tambahan -->
                        <p class="card-text">
                            <strong>Tanggal Mulai: </strong>{{ \Carbon\Carbon::parse($training->start_date)->format('d-m-Y') }} {{ \Carbon\Carbon::parse($training->start_time)->format('H:i') }}<br>
                            @if ($training->end_date)
                                <strong>Tanggal Selesai: </strong>{{ \Carbon\Carbon::parse($training->end_date)->format('d-m-Y') }} {{ \Carbon\Carbon::parse($training->end_time)->format('H:i') }}<br>
                            @endif
                            <strong>Kapasitas: </strong>{{ $training->capacity }} peserta<br>
                            <strong>Lokasi: </strong>{{ $training->location }}
                        </p>

                        <!-- Tombol Edit yang mengarah ke halaman edit terpisah -->
                        <a href="{{ route('trainings.edit', $training->id) }}" class="btn btn-warning btn-sm">
                            Edit Pelatihan
                        </a>

                        <!-- Tombol Lihat Peserta yang mengarah ke halaman peserta pelatihan -->
                        <a href="{{ route('trainings.participants', $training->id) }}" class="btn btn-info btn-sm">
                            Lihat Peserta
                        </a>

                        <!-- Tombol Hapus -->
                        <form action="{{ route('trainings.destroy', $training->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelatihan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                Hapus Pelatihan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination untuk menampilkan lebih dari 9 pelatihan -->
    <div class="d-flex justify-content-center mt-4">
        {{ $trainings->links() }}
    </div>
</div>
@endsection
