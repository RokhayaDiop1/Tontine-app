<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - KAAY NAAT</title>

    <!-- Fonts et styles -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,400,700" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background: linear-gradient(to right,  #240348, #78a7f9);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-custom {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            border: none;
            transition: all 0.3s ease-in-out;
        }

        .btn-custom:hover {
            color: #f6c23e;
            background: linear-gradient(to right, #2575fc, #6a11cb);
            transform: scale(1.03);
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-6 col-md-8">
                <div class="card shadow-lg border-0 my-5">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h1 class="h4 text-gray-900">Bienvenue sur <strong style="color: #f6c23e;">KAAY NAAT</strong></h1>
                            <p class="text-muted">Connectez-vous à votre compte</p>
                        </div>

                        {{-- Affichage des erreurs --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('auth.store') }}" class="user">
                            @csrf

                            <div class="form-group">
                                <input type="email" name="email" class="form-control form-control-user" placeholder="Adresse email" value="{{ old('email') }}" required autofocus>
                            </div>

                            <div class="form-group">
                                <input type="password" name="password" class="form-control form-control-user" placeholder="Mot de passe" required>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                                    <label class="custom-control-label" for="remember">Se souvenir de moi</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-custom btn-user btn-block">
                                Connexion
                            </button>
                        </form>

                        <hr>

                        <div class="text-center">
                            <a class="small" href="#">Mot de passe oublié ?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="{{ route('inscription.index') }}">Créer un compte !</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Scripts -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

</body>
</html>
