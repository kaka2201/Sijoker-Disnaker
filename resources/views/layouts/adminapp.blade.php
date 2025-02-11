<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Admin Panel') ~ Platform Pelatihan Kerja</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="icon" href="{{ asset('assets/admin.ico') }}" type="image/x-icon"/>
    <link rel="shortcut icon" href="{{ asset('assets/admin.ico') }}" type="image/x-icon"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <span class="toggle-btn" onclick="toggleSidebar()"><i class="fas fa-bars"></i></span>
        <a class="navbar-brand mx-3" href="#">DISNAKER</a>
        @php
            $action = match($currentPage ?? '') {
                'peserta' => route('admin.participant_management'),
                'dokumen' => route('admin.documents.index'),
                'pelatihan' => route('admin.training_management'),
                'akun' => route('admin.account_participants'),
                'pengaduan' => route('admin.complaints'),
                default => '#',
            };
        @endphp
        <form action="{{ $action }}" method="GET" class="d-flex ms-auto me-3">
            <input class="form-control me-2" name="search" type="search" placeholder="Cari sesuatu..." aria-label="Search" value="{{ request('search') }}">
            <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i></button>
        </form>

        <div class="profile-icon dropdown">
            <img src="{{ Auth::user()->profile && Auth::user()->profile->foto ? asset('storage/' . Auth::user()->profile->foto) : asset('image/default_profile.jpg') }}" alt="Profile Image" class="dropdown-toggle" data-bs-toggle="dropdown">
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#"><i class="fas fa-user"></i> Profil</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Pengaturan</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </ul>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> <span>Dashboard</span></a>
        <a href="{{ route('admin.participant_management') }}"><i class="fas fa-users"></i> <span>Peserta</span></a>
        <a href="{{ route('admin.documents.index') }}"><i class="fas fa-file-text"></i> <span>Dokumen</span></a>
        <a href="{{ route('admin.training_management') }}"><i class="fas fa-chalkboard-teacher"></i> <span>Pelatihan</span></a>
        <a href="{{ route('admin.account_participants') }}"><i class="fas fa-user-cog"></i> <span>Akun</span></a>

        <!-- Dropdown Pengaduan -->
        <div class="dropdown">
            <a href="#" class="dropdown-toggle complaint-menu">
                <i class="fas fa-comments"></i> <span>Pengaduan</span> <i class="fas fa-chevron-down dropdown-icon"></i>
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('admin.complaints') }}"><i class="fas fa-list"></i> Semua</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.complaints', ['status' => 'pending']) }}"><i class="fas fa-hourglass-half"></i> Belum Dijawab</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.complaints', ['status' => 'answered']) }}"><i class="fas fa-check-circle"></i> Terjawab</a></li>
            </ul>
        </div>

        <a href="#" class="pengunduran"><i class="fas fa-history"></i> <span>Pengunduran</span></a>
    </div>

    <!-- Page Content -->
    <div class="content" id="content">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
    @stack('scripts')
</body>
</html>
