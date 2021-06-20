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
            <a href="javascript:;" id="addGroup"  class="btn btn-sm btn-outline btn-success">
            <i class="fa fa-plus"></i> @lang('modules.files.addGroup')</a>
        </label>

        <label class="control-label">
            <a href="javascript:;" id="manageFiles"  class="btn btn-sm btn-outline btn-success">
            <i class="fa fa-plus"></i> @lang('modules.files.manageFiles')</a>
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
                            <th>@lang('modules.files.groupName')</th>
                            <th>@lang('modules.files.assignGroup')</th>
                            <th>@lang('app.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($usergroups as $key=>$userGroup)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $userGroup->employeeName }}</td>
                                <td>{{ $userGroup->groupName }}</td>
                                <td>
                                <select class="select2 form-control" data-placeholder="@lang('modules.files.groupName')" id="userid_{{$userGroup->id}}" name="group_id" value="">
                                    @foreach($groups as $key=>$group)
                                        <option value="{{ $group->id }}###{{$userGroup->id}}">{{$group->name}}</option>
                                    @endforeach
                                        </select>
                                </td>

                                <td>

                                    <div class="btn-group dropdown m-r-10">
                                        <button aria-expanded="false" data-toggle="dropdown" class="btn dropdown-toggle waves-effect waves-light" type="button"><i class="ti-more"></i></button>
                                        <ul role="menu" class="dropdown-menu pull-right">
                                            <li><a href="#" onClick="assignGroup('{{$userGroup->id}}')"><i class="icon-settings"></i> @lang('app.assign')</a></li>
                                            <li><a href="#" onClick="deleteAssignGroup('{{$userGroup->userGroupID}}')"><i class="fa fa-times" aria-hidden="true"></i> @lang('app.delete') </a></li>

                                        </ul>
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
                                            <div class="title m-b-15">@lang('messages.noDepartment')
                                            </div>
                                            <div class="subtitle">
                                                <a href="{{ route('admin.teams.create') }}" class="btn btn-outline btn-success btn-sm">@lang('app.add') @lang('app.team') <i class="fa fa-plus" aria-hidden="true"></i></a>

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
        <input type="hidden" name="userID" id="userID" value="" >
        <input type="hidden" name="groupID" id="groupID" value="" >
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
$('#createGroup').on('click', '#addGroup', function () {
        var url = '{{ route('admin.fileGroupCategory.create-group')}}';
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
function deleteAssignGroup(id)
{
        var url = "{{ route('admin.fileGroupCategory.delete-group',':id') }}";
        url = url.replace(':id', id);
        var token = "{{ csrf_token() }}";
        $.easyAjax({
            type: 'POST',
                            url: url,
                            data: {'_token': token, '_method': 'DELETE'},
            success: function (response) {
                if (response.status == "success") {
                    location.reload();
                }
            }
        });
}

$("#manageFiles").on('click', function () { 

    var url = '{{ route('admin.fileGroupCategory.manage-files')}}';
    location.href = url;

});
</script>

@endpush
