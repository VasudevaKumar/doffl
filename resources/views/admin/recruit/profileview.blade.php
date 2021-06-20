@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> Jobseeker profile</h4>
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
            <a href="#" onClick="profileList('<?php echo $jobAnswers[0]->jobapplication_id;?>'); return false;" id="manageFiles"  class="btn btn-sm btn-outline btn-success">
            <i class="fa fa-plus"></i> Profile List</a>
        </label>



            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang("app.menu.home")</a></li>
                <li class="active">{{ __($pageTitle) }}</li>
            </ol>
        </div>
        
        <!-- /.breadcrumb -->

    </div>
@endsection

<?php 
/*
echo '<pre>';
print_r($answers);
echo '</pre>';
exit();
*/
?>


@push('head-script')
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/html5-editor/bootstrap-wysihtml5.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/dropzone-master/dist/dropzone.css') }}">

@endpush

@section('content')


<div class="row">
    {!! Form::open(['id'=>'manageJobs','class'=>'ajax-form','method'=>'POST']) !!}
        <div class="col-md-12">
            <div class="white-box">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover toggle-circle default footable-loaded footable" id="users-table">
                        <thead>
                        <tr><th style="width:125px;">Name</th> <td><?php echo $jobAnswers[0]->name;?></td></tr>
                        <tr><th style="width:125px;">Email</th> <td><?php echo $jobAnswers[0]->email;?></td></tr>
                        <tr><th style="width:125px;">Phone</th> <td><?php echo $jobAnswers[0]->phone;?></td></tr>
                        <tr><th style="width:125px;">Cover letter</th> <td><?php echo $jobAnswers[0]->coverletter;?></td></tr>
                        <?php
                        if($jobAnswers[0]->resumePath!='') { ?>
                        <tr><th style="width:125px;">Resume Path</th> <td><a href="<?php echo url('/');?>/recruit/img/documents/<?php echo $jobAnswers[0]->resumePath;?>">Download Resume</a></td></tr>
                    <?php } 
                        if($jobAnswers[0]->docPath!='') { ?>
                        <tr><th style="width:125px;">Doc Path</th> <td><a href="<?php echo url('/');?>/recruit/img/documents/<?php echo $jobAnswers[0]->docPath;?>">Download Document</a></td></tr>
                    <?php } ?>
                        </thead>
                        
                    </table>
                    <div style="margin-top:10px; margin-bottom:10px;"><strong>Question & Answers Section<strong></div>
                    <table class="table table-bordered table-hover toggle-circle default footable-loaded footable" id="users-table">
                    @forelse($answers as $key=>$answer)
                    <tr><td><?php echo $answer->questionName; ?> &nbsp;:&nbsp;<?php echo $answer->answer; ?></td></tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">
                                    <div class="empty-space" style="height: 200px;">
                                        <div class="empty-space-inner">
                                            <div class="icon" style="font-size:30px"><i
                                                        class="icon-layers"></i>
                                            </div>
                                            <div class="title m-b-15">No answers found</div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
       
        {!! Form::close() !!}
    </div>
    <!-- .row -->

@endsection


@push('footer-script')
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/html5-editor/wysihtml5-0.3.0.js') }}"></script>
<script src="{{ asset('plugins/bower_components/html5-editor/bootstrap-wysihtml5.js') }}"></script>
<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/dropzone-master/dist/dropzone.js') }}"></script>


@endpush

<style type="text/css">
.smallfont{
    font-size:9px;
}
</style>


<script type="text/javascript">
function editJob(id)
{
      var url = '{{ route('admin.recruit.editJob', ':id')}}';
       url = url.replace(':id', id);
       location.href = url;
}

function createJob()
{
    var url = '{{ route('admin.recruit')}}';
       location.href = url;
}

function deleteJob(id)
{
    var  url = '{{route('admin.recruit.deleteJob')}}';
      var token = "{{ csrf_token() }}";

      $.easyAjax({
            type: 'POST',
            url: url,
            data: {'_token': token, 'id': id},
            success: function (response) {
                if (response.status == "success") {
                       window.location.reload();
                }
            }
        });
}

function profileList(id)
{
        var url = '{{ route('admin.recruit.profilelist', ':id')}}';
       url = url.replace(':id', id);
       location.href = url;
}
</script>