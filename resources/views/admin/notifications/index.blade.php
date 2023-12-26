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

            <!-- Page Heading -->

            <div class="row m-2"></div>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"> {{__('us_notify')}}  </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th> #</th>
                                <th>{{__('user')}}</th>
                                <th>{{__('pro')}}</th>
                                <th>{{__('title')}}</th>
                                <th>{{__('details')}}</th>
{{--                                <th>{{__('date')}}</th>--}}
{{--                                <th>{{__('state')}}</th>--}}
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

                ajax: "{{route('notify.index')}}",

                columns: [

                    {data: 'DT_RowIndex', name: 'id'},
                    {data: 'customer', name: 'customer'},
                    {data: 'provider', name: 'provider'},
                    {data: 'title', name: 'title'},
                    {data: 'details', name: 'details'},
                    // {data: 'date', name: 'date'},
                    // {data: 'state', name: 'state'},

                    {data: 'action', name: 'action', orderable: false, searchable: false},

                ]

            });





            //soft delete
            $('body').on('click', '.delete', function () {

                var id = $(this).data("id");
                var token = '{{csrf_token()}}';
                deleteRow("{{ route('notify.index')}}"+"/"+  id, table, token);

            });

        });

    </script>
@endpush


