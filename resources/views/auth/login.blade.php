<!doctype html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- manifest meta -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="manifest" href="manifest.json" />
    <!-- Favicons -->
    <link rel="apple-touch-icon" href="{{ asset('assets/img/favicon180.png') }}" sizes="180x180">
    <link rel="icon" href="{{ asset('assets/img/favicon32.png') }}" sizes="32x32" type="image/png">
    <link rel="icon" href="{{ asset('assets/img/favicon16.png') }}" sizes="16x16" type="image/png">
    <!-- Google fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <!-- style css for this template -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" id="style">
</head>
<body class="body-scroll d-flex flex-column h-100" data-page="signin">
    <!-- loader section -->
    <div class="container-fluid loader-wrap">
        <div class="row h-100">
            <div class="col-10 col-md-6 col-lg-5 col-xl-3 mx-auto text-center align-self-center">
                <div class="loader-cube-wrap loader-cube-animate mx-auto">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
                </div>
                <h2 class="mt-4"><strong>Please wait...</strong></h2>
            </div>
        </div>
    </div>
    <!-- loader section ends -->
    <!-- Begin page content -->
    <main class="container-fluid h-100">
        <div class="row h-100 overflow-auto">
            <div class="col-12 text-center mb-auto px-0">
                <header class="header">
                    <div class="row">
                        <div class="col-auto"></div>
                        <div class="col">
                            <div class="logo-small">
                                <img src="{{ asset(config('app.logo', 'assets/img/logo.png')) }}" alt="">
                                <h5>{{ config('app.title', 'SIAPLAKU') }}</h5>
                            </div>
                        </div>
                        <div class="col-auto"></div>
                    </div>
                </header>
            </div>
            <div class="col-10 col-md-6 col-lg-5 col-xl-3 mx-auto align-self-center text-center py-4">
                <h1 class="mb-4 text-color-theme">Sign in</h1>
                @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block"> 
                    <strong>{{ $message }}</strong>
                </div>
                @endif
                <form class="was-validated needs-validation" novalidate method="POST" action="{{ route('login.admin') }}" aria-label="{{ __('Login') }}">
                    @csrf
                    <div class="form-group form-floating mb-3 is-valid @error('password') is-invalid @enderror">
                        <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                        <label class="form-control-label" for="username">Username</label>
                        @error('username')
                            <button type="button" class="text-danger tooltip-btn" data-bs-toggle="tooltip"
                                data-bs-placement="left" title="{{ $message }}" id="passworderror">
                                <i class="bi bi-info-circle"></i>
                            </button>
                        @enderror
                    </div>
                    <div class="form-group form-floating is-valid @error('password') is-invalid @enderror mb-3">
                        <input type="password" class="form-control " name="password"   id="password" placeholder="Password">
                        <label class="form-control-label" for="password">Password</label>
                        @error('password')
                            <button type="button" class="text-danger tooltip-btn" data-bs-toggle="tooltip"
                                data-bs-placement="left" title="{{ $message }}" id="passworderror">
                                <i class="bi bi-info-circle"></i>
                            </button>
                        @enderror
                        
                    </div>
                    {{-- <p class="mb-3 text-center">
                        <div class="row">
                            <div class="col-auto pr-0 align-self-center text-end">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="remember_me">
                                    <label class="form-check-label" for="remember_me">Remember Me</label>
                                </div>
                            </div>
                        </div> --}}
                        {{-- <ul class="list-group list-group-flush bg-none">
                            <li class="list-group-item">
                                
                            </li>
                        </ul> --}}
                        {{-- <a href="forgot-password.html" class="">
                            Forgot your password?
                        </a> --}}
                    {{-- </p> --}}
                    <button type="submit" class="btn btn-lg btn-default w-100 mb-4 shadow">Sign in</button>
                </form>
               
            </div>
            <!-- <div class="col-12 text-center mt-auto">
                <div class="row justify-content-center footer-info">
                    <div class="col-auto">
                        <p class="text-muted">Or you can continue with </p>
                    </div>
                    <div class="col-auto ps-0">
                        <a href="#" class="p-1"><i class="bi bi-twitter"></i></a>
                        <a href="{{ url('login/google') }}" class="p-1"><i class="bi bi-google"></i></a>
                        <a href="#" class="p-1"><i class="bi bi-facebook"></i></a>
                    </div>
                </div>
            </div> -->
        </div>
    </main>
    <!-- Required jquery and libraries -->
    <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-5/js/bootstrap.bundle.min.js') }}"></script>
    <!-- cookie js -->
    <script src="{{ asset('assets/js/jquery.cookie.js') }}"></script>
    <!-- Customized jquery file  -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/color-scheme.js') }}"></script>
    <!-- PWA app service registration and works -->
    <script src="{{ asset('assets/js/pwa-services.js') }}"></script>
    <!-- page level custom script -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>