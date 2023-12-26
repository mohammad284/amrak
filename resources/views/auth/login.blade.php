<!DOCTYPE html>

<html class="loading" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Apex admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Apex admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title> login </title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('app-assets\img\ico\favicon.ico')}}">
    <link rel="shortcut icon" type="image/png" href="{{asset('app-assets\img\ico\favicon-32.png')}}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
          rel="stylesheet">

    <link rel="icon" type="image/png" href="{{asset('/img/amrak_tm.png')}}" />
    <!-- Custom styles for this template -->
    <link href="{{asset('css/sb-admin-2.min.css')}}" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

</head>

<body class="vertical-layout vertical-menu 1-column auth-page navbar-sticky blank-page" data-menu="vertical-menu" data-col="1-column">

<div class="wrapper">
    <div class="main-panel">

        <div class="main-content">
            <div class="content-overlay"></div>
            <div class="content-wrapper">
                <section id="login" class="auth-height">
                    <div class="row full-height-vh m-0" style="margin-top: 5px;">
                        <div class="col-12 d-flex align-items-center justify-content-center">
                            <div class="card overflow-hidden">
                                <div class="card-content" style="margin-top:25px; ">
                                    <div class="card-body auth-img">
                                        <div class="row m-auto pe-auto">
                                            <div class="col-lg-12 d-none d-lg-flex justify-content-center align-items-center auth-img-bg p-3">
                                                <img src="{{asset('/img/log.png')}}" alt="" style="align-content: center;" class="img-fluid" width="250" height="400">
                                            </div>
                                        <div class="container">
                                            <div class="row justify-content-center">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">{{ __('Login') }}</div>

                                                        <div class="card-body" style="align-content: center;">
                                                            <form method="POST" action="{{ route('login') }}">
                                                                @csrf

                                                                <div class="row mb-3">
                                                                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                                                    <div class="col-md-6">
                                                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                                                    </div>
                                                                </div>

                                                                <div class="row mb-3">
                                                                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                                                    <div class="col-md-6">
                                                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                                                    </div>
                                                                </div>


                                                                <div class="row mb-0">
                                                                    <div class="col-md-8 offset-md-4">
                                                                        <button type="submit" class="btn btn-primary">
                                                                            {{ __('Login') }}
                                                                        </button>


                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--Login Page Ends-->
            </div>
        </div>
        <!-- END : End Main Content-->
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Core plugin JavaScript-->
<script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

<!-- Custom scripts for all pages-->
<script src="{{asset('js/sb-admin-2.min.js')}}"></script>

<!-- Page level plugins -->
<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

<!-- Page level custom scripts -->
<script src="{{asset('js/demo/datatables-demo.js')}}"></script>
<script src="{{asset('helper/helper.js')}}"></script>
<script src="https://unpkg.com/sweetalert2@7.18.0/dist/sweetalert2.all.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</body>

</html>
