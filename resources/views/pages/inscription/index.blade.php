<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription</title>

    <!-- Fonts et styles -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(90deg, #240348, #78a7f9);
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
            color: #fff;
        }
    </style>
</head>
<body>

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Créer un compte</h1>
                            </div>

                            <form class="user" action="{{ route('inscription.register') }}" method="POST">
                                @csrf

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" name="prenom" class="form-control form-control-user" placeholder="Prénom" value="{{ old('prenom') }}">
                                        @error('prenom') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="nom" class="form-control form-control-user" placeholder="Nom" value="{{ old('nom') }}">
                                        @error('nom') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="email" name="email" class="form-control form-control-user" placeholder="Email" value="{{ old('email') }}">
                                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="telephone" class="form-control form-control-user" placeholder="Téléphone" value="{{ old('telephone') }}">
                                        @error('telephone') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="date" name="dateNaissance" class="form-control form-control-user" value="{{ old('dateNaissance') }}">
                                        @error('dateNaissance') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="adresse" class="form-control form-control-user" placeholder="Adresse" value="{{ old('adresse') }}">
                                        @error('adresse') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="cni" class="form-control form-control-user" placeholder="Numéro CNI" value="{{ old('cni') }}">
                                    @error('cni') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" name="password" class="form-control form-control-user" placeholder="Mot de passe">
                                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" name="password_confirmation" class="form-control form-control-user" placeholder="Confirmer mot de passe">
                                        @error('password_confirmation') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-custom btn-user btn-block">
                                    S'inscrire
                                </button>
                            </form>

                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{ route('auth.create') }}">Vous avez déjà un compte ? Connectez-vous</a>
                            </div>
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