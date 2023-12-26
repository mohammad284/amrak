<!DOCTYPE html>
<!--
Template Name: NobleUI - Laravel Admin Dashboard Template
Author: NobleUI
Purchase: https://1.envato.market/nobleui_laravel
Website: https://www.nobleui.com
Portfolio: https://themeforest.net/user/nobleui/portfolio
Contact: nobleui123@gmail.com
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html dir="rtl">
<head>
  <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="Responsive Laravel Admin Dashboard Template based on Bootstrap 5">
	<meta name="author" content="NobleUI">
	<meta name="keywords" content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, laravel, theme, front-end, ui kit, web">

  <title>AmrakTM</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
  <!-- End fonts -->

  <!-- CSRF Token -->
  <meta name="_token" content="{{ csrf_token() }}">

  <link rel="shortcut icon" href="{{'assets/images/amrak.png'}}">

  <!-- plugin css -->
  <link href="{{ asset('assets/fonts/feather-font/css/iconfont.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.css') }}" rel="stylesheet" />
  <link  href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css"  />
  {{-- <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css') }}"> --}}
  <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert/sweetalert.css') }}"/>
  <link rel="stylesheet" href="{{ asset('css/dropzone.min.css') }}"/>
  <!-- end plugin css -->

  @stack('plugin-styles')

  <!-- common css -->
  <link href="{{ asset('css/app.rtl.css') }}" rel="stylesheet" />
  <!-- end common css -->

  @stack('style')
</head>
<body data-base-url="{{url('/')}}">

  <script src="{{ asset('assets/js/spinner.js') }}"></script>

  <div class="main-wrapper" id="app">
    @include('layout.sidebar')
    <div class="page-wrapper">
      @include('layout.header')
      <div class="page-content">
        @yield('content')
      </div>
      @include('layout.footer')
    </div>
  </div>

    <!-- base js -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('assets/plugins/feather-icons/feather.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/dropzone.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap-colorpicker.js') }}"></script>
    <!-- end base js -->

    <!-- plugin js -->
    @stack('plugin-scripts')
    <!-- end plugin js -->

    <!-- common js -->
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <!-- end common js -->

    @stack('custom-scripts')
</body>
</html>
@stack('pageJs')
