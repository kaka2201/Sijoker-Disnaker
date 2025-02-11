@extends('layouts.adminapp')

@section('title', 'Manajemen Pelatihan')

@section('content')
<div class="container-fluid mx-4 my-5">
    <h1 class="mb-4 text-center">Manajemen Pelatihan</h1>

    <!-- Tombol untuk menambah pelatihan baru -->
    <div class="text-end mb-3">
        <a href="{{ route('trainings.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Tambah Pelatihan
        </a>
    </div>

    <!-- Jika ada pesan sukses -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @forelse($trainings as $training)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100 border-0">
                    <!-- Gambar dari database atau placeholder -->
                    <img src="{{ $training->image ? asset('storage/' . $training->image) : asset('images/training-default.jpg') }}" 
                         class="card-img-top rounded-top" 
                         alt="{{ $training->title }}" 
                         style="height: 200px; object-fit: cover;">

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-primary">{{ $training->title }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($training->description, 100) }}</p>
                        <p class="card-text">
                            <small><i class="fa fa-calendar"></i> {{ \Carbon\Carbon::parse($training->start_date)->format('d-m-Y H:i') }}</small><br>
                            @if ($training->end_date)
                                <small><i class="fa fa-calendar-check"></i> {{ \Carbon\Carbon::parse($training->end_date)->format('d-m-Y H:i') }}</small><br>
                            @endif
                            <small><i class="fa fa-users"></i> Kapasitas: {{ $training->capacity }} peserta</small><br>
                            <small><i class="fa fa-map-marker-alt"></i> {{ $training->location }}</small>
                        </p>

                        <div class="mt-auto">
                            <a href="{{ route('trainings.edit', $training->id) }}" class="btn text-white btn-warning btn-sm me-1">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('trainings.participants', $training->id) }}" class="btn text-white btn-info btn-sm me-1">
                                <i class="fa fa-users"></i> Peserta
                            </a>
                            <form action="{{ route('trainings.destroy', $training->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pelatihan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center text-muted mb-4">
                <h5>Tidak ada Data Trainings<h5>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $trainings->links() }}
    </div>
</div>
@endsection
