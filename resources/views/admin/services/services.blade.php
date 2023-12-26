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
{{--            <button id="add" class="btn btn-primary"> {{__('add')}} </button> &nbsp;--}}
            <a class="card-header py-3" href={{ url('add_new_serv') }}>{{__('add serv')}}</a>

        </div>
        {{--</div>--}}
        <div class="col-sm-3 col-3">
            <fieldset class="form-group">

                <label for="roundText"> {{__('cat')}}  </label>
                <select id="cat_test" class="select_cat form-control" style="width: 100%"></select>

            </fieldset>
        </div>

        <div class="col-sm-1 col-1">
            <fieldset class="form-group">
                <br>
                <button class="btn btn-success" id="filterBtn">   <i class="fa fa-filter"></i> </button>



            </fieldset>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"> {{__('service')}}  </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                        <thead>
                            <tr>
                                <th> #</th>
                                <th>{{__('icon')}}</th>
                                <th>{{__('name')}}</th>
                                <th>{{__('pro')}}</th>
                                <th>{{__('details')}}</th>
                                <th>{{__('cat')}}</th>
                                <th>{{__('dur')}}</th>
                                <th>{{__('discount')}}</th>
                                <th>{{__('price')}}</th>
                                <th>{{__('un_price')}}</th>
                                <th>{{__('tax')}}</th>
                                <th>{{__('hint')}}</th>
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
                    <label class="modal-title text-text-bold-600" id="myModalLabel"> {{__('add')}}  </label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close font-medium-2 text-bold-700"></i></span>
                    </button>
                </div>
                <div class="container">
                <form action="{{ route('services.store') }}" method="POST" id="addForm">
                    <input type="hidden" name="_id" id="_id" >
{{--                    <input type="hidden" class="needsclick dropzone col-md-6 col-lg-6 col-xs-12 col-sm-6" id="document">--}}


                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="roundText">{{__('icon')}}</label>
                            <div class="row">
                                <div class="col-md-6 col-lg-6 col-xs-12 col-sm-6" id="icon"></div>
                                <div class="needsclick dropzone col-md-6 col-lg-6 col-xs-12 col-sm-6" id="document-dropzone"></div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="roundText">{{__('name ar')}} </label>
                            <input type="text" class="form-control" id="name_ar" name="name_ar">
                        </div>

                        <div class="form-group">
                            <label for="roundText">{{__('name en')}}</label>
                            <input type="text" class="form-control" id="name_en" name="name_en">
                        </div>

                        <div class="form-group">
                            <label for="roundText"> {{__('pro')}}</label>
                            <select name="provider_id" id="provider_id" class="form-control SlectBox">
                                <!--placeholder-->
                                <option value="" selected disabled>{{__('sel_pro')}}</option>
                                @foreach ($providers as $prov)
                                    <option value="{{ $prov->id }}"> {{ $prov->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="roundText">{{__('cat')}}</label>
                            <select name="cat_id" id="cat_id" class="form-control SlectBox">
                                <!--placeholder-->
                                <option value="" selected disabled>{{__('sel_cat')}}</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"> {{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="roundText">{{__('hint en')}}</label>
                            <input type="text" class="form-control" id="hint_en" name="hint_en" required>
                        </div>
                        <div class="form-group">
                            <label for="roundText">{{__('hint ar')}}</label>
                            <input type="text" class="form-control" id="hint_ar" name="hint_ar" required>
                        </div>
                        <div class="form-group">
                            <label for="roundText">{{__('details en')}}</label>
                            <input type="text" class="form-control" id="description_en" name="description_en" required>
                        </div>
                        <div class="form-group">
                            <label for="roundText">{{__('details ar')}}</label>
                            <input type="text" class="form-control" id="description_ar" name="description_ar" required>
                        </div>
                        <div class="form-group">
                            <label for="roundText">{{__('dur')}}</label>
                            <input type="time" class="form-control" id="duration" name="duration" required>
                        </div>

                        <div class="form-group">
                            <label for="roundText">{{__('price')}}</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>

                        <div class="form-group">
                            <label for="roundText">{{__('discount')}}</label>
                            <input type="number" class="form-control" id="discount" name="discount" required>
                        </div>
                        <div class="form-group">
                            <label for="roundText">{{__('tax')}}</label>
                            <input type="number" class="form-control" id="tax" name="tax" required>
                        </div>

                        <div class="form-group">
                            <label for="roundText">{{__('un_price')}}</label>
                            <input type="text" class="form-control" id="price_unit" name="price_unit" required>
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

        Dropzone.autoDiscover = false;
        var uploadedDocumentMap = {};
        var serviceDropZone  =   new Dropzone( "#document-dropzone", {
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function (file, response) {
                $('#addFormBtn').attr('disabled',false);
                $('#addForm').append('<input type="hidden" name="icon" value="' + response.name + '">')
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
                $('#addForm').find('input[name="icon"][value="' + name + '"]').remove()
            }, // end remove file

            url: '{{ route('projects.storeMedia',['table'=>"services"]) }}',
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

                 $('#_id').val('');
                 $("#addForm").trigger("reset");
                 $("#addModal").modal('show');
                 serviceDropZone.removeAllFiles(true);
                 $("#icon").html("");

             });

            var table = $('#dataTable').DataTable({
                destroy: true,
                processing: true,

                serverSide: true,
                stateSave: true,

                ajax: "{{route('services.index')}}",

                columns: [

                    {data: 'DT_RowIndex', name: 'id'},

                    {data: 'icon', name: 'icon'},
                    {data: 'name', name: 'name'},
                    {data: 'provider_id', name: 'provider_id'},
                    {data: 'description', name: 'description'},
                    {data: 'cat_id', name: 'cat_id'},
                    {data: 'duration', name: 'duration'},
                    {data: 'discount', name: 'discount'},
                    {data: 'price', name: 'price'},
                    {data: 'price_unit', name: 'price_unit'},
                    {data: 'tax', name: 'tax'},
                    {data: 'hint', name: 'hint'},

                    {data: 'action', name: 'action', orderable: false, searchable: false},

                ]

            });


            $("#addBtn").click(function (e) {
                e.preventDefault();

                $("#addBtn").html('<i class="fa fa-load"></i> ... ');
                $("#addBtn").attr('disabled',true);
                addNewRow("{{route('services_update')}}", table);
                $("#addBtn").html('{{__('edit')}}');

            }); // end add new record


            $('body').on('click', '.edit', function () {


                $("#addModal").modal('show');
                serviceDropZone.removeAllFiles(true);

                var id = $(this).data('id');

                $.get("{{ route('services.index') }}" + '/' + id + '/edit', function (data) {

                   $('#_id').val(data.id);

                    $('#name_ar').val(data.name);
                    $('#name_en').val(data.name);
                    $('#provider_id').val(data.provider_id);
                    $('#hint_en').val(data.hint);
                    $('#hint_ar').val(data.hint);
                    $('#description_en').val(data.description);
                    $('#description_ar').val(data.description);
                    $('#cat_id').val(data.cat_id);
                    $('#price').val(data.price);
                    $('#price_unit').val(data.price_unit);
                    $('#duration').val(data.duration);
                    $('#discount').val(data.discount);
                    $('#tax').val(data.tax);

                    $("#icon").html('');

                    if(data.icon != null && data.icon.length > 5) {

                        var icon = data.icon;
                        var basic_list_group = "";
                        var asset_url = '';

                        basic_list_group += "<div class=\"col-xl-3 col-md-6 col-12\">\n" +
                            "                                                   <h4 class=\"card-title\">\n" +

                            "                                    <input type=\"hidden\" name=\"icon\" value='" + icon + "'>\n" +

                            "                                                       <p class=\"m-0\">\n" +
                            "                                                           <img  id='" + icon + "' src='" + asset_url +"/"+ icon + "' width=\"120\" height=\"120\">\n" +
                            "                                                       </p>\n" +
                            "\n" +
                            "                                                   </h4>\n" +
                            "                                               </div>\n" +
                            "                                               <div class=\"card-content\">\n" +
                            // "                                                   <div class=\"card-body\">\n" +
                            // "<button data-img='" + icon + "' data-id='" + data.id + "' class='btn btn-danger deleteImg' >  <i class='fa fa-trash'></i> </button>" +
                            // "\n" +
                            // "                                                   </div>\n" +
                            "                                       </div>";

                        $("#icon").html(basic_list_group);
                        // $("#document").val(data.icon);
                    }
                })


            }) ;// end edit function;

            $("#filterBtn").on('click', function (e) {


                var cat_id = $(".select_cat").val();


                table.clear();
                table = $('#dataTable').DataTable({
                    destroy: true,
                    processing: true,

                    serverSide: true,
                    stateSave: true,

                    {{--ajax: "{{ url('filter/products') }}/"+type_send+"/"+cat_id,--}}
                    ajax: "{{ url('filter/service') }}"+"/"+cat_id ,

                    columns: [

                        {data: 'DT_RowIndex', name: 'id'},

                        {data: 'icon', name: 'icon'},
                        {data: 'name', name: 'name'},
                        {data: 'provider_id', name: 'provider_id'},
                        {data: 'description', name: 'description'},
                        {data: 'cat_id', name: 'cat_id'},
                        {data: 'duration', name: 'duration'},
                        {data: 'discount', name: 'discount'},
                        {data: 'price', name: 'price'},
                        {data: 'price_unit', name: 'price_unit'},
                        {data: 'tax', name: 'tax'},
                        {data: 'hint', name: 'hint'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},

                    ]

                });


            });

            //soft delete
            $('body').on('click', '.delete', function () {

                var id = $(this).data("id");
                var token = '{{csrf_token()}}';
                deleteRow("{{ route('services.index')}}"+"/"+  id, table, token);

            });

        });

        $(document).ready(function() {
            // alter($cats);
            $('.select_cat').select2({

                // dropdownParent: $('#addForm'),
                placeholder: 'select category',
                // multiple:true,
                // maximumSelectionLength:1,
                // formatSelectionTooBig: function (limit) {
                //     return 'Too many selected items';
                // },


                data: [
                        @foreach ($categories as $ca)
                    { id: '{{$ca->id}}', text: '{{$ca->name}}' },
                    @endforeach
                ]
            });
        });

    </script>
    @endpush


