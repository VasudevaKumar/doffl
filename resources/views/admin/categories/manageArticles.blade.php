@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> Articles</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->

        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 text-right">
        
        
        <!-- <label class="control-label">
            <a href="javascript:;" id="addFiles"  class="btn btn-sm btn-outline btn-success">
            <i class="fa fa-plus"></i> @lang('modules.files.addFiles')</a>
        </label>
        -->

        <label class="control-label">
            <a href="{{route('admin.knowledgebase')}}" id="manageFiles"  class="btn btn-sm btn-outline btn-success">
            <i class="fa fa-plus"></i> @lang('modules.category.listCategory')</a>
        </label>

        <label class="control-label">
            <a href="#" onClick="createArticle('<?php echo $categoryID;?>'); return false;" id="manageFiles"  class="btn btn-sm btn-outline btn-success">
            <i class="fa fa-plus"></i> @lang('modules.category.addArticle')</a>
        </label>

            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang("app.menu.home")</a></li>
                <li class="active">{{ __($pageTitle) }}</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    
    </div>

    

    <div class="row">
    {!! Form::open(['id'=>'manageArticles','class'=>'ajax-form','method'=>'POST']) !!}
        <div class="col-md-12">
            <div class="white-box">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover toggle-circle default footable-loaded footable" id="users-table">
                        <thead>
                        <tr>
                            <th>@lang('app.id')</th>
                            <th>Category Name</th>
                            <th>Article Title</th>
                            <th>Views</th>
                            <th>@lang('app.createdAt')</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($articles as $key=>$article)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $article->categoryTitle }}</td>
                                <td>{{ $article->articleTitle }}</td>
                                <td>{{ $article->visits }}</td>
                                <td>{{ $article->created_at }}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-3 float-left">
                                        <button type="button" class="btn btn-default btn-sm" onClick="editArticle({{ $article->id }} , '<?php echo $categoryID;?>')">
                                              <span class="glyphicon glyphicon-edit"></span> Edit
                                        </button>

                                        </div>

                                        <div class="col-md-3 float-left">

                                        <button type="button" class="btn btn-default btn-sm" onClick="deleteArticle({{ $article->id }} , '<?php echo $categoryID;?>')">
                                              <span class="glyphicon glyphicon-remove-sign"></span> Remove
                                        </button>

                                        </div>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">
                                    <div class="empty-space" style="height: 200px;">
                                        <div class="empty-space-inner">
                                            <div class="icon" style="font-size:30px"><i
                                                        class="icon-layers"></i>
                                            </div>
                                            <div class="title m-b-15">@lang('messages.noArticles')
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
       
        {!! Form::close() !!}
    </div>
    <!-- .row -->


@endsection

@push('head-script')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/summernote/dist/summernote.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/dropzone-master/dist/dropzone.css') }}">

<style>
    .panel-black .panel-heading a, .panel-inverse .panel-heading a {
        color: unset!important;
    }
    .bootstrap-select.btn-group .dropdown-menu li a span.text {
        color: #000;
    }
    .panel-black .panel-heading a:hover, .panel-inverse .panel-heading a:hover {
        color: #000 !important;
    }
    .panel-black .panel-heading a, .panel-inverse .panel-heading a {
        color: #000 !important;
    }
    .btn-info.active, .btn-info:active, .open>.dropdown-toggle.btn-info {
        background-color:unset !important; ;
        border-color: #269abc;
    }
    .note-editor{
        border: 1px solid #e4e7ea !important;
    }
    .btn-info.active.focus, .btn-info.active:focus, .btn-info.active:hover, .btn-info.focus, .btn-info.focus:active, .btn-info:active:focus, .btn-info:active:hover, .btn-info:focus, .open>.dropdown-toggle.btn-info.focus, .open>.dropdown-toggle.btn-info:focus, .open>.dropdown-toggle.btn-info:hover {
        background-color: #03a9f3;
        border: 1px solid #03a9f3;
        color: #000;
    }
</style>
@endpush

@section('content')
@endsection

@push('footer-script')
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/summernote/dist/summernote.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/dropzone-master/dist/dropzone.js') }}"></script>


<script type="text/javascript">
function editArticle(id , categoryID)
{
      var url = '{{ route('admin.knowledgebase.editArticle', ':id')}}';
       url = url.replace(':id', id);
       location.href = url;
}
function deleteArticle(id , categoryID)
{
       
    var  url = '{{route('admin.knowledgebase.deleteArticle')}}';
      var token = "{{ csrf_token() }}";

      $.easyAjax({
            type: 'POST',
            url: url,
            data: {'_token': token, 'id': id, 'categoryID':categoryID},
            success: function (response) {
                if (response.status == "success") {
                  //  $.unblockUI();
//                                    swal("Deleted!", response.message, "success");
                    window.location.reload();
                }
            }
        });

}
function createArticle(categoryID)
{
    var url = '{{ route('admin.knowledgebase.createArticle', ':categoryID')}}';
    url = url.replace(':categoryID', categoryID);
    location.href = url;

}

function manageArticles(id)
{
    // alert(categoryID);

    var url = '{{ route('admin.knowledgebase.manageArticles', ':id')}}';
    url = url.replace(':id', id);
    location.href = url;

}
</script>

@endpush