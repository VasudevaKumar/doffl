@extends('layouts.app')

@section('page-title')
    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="{{ $pageIcon }}"></i> {{ __($pageTitle) }}</h4>
        </div>
        <!-- /.page title -->
        <div class="col-lg-5 col-md-7 col-sm-7 col-xs-12"></div>
        
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
         <label class="control-label">
            <a href="javascript:;" id="ManageGroups"  class="btn btn-sm btn-outline btn-success">
            <i class="fa fa-plus"></i> @lang('modules.files.ManageGroups')</a>
        </label>  
        </div>      

        
    </div>

    @endsection

    @push('head-script')
<link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
@endpush


@section('other-section')

<div class="row">
        <div class="col-md-12">

            <div class="chat-main-box">

                <!-- .chat-left-panel -->
                <div class="chat-left-aside">
                    <div class="open-panel"><i class="ti-angle-right"></i></div>
                    <div class="chat-left-inner">

                        <div class="form-material"><input class="form-control p-20" id="userSearch" type="text"
                                                        placeholder="@lang("modules.messages.searchContact")"></div>

                        <ul class="chatonline style-none userList">
                        
                        <li id="">
                                    <a href="javascript:void(0)" id=""
                                       onclick="showMessages('All Groups' , '0');">

                                       <img src="<?php echo url('/');?>/user-uploads/messagegroup/groupDiscussion.png" alt="msg-img"
                                                 class="img-circle">

                                        <span> All Groups
                                        </span>
                                    </a>
                                </li>
                            @forelse($messageGroups as $messagegroup)
                                <li id="">
                                    <a href="javascript:void(0)" id=""
                                       onclick="showMessages('{{$messagegroup->name}}' , {{$messagegroup->id}});">

                                       <img src="<?php echo url('/');?>/user-uploads/messagegroup/<?php echo $messagegroup->image;?>" alt="msg-img"
                                                 class="img-circle">

                                        <span> {{$messagegroup->name}}
                                        </span>
                                    </a>
                                </li>


                            @empty
                                
                            @endforelse


                            <li class="p-20"></li>
                        </ul>
                    </div>
                </div>
                <!-- .chat-left-panel -->
            </div>
        </div>
</div>

    <!-- .row -->
@endsection


@section('content')

    <div class="row" id="groupMessageDiv" style="display:none;">
        <div class="col-md-12">

            <div class="chat-main-box">


                <!-- .chat-right-panel -->
                <div class="chat-right-aside">
                    <div class="chat-main-header">
                        <div class="p-20 b-b row">

                            <div style="float:left;" class="col-md-12" id="messageHeading"></div>
                        </div>
                    </div>
                    <div class="chat-box ">

                        <ul class="chat-list slimscroll p-t-30 chats" style="min-height: 250px;"></ul>

                        <div class="row send-chat-box">
                        {!! Form::open(['id'=>'saveFile','class'=>'ajax-form','method'=>'POST']) !!}
                            <div class="col-sm-12">
                                <input type="text" name="message" id="submitTexts" autocomplete="off" placeholder="@lang("modules.messages.typeMessage")"
                                       class="form-control">
                                

                                
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

                                <div class="custom-send">
                                    <button id="submitBtn" class="btn btn-danger btn-rounded" type="button">@lang("modules.messages.send")
                                    </button>
                                    <input id="userID" value="{{$user_id}}" type="hidden" name="user_id"/>
                                    <input id="groupID" value="1" type="hidden" name="groupID" />

                                </div>
                                <div id="errorMessage"></div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- .chat-right-panel -->
            </div>
        </div>


    </div>
    <!-- .row -->

    {{--Ajax Modal--}}
    <div class="modal fade bs-modal-md in" id="newChatModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
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
$('#createMessageGroup').on('click', '#addMessageGroup', function () {
        var url = '{{ route('admin.messageGroup.create-group')}}';
        $('#modelHeading').html('Manage Groups');
        $.ajaxModal('#groupModal', url);
    })

    $('#ManageGroups').on('click',  function () {
        var url = '{{ route('admin.messageGroup.showGroupsindex')}}';
        window.location.href = url;
    });


function showMessages(messageName, groupID)
{
    $("#groupMessageDiv").show();
    $("#messageHeading").html('<h3 class="box-title col-md-9">Group Discussion - '+messageName+'</h3>');
    $("#groupID").val(groupID);
    $('.chats').html('');
     //getting values by input fields
     var userID = $('#userID').val();
     getChatData(userID, groupID);

}

//submitting message
$('#submitBtn').on('click', function (e) {
        e.preventDefault();
        //getting values by input fields
        var submitText = $('#submitTexts').val();
        var userID = $('#userID').val();
        var groupID = $('#groupID').val();
       

        //checking fields blank
        if (submitText == "" || submitText == undefined || submitText == null) {
            $('#errorMessage').html('<div class="alert alert-danger"><p>Message field cannot be blank</p></div>');
            return;
        } else if (userID == '' || submitText == undefined) {
            $('#errorMessage').html('<div class="alert alert-danger"><p>No user for message</p></div>');
            return;
        } else {

            var url = "{{ route('admin.messageGroup.saveMessages') }}";
            var token = "{{ csrf_token() }}";
            $.easyAjax({
                type: 'POST',
                url: url,
                messagePosition: '',
               // data: {'message': submitText, 'user_id': userID, 'groupID':groupID, '_token': token},
               data: $('#saveFile').serialize(),
               container: '#saveFile',
                file: (document.getElementById("image").files.length == 0) ? false : true,
                blockUI: true,
                redirect: false,
                success: function (response) {
                    var blank = "";
                    $('#submitTexts').val('');
                    $(".thumbnail").html('');

                    //getting values by input fields
                    var userID = $('#userID').val();
                    var groupID = $('#groupID').val();

                    //set chat data
                    getChatData(userID, groupID);
                    //set user list
                    $('.userList').html(response.userList);

                    //set active user
                    if (userID) {
                        $('#userID' + userID + 'a').addClass('active');
                    }
                }
            });
        }

        return false;
    });


//getting all chat data according to user
function getChatData(id, dpName, scroll) {
     
        var getID = '';
        $('#errorMessage').html('');
        if (id != "" && id != undefined && id != null) {
            $('.userList li a.active ').removeClass('active');
            $('#dpa_' + id).addClass('active');
            $('#dpID').val(id);
            getID = id;
            $('#badge_' + id).val('');
        } else {
            $('.userList li:first-child a').addClass('active');
            getID = $('#dpID').val();
        }

        var url = "{{ route('admin.messageGroup.getMessages') }}";

        $.easyAjax({
            type: 'GET',
            url: url,
            messagePosition: '',
            data: {'userID': getID, 'groupID': dpName},
            container: ".chats",
            success: function (response) {
                //set messages in box
               //  console.log(response);
                $('.chats').html(response.chatData);
                // scrollChat();
            }
        });
    }

    
    //getting all chat data according to user
    //submitting message
    
    $("#userSearch").keyup(function (e) {
        var url = "{{ route('admin.messageGroup.group-search') }}";

        $.easyAjax({
            type: 'GET',
            url: url,
            messagePosition: '',
            data: {'term': this.value},
            container: ".userList",
            success: function (response) {
                //set messages in box
                $('.userList').html(response.userList);
            }
        });
    });

</script>
@endpush





