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


        <div class="card-header py-3">
{{--            <a id="" href="{{url('add_new')}}"> {{__('add cat')}} </a> &nbsp;--}}
            <a class="card-header py-3" href={{ url('add_new') }}>{{__('add cat')}}</a>
        </div>



            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"> {{__('cats')}}  </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="90%" cellspacing="0">

                            <thead>

                            <tr>
                                <th>#</th>
                                <th>{{__('name')}}</th>
                                <th>{{ __('icon') }}  </th>
                                <th>{{ __('color') }}  </th>
                                <th>{{__('bg_col')}}</th>
                                <th>{{__('ft_col')}} </th>
                                <th>{{__('state')}}  </th>
                                <th>{{__('cat_pa')}} </th>
{{--                                <th>اللغة  </th>--}}
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
        <!-- Begin Page Content -->
    </section>

    @if($lang === 'ar')
        <div class="modal fade text-right" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            @elseif($lang === 'en')
                <div class="modal fade text-left" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    @endif
                    <div class="modal-dialog modal-xs" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <label class="modal-title text-text-bold-600" id="myModalLabel33"> {{__('add')}}  </label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-close font-medium-2 text-bold-700"></i></span>
                    </button>
                </div>
                <div class="container">
                    <form action="" method="post" id="addForm">
                        <input type="hidden" name="_id" id="_id" >
                        <input type="hidden" name="trans_id" id="trans_id" >
                        @csrf

                        <div class="row">
                        <div class="col-md-6">
                        <fieldset class="form-group">
                            <label for="roundText"> {{__('name ar')}}  </label>
                            <input type="text" name="name_ar" id="name_edit_ar" placeholder="" class="form-control" required>
                            <div id="img-list">

                            </div>
                        </fieldset>
                        <fieldset class="form-group">
                            <label for="roundText"> {{__('name en')}}  </label>
                            <input type="text" name="name_en" id="name_edit_en" placeholder="" class="form-control" required>
                            <div id="img-list">

                            </div>
                        </fieldset>
                            <div class="form-group">
                                <label for="roundText">{{__('col')}}</label>
                                <select name="color_id" id="color_id" class="form-control SlectBox">
                                    <!--placeholder-->
                                    <option value="" selected disabled>{{__('sel_col')}}</option>
                                    @foreach ($colors as $cat)
                                        <option value="{{ $cat->id }}"> {{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="roundText">{{__('bg_col')}}</label>
                                <select name="background_color" id="background_color" class="form-control SlectBox">
                                    <!--placeholder-->
                                    <option value="" selected disabled>{{__('sel_col')}}</option>
                                    @foreach ($colors as $cat)
                                        <option value="{{ $cat->id }}"> {{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="roundText">{{__('ft_col')}}</label>
                                <select name="font_color" id="font_color" class="form-control SlectBox">
                                    <!--placeholder-->
                                    <option value="" selected disabled>{{__('sel_col')}}</option>
                                    @foreach ($colors as $cat)
                                        <option value="{{ $cat->id }}"> {{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <fieldset class="form-group">
                                <select name="featured" id="featured" class="form-control SlectBox">
                                    <!--placeholder-->
                                    <option value="" selected disabled>{{__('state')}}</option>

                                    <option value="1"> {{__('feat')}}</option>
                                    <option value="0"> {{__('un_feat')}}</option>

                                </select>
                            </fieldset>

                            <fieldset class="form-group">
                                <label for="roundText"> {{__('cat_pa')}}</label>
                                <select class="select_cat form-control" id="parent_id" name="parent_id" >

                                </select>


                            </fieldset>
                        </div>
                        <br>
                            <div class="form-group">
                                <label for="roundText">{{__('icon')}}</label>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6 col-lg-6 col-xs-12 col-sm-6" id="icon"></div>
                                        <div class="needsclick dropzone col-md-6 col-lg-6 col-xs-12 col-sm-6" id="document-dropzone"></div>
                                    </div>

                                </div>

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
    {{--dropzone--}}
    <script>
        Dropzone.autoDiscover = false;
        var uploadedDocumentMap = {};
        var serviceDropZone  =   new Dropzone( "#document-dropzone", {
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function (file, response) {
                $('#addBtn').attr('disabled',false);
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

            url: '{{ route('projects.storeMedia',['table'=>"categories"]) }}',
            maxFilesize: 8, // MB
            addRemoveLinks: true,
            timeout:0,
            acceptedFiles: ".jpg, .png",
            init: function() {
                // this.on( 'removedfile', removedFileCallback );

            }, // end init

        } ); // end dropzone.
    </script>
    <script type="text/javascript">

        $(function () {

            $("#add").click(function (e) {
                e.preventDefault();
                $("#addBtn").html("{{__('add')}}");
                $("#title").html({{__('add')}});
                $('#_id').val('') ;
                $('#addForm').trigger("reset");
                $("#addModal").modal("show");
                serviceDropZone.removeAllFiles(true);
                $("#icon").html("");
                $("#document-dropzone").html("");
            });
            var table = $('#dataTable').DataTable({

                destroy: true,
                processing: true,

                serverSide: true,
                stateSave: true,

                ajax: "{{ route('categories.index') }}",

                columns: [

                    {data: 'DT_RowIndex', name: 'id'},

                    {data: 'name', name: 'name'},
                    {data: 'icon', name: 'icon'},
                    {data: 'color', name: 'color'},
                    {data: 'background', name: 'background'},
                    {data: 'font', name: 'font'},
                    {data: 'state', name: 'state'},
                    {data: 'parent', name: 'parent'},
                    // {data: 'lang', name: 'lang'},


                    {data: 'action', name: 'action', orderable: false, searchable: false},

                ]

            });


            $('body').on('click', '.edit', function () {

                var product_id = $(this).data('id');

                $('#addForm').trigger("reset");

                // $("#icon").html("");
                serviceDropZone.removeAllFiles(true);
                $.get("{{ route('categories.index') }}" + '/' + product_id + '/edit', function (data) {

                    $("#addModal").modal('show');

                    $("#addBtn").val('{{__('sv')}}');
                    $('#_id').val(data.id);
                    $('#name_edit_ar').val(data.name);
                    $('#name_edit_en').val(data.name);
                    $('#color_id').val(data.color_id);
                    $('#font_color').val(data.font_color);
                    $('#background_color').val(data.background_color);
                    $('#featured').val(data.featured);
                    $('#parent_id').val(data.parent_id);

                    $('#lang').val(data.lang);
                    {{--var icon_s = "<img src='{{asset('/storage')}}/"+data.icon+"' width='100' height='100'>";--}}

                    // $("#document-dropzone").html(icon_s);


                    $("#icon").html('');

                    if(data.icon != null && data.icon.length > 5) {

                        var icon = data.icon;
                        var basic_list_group = "";
                        var asset_url = '';

                        basic_list_group += "<div class=\"col-xl-3 col-md-6 col-12\">\n" +
                            "                                                   <h4 class=\"card-title\">\n" +

                            "                                    <input type=\"hidden\" name=\"icon\" value='" + icon + "'>\n" +

                            "                                                       <p class=\"m-0\">\n" +
                            "                                                           <img  id='" + icon + "' src='" + asset_url + "/" + icon + "' width=\"120\" height=\"120\">\n" +
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
                    }
                })



            }) ;// end edit function;

     // end save  record data
            $("#addBtn").click(function (e) {
                e.preventDefault();

                $("#addBtn").html('<i class="fa fa-load"></i> ... ');
                $("#addBtn").attr('disabled',true);
                addNewRow("{{route('update_cat')}}", table);
                $("#addBtn").html('{{__('edit')}}');

            });



            $('body').on('click', '.delete', function () {

                var id = $(this).data("id");
                var token = '{{csrf_token()}}';
                deleteRow("{{ route('categories.index')}}"+"/"+  id, table, token);

            });


        });
        $(document).ready(function() {
            // alter($cats);
            $('.select_cat').select2({

                dropdownParent: $('#addForm'),
                placeholder: 'search category',
                multiple:true,
                maximumSelectionLength:1,
                formatSelectionTooBig: function (limit) {
                    return 'Too many selected items';
                },

                data: [
                        @foreach ($cats as $ca)
                    { id: '{{$ca->id}}', text: '{{$ca->name}}' },
                    @endforeach
                ]
            });
        });

    </script>

@endpush
