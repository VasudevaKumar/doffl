@extends('layouts.member-app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
                <li><a href="{{ route('admin.clients.index') }}">{{ __($pageTitle) }}</a></li>
                <li class="active">@lang('app.addNew')</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
@endpush

@section('content')

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-inverse">
                <div class="panel-heading"> @lang('modules.files.uploadFiile')</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        {!! Form::open(['id'=>'saveFile','class'=>'ajax-form','method'=>'POST']) !!}
                        @if(isset($leadDetail->id))
                            <input type="hidden" name="lead" value="{{ $leadDetail->id }}">
                        @endif
                            <div class="form-body">
                                <div class="row" style="margin-bottom: 20px;">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div style="margin-bottom: 10px;">
                                                <label class="control-label">@lang('modules.files.chooseFileType')</label>
                                                <a class="mytooltip" href="javascript:void(0)"> <i class="fa fa-info-circle"></i><span class="tooltip-content5"><span class="tooltip-text3"><span class="tooltip-inner2">@lang('modules.client.sendCredentialsMessage')</span></span></span></a>
                                            </div>
                                            <div class="radio radio-inline col-md-4">
                                                <input type="radio" name="chkfileType" id="personal"
                                                       value="2" checked    onClick="checkProjectDropdown(this.value);">
                                                <label for="sendMail1" class="">
                                                    @lang('modules.files.personal') </label>
                                            </div>
                                            <!-- 
                                            <div class="radio radio-inline col-md-4">
                                                <input type="radio" name="chkfileType"
                                                       id="project" checked value="1" onClick="checkProjectDropdown(this.value);">
                                                <label for="sendMail2" class="">
                                                    @lang('modules.files.project') </label>
                                            </div>
                                            -->
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-6" style="margin-top:25px;">
                                       <div class="form-group">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-preview fileinput-exists thumbnail"
                                                     style="max-width: 300px; max-height: 50px; margin-left:8px !important;"></div>
                                                <div>
                                
                                <span class="btn btn-info btn-file">
                                    <span class="fileinput-new"> @lang('app.selectFile') </span>
                                    <span class="fileinput-exists"> @lang('app.change') </span>
                                    <input type="file" id="image" name="image"> </span>
                                                    <a href="javascript:;" class="btn btn-danger fileinput-exists"
                                                       data-dismiss="fileinput"> @lang('app.remove') </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                
                                </div>

                        </div>
                        

                            </div>
                            <div class="row form-actions" style="margin-left:20px;">
                                <button type="submit" id="save-form" class="btn btn-success"> <i class="fa fa-check"></i> @lang('app.save')</button>

                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>    <!-- .row -->

@endsection

@push('footer-script')
<script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

<script>
    $(".date-picker").datepicker({
        todayHighlight: true,
        autoclose: true,
        weekStart:'{{ $global->week_start }}',
        format: '{{ $global->date_picker_format }}',
    });

    $('#save-form').click(function () {
        $.easyAjax({
            url: '{{route('member.fileGroupCategory.store-files')}}',
            container: '#saveFile',
            type: "POST",
            redirect: true,
            blockUI: true,
            redirect: true,
            data: $('#saveFile').serialize(),
            file: (document.getElementById("image").files.length == 0) ? false : true,
            success: function (response) {
                // manage-files
                var url = '{{ route('member.fileGroupCategory.manage-files')}}';
                location.href = url;
                }
        })
    });

    function checkProjectDropdown(checkedValue)
    {
        if(checkedValue == 1){
            $("#projects").show();
        }
        else {
            $("#projects").hide();
        }
    }
</script>
@endpush

