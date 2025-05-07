<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participant - @yield('title', 'Tableau de Bord')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    


    <!-- Styles personnalisés -->
    <style>
        body {
            background-color: #eaf0ff !important;
        }

        .navbar {
            background: linear-gradient(90deg, #240348, #78a7f9); /* dégradé violet-bleu */
        }

        .navbar-brand, .nav-link, .dropdown-item {
            color: #fff !important;
        }
        .navbar-brand{
            font-size: 45px
        }

        .nav-link:hover, .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .card {
            border: none;
            border-radius: 1rem;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">KAAY NAAT</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon text-white"></span>
            </button>
            

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto">
                    {{-- <li class="nav-item"><a class="nav-link" href="{{ route('participant.dashboard') }}">Accueil</a></li> --}}
                    <li class="nav-item"><a class="nav-link" href="#section-mes-tontines">Mes tontines</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('participant.cotisations') }}">Cotisations</a></li>
                    {{-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="profilDropdown" role="button" data-bs-toggle="dropdown"> Profil </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('participant.profil') }}">Mon profil</a>Mon profil</li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}">Se déconnecter</a>Se déconnecter</li>
                        </ul>
                    </li> --}}
                    
                </ul>
                
               
            </div>
            
        </div>
        <!-- Bouton de déconnexion en dehors du menu de navigation -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<button type="button" class="btn btn-danger m-3" onclick="confirmLogout()" style="background: linear-gradient(to right, #fd7e14, #f6c23e)">
    <i class="fas fa-sign-out-alt"></i> Déconnexion
</button>

    </nav>

    <!-- Contenu -->
    <main class="py-4 container">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-center py-4 text-muted">
        &copy; {{ date('Y') }} Ma Tontine. Tous droits réservés.
    </footer>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
</body>
</html>
