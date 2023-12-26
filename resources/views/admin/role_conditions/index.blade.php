@extends("admin_layout")
<?php
$lang = Session('locale');
if ($lang != "en") {
    $lang = "ar";
}
?>
@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.css"/>
    <section id="input-style">
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800"></h1>


            <div class="card-header py-3">
            <a class="card-header py-3" href={{ url('add_new_cond') }}>{{__('add_new_cond')}}</a>

            </div>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"> {{__('role')}} </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th> #</th>
                                <th>{{__('title')}}</th>
                                <th>{{__('content')}}</th>
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
                    <div class="modal-dialog modal-xs" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <label class="modal-title text-text-bold-600" id="myModalLabel"> {{__('add')}}  </label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close font-medium-2 text-bold-700"></i></span>
                    </button>
                </div>
                <div class="container">
                    <form action="" method="POST" id="addForm">
                        <input type="hidden" name="_id" id="_id" >

                        @csrf
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="roundText">{{__('title')}}</label>
                                <input type="text" class="form-control" id="title" name="title">
                            </div>
                            <div class="form-group">
                                <label for="roundText">{{__('content')}}</label>
                                <textarea type="text" class="form-control" name="content1" id="content1"></textarea>
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

        $('#text').summernote();


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

                ajax: "{{route('role_condition.index')}}",

                columns: [

                    {data: 'DT_RowIndex', name: 'id'},

                    {data: 'title', name: 'title'},
                    {data: 'content', name: 'content'},

                    {data: 'action', name: 'action', orderable: false, searchable: false},

                ]

            });


            $("#addBtn").click(function (e) {
                e.preventDefault();

                $("#addBtn").html('<i class="fa fa-load"></i> ... ');
                $("#addBtn").attr('disabled',true);
                addNewRow("{{route('update_role')}}", table);
            }); // end add new record


            $('body').on('click', '.edit', function () {

                $("#addModal").modal('show');

                var id = $(this).data('id');

                $.get("{{ route('role_condition.index') }}" + '/' + id + '/edit', function (data) {
                    // $("#addBtn").html('تعديل');

                    $('#_id').val(data.id);

                    $('#title').val(data.title);
                    $('#content1').val(data.content);

                })

            }) ;// end edit function;


            $('body').on('click', '.delete', function () {

                var id = $(this).data("id");
                var token = '{{csrf_token()}}';
                deleteRow("{{ route('role_condition.index')}}"+"/"+  id, table, token);

            });

        });

    </script>
@endpush


