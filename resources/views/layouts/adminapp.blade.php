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

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            background-color: #f8f9fa;
            transition: margin-left 0.4s ease-in-out;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: white;
        }

        /* Sidebar */
        .sidebar {
            height: 100vh;
            width: 200px;
            position: fixed;
            top: 0;
            left: 0;
            background: #2a5298;
            color: white;
            padding-top: 60px;
            transition: width 0.4s ease-in-out;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            overflow-x: hidden;
        }

        .sidebar.closed {
            width: 60px;
        }

        .sidebar a {
            padding: 15px 20px;
            font-size: 17px;
            color: white;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: 0.3s;
            text-decoration: none;
            white-space: nowrap;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
            border-left: 4px solid #f0ad4e;
        }

        .sidebar a i {
            font-size: 20px;
            width: 30px;
            text-align: center;
        }

        /* Efek teks sidebar saat ditutup */
        .sidebar span {
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .sidebar.closed span {
            opacity: 0;
            transform: translateX(-20px);
            pointer-events: none;
        }

        /* Efek hover sidebar tertutup */
        .sidebar.closed a:hover {
            background: rgba(255, 255, 255, 0.2);
            border-left: 4px solid #f0ad4e;
        }

        /* Toggle button */
        .toggle-btn {
            font-size: 24px;
            cursor: pointer;
            color: white;
            margin-left: 20px;
        }

        /* Content */
        .content {
            margin-left: 180px;
            padding: 30px;
            transition: margin-left 0.4s ease-in-out;
        }

        .content.shift {
            margin-left: 40px;
        }

        /* Profile dropdown */
        .profile-icon {
            cursor: pointer;
            position: relative;
            display: flex;
            align-items: center;
            margin-right: 15px;
        }

        .profile-icon img {
            width: 35px;
            height: 35px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #013e7e;;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <span class="toggle-btn" onclick="toggleSidebar()"><i class="fas fa-bars"></i></span>
        <a class="navbar-brand mx-3" href="#">DISNAKER</a>
        <form class="d-flex ms-auto me-3">
            <input class="form-control me-2" type="search" placeholder="Cari sesuatu..." aria-label="Search">
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
        <a href="{{ route('admin.training_management') }}"><i class="fas fa-chalkboard-teacher"></i> <span>Pelatihan</span></a>
        <a href="{{ route('admin.account_participants') }}"><i class="fas fa-user-cog"></i> <span>Akun</span></a>
        <a href="#"><i class="fas fa-comments"></i> <span>Pengaduan</span></a>
        <a href="#"><i class="fas fa-history"></i> <span>Pengunduran</span></a>
    </div>

    <!-- Page Content -->
    <div class="content" id="content">
        @yield('content')
    </div>

    <!-- JavaScript -->
    <script>
        function toggleSidebar() {
            let sidebar = document.getElementById("sidebar");
            let content = document.getElementById("content");

            sidebar.classList.toggle("closed");
            content.classList.toggle("shift");
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    @stack('scripts')
</body>
</html>
