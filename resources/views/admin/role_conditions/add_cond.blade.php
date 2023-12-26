@extends('admin_layout')
{{----}}

@section('content')
<h4 id="default"></h4>
    <div class="example">
      <ul class="nav nav-tabs" id="" role="">
      <li class="nav-item">
          <a class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" role="tab" aria-controls="home" aria-selected="true">{{__('add_new_cond')}}</a>
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
                        <label for="roundText"> {{__('title ar')}} </label>
                        <input type="text" name="title_ar" id="title_ar" placeholder="" class="form-control" required>
                    </fieldset>
                    <div class="form-group">
                        <label for="roundText">{{__('content ar')}}</label>
                        <textarea class=" form-control" name="text_ar" id="text_ar"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <fieldset class="form-group">
                        <label for="roundText"> {{__('title en')}} </label>
                        <input type="text" name="title_en" id="title_en" placeholder="" class="form-control" required>
                    </fieldset>
                    <div class="form-group">
                        <label for="roundText">{{__('content en')}}</label>
                        <textarea class=" form-control" name="text_en" id="text_en"></textarea>
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

    <script type="text/javascript">
        $('#text_ar').summernote();
        $('#text_en').summernote();

        $(function () {
            var table = $('#dataTable').DataTable({
                destroy: true,
                processing: true,

                serverSide: true,
                stateSave: true,

                ajax: "{{route('role_condition.index')}}",

                columns: [

                    {data: 'DT_RowIndex', name: 'id'},

                    {data: 'title', name: 'title'},
                    {data: 'content', name: 'content'},

                    {data: 'action', name: 'action', orderable: false, searchable: false},

                ]

            });


            $("#addBtn").click(function (e) {
                e.preventDefault();

                $("#addBtn").html('<i class="fa fa-load"></i> ... ');
                $("#addBtn").attr('disabled',true);

                $("#addBtn").html('{{__('sv')}}');
                addNewRow("{{route('role_condition.store')}}", table);
            });


        });


    </script>

@endpush
