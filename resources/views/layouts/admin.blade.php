<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - KAAY NAAT</title>

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    
    <!-- Dans layouts.admin.blade.php ou layout principal -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <style>
        .custom-sidebar {
            background: linear-gradient(135deg, #240348, #78a7f9);
            color: white;
            font-size: 25px;
            font-weight: bold;
        }
    </style>
    


    
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper" >

        {{-- Sidebar --}}
        <ul class="navbar-nav custom-sidebar sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Branding -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}" >
                <div class="sidebar-brand-icon">
                    <i class="fas fa-crown"> </i>
                </div>
                <div style="display: flex">  Super Admin</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Tableau de Bord</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Gestion Utilisateurs -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.gestionnaires') }}">
                    <i class="fas fa-user-shield"></i>
                    <span>Gestionnaires</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.membres') }}">
                    <i class="fas fa-user"></i>
                    <span>Membres</span>
                </a>
            </li>
            

            <!-- Gestion tontines -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.creer-tontine') }}">
                    <i class="fas fa-plus-circle"></i>
                    <span>Créer une tontine</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.liste-tontines') }}">
                    <i class="fas fa-list"></i>
                    <span>Liste des tontines</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.statistiques') }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Statistiques</span>
                </a>
            </li>
            
            

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

           <!-- Déconnexion SweetAlert -->
            
            <li class="nav-item">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                <button type="button" class="btn btn-danger m-3" onclick="confirmLogout()" style="background: linear-gradient(to right, #fd7e14, #f6c23e">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </button>
            </li>



        </ul>
        <!-- Fin Sidebar -->

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
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                
                                <!-- Affichage de l'image de profil, ou une image par défaut -->
                                <img  src="{{ asset('images/admin.png') }}" alt="Photo de profil" style="width: 40px; height: 40px; border: 1px solid #240348;" class="rounded-circle shadow">
                                

                                <!-- Affichage du prénom de l'utilisateur -->
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small" style="font-weight: bold;; font-size:18px">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</span>
                            
                                
                            </a>
                            <!-- Dropdown content (vous pouvez l'ajouter si nécessaire) -->
                        </li>
                    </ul>
                    
                </nav>

                <!-- Début du contenu de la page -->
                <div class="container-fluid">
                    @yield('contenu')
                </div>

            </div>
            <!-- Fin Main Content -->

        </div>
        <!-- Fin Content Wrapper -->

    </div>
    <!-- Fin Page Wrapper -->

    

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

    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript -->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- SB Admin 2 -->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    @stack('scripts')
</body>

</html>
