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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <style>
        body {
            padding-top: 56px;
        }

        @media (min-width: 768px) {
            body {
                padding-top: 72px;
            }
        }

        .navbar-brand {
            margin-right: auto;
        }

        .profile-icon {
            cursor: pointer;
            margin-right: 10px;
        }

        /* Adjusting sidebar */
        .sidebar {
            height: 100%;
            width: 220px;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(rgba(40, 120, 235, 0.9), rgba(40, 120, 235, 0.9));
            padding-top: 56px;
            color: white;
            margin-right: 10px;
        }

        .sidebar a {
            padding: 10px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
            margin-left: 20px;
        }

        .content {
            margin-left: 230px;
            padding: 20px;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                width: 200px;
            }

            .content {
                margin-left: 210px;
            }
        }

        @media (max-width: 767.98px) {
            .sidebar {
                width: 180px;
            }

            .content {
                margin-left: 190px;
            }
        }

        .bg-color {
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-color fixed-top">
        <a class="navbar-brand" href="#" style="margin-left: 40px; font-weight: bold;">DISNAKER</a>
        <hr class="dropdown-divider" style="border-color: white; margin-right: 20px;">
        <form class="d-flex ms-auto" style="margin-right: 50px;">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" style="width: 250px;">
            <button class="btn btn-outline-light" type="submit">Search</button>
        </form>

        <div class="profile-icon" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ asset('assets/admin.ico') }}" alt="Profile Image" style="width: 30px; height: 30px;">
        </div>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="dropdown-item">Logout</button>
            </form>
        </ul>
    </nav>
    
    <!-- Sidebar -->
    <div class="sidebar bg-color">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.participant_management') }}">Manajemen Peserta</a>
        <a href="{{ route('admin.training_management') }}">Manajemen Pelatihan</a>
        <a href="{{ route('admin.account_participants') }}">Manajemen Akun</a>
        <a>Riwayat Pengunduran</a>
    </div>

    <!-- Page Content -->
    <div class="content">
        @yield('content')
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

</body>

</html>
