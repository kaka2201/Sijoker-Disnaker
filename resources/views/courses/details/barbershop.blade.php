@extends('layouts.appuser')

@section('title', 'Barbershop')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-6">
                <!-- Gambar Utama -->
                <img id="mainImage" src="https://via.placeholder.com/500x400" alt="Barbershop Course Image" class="img-fluid mb-4 shadow-sm rounded">
                
                <!-- List Gambar Thumbnail dengan Scroll -->
                <div class="thumbnail-container d-flex overflow-auto bg-light p-2 rounded" style="max-width: 500px; white-space: nowrap; border: 1px solid #ddd; padding: 10px;">
                    @for($i = 0; $i < 8; $i++)
                        <img src="https://via.placeholder.com/500x400/{{ $i % 2 === 0 ? '000000' : 'ff0000' }}" 
                             onclick="changeImage(this)" 
                             class="img-thumbnail mx-1 rounded shadow-sm" 
                             style="width: 80px; cursor: pointer; transition: transform 0.2s;" 
                             onmouseover="this.style.transform='scale(1.1)'" 
                             onmouseout="this.style.transform='scale(1)'">
                    @endfor
                </div>
            </div>
            <div class="col-md-6">
                <h2 class="text-dark font-weight-bold" style="font-size: 36px;">Barbershop</h2>
                <p class="lead">Belajar teknik dasar potong rambut hingga perawatan modern di bidang barbershop.</p>
                
                <h4 class="mt-4">Apa yang Akan Dipelajari</h4>
                <ul class="list-unstyled ml-3">
                    <li><i class="fas fa-check-circle text-success"></i> Teknik dasar potong rambut</li>
                    <li><i class="fas fa-check-circle text-success"></i> Penggunaan alat cukur profesional</li>
                    <li><i class="fas fa-check-circle text-success"></i> Perawatan rambut dan kulit kepala</li>
                    <li><i class="fas fa-check-circle text-success"></i> Teknik styling rambut pria</li>
                    <li><i class="fas fa-check-circle text-success"></i> Kebersihan dan sanitasi peralatan cukur</li>
                </ul>

                <h4 class="mt-4">Syarat Pendaftaran</h4>
                <ul class="list-unstyled ml-3">
                    <li><i class="fas fa-file-alt text-secondary"></i> KTP (2 Lembar)</li>
                    <li><i class="fas fa-file-alt text-secondary"></i> KK (2 Lembar)</li>
                    <li><i class="fas fa-file-alt text-secondary"></i> Ijasah Terakhir (2 Lembar)</li>
                    <li><i class="fas fa-file-alt text-secondary"></i> Kartu AK1 (2 Lembar)</li>
                    <li><i class="fas fa-image text-secondary"></i> Pas foto ukuran 4x6 (2 Lembar)</li>
                </ul>
                
                <h4 class="mt-4">Syarat Pelatihan</h4>
                <ul class="list-unstyled ml-3">
                    <li><i class="fas fa-id-card text-secondary"></i> Warga Kota Batu/ber KTP Batu</li>
                    <li><i class="fas fa-graduation-cap text-secondary"></i> Pendidikan Formal Lulus SMA/SMK/Sederajat, S1</li>
                    <li><i class="fas fa-calendar-alt text-secondary"></i> Usia 17 s/d 40</li>
                    <li><i class="fas fa-times-circle text-secondary"></i> Tidak Sedang Menempuh Sekolah atau Kuliah</li>
                    <li><i class="fas fa-briefcase text-secondary"></i> Terdaftar Sebagai Pencari Kerja/Pemilik AK1</li>
                </ul>
                
                <a href="{{ url('/#pelatihan-tersedia') }}" class="btn btn-success mt-4 px-4 py-2 shadow-sm" style="font-size: 18px;">
                    <i class="fas fa-clipboard-list"></i> Daftar Pelatihan
                </a>
                <a href="{{ route('courses.index') }}" class="btn btn-primary mt-4 px-4 py-2 shadow-sm" style="font-size: 18px;">
                    <i class="fas fa-arrow-left"></i> Kembali ke Courses
                </a>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk mengganti gambar utama dengan gambar yang diklik
        function changeImage(element) {
            document.getElementById('mainImage').src = element.src;
            // Tambahkan efek fade pada gambar utama
            document.getElementById('mainImage').classList.add('fade');
            setTimeout(() => {
                document.getElementById('mainImage').classList.remove('fade');
            }, 300); // Durasi efek fade
        }
    </script>

    <style>
        /* Efek fade untuk gambar utama */
        .fade {
            opacity: 0.5;
            transition: opacity 0.3s ease-in-out;
        }
    </style>
@endsection
