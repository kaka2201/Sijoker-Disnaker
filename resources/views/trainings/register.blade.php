@extends('layouts.appuser')

@section('title', 'Pendaftaran Pelatihan')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Pendaftaran Pelatihan: {{ $training->title }}</h2>

    <!-- Form Pendaftaran -->
    <form id="registrationForm" method="POST" action="{{ route('trainings.process', $training->id) }}">
        @csrf
        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->profile->name }}" readonly>
        </div>
        <div class="form-group">
            <label for="nik">NIK</label>
            <input type="text" class="form-control" id="nik" name="nik" value="{{ $user->profile->nik }}" readonly>
        </div>
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $user->profile->jalan }}, {{ $user->profile->desa }}, {{ $user->profile->kecamatan }}" readonly>
        </div>
        <div class="form-group">
            <label for="nomor">No Telpon</label>
            <input type="text" class="form-control" id="nomor" name="nomor" value="{{ $user->profile->nomor }}" readonly>
        </div>

        <!-- Tombol Konfirmasi -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmModal">Konfirmasi Pendaftaran</button>

        <!-- Pop-up Konfirmasi -->
        <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Data Pendaftaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Nama: {{ $user->profile->name }}</p>
                        <p>NIK: {{ $user->profile->nik }}</p>
                        <p>Alamat: {{ $user->profile->jalan }}, {{ $user->profile->desa }}, {{ $user->profile->kecamatan }}</p>
                        <p>Nomor Telepon: {{ $user->profile->nomor }}</p>
                        <p>Pelatihan: {{ $training->title }}</p>
                        <p>Lokasi: {{ $training->location }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
