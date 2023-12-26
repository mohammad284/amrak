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
{{--                <button id="add" class="btn btn-primary"> {{__('add')}} </button> &nbsp;--}}
            </div>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"> {{__('pro_subs')}} </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th> #</th>
                                <th>{{__('pro')}}</th>
                                <th>{{__('subs')}}</th>
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
                    <label class="modal-title text-text-bold-600" id="myModalLabel"> {{__('edit')}}  </label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close font-medium-2 text-bold-700"></i></span>
                    </button>
                </div>
                <div class="container">
                    <form action="{{ route('providers_subs.store') }}" method="POST" id="addForm">
                        <input type="hidden" name="_id" id="_id" >


                        @csrf
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="roundText">{{__('pro')}}</label>
                                <select name="provider_id" id="provider_id" class="form-control SlectBox">
                                    <!--placeholder-->
                                    <option value="" selected disabled>ا{{__('sel_pro')}}</option>
                                    @foreach ($providers as $prov)
                                        <option value="{{ $prov->id }}"> {{ $prov->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="roundText">{{__('subs')}}</label>
                                <select name="subscript_id" id="subscript_id" class="form-control SlectBox">
                                    <!--placeholder-->
                                    <option value="" selected disabled>{{__('sel_subs')}}</option>
                                    @foreach ($subscripts as $cust)
                                        <option value="{{ $cust->id }}"> {{ $cust->name }}</option>
                                    @endforeach
                                </select>
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

            {{--$("#add").click(function () {--}}
            {{--    --}}{{--$("#addBtn").html('{{__('sv')}}');--}}
            {{--    $('#_id').val('');--}}
            {{--    $("#addForm").trigger("reset");--}}
            {{--    $("#addModal").modal('show');--}}

            {{--});--}}

            var table = $('#dataTable').DataTable({
                destroy: true,
                processing: true,

                serverSide: true,
                stateSave: true,

                ajax: "{{route('providers_subs.index')}}",

                columns: [

                    {data: 'DT_RowIndex', name: 'id'},

                    {data: 'provider', name: 'provider'},
                    {data: 'subscript', name: 'subscript'},

                    {data: 'action', name: 'action', orderable: false, searchable: false},

                ]

            });


            $("#addBtn").click(function (e) {
                e.preventDefault();

                $("#addBtn").html('<i class="fa fa-load"></i> ... ');
                $("#addBtn").attr('disabled',true);
                addNewRow("{{route('providers_subs.store')}}", table);
            }); // end add new record


            $('body').on('click', '.edit', function () {

                $("#addBtn").html('تعديل');
                $("#myModalLabel").html('تعديل');
                $("#addModal").modal('show');

                var id = $(this).data('id');

                $.get("{{ route('providers_subs.index') }}" + '/' + id + '/edit', function (data) {
                    $("#addBtn").html('تعديل');

                    $('#_id').val(data.id);

                    $('#subscript_id').val(data.subscript_id);
                    $('#provider_id').val(data.provider_id);

                })

            }) ;// end edit function;

            //soft delete
            $('body').on('click', '.delete', function () {

                var id = $(this).data("id");
                var token = '{{csrf_token()}}';
                deleteRow("{{ route('providers_subs.index')}}"+"/"+  id, table, token);
            });

        });

    </script>
@endpush


