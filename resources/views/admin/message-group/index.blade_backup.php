@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->

        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 text-right">
        {!! Form::open(['id'=>'createMessageGroup','class'=>'ajax-form','method'=>'POST']) !!}
        <label class="control-label">
            <a href="javascript:;" id="addMessageGroup"  class="btn btn-sm btn-outline btn-success">
            <i class="fa fa-plus"></i> @lang('modules.files.addMessageGroup')</a>
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
    {!! Form::open(['id'=>'assignMessageGroup','class'=>'ajax-form','method'=>'POST']) !!}
    <div class="col-md-12">
        <div class="white-box">

        <div id="accordion">
        <?php
            $userMessageGroupArray = [];
            foreach($userMessageGroups as $userMessageGroup)
            {
                $userMessageGroupArray[] = $userMessageGroup->messageGroupID;
            }
            
        ?>

        @forelse($messageGroups as $key=>$messageGroup)
        <h3>Assign employees to {{$messageGroup->name}}</h3>
        <div>
            <p>
                @foreach($users as $user)
                <div style="float:left; width:auto; margin-left:15px;">
                <?php
                    $isChecked = '';
                    $loopGropuID= $user->id.'###'.$messageGroup->id;

                    if(in_array($loopGropuID, $userMessageGroupArray))
                    {
                        $isChecked = 'checked=checked';
                    }
                    else {
                        $isChecked = '';
                    }
                ?>
                    <input type="checkbox" name="userMessageGroup[]" value="{{$user->id}}###{{$messageGroup->id}}" class="groupCheckBox" <?php echo $isChecked;?>>
                    {{$user->name}}
                </div>
                @endforeach
            </p>
        </div>
        @empty
            <div>
                <p>
            No data available
                </p>
            </div>
        @endforelse


</div>

        </div>

        <div class="col-md-12">
            <div class = "col-md-4 alert-danger" style="float:left; margin-left:20px;display:none; padding:10px;" id="msgValidation">
                    Please choose any chekbox.
            </div>
            <div class = "col-md-1" style="float:right; margin-right:20px;">
                <div class="form-group m-t-20">
                    <button type="button" id="apply-filter" class="btn btn-info btn-block" onClick="validateForm(); return false;">Apply</button>
                </div>
            </div>
        </div>

    </div>
    
    
    {!! Form::close() !!}
</div>
<!-- .row -->
   
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
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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


{{--Ajax Modal--}}
    <div class="modal fade bs-modal-md in" id="groupModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
                </div>
                <div class="modal-body">
                    Loading...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn blue">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--Ajax Modal Ends--}}

@endsection

@push('footer-script')
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/summernote/dist/summernote.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/dropzone-master/dist/dropzone.js') }}"></script>

<script>

$( "#accordion" ).accordion();

$('#createMessageGroup').on('click', '#addMessageGroup', function () {
        var url = '{{ route('admin.messageGroup.create-group')}}';
        $('#modelHeading').html('Manage Groups');
        $.ajaxModal('#groupModal', url);
    })

function assignGroup(userID)
{
   var selectedValue = $("#userid_"+userID).val();
   // alert(assignGroupIDVal);
   var selectedValueArray = selectedValue.split('###');
   $("#userID").val(selectedValueArray[1]);
   $("#groupID").val(selectedValueArray[0]);
   saveData();
}

function saveData()
{
   
   $.easyAjax({
            url: '{{route('admin.fileGroupCategory.assign-group')}}',
            container: '#assignGroupCategory',
            type: "POST",
            data: $('#assignGroupCategory').serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    if(response.status == 'success'){
                        //console.log(response.data);
                        // return redirect()->to('/user-file'); 
                        location.reload();
                   }
                }
            }
        })

}
$("#manageFiles").on('click', function () { 

    var url = '{{ route('admin.fileGroupCategory.manage-files')}}';
    location.href = url;

});

function validateForm()
{
    if($('.groupCheckBox:checkbox:checked').length == 0)
    {
        $("#msgValidation").show();
    }
    else{
        $("#msgValidation").hide();


        $.easyAjax({
            url: '{{route('admin.messageGroup.assign-message-group')}}',
            container: '#assignMessageGroup',
            type: "POST",
            data: $('#assignMessageGroup').serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    if(response.status == 'success'){
                        //console.log(response.data);
                        // return redirect()->to('/user-file'); 
                        location.reload();
                   }
                }
            }
        })
        
    }
}
</script>

@endpush
