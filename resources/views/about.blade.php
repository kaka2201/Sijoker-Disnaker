@extends('layouts.appuser')

@section('title', 'Dinas Tenaga Kerja Kota Batu - Pelatihan Tenaga Kerja')

@section('content')
    <!-- Header Start -->
    <div class="bg-gradient-primary py-5" style="background: linear-gradient(135deg, #1a73e8, #4285f4);">
        <div class="container text-center py-5">
            <h1 class="text-white font-weight-bold mb-3 animate__animated animate__fadeInDown">Pelatihan Tenaga Kerja</h1>
            <h1 class="text-white mb-3 animate__animated animate__fadeInUp">Tentang Dinas Tenaga Kerja Kota Batu</h1>
            <p class="text-white-50 animate__animated animate__fadeInUp">Meningkatkan keterampilan dan daya saing tenaga kerja lokal melalui pelatihan berkualitas</p>
        </div>
    </div>
    <!-- Header End -->

    <!-- About Start -->
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img class="img-fluid rounded shadow-lg" src="{{ asset('image/logo.jpeg') }}" alt="Logo Disnaker" style="border-radius: 20px;">
            </div>
            <div class="col-lg-6">
                <h2 class="font-weight-bold mb-4" style="font-family: 'Poppins', sans-serif;">Tentang Kami</h2>
                <p class="text-muted">
                    Dinas Tenaga Kerja Kota Batu berkomitmen untuk meningkatkan kualitas dan keterampilan tenaga kerja melalui program pelatihan gratis yang inovatif. Kami membantu menciptakan tenaga kerja yang siap bersaing di tingkat nasional dan internasional, menjembatani kesenjangan antara pendidikan dan dunia kerja.
                </p>
                <p class="text-muted">
                    Melalui kolaborasi dengan berbagai mitra industri, kami memastikan program pelatihan kami selalu sesuai dengan kebutuhan pasar kerja yang dinamis.
                </p>
                <div class="row mt-4">
                    <div class="col-md-4 mb-3 text-center">
                        <h4 class="font-weight-bold text-primary display-4">10</h4>
                        <p class="text-muted">Program Pelatihan</p>
                    </div>
                    <div class="col-md-4 mb-3 text-center">
                        <h4 class="font-weight-bold text-primary display-4">15+</h4>
                        <p class="text-muted">Instruktur Ahli</p>
                    </div>
                    <div class="col-md-4 mb-3 text-center">
                        <h4 class="font-weight-bold text-primary display-4">500+</h4>
                        <p class="text-muted">Peserta Terlatih</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Visi dan Misi Start -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4">
                    <i class="fas fa-bullseye text-primary fa-3x mb-3"></i>
                    <h3 class="font-weight-bold" style="font-family: 'Poppins', sans-serif;">Visi</h3>
                    <p class="text-muted">
                        Menjadi lembaga pelatihan kerja terbaik yang berkontribusi dalam menciptakan tenaga kerja berkualitas, produktif, dan siap bersaing di tingkat nasional dan global.
                    </p>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4">
                    <i class="fas fa-lightbulb text-primary fa-3x mb-3"></i>
                    <h3 class="font-weight-bold" style="font-family: 'Poppins', sans-serif;">Misi</h3>
                    <ul class="text-muted text-left pl-4">
                        <li>Menyediakan pelatihan berkualitas yang sesuai dengan kebutuhan industri.</li>
                        <li>Meningkatkan keterampilan dan kompetensi tenaga kerja melalui pendidikan vokasional.</li>
                        <li>Membuka akses pelatihan kepada masyarakat tanpa diskriminasi.</li>
                        <li>Mendorong kemitraan dengan berbagai sektor untuk menciptakan lapangan pekerjaan.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Visi dan Misi End -->

    <!-- Features Start -->
    <div class="bg-light py-5">
        <div class="container py-5">
            <h2 class="text-center font-weight-bold mb-5" style="font-family: 'Poppins', sans-serif;">Mengapa Memilih Program Kami</h2>
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm h-100 hover-zoom">
                        <div class="card-body text-center">
                            <i class="fas fa-graduation-cap fa-3x text-primary mb-3"></i>
                            <h4 class="font-weight-bold mb-3">Instruktur Berpengalaman</h4>
                            <p class="text-muted">Pelatihan dipandu oleh instruktur ahli dengan pengalaman industri yang relevan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm h-100 hover-zoom">
                        <div class="card-body text-center">
                            <i class="fas fa-certificate fa-3x text-primary mb-3"></i>
                            <h4 class="font-weight-bold mb-3">Sertifikasi Resmi</h4>
                            <p class="text-muted">Dapatkan sertifikat resmi yang diakui industri setelah menyelesaikan pelatihan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm h-100 hover-zoom">
                        <div class="card-body text-center">
                            <i class="fas fa-briefcase fa-3x text-primary mb-3"></i>
                            <h4 class="font-weight-bold mb-3">Peluang Karir</h4>
                            <p class="text-muted">Akses ke jaringan mitra industri untuk meningkatkan peluang kerja Anda.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Features End -->
@endsection
