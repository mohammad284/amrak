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

            <div class="row m-2"></div>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"> {{__('user addr')}} </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>

                                <th> #</th>
                                <th>{{__('user name')}}</th>
                                <th>{{__('name')}}</th>
                                <th>{{__('addr')}}</th>
                                <th>{{__('ltud')}}</th>
                                <th>{{__('lgtu')}}</th>
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

@endsection

@push('pageJs')
    <script type="text/javascript">

        $(function () {



            var table = $('#dataTable').DataTable({
                destroy: true,
                processing: true,

                serverSide: true,
                stateSave: true,

                ajax: "{{route('user_address.index')}}",

                columns: [

                    {data: 'DT_RowIndex', name: 'id'},
                    {data: 'customer', name: 'customer'},
                    {data: 'name', name: 'name'},
                    {data: 'address', name: 'address'},
                    {data: 'longitude', name: 'longitude'},
                    {data: 'latitude', name: 'latitude'},

                    {data: 'action', name: 'action', orderable: false, searchable: false},

                ]

            });





            //soft delete
            $('body').on('click', '.delete', function () {

                var id = $(this).data("id");
                var token = '{{csrf_token()}}';
                deleteRow("{{ route('user_address.index')}}"+"/"+  id, table, token);

            });

        });

    </script>
@endpush


