@extends("admin_layout")
<?php
$lang = Session('locale');
if ($lang != "en") {
    $lang = "ar";
}
?>


@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
    <section id="input-style">
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800"></h1>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"> {{__('acc_prov')}} </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('name')}}</th>
                            <th>{{__('email')}} </th>
                            <th> {{__('mobile')}}</th>
                            <th> {{__('address')}}  </th>
                            <th> {{__('icon')}} </th>
                            <th> {{__('available')}} </th>
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
                    <form action="{{ route('providers.store') }}" method="POST" id="addForm">
                        <input type="hidden" name="_id" id="_id" >

                        @csrf
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="roundText">{{__('name')}}</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>

                            <div class="form-group">
                                <label for="roundText">{{__('mob')}}</label>
                                <input type="number" class="form-control" id="mobile" name="mobile">

                            </div>

                            <div class="form-group">
                                <label for="roundText">{{__('mail')}}</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>


                            <div class="form-group">
                                <label for="roundText">{{__('available')}}</label>
                                <select name="available" id="available" class="form-control SlectBox">
                                    <!--placeholder-->
                                    <option value="" selected disabled>{{__('sel_st')}}</option>
                                    <option value="1"> {{__('available')}}</option>
                                    <option value="0">{{__('un_available')}}</option>
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

{{--        Dropzone.autoDiscover = false;--}}
{{--        var uploadedDocumentMap = {};--}}
{{--        var serviceDropZone  =   new Dropzone( "#document-dropzone", {--}}
{{--            headers: {--}}
{{--                'X-CSRF-TOKEN': "{{ csrf_token() }}"--}}
{{--            },--}}
{{--            success: function (file, response) {--}}
{{--                $('#addFormBtn').attr('disabled',false);--}}
{{--                $('#addForm').append('<input type="hidden" name="icon" value="' + response.name + '">')--}}
{{--                uploadedDocumentMap[file.name] = response.name--}}

{{--            },  // end auccess--}}
{{--            removedfile: function (file) {--}}
{{--                file.previewElement.remove()--}}
{{--                var name = ''--}}
{{--                if (typeof file.file_name !== 'undefined') {--}}
{{--                    name = file.file_name--}}
{{--                } else {--}}
{{--                    name = uploadedDocumentMap[file.name]--}}
{{--                }--}}
{{--                $('#addForm').find('input[name="icon"][value="' + name + '"]').remove()--}}
{{--            }, // end remove file--}}

{{--            url: '{{ route('projects.storeMedia',['table'=>"providers"]) }}',--}}
{{--            maxFilesize: 8, // MB--}}
{{--            addRemoveLinks: true,--}}
{{--            timeout:0,--}}
{{--            acceptedFiles: ".jpg, .png",--}}
{{--            init: function() {--}}
{{--                // this.on( 'removedfile', removedFileCallback );--}}

{{--            }, // end init--}}

{{--        } ); // end dropzone.--}}

        $(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var table = $('#dataTable').DataTable({

                    destroy: true,
                    processing: true,
                    serverSide: true,
                    stateSave: true,
                    ajax: "{{ url('accepted/providers') }}",
                    // dd(data)
                    columns: [
                        { data: 'id', name: 'id' },
                        { data: 'name', name: 'name' },
                        { data: 'email', name: 'email' },
                        { data: 'mobile', name: 'mobile' },
                        { data: 'address', name: 'address' },
                        { data: 'icon', name: 'icon' },
                        { data: 'available', name: 'available' },

                        {data: 'action', name: 'action', orderable: true},
                    ],
                    order: [[0, 'desc']]

                });
    $("#addBtn").click(function (e) {
        e.preventDefault();

        $("#addBtn").html('<i class="fa fa-load"></i> ... ');
        $("#addBtn").attr('disabled',true);
        addNewRow("{{route('providers.store')}}", table);
    }); // end add new record

    $('body').on('click', '.edit', function () {


                 $("#addModal").modal('show');
                 // serviceDropZone.removeAllFiles(true);

                 var id = $(this).data('id');

                 $.get("{{ route('providers.index') }}" + '/' + id + '/edit', function (data) {
                     $("#addBtn").html('تعديل');

                     $('#_id').val(data.id);

                     $('#name').val(data.name);
                     $('#email').val(data.email);
                     $('#mobile').val(data.mobile);
                     $('#address').val(data.address);
                     $('#available').val(data.available);
                     {{--$("#icon").html('');--}}

                     {{--if(data.icon != null && data.icon.length > 5) {--}}

                     {{--    var icon = data.icon;--}}
                     {{--    var basic_list_group = "";--}}
                     {{--    var asset_url = '{{asset('/storage/')}}';--}}

                     {{--    basic_list_group += "<div class=\"col-xl-3 col-md-6 col-12\">\n" +--}}
                     {{--        "                                                   <h4 class=\"card-title\">\n" +--}}

                     {{--        "                                    <input type=\"hidden\" name=\"offer_image\" value='" + icon + "'>\n" +--}}

                     {{--        "                                                       <p class=\"m-0\">\n" +--}}
                     {{--        "                                                           <img  id='" + icon + "' src='" + asset_url +"/"+ icon + "' width=\"120\" height=\"120\">\n" +--}}
                     {{--        "                                                       </p>\n" +--}}
                     {{--        "\n" +--}}
                     {{--        "                                                   </h4>\n" +--}}
                     {{--        "                                               </div>\n" +--}}
                     {{--        "                                               <div class=\"card-content\">\n" +--}}
                     {{--        // "                                                   <div class=\"card-body\">\n" +--}}
                     {{--        // "<button data-img='" + icon + "' data-id='" + data.id + "' class='btn btn-danger deleteImg' >  <i class='fa fa-trash'></i> </button>" +--}}
                     {{--        // "\n" +--}}
                     {{--        // "                                                   </div>\n" +--}}
                     {{--        "                                       </div>";--}}

                     {{--    $("#icon").html(basic_list_group);--}}
                     {{--}--}}
                 })


             }) ;// end edit function;

    $('body').on('click', '.reject', function () {

                 var provider_id = $(this).data("id");

                 var co = confirm("  are you ready to reject !");
                 if (!co) {
                     return;
                 }

                 $.ajax({
                     data: {
                         "_token":$("input[name=_token]").val(),
                         "accept": 0
                     },
                     type: "POST",

                     url: "{{ url('agree/provider') }}" + '/' + provider_id,

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
                 deleteRow("{{ route('providers.index')}}"+"/"+  id, table, token);

             });
            });

        </script>

    @endpush
