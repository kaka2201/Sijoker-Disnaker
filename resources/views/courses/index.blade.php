@extends('layouts.appuser')

@section('title', 'Pelatihan Tenaga Kerja - Dinas Tenaga Kerja Kota Batu')

@section('content')
<style>
    .course-card {
        transition: all 0.3s ease;
        overflow: hidden;
    }
    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .course-card img {
        transition: transform 0.3s ease;
    }
    .course-card:hover img {
        transform: scale(1.05);
    }
    .btn-outline-primary {
        border-color: #007bff;
        color: #007bff;
    }
    .btn-outline-primary:hover {
        background-color: #007bff;
        color: white;
    }
    .animate-fade-in {
        opacity: 0;
        animation: fadeIn 0.8s ease-out forwards;
    }
    @keyframes fadeIn {
        to { opacity: 1; }
    }
</style>

<div class="bg-light py-5">
    <div class="container">
        <h1 class="text-center font-weight-bold mb-5 animate-fade-in">Program Pelatihan Tenaga Kerja</h1>
        <div class="row">
            @php
                $courses = [
                    ['title' => 'Digital Marketing', 'image' => 'https://images.pexels.com/photos/265087/pexels-photo-265087.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 'description' => 'Belajar strategi pemasaran digital modern, mulai dari SEO hingga media sosial untuk bisnis online.', 'route' => 'courses.digital'],
                    ['title' => 'Barista', 'image' => 'https://images.pexels.com/photos/373639/pexels-photo-373639.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 'description' => 'Pelajari keterampilan menjadi barista profesional, mulai dari menyeduh kopi hingga espresso.', 'route' => 'courses.barista'],
                    ['title' => 'Membatik', 'image' => 'https://images.pexels.com/photos/10682942/pexels-photo-10682942.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 'description' => 'Pelajari seni membatik tradisional, mulai dari pembuatan pola hingga teknik pewarnaan.', 'route' => 'courses.membatik'],
                    ['title' => 'Barbershop', 'image' => 'https://images.pexels.com/photos/1813272/pexels-photo-1813272.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 'description' => 'Belajar teknik dasar potong rambut hingga perawatan modern di bidang barbershop.', 'route' => 'courses.barbershop'],
                    ['title' => 'Desain Grafis', 'image' => 'https://images.pexels.com/photos/56759/pexels-photo-56759.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 'description' => 'Pelajari keterampilan desain grafis menggunakan software profesional seperti Photoshop dan Illustrator.', 'route' => 'courses.grafis'],
                    ['title' => 'Menjahit', 'image' => 'https://images.pexels.com/photos/3738088/pexels-photo-3738088.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 'description' => 'Pelajari teknik dasar menjahit hingga membuat pakaian dengan desain sendiri.', 'route' => 'courses.menjahit'],
                    ['title' => 'Fotografi', 'image' => 'https://images.pexels.com/photos/450054/pexels-photo-450054.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 'description' => 'Pelajari keterampilan fotografi, dari teknik dasar hingga fotografi komersial.', 'route' => 'courses.fotografi'],
                    ['title' => 'Jaringan Komputer', 'image' => 'https://images.pexels.com/photos/1181675/pexels-photo-1181675.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 'description' => 'Pelajari tentang konfigurasi dan manajemen jaringan komputer untuk berbagai skala.', 'route' => 'courses.jaringan'],
                    ['title' => 'Pembuatan Roti dan Kue', 'image' => 'https://images.pexels.com/photos/8902053/pexels-photo-8902053.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 'description' => 'Pelajari teknik dasar pembuatan roti dan kue untuk usaha atau konsumsi pribadi.', 'route' => 'courses.kue'],
                    ['title' => 'Service Sepeda Motor Injeksi', 'image' => 'https://images.pexels.com/photos/3822784/pexels-photo-3822784.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 'description' => 'Pelajari teknik perbaikan dan perawatan sepeda motor dengan sistem injeksi modern.', 'route' => 'courses.service'],
                ];
            @endphp

            @foreach($courses as $index => $course)
                <div class="col-lg-4 col-md-6 mb-4 animate-fade-in" style="animation-delay: {{ 0.1 * $index }}s;">
                    <div class="card course-card h-100 border-0 shadow-sm">
                        <img src="{{ $course['image'] }}" class="card-img-top" alt="{{ $course['title'] }} Image" style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title font-weight-bold">{{ $course['title'] }}</h5>
                            <p class="card-text flex-grow-1">{{ $course['description'] }}</p>
                            <a href="{{ route($course['route']) }}" class="btn btn-outline-primary mt-auto align-self-start">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                }
            });
        }, {threshold: 0.1});

        document.querySelectorAll('.animate-fade-in').forEach(el => {
            observer.observe(el);
        });
    });
</script>
@endsection