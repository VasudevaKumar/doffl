@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i>Create Question</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('app.menu.home')</a></li>
                <li class="active">{{ __($pageTitle) }}</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>
@endsection

@push('head-script')
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/html5-editor/bootstrap-wysihtml5.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/dropzone-master/dist/dropzone.css') }}">

@endpush

@section('content')


<div class="row">
        <div class="col-md-12">
            <div class="panel panel-inverse">
                <div class="panel-heading"> @lang('app.create') @lang('app.timeLog') @lang('app.invoice')</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        {!! Form::open(['id'=>'storeQuestion','class'=>'ajax-form','method'=>'POST']) !!}
                        <div class="form-body">

                            <div class="row">
                             

                                <div class="col-md-4">

                                    <div class="form-group" >
                                        <label class="control-label">@lang('app.menu.recruit.Question')</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                            <div class="input-icon">
                                                    <input type="text" class="form-control" name="question_name" id="question_name" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            

                            <hr>

                        </div>

                        <div class="form-actions" style="margin-top: 70px; margin-left:20px;">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type ="hidden" name = "jobID" id="jobID" value="<?php echo $jobID;?>">
                                    <button type="button" id="save-form" class="btn btn-success" onClick="validateForm(); return false;"> <i class="fa fa-check"></i> @lang('app.save')</button>
                                </div>

                                <div class="col-md-4 alert alert-danger" style=" display:none;  margin-left:10px;" id="errorMessage"></div>

                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>    <!-- .row -->

@endsection


@push('footer-script')
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/html5-editor/wysihtml5-0.3.0.js') }}"></script>
<script src="{{ asset('plugins/bower_components/html5-editor/bootstrap-wysihtml5.js') }}"></script>
<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/dropzone-master/dist/dropzone.js') }}"></script>


<script type="text/javascript">
$('#job_description').wysihtml5();
$('#job_Responsibilities').wysihtml5();
$("#job_Benefits").wysihtml5();

function validateForm()
{
    var isSubmit = true;
    $("#errorMessage").html('');
    $("#errorMessage").hide();
    

    if($("#question_name").val() == '')
    {
        $("#errorMessage").show();
        $("#errorMessage").html('Question name should not be empty');
        isSubmit = false;
    }

    if(isSubmit)
    {
       //  alert('added');

       $.easyAjax({
            url: '{{route('admin.recruit.saveQuestion')}}',
            container: '#storeJobs',
            type: "POST",
            data: $('#storeJobs').serialize(),
            file:  true,
            success: function (response) {
                if (response.status == 'success') {
                  
                    var url = '{{ route('admin.recruit.managejob')}}';
                     location.href = url;
                     
                }else{
                    // console.log(response);
                    $("#errorMessage").show();
                    $("#errorMessage").html(response.message);
                }
            }
        });

    }



}




</script>

@endpush

<style type="text/css">
.smallfont{
    font-size:9px;
}
</style>