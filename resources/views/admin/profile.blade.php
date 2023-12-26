@extends('admin_layout')
@section('content')

<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">

                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="">
                            <h1 class="h4 text-gray-900 mb-4">profile </h1>
                        </div>
                        <form class="user" id="user">
                            @csrf
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="text" class="text-gray-900 font-weight-bold form-control form-control-user" id="name" name="name"
                                           placeholder="Name" value="{{Auth::user()->name}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="email" class="text-gray-900 font-weight-bold form-control form-control-user" id="email" name="email"
                                       placeholder="Email Address" value="{{Auth::user()->email}}">
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="text-gray-900 font-weight-bold form-control form-control-user" name="password"
                                           id="password" placeholder="Password">
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" class="text-gray-900 font-weight-bold form-control form-control-user" name="password_confirmation"
                                           id="password_confirmation" placeholder="Repeat Password">
                                </div>

                                <h6 class=" text-gray-600 m-4">  {{trans('message.re_pass')}} </h6>

                            </div>

                            <button class="btn btn-primary " id="addFormBtn" > save </button>

                        </form>
                        <hr>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

    @endsection
@push('pageJs')

    <script type="text/javascript">

        $(function () {


            $("#addFormBtn").click(function (e) {
                e.preventDefault();

                $("#addFormBtn").html('<i class="fa fa-load"></i> ... ');
                $("#addFormBtn").attr('disabled', true);

                $.ajax({

                    data: $('#user').serialize(),

                    url: "{{route('profile.update')}}",

                    type: "POST",

                    dataType: 'json',
                    timeout: 4000,
                    success: function (data) {
                        if (data.status == 200) {

                            resetButton();

                            Swal.fire({
                                title: " ", text: "Saved",
                                type: "success", confirmButtonClass: "btn btn-primary", buttonsStyling: !1
                            });

                        } else {
                            warningMessage(data);
                            resetButton();
                        }
                    },

                    error: function (data) {

                        resetButton();
                        errorMessage(data);

                    }

                });
            }); // end add new record
        });

        </script>
        @endpush
