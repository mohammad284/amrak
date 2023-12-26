@extends('admin_layout')
{{----}}

@section('content')
<h4 id="default"></h4>
    <div class="example">
      <ul class="nav nav-tabs" id="" role="">
      <li class="nav-item">
          <a class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" role="tab" aria-controls="home" aria-selected="true">{{__('add cat')}}</a>
        </li>

      </ul>
      <div class="tab-content border border-top-0 p-3" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
                <form action="" method="post" id="addForm">
                    <input type="hidden" name="_id" id="_id" >
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <fieldset class="form-group">
                        <label for="roundText"> {{__('name ar')}} </label>
                        <input type="text" name="name_ar" id="name_ar" placeholder="" class="form-control" required>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="roundText"> {{__('name en')}} </label>
                        <input type="text" name="name_en" id="name_en" placeholder="" class="form-control" required>
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

                    <fieldset class="form-group">
                        <label for="roundText">{{__('ft_col')}}</label>
                        <select name="font_color" id="font_color" class="form-control SlectBox">
                            <!--placeholder-->
                            <option value="" selected disabled>{{__('sel_col')}}</option>
                            @foreach ($colors as $cat)
                                <option value="{{ $cat->id }}"> {{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </fieldset>
                </div>
                <div class="col-md-6" style="margin-top:30px ;">

                {{--                    </fieldset> --}}
                    <fieldset class="form-group">
                        <select name="featured" id="featured" class="form-control SlectBox">
                            <!--placeholder-->
                            <option value="" selected disabled>{{__('state')}}</option>

                            <option value="1"> {{__('feat')}}</option>
                            <option value="0"> {{__('unfeat')}}</option>

                        </select>
                    </fieldset>

                    <fieldset class="form-group">
                        <label for="roundText"> {{__('cat_par')}}  </label>
                        <select class="select_cat form-control" id="parent_id" name="parent_id" >

                        </select>


                    </fieldset>
                <br>
                <div class="form-group">
                    <label for="roundText">{{__('icon')}}</label>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12" id="icon"></div>
                            <div class="needsclick dropzone col-md-12 col-lg-12 col-xs-12 col-sm-12" id="document-dropzone"></div>
                        </div>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
{{--                    <input type="reset" class="btn bg-light-secondary" data-dismiss="modal" value="إغلاق">--}}
                    <input type="submit" id="addBtn" class="btn btn-primary" value="{{__('sv')}}">
                </div>


            </div>

        </form>
          </div>
        </div>
    </div>
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
                console.log(response);
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
                    {data: 'background_color', name: 'background_color'},
                    {data: 'font_color', name: 'font_color'},
                    {data: 'featured', name: 'featured'},
                    {data: 'parent', name: 'parent'},
                    // {data: 'lang', name: 'lang'},


                    {data: 'action', name: 'action', orderable: false, searchable: false},

                ]

            });



            $("#addBtn").click(function (e) {
                e.preventDefault();

                $("#addBtn").html('<i class="fa fa-load"></i> ... ');
                $("#addBtn").attr('disabled',true);
                addNewRow("{{route('categories.store')}}", table);
            });


        });
        $(document).ready(function() {
            // alter($cats);
            $('.select_cat').select2({

                dropdownParent: $('#addForm'),
                placeholder: '{{__('ser_cat')}}',
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
