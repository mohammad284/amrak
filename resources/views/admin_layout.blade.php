<?php
$lang = Session('locale');
if ($lang != "en") {
    $lang = "ar";
}
//else $lang = "en";
?>
<!DOCTYPE html>
<html lang="">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">

    <!-- Custom styles for this template -->

    @if($lang === 'ar')
        <link href="{{asset('css/sb-admin-2.min.css')}}" rel="stylesheet">

    @else
        <link href="{{asset('css/sb-admin-2-ltr.min.css')}}" rel="stylesheet">
    @endif

    <link href="{{asset('css/dropzone.min.css')}}" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/4.1.5/css/flag-icons.min.css" integrity="sha512-UwbBNAFoECXUPeDhlKR3zzWU3j8ddKIQQsDOsKhXQGdiB5i3IHEXr9kXx82+gaHigbNKbTDp3VY/G6gZqva6ZQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{--<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.min.css" rel="stylesheet">--}}
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.2.0/css/bootstrap-colorpicker.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" integrity="sha512-pDpLmYKym2pnF0DNYDKxRnOk1wkM9fISpSOjt8kWFKQeDmBTjSnBZhTd41tXwh8+bRMoSaFsRnznZUiH9i3pxA==" crossorigin="anonymous" />

    <title>amrak </title>
    <meta name="title" content="{{ config('app.name', 'amrak') }}">
    <link rel="icon" type="image/png" href="{{asset('/img/amrak_tm.png')}}" />

</head>


{{--<form method="POST" action="{{route('logout')}}" id="logout-form">@csrf</form>--}}

        <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Sidebar -->
            <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

                <!-- Sidebar - Brand -->
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{url('/home')}}">
{{--                    <div class="sidebar-brand-icon rotate-n-15">--}}
{{--                        <i class="fas fa-server"></i>--}}
{{--                    </div>--}}
                    <img class="img-profile rounded-circle"
                         src="{{asset('/img/amrak_tm.png')}}" height="40" width="40" style="background-color: #ffffff;">

                    <div class="sidebar-brand-text mx-3"> Amrak Tm <sup></sup></div>
                </a>

                <!-- Divider -->
                <hr class="sidebar-divider my-0">

                <!-- Nav Item - Dashboard -->
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/home')}}">
                        <i class="fas fa-chart-pie"></i>
                        <span>{{__('main')}}</span></a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->


                <!-- Nav Item - Charts -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
                       aria-expanded="true" aria-controls="collapseOne">
                        <i class="fas fa-fw fa-user"></i>
                        <span>{{__('users')}}</span>
                    </a>
                    <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href={{ route('users.index') }}>{{__('users')}}</a>
                            <a class="collapse-item" href={{ route('admin.index') }}>{{__('admin')}}</a>
                            <a class="collapse-item" href={{ url('accepted/users') }}>{{__('acc us')}}</a>
                        </div>
                    </div>
                </li>

                <!-- Nav Item - Tables -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                       aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-user-friends"></i>
                        <span>{{__('pro')}}</span>
                    </a>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href={{ route('providers.index') }}>{{__('prov')}} </a>
                            <a class="collapse-item" href={{ url('accepted/providers') }}>{{__('acc pro')}} </a>
                            <a class="collapse-item" href={{ url('prov_review') }}>{{__('pro_rev')}} </a>
                            <a class="collapse-item" href={{ url('prov_work') }}>{{__('pro_work')}} </a>
                            <a class="collapse-item" href={{ route('availability_hours.index') }}>{{__('w_hour')}}</a>
                            <a class="collapse-item" href={{ route('providers_subs.index') }}>{{__('pro_sub')}}</a>
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo2"
                       aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-quote-left"></i>
                        <span>{{__('service')}}</span>
                    </a>
                    <div id="collapseTwo2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href={{ route('services.index') }}> {{__('service')}} </a>
                            <a class="collapse-item" href={{ route('services_review.index') }}> {{__('serv review')}} </a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo3"
                       aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-donate"></i>
                        <span> {{__('pay')}}</span>
                    </a>
                    <div id="collapseTwo3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
{{--                            <a class="collapse-item" href={{ route('payment_method.index') }}>طرق الدفع </a>--}}
                            <a class="collapse-item" href={{ route('payment_state.index') }}>{{__('st_pay')}} </a>
                            <a class="collapse-item" href={{ route('bookingStates.index') }}>{{__('st_book')}} </a>
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo4"
                       aria-expanded="true" aria-controls="collapseTwo">
                        <i class="far fa-calendar-check"></i>
                        <span> {{__('book')}}</span>
                    </a>
                    <div id="collapseTwo4" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href={{ route('bookings.index') }}>  {{__('book')}} </a>
                            <a class="collapse-item" href={{ url('accepted/bookings') }}> {{__('acc-book')}}</a>
                        </div>
                    </div>
                </li>

{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link" href={{ route('services.index') }}>--}}
{{--                        <i class="fas fa-google-wallet"></i>--}}
{{--                        <span>الخدمات</span></a>--}}
{{--                </li>--}}

                <li class="nav-item">
                    <a class="nav-link" href={{ url('/categories') }}>
                        <i class="fa fa-align-center"></i>
                        <span>  {{__('cats')}}</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href={{ url('/subscriptions') }}><i class="	fa fa-th-large"></i><span>  {{__('subscript')}}</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href={{ route('colors.index') }}>
                        <i class="fas fa-palette"></i>
                        <span>  {{__('color')}}</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href={{ route('sliders.index') }}>
                        <i class="fas fa-image"></i>
                        <span>  {{__('slider')}}</span></a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href={{ route('coupons.index') }}>
                        <i class="fas fa-fw fa-code"></i>
                        <span>  {{__('coupon')}}</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href={{ route('notify.index') }}>
                        <i class="fas fa-fw fa-bell"></i>
                        <span>  {{__('notify')}}</span></a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href={{ route('user_address.index') }}>
                        <i class="fas fa-map-marker"></i>
                        <span> {{__('user addr')}}</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href={{ route('user_fav.index') }}>
                        <i class="fas fa-heart"></i>
                        <span> {{__('user fav')}}</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href={{ route('term_privacy.index') }}>
                        <i class="fas fa-lock"></i>
                        <span>  {{__('term')}}</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href={{ route('role_condition.index') }}>
                        <i class="fas fa-user-lock"></i>
                        <span>  {{__('role')}}</span></a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">

                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center  d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>

            </ul>
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                        <!-- Sidebar Toggle (Topbar) -->
                        <form class="form-inline">
                            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                                <i class="fa fa-bars"></i>
                            </button>
                        </form>

                        <!-- Topbar Search -->
                        <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                                <input type="text" class="form-control bg-light border-0 small" placeholder="{{__('search')}}"
                                       aria-label="Search" aria-describedby="basic-addon2">

                            </div>
                        </form>

                        <!-- Topbar Navbar -->
                        <ul class="navbar-nav ml-auto">


                            <div class="topbar-divider d-none d-sm-block"></div>

                            <!-- Nav Item - User Information -->
                            <div class="navbar-container">
                                <div class="collapse navbar-collapse d-block" id="navbarSupportedContent">
                                    <ul class="navbar-nav">

{{--                                        <span class="mr-2 d-lg-inline text-gray-600 small">Hi</span>--}}

                                        <li class="nav-item dropdown no-arrow">
                                            <a class="nav-link dropdown-toggle" href="" id="userDropdown" role="button"
                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">  {{ Auth::user()->name }}</span>
                                                <img class="img-profile rounded-circle"
                                                     src="{{asset('/img/amrak_tm.png')}}">
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="{{ route('logout') }}"
                                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                    {{__('logout')}}
                                                </a>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                    @csrf
                                                </form>
                                            </div>

                                        </li>


                                    </ul>
{{--                                    <ul class="navbar-nav">--}}

                                        {{--                                        <span class="mr-2 d-lg-inline text-gray-600 small">Hi</span>--}}

{{--                                        <li class="nav-item dropdown no-arrow">--}}
{{--                                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"--}}
{{--                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>--}}
{{--                                                <i class="fa fa-language"></i>--}}
{{--                                            </a>--}}
{{--                                            <!-- Dropdown - User Information -->--}}
{{--                                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"--}}
{{--                                                 aria-labelledby="userDropdown" style="margin: 5px;">--}}
{{--                                                @if($lang === 'ar')--}}
                                                <i></i>
                                                <a href="{{url('/changeLanguage/en')}}" class="flag-icon flag-icon-gb"> </a>
{{--                                                @else--}}
                                                <div class="dropdown-divider" >&nspar;</div>
                                                <i ></i>
                                                    <a href="{{url('/changeLanguage/ar')}}" class="flag-icon flag-icon-ae"></a>
{{--                                                @endif--}}
{{--                                                </div>--}}
{{--                                        </li>--}}

{{--                                    </ul>--}}
                                </div>
                            </div>
{{--                            <li class="nav-item dropdown no-arrow">--}}
{{--                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"--}}
{{--                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                                    <span class="mr-2 d-lg-inline text-gray-600 small">Hi Amrak tm</span>--}}

{{--                                </a>--}}
{{--                                <!-- Dropdown - User Information -->--}}
{{--                                <div class="dropdown-menu dropdown-menu-left shadow animated--grow-in"--}}
{{--                                     aria-labelledby="userDropdown">--}}
{{--                                    <a class="dropdown-item" href="">--}}
{{--                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>--}}
{{--                                        الملف الشخصي--}}
{{--                                    </a>--}}

{{--                                    <div class="dropdown-divider"></div>--}}
{{--                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">--}}
{{--                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>--}}
{{--                                        تسجيل خروج--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                            </li>--}}

                        </ul>

                    </nav>
                    <!-- End of Topbar -->

                    @yield('content')
                </div>
                <!-- End of Main Content -->

                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; AmrakTM 2022 </span>
{{--                            <span>Copyright &copy; AmrakTM 2021 By Alesar.Ism</span>--}}
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal-->
{{--        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"--}}
{{--             aria-hidden="true">--}}
{{--            <div class="modal-dialog" role="document">--}}
{{--                <div class="modal-content">--}}
{{--                    <div class="modal-header">--}}
{{--                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>--}}
{{--                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">--}}
{{--                            <span aria-hidden="true">×</span>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>--}}
{{--                    <div class="modal-footer">--}}
{{--                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>--}}
{{--                        <li class="dropdown nav-item mr-1"><a class="nav-link dropdown-toggle user-dropdown d-flex align-items-end" id="dropdownBasic2" href="javascript:;" data-toggle="dropdown" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">--}}
{{--                                <div class="user d-md-flex d-none mr-2"><span class="text-right">  <i class="ft-power mr-2"></i> </span><span class="text-right text-muted font-small-3">Logout</span></div> </a>--}}
{{--                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">--}}
{{--                                {{ csrf_field() }}--}}
{{--                            </form>--}}
{{--                          </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

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
        <script src="{{asset('js/dropzone.min.js')}}"></script>
        <script src="{{asset('js/jscolor.js')}}"></script>
        <script src="{{asset('js/jscolor.min.js')}}"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.js" integrity="sha512-kZv5Zq4Cj/9aTpjyYFrt7CmyTUlvBday8NGjD9MxJyOY/f2UfRYluKsFzek26XWQaiAp7SZ0ekE7ooL9IYMM2A==" crossorigin="anonymous"></script>
        <script src = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.2.0/js/bootstrap-colorpicker.min.js" > </script>
        <script src="https://unpkg.com/sweetalert2@7.18.0/dist/sweetalert2.all.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        </body>

</html>
@stack('pageJs')
