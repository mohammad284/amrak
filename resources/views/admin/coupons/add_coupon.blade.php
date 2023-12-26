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
                <button id="add" class="btn btn-primary">{{__('add')}}</button> &nbsp;
            </div>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"> {{__('coupon')}}  </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('code')}} </th>
                                <th>{{__('discount')}}</th>
                                <th>{{__('dis_typ')}}</th>
                                <th> {{__('serv')}} </th>
                                <th> {{__('state')}} </th>
{{--                                <th> {{__('expiry')}} </th>--}}
                                <th>{{__('operate')}}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--add -->
    @if($lang === 'ar')
        <div class="modal fade text-right" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            @elseif($lang === 'en')
                <div class="modal fade text-left" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    @endif
                    <div class="modal-dialog  modal-xs" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{__('add')}}</h6>
                    <button aria-label="Close" class="close" data-dismiss="addModal" type="button"><span aria-hidden="true"></span></button>
                </div>
                <form action="{{ route('coupons.store') }}" method="POST" id="addForm">
                    <input type="hidden" name="_id" id="_id" >

                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label>{{__('code')}}</label>
                            <input type="text" class="form-control" id="code" name="code">
                        </div>

                        <div class="form-group">
                            <label>{{__('discount')}}</label>
                            <input type="text" class="form-control" id="discount" name="discount">
                        </div>


                        <div class="form-group">
                            <label for="roundText">{{__('dis_typ')}}</label>
                            <select name="discount_type" id="discount_type" class="form-control SlectBox">
{{--                                <option value="" selected disabled>{{__('sel_typ')}}</option>--}}
                                <option value="0"> {{__('const')}}</option>
                                <option value="1">{{__('percent')}}</option>
                            </select>
                        </div>

                        <div class="form-group">
                                <label for="roundText">{{__('serv')}}</label>
                                <select name="service_id" id="service_id" class="form-control SlectBox">
{{--                                      <option value="" selected disabled>{{__('sel_serv')}}</option>--}}
                                @foreach ($serv as $cat)
                                        <option value="{{ $cat->id }}" > {{ $cat->name }} </option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="form-group">
                            <label for="roundText">{{__('state')}}</label>
                            <select name="enable" id="enable" class="form-control SlectBox">
                                <!--placeholder-->
{{--                                <option value="" selected disabled>{{__('sel_st')}}</option>--}}
                                <option value="1"> {{__('enable')}}</option>
                                <option value="0"> {{__('un_enable')}}</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="addBtn">{{__('sv')}}</button>
                        <button type="reset"  data-dismiss="modal" class="btn btn-danger">{{__('ext')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('pageJs')
    <script type="text/javascript">

            $(function () {

            $("#add").click(function () {
            // $("#addBtn").html('حفظ');
            $('#_id').val('');
            $("#addForm").trigger("reset");
            $("#addModal").modal('show');

            });

            var table = $('#dataTable').DataTable({
            destroy: true,
            processing: true,

            serverSide: true,
            stateSave: true,

            ajax: "{{route('coupons.index')}}",

            columns: [

            {data: 'DT_RowIndex', name: 'id'},

            {data: 'code', name: 'code'},
            {data: 'discount', name: 'discount'},
            {data: 'dis_b', name: 'dis_b'},
            {data: 'services', name: 'services'},
            {data: 'sate', name: 'sate'},
            // {data: 'expire_at', name: 'expire_at'},

            {data: 'action', name: 'action', orderable: false, searchable: false},

            ]

            });


            $("#addBtn").click(function (e) {
            e.preventDefault();

            $("#addBtn").html('<i class="fa fa-load"></i> ... ');
            $("#addBtn").attr('disabled',true);
            addNewRow("{{route('coupons.store')}}", table);
            }); // end add new record


            $('body').on('click', '.edit', function () {

            // $("#addBtn").html('تعديل');
            $("#addModal").modal('show');

            var id = $(this).data('id');

            $.get("{{ route('coupons.index') }}" + '/' + id + '/edit', function (data) {
            // $("#addBtn").html('تعديل');

            $('#_id').val(data.id);

            $('#code').val(data.code);
            $('#discount').val(data.discount);
            $('#service_id').val(data.service_id);
            $('#discount_type').val(data.discount_type);

            $('#expire_at').val(data.expire_at);

            })

            }) ;// end edit function;


            //soft delete
            $('body').on('click', '.delete', function () {

            var id = $(this).data("id");
            var token = '{{csrf_token()}}';
            deleteRow("{{ route('coupons.index')}}"+"/"+  id, table, token);

            });


            });

   </script>
@endpush


