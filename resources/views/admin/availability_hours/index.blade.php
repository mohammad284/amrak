@extends('admin_layout')

<?php
$lang = Session('locale');
if ($lang != "en") {
    $lang = "ar";
}
?>


@section('content')

    <section id="input-style">
{{--            <div class="row mr-5">--}}
{{--                <button id="add" class="btn btn-primary"> {{__('add')}} </button> &nbsp;--}}
{{--            </div>--}}

{{--            <!-- Begin Page Content -->--}}
            <div class="container-fluid">

                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800"></h1>

                    <!-- Page Heading -->
                    <div class="row m-2">
                        <button id="add" class="btn btn-primary"> {{__('add')}} </button> &nbsp;
                    </div>
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">{{__('w_hour')}} </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('service')}}</th>
                                <th>{{__('day')}}  </th>
                                <th>{{__('st_at')}}  </th>
                                <th>{{__('en_at')}}  </th>
                                <th>{{__('operate')}}</th>

                            </tr>
                            </thead>

                                <tbody>

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

    </section>

    @if($lang === 'ar')
        <div class="modal fade text-right" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            @elseif($lang === 'en')
                <div class="modal fade text-left" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    @endif
                    <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <label class="modal-title text-text-bold-600" id="title">{{__('add_tm')}}  </label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close"></i></span>

                    </button>
                </div>
                <div class="container">
                <form action="" method="post" id="addForm">
                    <input type="hidden" name="_id" id="_id" >
                    @csrf
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <fieldset class="form-group">
                                <select name="service_id" id="service_id" class="form-control SlectBox">
                                    <!--placeholder-->
                                    <option value="" selected disabled> {{__('service')}}</option>
                                    @foreach ($service as $ser)
                                        <option value="{{ $ser->id }}"> {{ $ser->name }}</option>
                                    @endforeach
                                </select>
                            </fieldset>

                            <fieldset class="form-group">
                                <select name="day_id" id="day_id" class="form-control SlectBox">
                                    <!--placeholder-->
                                    <option value="" selected disabled>{{__('day')}}</option>
                                    @foreach ($day as $row)
                                        <option value="{{ $row->id }}"> {{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </fieldset>
                            <div class="form-group">
                                <label for="roundText">{{__('st_at')}}</label>
                                <input type="time" class="form-control" id="start_at" name="start_at">
                            </div>
                            <div class="form-group">
                                <label for="roundText">{{__('en_at')}}</label>
                                <input type="time" class="form-control" id="end_at" name="end_at">
                            </div>
                        </div>
                        <br>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="addBtn">{{__('sv')}}</button>
                        <button type="reset" id="close" class="btn btn-danger" data-dismiss="modal">{{__('ext')}}</button>
                    </div>

                </form>
            </div>
            </div>
        </div>
    </div>

@endsection

@push('pageJs')

    <script type="text/javascript">

        $(function () {

            $("#add").click(function (e) {
                e.preventDefault();

                $('#_id').val('') ;
                $('#addForm').trigger("reset");
                $("#addModal").modal("show");

            });
            var table = $('#dataTable').DataTable({

                destroy: true,
                processing: true,

                serverSide: true,
                stateSave: true,

                ajax: "{{ route('availability_hours.index') }}",

                columns: [

                    {data: 'DT_RowIndex', name: 'id'},

                    {data: 'service', name: 'service'},
                    {data: 'days', name: 'days'},
                    {data: 'start_at', name: 'start_at'},
                    {data: 'end_at', name: 'end_at'},


                    {data: 'action', name: 'action', orderable: false, searchable: false},

                ]

            });
            $("#addBtn").click(function (e) {
                e.preventDefault();

                $("#addBtn").html('<i class="fa fa-load"></i> ... ');
                $("#addBtn").attr('disabled',true);
                addNewRow("{{route('availability_hours.store')}}", table);
            }); // end add new record

            $('body').on('click', '.edit', function () {


                $("#addModal").modal('show');
                var id = $(this).data('id');

                $.get("{{ route('availability_hours.index') }}" + '/' + id + '/edit', function (data) {

                      $('#_id').val(data.id);

                    $('#service_id').val(data.service_id);
                    $('#day_id').val(data.day_id);
                    $('#start_at').val(data.start_at);
                    $('#end_at').val(data.end_at);

                })


            }) ;// end edit function;


            //soft delete
            $('body').on('click', '.delete', function () {

                var id = $(this).data("id");
                var token = '{{csrf_token()}}';
                deleteRow("{{ route('availability_hours.index')}}"+"/"+  id, table, token);

            });

        });

    </script>

@endpush
