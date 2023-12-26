@extends("admin_layout")
@section('content')


    <style>
       a{color: #c39304
       }

    </style>


    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-8 col-lg-7">

            <!-- Area Chart -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{__('earn')}}</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
                        <input type="hidden" id="1" value="{{$book1}}" />
                        <input type="hidden" id="2" value="{{$book2}}" />
                        <input type="hidden" id="3" value="{{$book3}}" />
                        <input type="hidden" id="4" value="{{$book4}}" />
                        <input type="hidden" id="5" value="{{$book5}}" />
                        <input type="hidden" id="6" value="{{$book6}}" />
                        <input type="hidden" id="7" value="{{$book7}}" />
                        <input type="hidden" id="8" value="{{$book8}}" />
                        <input type="hidden" id="9" value="{{$book9}}" />
                        <input type="hidden" id="10" value="{{$book10}}" />
                        <input type="hidden" id="11" value="{{$book11}}" />
                        <input type="hidden" id="12" value="{{$book12}}" />
                        <input type="hidden" id="13" value="{{$book13}}" />
                        <input type="hidden" id="14" value="{{$book14}}" />
                    </div>
                    <div class="card-header py-3">
                        <a class="card-header py-3" >{{__('totle_chart')}}</a>
                    </div>
                    <hr>
                </div>
            </div>


        </div>

        <!-- Donut Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{__('totl')}}</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4">
                        <canvas id="myPieChart"></canvas>
                        <input type="hidden" id="user" value="{{$user}}" />
                        <input type="hidden" id="prov" value="{{$pro}}" />
                        <input type="hidden" id="book" value="{{$book}}" />
                    </div>
                    <div class="card-header py-3">
                         <i class="fa fa-circle fa-lg" style="color:#3cac54; "></i>{{__('prov_chart')}}
                         <i class="fa fa-circle fa-lg" style="color:#eea02c; "></i>{{__('book_chart')}}
                         <i class="fa fa-circle fa-lg" style="color:#622e07; "></i>{{__('user_chart')}}
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row m-1">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-4 mb-4">
            <a href="{{route('services.index')}}">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                {{__('service')}}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$serv ?? ''}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-passport fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            </a>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-4 mb-4">
            <a href="{{route('providers.accepted')}}">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                {{__('prov')}}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$pro ?? ''}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            </a>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-4 mb-4">
            <a href="{{route('users.accepted')}}">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    {{__('users')}}
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$user ?? ''}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row m-1">
    <div class="col-xl-4 col-md-4 mb-4">
        <a href="{{route('booking.accepted')}}">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                {{__('earn')}}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$earning ?? '0'}}</div>

                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-4 mb-4">
        <a href="{{route('bookings.index')}}">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                {{__('book')}}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$book ?? '0'}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-donate fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-4 mb-4">

    <a href="{{route('categories.index')}}">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            {{__('cats')}}
                        </div>
                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$cat ?? ''}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa fa-align-center fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>
    </div>
    </div>
    <div class="row m-1">
    <div class="col-xl-4 col-md-4 mb-4">

        <a href="{{route('services_review.index')}}">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                {{__('serv review')}}
                            </div>
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$rev ?? ''}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-4 col-md-4 mb-4">
            <a href="{{route('user_address.index')}}">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    {{__('user addr')}}
                                </div>
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$add ?? ''}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-address-card fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
    </div>
    <div class="col-xl-4 col-md-4 mb-4">
                <a href="{{route('user_fav.index')}}">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        {{__('user fav')}}
                                    </div>
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$fav ?? ''}}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-heart fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
    </div>
    </div>
@endsection
@push('pageJs')
        <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
        <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
        <script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
        <script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>
        <script src="{{ asset('js/demo/chart-bar-demo.js') }}"></script>
@endpush
