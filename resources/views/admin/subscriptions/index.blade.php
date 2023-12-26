@extends("admin_layout")

<?php
$lang = Session('locale');
if ($lang != "en") {
    $lang = "ar";
}
?>

@section('content')
    <section id="input-style">
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
                    <h6 class="m-0 font-weight-bold text-primary"> {{__('subscript')}} </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th> #</th>
                                <th>{{__('name')}}</th>
                                <th>{{__('max_ser')}}</th>
                                <th>{{__('max_adv')}}</th>
                                <th>{{__('time')}}</th>
                                <th>{{__('price')}}</th>
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


    <!--add Color-->
    @if($lang === 'ar')
        <div class="modal fade text-right" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            @elseif($lang === 'en')
                <div class="modal fade text-left" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    @endif
                    <div class="modal-dialog modal-xs" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <label class="modal-title text-text-bold-600" id="myModalLabel"> {{__('add')}}  </label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close font-medium-2 text-bold-700"></i></span>
                    </button>
                </div>
                <div class="container">
                    <form action="{{ route('update_sub') }}" method="POST" id="addForm">
                        <input type="hidden" name="_id" id="_id" >

                        @csrf
                        <div class="modal-body">

                            <label for="roundText"> {{__('name')}} </label>
                            <div class="form-group">
                                <input type="text" name="name" id="name" placeholder="" class="form-control" required>
                            </div>
                            <label for="roundText"> {{__('max_ser')}} </label>
                            <div class="form-group">
                                <input type="number" name="max_service" id="max_service" placeholder="" class="form-control" required>
                            </div>
                            <label for="roundText"> {{__('max_adv')}} </label>
                            <div class="form-group">
                                <input type="number" name="max_adv" id="max_adv" placeholder="" class="form-control" required>
                            </div>
                            <label for="roundText"> {{__('time')}} </label>
                            <div class="form-group">
                                <input type="date" name="duration" id="duration" placeholder="" class="form-control" required>
                            </div>
                            <label for="roundText"> {{__('price')}} </label>
                            <div class="form-group">
                                <input type="number" name="price" id="price" placeholder="" class="form-control" required>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="addBtn1">{{__('sv')}}</button>
                            <button type="reset" id="close" class="btn btn-danger" data-dismiss="modal">{{__('ext')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

                @if($lang === 'ar')
                    <div class="modal fade text-right" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        @elseif($lang === 'en')
                            <div class="modal fade text-left" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                @endif
                                <div class="modal-dialog modal-xs" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <label class="modal-title text-text-bold-600" id="myModalLabel"> {{__('add')}}  </label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close font-medium-2 text-bold-700"></i></span>
                    </button>
                </div>
                <div class="container">
                <form action="{{ route('subscriptions.store') }}" method="POST" id="addForm">
                    <input type="hidden" name="_id" id="_id" >

                    @csrf
                    <div class="modal-body">
                            <label for="roundText"> {{__('name ar')}} </label>
                            <div class="form-group">
                                <input type="text" name="name_ar" id="name_ar" placeholder="" class="form-control" required>
                            </div>
                            <label for="roundText"> {{__('name en')}} </label>
                            <div class="form-group">
                                <input type="text" name="name_en" id="name_en" placeholder="" class="form-control" required>
                            </div>
                            <label for="roundText"> {{__('max_ser')}} </label>
                            <div class="form-group">
                                <input type="number" name="max_service" id="max_service" placeholder="" class="form-control" required>
                            </div>
                            <label for="roundText"> {{__('max_adv')}} </label>
                            <div class="form-group">
                                <input type="number" name="max_adv" id="max_adv" placeholder="" class="form-control" required>
                            </div>
                            <label for="roundText"> {{__('time')}} </label>
                            <div class="form-group">
                                <input type="date" name="duration" id="duration" placeholder="" class="form-control" required>
                            </div>
                            <label for="roundText"> {{__('price')}} </label>
                            <div class="form-group">
                                <input type="number" name="price" id="price" placeholder="" class="form-control" required>
                            </div>


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

            $("#add").click(function () {
            $("#addBtn").html('save');
            $('#_id').val('');
            $("#addForm").trigger("reset");
            $("#addModal").modal('show');

            });

            var table = $('#dataTable').DataTable({
            destroy: true,
            processing: true,

            serverSide: true,
            stateSave: true,

            ajax: "{{route('subscriptions.index')}}",

            columns: [

            {data: 'DT_RowIndex', name: 'id'},

                {data: 'name', name: 'name'},
                {data: 'max_service', name: 'max_service'},
                {data: 'max_adv', name: 'max_adv'},
                {data: 'duration', name: 'duration'},
                {data: 'price', name: 'price'},
            {data: 'action', name: 'action', orderable: false, searchable: false},

            ]

            });


            $("#addBtn").click(function (e) {
            e.preventDefault();

            $("#addBtn").html('<i class="fa fa-load"></i> ... ');
            $("#addBtn").attr('disabled',true);
            addNewRow("{{route('subscriptions.store')}}", table);
            }); // end add new record

                $("#addBtn1").click(function (e) {
                    e.preventDefault();

                    $("#addBtn1").html('<i class="fa fa-load"></i> ... ');
                    $("#addBtn1").attr('disabled',true);
                    $("#addModal1").modal('hide');

                    $("#addBtn1").html('حفظ');
                    $("#addBtn1").attr('disabled',false);
                    addNewRow("{{route('update_sub')}}", table);
                });
            $('body').on('click', '.edit', function () {

            $("#addBtn").html('edit');
            $("#myModalLabel").html('edit');
            $("#addModal1").modal('show');

            var id = $(this).data('id');

            $.get("{{ route('subscriptions.index') }}" + '/' + id + '/edit', function (data) {
            $("#addBtn").html('edit');

            $('#_id').val(data.id);
            $('#name').val(data.name);
            $('#max_service').val(data.max_service);
            $('#max_adv').val(data.max_adv);
            $('#duration').val(data.duration);
            $('#price').val(data.price);

            })

            }) ;// end edit function;


            //soft delete
            $('body').on('click', '.delete', function () {

            var id = $(this).data("id");
            var token = '{{csrf_token()}}';
            deleteRow("{{ route('subscriptions.index')}}"+"/"+  id, table, token);

            });
                // $('#color-picker').colorpicker({
                //     parent: $('#addForm')
                // });


            });

   </script>
@endpush


