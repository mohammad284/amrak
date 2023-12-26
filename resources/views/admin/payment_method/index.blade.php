@extends("admin_layout")

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
                    <h6 class="m-0 font-weight-bold text-primary"> طرق الدفع  </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th> #</th>
                                <th>الاسم</th>
                                <th>الحالة</th>
                                <th>اللغة</th>
                                <th>العمليات</th>
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
    <div class="modal fade text-right" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xs" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <label class="modal-title text-text-bold-600" id="myModalLabel"> {{__('add')}}  </label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close font-medium-2 text-bold-700"></i></span>
                    </button>
                </div>
                <div class="container">
                    <form action="{{ route('payment_method.store') }}" method="POST" id="addForm">
                        <input type="hidden" name="_id" id="_id" >
                        <input type="hidden" name="trans_id" id="trans_id" >
                        @csrf
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="roundText">الاسم</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>

                          <div class="form-group">
                            <label for="roundText">الحالة</label>
                            <select name="enable" id="enable" class="form-control SlectBox">
                                <!--placeholder-->
                                <option value="" selected disabled>اختر الحالة</option>
                                <option value="1"> فعالة</option>
                                <option value="0"> غير فعالة</option>
                            </select>
                        </div>
                            <div class="form-group">
                                <label for="roundText"> اللغة</label>
                                <select name="lang" id="lang" class="form-control SlectBox">
                                    <!--placeholder-->
                                    <option value="" selected disabled>اختر اللغة</option>
                                    <option value="ar"> عربي</option>
                                    <option value="en"> انكليزي</option>
                                </select>
                            </div>


                </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="addBtn">حفظ</button>
                            <button type="reset" id="close" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
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
                $("#addBtn").html('حفظ');
                $('#_id').val('');
                $("#addForm").trigger("reset");
                $("#addModal").modal('show');

            });

            var table = $('#dataTable').DataTable({
                destroy: true,
                processing: true,

                serverSide: true,
                stateSave: true,

                ajax: "{{route('payment_method.index')}}",

                columns: [

                    {data: 'DT_RowIndex', name: 'id'},

                    {data: 'name', name: 'name'},
                    {data: 'state', name: 'state'},
                    {data: 'lang', name: 'lang'},

                    {data: 'action', name: 'action', orderable: false, searchable: false},

                ]

            });


            $("#addBtn").click(function (e) {
                e.preventDefault();

                $("#addBtn").html('<i class="fa fa-load"></i> ... ');
                $("#addBtn").attr('disabled',true);
                addNewRow("{{route('payment_method.store')}}", table);
            }); // end add new record


            $('body').on('click', '.edit', function () {

                $("#addBtn").html('تعديل');
                $("#myModalLabel").html('تعديل');
                $("#addModal").modal('show');

                var id = $(this).data('id');

                $.get("{{ route('payment_method.index') }}" + '/' + id + '/edit', function (data) {
                    $("#addBtn").html('تعديل');

                    $('#_id').val(data.id);

                    $('#name').val(data.name);
                    $('#enable').val(data.enable);
                    $('#lang').val(data.lang);

                })

            }) ;// end edit function;
            $('body').on('click', '.addTra', function () {

                $("#addBtn").html('{{__('sv')}}');
                $("#myModalLabel").html('{{__('add')}}');
                $("#addModal").modal('show');

                var id = $(this).data('id');
                $("#addBtn").html('{{__('sv')}}');

                $('#trans_id').val(id);

            }) ;// end edit function;


            //soft delete
            $('body').on('click', '.delete', function () {

                var id = $(this).data("id");
                var token = '{{csrf_token()}}';
                deleteRow("{{ route('payment_method.index')}}"+"/"+  id, table, token);

            });

        });

    </script>
@endpush


