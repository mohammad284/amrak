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
                    <h6 class="m-0 font-weight-bold text-primary"> {{__('pro_rev')}} </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th> #</th>
                                <th>{{__('pro')}}</th>
                                <th>{{__('user')}}</th>
                                <th>{{__('comm')}}</th>
                                <th>{{__('rate')}}</th>
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
                    <form action="{{ route('prov_review.store') }}" method="POST" id="addForm">
                        <input type="hidden" name="_id" id="_id" >


                        @csrf
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="roundText">{{__('pro')}}</label>
                                <select name="provider_id" id="provider_id" class="form-control SlectBox">
                                    <!--placeholder-->
                                    <option value="" selected disabled>ا{{__('sel_pro')}}</option>
                                    @foreach ($provider as $prov)
                                        <option value="{{ $prov->id }}"> {{ $prov->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="roundText">{{__('user')}}</label>
                                <select name="user_id" id="user_id" class="form-control SlectBox">
                                    <!--placeholder-->
                                    <option value="" selected disabled>{{__('sel_use')}}</option>
                                    @foreach ($user as $cust)
                                        <option value="{{ $cust->id }}"> {{ $cust->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="roundText">{{__('rate')}}</label>
                                <input type="number" class="form-control" id="rate" name="rate">
                            </div>

                            <div class="form-group">
                                <label for="roundText">{{__('comm')}}</label>
                                <input type="text" class="form-control" id="comment" name="comment">
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



            var table = $('#dataTable').DataTable({
                destroy: true,
                processing: true,

                serverSide: true,
                stateSave: true,

                ajax: "{{route('prov_review.index')}}",

                columns: [

                    {data: 'DT_RowIndex', name: 'id'},

                    {data: 'provider', name: 'provider'},
                    {data: 'customer', name: 'customer'},
                    {data: 'comment', name: 'comment'},
                    {data: 'rate', name: 'user'},

                    {data: 'action', name: 'action', orderable: false, searchable: false},

                ]

            });
            $('body').on('click', '.accept', function () {

                var user_id = $(this).data("id");

                var co = confirm("  {{__('inform-acc')}}");
                if (!co) {
                    return;
                }

                $.ajax({
                    data: {
                        "_token":$("input[name=_token]").val(),
                        "accept": 1
                    },
                    type: "POST",

                    url: "{{ url('agree/providerReview') }}" + '/' + user_id,

                    success: function (data) {
                        successMessage();
                        table.draw(false);
                    },

                    error: function (data) {
                        errorMessage(data);

                    }

                });

                });
                $('body').on('click', '.reject', function () {

                var user_id = $(this).data("id");

                var co = confirm(" {{__('inform-rej')}}");
                if (!co) {
                    return;
                }

                $.ajax({
                    data: {
                        "_token":$("input[name=_token]").val(),
                        "accept": 0
                    },
                    type: "POST",

                    url: "{{ url('agree/providerReview') }}" + '/' + user_id,

                    success: function (data) {
                        successMessage();
                        table.draw(false);
                    },

                    error: function (data) {
                        errorMessage(data);

                    }

                });

                });

            $("#addBtn").click(function (e) {
                e.preventDefault();

                $("#addBtn").html('<i class="fa fa-load"></i> ... ');
                $("#addBtn").attr('disabled',true);
                addNewRow("{{route('prov_review.store')}}", table);
            }); // end add new record


            $('body').on('click', '.edit', function () {

                $("#addBtn").html('{{__('edit')}}');
                $("#myModalLabel").html('{{__('edit')}}');
                $("#addModal").modal('show');

                var id = $(this).data('id');

                $.get("{{ route('prov_review.index') }}" + '/' + id + '/edit', function (data) {
                    $("#addBtn").html('{{__('edit')}}');

                    $('#_id').val(data.id);

                    $('#name').val(data.name);
                    $('#lang').val(data.lang);

                })

            }) ;// end edit function;


            //soft delete
            $('body').on('click', '.delete', function () {

                var id = $(this).data("id");
                var token = '{{csrf_token()}}';
                deleteRow("{{ route('prov_review.index')}}"+"/"+  id, table, token);

            });

        });

    </script>
@endpush


