@extends('layouts.member-app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->

        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 text-right">
        {!! Form::open(['id'=>'createGroup','class'=>'ajax-form','method'=>'POST']) !!}
        
        <label class="control-label">
            <a href="javascript:;" id="addFiles"  class="btn btn-sm btn-outline btn-success">
            <i class="fa fa-plus"></i> @lang('modules.files.addFiles')</a>
        </label>
        
        
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang("app.menu.home")</a></li>
                <li class="active">{{ __($pageTitle) }}</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
        {!! Form::close() !!}
    </div>

    
    <div class="row">
    
        <div class="col-md-12">
            <div class="white-box">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover toggle-circle default footable-loaded footable" id="users-table">
                        <thead>
                        <tr>
                            <th>@lang('app.id')</th>
                            <th>@lang('modules.employees.employeeName')</th>
                            <th>@lang('modules.files.fileType')</th>
                            <th>@lang('modules.files.filePath')</th>
                            <th>@lang('modules.files.projectName')</th>
                            <th>@lang('app.createdAt')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($groups as $key=>$userGroup)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $userGroup->employeeName }}</td>
                                <td>{{ $userGroup->fileType }}</td>
                                <td><a href="{{ $userGroup->filePath }}" target="_blank">{{ $userGroup->filePath }}</a></td>
                                <td>{{ $userGroup->projectName }}</td>
                                <td>{{ $userGroup->created_at }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">
                                    <div class="empty-space" style="height: 200px;">
                                        <div class="empty-space-inner">
                                            <div class="icon" style="font-size:30px"><i
                                                        class="icon-layers"></i>
                                            </div>
                                            <div class="title m-b-15">@lang('messages.noFiles')
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
        {!! Form::open(['id'=>'assignGroupCategory','class'=>'ajax-form','method'=>'POST']) !!}
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
$("#addFiles").on('click', function() {
    var url = '{{ route('member.fileGroupCategory.add-files')}}';
    location.href = url;
});
</script>

@endpush