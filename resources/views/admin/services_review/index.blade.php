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

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{__('serv review')}} </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                        <thead>
                                        <tr>

                                            <th>#</th>
                                            <th>{{__('serv')}}</th>
                                            <th>{{__('comm')}}</th>
                                            <th>{{__('rate')}}</th>
                                            <th >{{__('operate')}}</th>

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
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

               var table =  $('#dataTable').DataTable({

                   destroy: true,
                   processing: true,

                   serverSide: true,
                   stateSave: true,
                    ajax: "{{ route('services_review.index') }}",
                    // dd(data)
                    columns: [
                        { data: 'id', name: 'id' },
                        { data: 'service_id', name: 'service_id' },
                        { data: 'review', name: 'review' },
                        { data: 'rate', name: 'rate' },
                        // { data: 'available', name: 'available' },

                        {data: 'action', name: 'action', orderable: true},
                    ],
                    order: [[0, 'desc']]
                });


             $('body').on('click', '.accept', function () {

                 var user_id = $(this).data("id");

                 var co = confirm("  هل أنت متأكد من  القبول  !");
                 if (!co) {
                     return;
                 }

                 $.ajax({
                     data: {
                         "_token":$("input[name=_token]").val(),
                         "accept": 1
                     },
                     type: "POST",

                     url: "{{ url('agree/review') }}" + '/' + user_id,

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

                 var co = confirm("  هل أنت متأكد من الرفض!");
                 if (!co) {
                     return;
                 }

                 $.ajax({
                     data: {
                         "_token":$("input[name=_token]").val(),
                         "accept": 0
                     },
                     type: "POST",

                     url: "{{ url('agree/review') }}" + '/' + user_id,

                     success: function (data) {
                         successMessage();
                         table.draw(false);
                     },

                     error: function (data) {
                         errorMessage(data);

                     }

                 });

             });


             $('body').on('click', '.delete', function () {

                 var id = $(this).data("id");
                 var token = '{{csrf_token()}}';
                 deleteRow("{{ route('services_review.index')}}"+"/"+  id, table, token);

             });
            });


        </script>

    @endpush
