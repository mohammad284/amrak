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
            <button id="add" class="btn btn-primary">{{__('add')}} </button> &nbsp;
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"> {{__('slider')}}  </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                        <thead>
                            <tr>
                            <tr>
                                <th>#</th>
                                <th>{{__('txt')}}</th>
                                <th>{{__('btn')}}  </th>
                                <th>{{__('icon')}}  </th>
                                <th>{{__('txt_col')}}  </th>
                                <th>{{__('btn_col')}}</th>
                                <th>{{__('bg_col')}}  </th>
                                <th>{{__('ind_col')}}</th>
{{--                                <th>{{__('state')}}  </th>--}}
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

    <!--add Service-->
    @if($lang === 'ar')
        <div class="modal fade text-right" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            @elseif($lang === 'en')
                <div class="modal fade text-left" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    @endif
                    <div class="modal-dialog modal-xs" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <label class="modal-title text-text-bold-600" id="myModalLabel">{{__('add')}} </label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close font-medium-2 text-bold-700"></i></span>
                    </button>
                </div>
                <div class="container">
                <form action="{{ route('sliders.store') }}" method="POST" id="addForm">
                    <input type="hidden" name="_id" id="_id" >

                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="roundText">{{__('icon')}}</label>
                            <div id="image_service" name="image_service">
                            </div>
                            <div class="needsclick dropzone" id="document-dropzone"></div>


                        <div class="col-md-12">
                            <label> {{__('txt')}} </label>
                            <div class="form-group">
                                <input type="text" name="text" id="text" placeholder="" class="form-control" required>
                            </div>
                            <label> {{__('btn')}} </label>
                            <div class="form-group">
                                <input type="text" name="btn" id="btn" placeholder="" class="form-control" required>
                            </div>
{{--                            <div class="card">--}}
                                <div class="form-group">
                                    <label for="roundText">{{__('bg_col')}}</label>
                                    <input type="text" data-jscolor="{}" id="background_color" name="background_color" class="form-control" placeholder=" ">
                                </div>
                            <div class="form-group">
                                <label for="roundText">{{__('btn_col')}}</label>
                                <input type="text" data-jscolor="{}" id="btn_color" name="btn_color" class="form-control" placeholder=" ">
                            </div>
                            <div class="form-group">
                                <label for="roundText">{{__('txt_col')}}</label>
                                <input type="text" data-jscolor="{}" id="text_color" name="text_color" class="form-control" placeholder=" ">
                            </div>
                                <div class="form-group">
                                <label for="roundText">{{__('ind_col')}}</label>
                                <input type="text" data-jscolor="{}" id="indicator_color" name="indicator_color" class="form-control" placeholder=" ">
                            </div>
                        </div>
{{--                        <div class="form-group">--}}
{{--                            <label for="roundText">اللغة</label>--}}
{{--                            <select name="lang" id="lang" class="form-control SlectBox">--}}
{{--                                <!--placeholder-->--}}
{{--                                <option value="" selected disabled>اختر لغة</option>--}}
{{--                                    <option value="ar"> عربي</option>--}}
{{--                                    <option value="en"> انكليزي</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}

{{--                    </div>--}}
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="addBtn">{{__('sv')}}</button>
                        <button type="reset" id="close" class="btn btn-danger" data-dismiss="modal">{{__('ext')}}</button>
                    </div>
                        </div>
                    </div>

                </form>

    </div>
  </div>
@endsection

@push('pageJs')
    <script type="text/javascript">

        Dropzone.autoDiscover = false;
        var uploadedDocumentMap = {};
        var serviceDropZone  =   new Dropzone( "#document-dropzone", {
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function (file, response) {
                $('#addFormBtn').attr('disabled',false);
                $('#addForm').append('<input type="hidden" name="image_service" value="' + response.name + '">')
                uploadedDocumentMap[file.name] = response.name

            },  // end auccess
            removedfile: function (file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedDocumentMap[file.name]
                }
                $('#addForm').find('input[name="image_service"][value="' + name + '"]').remove()
            }, // end remove file

            url: '{{ route('projects.storeMedia',['table'=>"sliders"]) }}',
            maxFilesize: 8, // MB
            addRemoveLinks: true,
            timeout:0,
            acceptedFiles: ".jpg, .png",
            init: function() {
                // this.on( 'removedfile', removedFileCallback );

            }, // end init

        } ); // end dropzone.

        $(function () {

             $("#add").click(function () {
                 // $("#addBtn").html('حفظ');
                 $('#_id').val('');
                 $("#addForm").trigger("reset");
                 $("#addModal").modal('show');
                 serviceDropZone.removeAllFiles(true);
                 $("#image_service").html("");

             });

            var table = $('#dataTable').DataTable({
                destroy: true,
                processing: true,

                serverSide: true,
                stateSave: true,

                ajax: "{{route('sliders.index')}}",

                columns: [

                    {data: 'DT_RowIndex', name: 'id'},


                    {data: 'text', name: 'text'},
                    {data: 'btn', name: 'btn'},
                    {data: 'image_service', name: 'image_service'},
                    {data: 'text_color', name: 'text_color'},
                    {data: 'btn_color', name: 'btn_color'},
                    {data: 'background_color', name: 'background_color'},
                    {data: 'indicator_color', name: 'indicator_color'},
                    // {data: 'enable', name: 'enable'},


                    {data: 'action', name: 'action', orderable: false, searchable: false},

                ]

            });


            $("#addBtn").click(function (e) {
                e.preventDefault();

                $("#addBtn").html('<i class="fa fa-load"></i> ... ');
                $("#addBtn").attr('disabled',true);
                addNewRow("{{route('sliders.store')}}", table);
            }); // end add new record


            $('body').on('click', '.edit', function () {

                // $("#addBtn").html('تعديل');
                $("#addModal").modal('show');
                serviceDropZone.removeAllFiles(true);

                var id = $(this).data('id');

                $.get("{{ route('sliders.index') }}" + '/' + id + '/edit', function (data) {
                    // $("#addBtn").html('edit');

                    $('#_id').val(data.id);

                    $('#text').val(data.text);
                    $('#btn').val(data.btn);
                    $('#text_color').val(data.text_color);
                    $('#btn_color').val(data.btn_color);
                    $('#background_color').val(data.background_color);
                    $('#indicator_color').val(data.indicator_color);
                    $("#image_service").html('');

                    if(data.image_service != null && data.image_service.length > 5) {

                        var image_service = data.image_service;
                        var basic_list_group = "";
                        var asset_url = '{{asset('/storage/')}}';

                        basic_list_group += "<div class=\"col-xl-3 col-md-6 col-12\">\n" +
                            "                                           <div class=\"card draggable\">\n" +
                            "                                               <div class=\"card-header\">\n" +
                            "                                                   <h4 class=\"card-title\">\n" +

                            "                                    <input type=\"hidden\" name=\"image_service\" value='" + image_service + "'>\n" +

                            "                                                       <p class=\"m-0\">\n" +
                            "                                                           <img  id='" + image_service + "' src='" + asset_url +"/"+ image_service + "' width=\"100\" height=\"100\">\n" +
                            "                                                       </p>\n" +
                            "\n" +
                            "                                                   </h4>\n" +
                            "                                               </div>\n" +
                            "                                               <div class=\"card-content\">\n" +
                            // "                                                   <div class=\"card-body\">\n" +
                            // "<button data-img='" + image_service + "' data-id='" + data.id + "' class='btn btn-danger deleteImg' >  <i class='fa fa-trash'></i> </button>" +
                            // "\n" +
                            // "                                                   </div>\n" +
                            "                                               </div>\n" +
                            "                                           </div>\n" +
                            "                                       </div>";

                        $("#image_service").html(basic_list_group);
                    }
                })


            }) ;// end edit function;


            //soft delete
            $('body').on('click', '.delete', function () {

                var id = $(this).data("id");
                var token = '{{csrf_token()}}';
                deleteRow("{{ route('sliders.index')}}"+"/"+  id, table, token);

            });

        });

    </script>
    @endpush


