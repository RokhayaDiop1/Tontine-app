<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérant - KAAY NAAT</title>

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .custom-sidebar {
            background: linear-gradient(135deg, #002b5b, #4d91ff);
            color: white;
            font-size: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body id="page-top">

<div id="wrapper">
    {{-- Sidebar --}}
    <ul class="navbar-nav custom-sidebar sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Branding -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('gerant.dashboard') }}">
            <div class="sidebar-brand-icon">
                <i class="fas fa-user-tie"></i>
            </div>
            <div style="display: flex"> Gérant </div>
        </a>

        <hr class="sidebar-divider my-0">

        <!-- Tableau de bord -->
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('gerant.dashboard') }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Tableau de Bord</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <!-- Mes tontines -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('gerant.tontines') }}">
                <i class="fas fa-box"></i>
                <span>Mes Tontines</span>
            </a>
        </li>

        <!-- Participants -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('gerant.participants') }}">
                <i class="fas fa-users"></i>
                <span>Participants</span>
            </a>
        </li>

        <!-- Cotisations -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('gerant.cotisations') }}">
                <i class="fas fa-money-bill-wave"></i>
                <span>Cotisations</span>
            </a>
        </li>

        <!-- Tirage -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('gerant.tirage') }}">
                <i class="fas fa-random"></i>
                <span>Tirage au sort</span>
            </a>
        </li>

        <hr class="sidebar-divider d-none d-md-block">

        <!-- Déconnexion -->
        <li class="nav-item">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <button type="button" class="btn btn-danger m-3" onclick="confirmLogout()" style="background: linear-gradient(to right, #fd7e14, #f6c23e)">
                <i class="fas fa-sign-out-alt"></i> Déconnexion
            </button>
        </li>
    </ul>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">

            {{-- Navbar --}}
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Navbar droite -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown">
                            <img src="{{ asset('images/admin.png') }}" alt="Photo" style="width: 40px; height: 40px;" class="rounded-circle shadow">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small" style="font-weight: bold; font-size:18px">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</span>
                        </a>
                    </li>
                </ul>
            </nav>

        <!-- Contenu principal -->
        <div class="container-fluid">
            @yield('content')
        </div>

        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Déconnexion',
            text: "Voulez-vous vraiment vous déconnecter ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Oui, me déconnecter',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>

<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

</body>
</html>
