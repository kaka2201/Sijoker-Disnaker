@extends('layouts.appuser')

@section('title', 'Ganti Kata Sandi')

@section('content')
<div class="container-fluid py-5 bg-light">
    <div class="row justify-content-center">
        <!-- Sidebar -->
        @include('profile.menu')

        <!-- Content Area -->
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title mb-4">Ubah Kata Sandi</h4>
                    <p>Silakan ubah kata sandi dengan yang baru</p>

                    <!-- Form untuk mengubah kata sandi -->
                    <form action="{{ route('profile.update-password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Pesan Error -->
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Pesan Sukses -->
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="mb-3">
                            <label for="current-password" class="form-label">Kata sandi sekarang</label>
                            <input type="password" class="form-control" id="current-password" name="current_password" placeholder="Kata sandi sekarang" required>
                        </div>
                        <div class="mb-3">
                            <label for="new-password" class="form-label">Kata sandi baru</label>
                            <input type="password" class="form-control" id="new-password" name="new_password" placeholder="Kata sandi baru" required>
                            <div class="form-text">Minimal 8 karakter dan mengandung kombinasi huruf kecil, huruf besar, dan angka</div>
                        </div>
                        <div class="mb-3">
                            <label for="confirm-password" class="form-label">Ketik ulang kata sandi baru</label>
                            <input type="password" class="form-control" id="confirm-password" name="new_password_confirmation" placeholder="Ketik ulang kata sandi baru" required>
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
