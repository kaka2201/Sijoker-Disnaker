@extends('layouts.appuser')

@section('title', 'Preview Profil')

@section('content')
    <div class="container py-5">
        <h2 class="text-center font-weight-bold mb-4">Review Data Profil Sebelum Daftar</h2>

        <!-- Menampilkan pesan sukses/error -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" value="{{ $profile->name }}" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" class="form-control" value="{{ $profile->nik }}" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="ttl" class="form-label">Tanggal Lahir</label>
                        <input type="text" class="form-control" value="{{ $profile->ttl }}" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="gender" class="form-label">Jenis Kelamin</label>
                        <input type="text" class="form-control" value="{{ $profile->gender }}" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="jalan" class="form-label">Jalan, RT/RW</label>
                        <input type="text" class="form-control" value="{{ $profile->jalan }}" readonly>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="desa" class="form-label">Desa/Kelurahan</label>
                        <input type="text" class="form-control" value="{{ $profile->desa }}" readonly>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="kecamatan" class="form-label">Kecamatan</label>
                        <input type="text" class="form-control" value="{{ $profile->kecamatan }}" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="pendidikan" class="form-label">Pendidikan Terakhir</label>
                        <input type="text" class="form-control" value="{{ $profile->pendidikan }}" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nomor" class="form-label">No Telpon</label>
                        <input type="text" class="form-control" value="{{ $profile->nomor }}" readonly>
                    </div>
                </div>

                <!-- Menampilkan informasi pelatihan -->
                <h4 class="font-weight-bold">Pelatihan yang Dipilih: {{ $training->title }}</h4>
                <p>Lokasi: {{ $training->location }}</p>
                <p>Waktu Mulai: {{ \Carbon\Carbon::parse($training->start_date)->format('d M Y') }} Pukul : {{ $training->start_time }}</p>

                <!-- Form dan tombol -->
                <div class="d-flex justify-content-between mt-4">
                    <!-- Text "Data Belum Sesuai?" -->
                    <div class="d-flex flex-column align-items-start">
                        <p>Data Belum Sesuai?</p>
                        <!-- Tombol Edit Profile -->
                        <a href="{{ route('profile') }}" class="btn btn-warning">Edit Profil</a>
                    </div>
                    
                    <!-- Tombol Konfirmasi Daftar -->
                    <form action="{{ route('course.register') }}" method="POST" class="align-self-end">
                        @csrf
                        <input type="hidden" name="training_id" value="{{ $training->id }}">
                        <button type="submit" class="btn btn-success">Konfirmasi Daftar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
