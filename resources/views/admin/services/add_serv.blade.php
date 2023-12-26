@extends('admin_layout')
<?php
$lang = Session('locale');
if ($lang != "en") {
    $lang = "ar";
}
?>
@section('content')
<h4 id="default"></h4>
    <div class="example">
      <ul class="nav nav-tabs" id="" role="">
      <li class="nav-item">
          <a class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" role="tab" aria-controls="home" aria-selected="true">{{__('add serv')}}</a>
        </li>

      </ul>
      <div class="tab-content border border-top-0 p-3" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
                <form action="{{ route('services.store') }}" method="POST" id="addForm">
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
                        <label for="roundText">{{__('pro')}}</label>
                            <select name="provider_id" id="provider_id" class="form-control SlectBox">
                                <!--placeholder-->
                                <option value="" selected disabled>{{__('sel_pro')}}</option>
                                @foreach ($providers as $prov)
                                    <option value="{{ $prov->id }}"> {{ $prov->name }}</option>
                                @endforeach
                            </select>
                    </div>

                    <div class="form-group">
                        <label for="roundText">{{__('hint en')}}</label>
                        <input type="text" class="form-control" id="hint_en" name="hint_en">
                    </div>
                    <div class="form-group">
                        <label for="roundText">{{__('hint ar')}}</label>
                        <input type="text" class="form-control" id="hint_ar" name="hint_ar">
                    </div>
                    <div class="form-group">
                        <label for="roundText">{{__('details en')}}</label>
                        <input type="text" class="form-control" id="description_en" name="description_en">
                    </div>
                    <div class="form-group">
                        <label for="roundText">{{__('details ar')}}</label>
                        <input type="text" class="form-control" id="description_ar" name="description_ar">
                    </div>
                </div>
                <div class="col-md-6">

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
                        <label for="roundText">{{__('dur')}}</label>
                        <input type="time" class="form-control" id="duration" name="duration">
                    </div>

                    <div class="form-group">
                        <label for="roundText">{{__('price')}}</label>
                        <input type="number" class="form-control" id="price" name="price">
                    </div>

                    <div class="form-group">
                        <label for="roundText">{{__('discount')}}</label>
                        <input type="number" class="form-control" id="discount" name="discount">
                    </div>
                    <div class="form-group">
                        <label for="roundText">{{__('tax')}}</label>
                        <input type="number" class="form-control" id="tax" name="tax">
                    </div>

                    <div class="form-group">
                        <label for="roundText">{{__('un_price')}}</label>
                        <input type="text" class="form-control" id="price_unit" name="price_unit">
                    </div>


                <div class="form-group">
                    <label for="roundText">{{__('icon')}}</label>
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12" id="icon"></div>
                            <div class="needsclick dropzone col-md-12 col-lg-12 col-xs-12 col-sm-12" id="document-dropzone"></div>
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

            url: '{{ route('projects.storeMedia',['table'=>"services"]) }}',
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

                ajax: "{{ route('services.index') }}",

                columns: [

                    {data: 'DT_RowIndex', name: 'id'},

                    {data: 'icon', name: 'icon'},
                    {data: 'name', name: 'name'},
                    {data: 'provider_id', name: 'provider_id'},
                    {data: 'cat_id', name: 'cat_id'},
                    {data: 'duration', name: 'duration'},
                    {data: 'discount', name: 'discount'},
                    {data: 'price', name: 'price'},
                    {data: 'price_unit', name: 'price_unit'},
                    {data: 'tax', name: 'tax'},
                    {data: 'lang', name: 'lang'},

                    {data: 'action', name: 'action', orderable: false, searchable: false},

                ]

            });



            $("#addBtn").click(function (e) {
                e.preventDefault();

                $("#addBtn").html('<i class="fa fa-load"></i> ... ');
                $("#addBtn").attr('disabled',true);
                addNewRow("{{route('services.store')}}", table);
            });


        });
        {{--$(document).ready(function() {--}}
        {{--    // alter($cats);--}}
        {{--    $('.select_cat').select2({--}}

        {{--        dropdownParent: $('#addForm'),--}}
        {{--        placeholder: '{{__('ser_cat')}}',--}}
        {{--        multiple:true,--}}
        {{--        maximumSelectionLength:1,--}}
        {{--        formatSelectionTooBig: function (limit) {--}}
        {{--            return 'Too many selected items';--}}
        {{--        },--}}

        {{--        data: [--}}
        {{--                @foreach ($cats as $ca)--}}
        {{--            { id: '{{$ca->id}}', text: '{{$ca->name}}' },--}}
        {{--            @endforeach--}}
        {{--        ]--}}
        {{--    });--}}
        {{--});--}}

    </script>

@endpush
