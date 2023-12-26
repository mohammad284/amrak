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
                <h6 class="m-0 font-weight-bold text-primary"> {{__('acc-book')}} </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                        <thead>
                            <tr>
                                <th> #</th>
                                <th>{{__('serv')}}</th>
                                <th>{{__('user')}}</th>
                                <th>{{__('pro')}}</th>
                                <th>{{__('addr')}}</th>
                                <th>{{__('st_book')}}</th>
                                <th>{{__('st_pay')}}</th>
                                <th>{{__('coupon')}}</th>
                                <th>{{__('total')}}</th>
                                <th>{{__('date')}}</th>
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

    <!--add Service-->
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
                <form action="" method="POST" id="addForm">
                    <input type="hidden" name="_id" id="_id" >

                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="roundText">{{__('st_book')}}</label>

                            <select name="booking_state_id" id="booking_state_id" class="form-control SlectBox">
                                <!--placeholder-->
                                <option value="" selected disabled>{{__('sel_st_bp')}}</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}"> {{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="addBtn">{{__('sv')}}</button>
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

                ajax: "{{url('accepted/bookings')}}",

                columns: [

                    {data: 'DT_RowIndex', name: 'id'},

                    {data: 'service_id', name: 'service_id'},
                    {data: 'customer_id', name: 'customer_id'},
                    {data: 'provider_id', name: 'provider_id'},
                    {data: 'address', name: 'address'},
                    {data: 'booking_state_id', name: 'booking_state_id'},
                    {data: 'payment_state_id', name: 'payment_state_id'},
                    {data: 'coupon_id', name: 'coupon_id'},
                    {data: 'total', name: 'total'},
                    {data: 'book_date', name: 'book_date'},

                    {data: 'action', name: 'action', orderable: false, searchable: false},

                ]

            });


            $("#addBtn").click(function (e) {
                e.preventDefault();

                $("#addBtn").html('<i class="fa fa-load"></i> ... ');
                $("#addBtn").attr('disabled',true);
                addNewRow("{{route('bookings.store')}}", table);
            }); // end add new record


            $('body').on('click', '.edit', function () {

                $("#addBtn").html('{{__('edit')}}');
                $("#addModal").modal('show');

                var id = $(this).data('id');

                $.get("{{ route('bookings.index') }}" + '/' + id + '/edit', function (data) {

                    $('#_id').val(data.id);

                    $('#booking_state_id').val(data.booking_state_id);

                });// end edit function;
            });


            //soft delete
            $('body').on('click', '.delete', function () {

                var id = $(this).data("id");
                var token = '{{csrf_token()}}';
                deleteRow("{{ route('bookings.index')}}"+"/"+  id, table, token);

            });


            $('body').on('click', '.reject', function () {

                var booking_id = $(this).data("id");

                var co = confirm("{{__('inform-rej')}}");
                if (!co) {
                    return;
                }

                $.ajax({
                    data: {
                        "_token":$("input[name=_token]").val(),
                        "accept": 0
                    },
                    type: "POST",

                    url: "{{ url('agree/booking') }}" + '/' + booking_id,

                    success: function (data) {
                        successMessage();
                        table.draw(false);
                    },

                    error: function (data) {
                        errorMessage(data);

                    }

                });

            });

        });

    </script>
    @endpush


