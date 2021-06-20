<link rel="stylesheet" href="{{ asset('plugins/bower_components/icheck/skins/all.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/multiselect/css/multi-select.css') }}">
<style>
    .select2-container-multi .select2-choices .select2-search-choice{border: 1px solid #929291;border-radius: 60px;background: #edda54;padding: 5px 5px 5px 20px;font-size: 12px;}
    .select2-container-multi .select2-search-choice-close{left: 7px;top: 4px;}
    .modal-body{font-family: 'Roboto', sans-serif;font-size: 14px;}
    .btn-group-sm>.btn, .btn-sm, .btn-group-xs>.btn, .btn-xs {line-height: initial;}
</style>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title">@lang('modules.groupMessages.sendMsgEmployees')</h4>
</div>
<div class="modal-body">
    <div class="portlet-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('app.name')</th>
                    <th>Role</th>
                </tr>
                </thead>
                <tbody>
                @forelse($existingEmployees as $key=>$existingEmployee)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ ucwords($existingEmployee->employeeName) }}</td>
                        <td>{{ ucwords($existingEmployee->roleName) }}</td>
                   </tr>
                @empty
                    <tr>
                        <td colspan="3">@lang('messages.noRoleMemberFound')</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <hr>
        {!! Form::open(['id'=>'createProjectCategory','class'=>'ajax-form','method'=>'POST']) !!}

        <div class="form-body">
            <div class="row">
                <div class="col-xs-12 ">
                    <div class="form-group">
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

                        
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <input type="hidden" name="groupID" value="{{ $memberGroupID }}">
            <div id ="error_message" class="alert-danger" style="display:none; width:50%; padding:5px; margin-bottom:2px;">Please select employees</div>
            <button type="button" id="save-category" class="btn btn-success"> <i class="fa fa-check"></i> @lang('app.save')</button>

        </div>
        {!! Form::close() !!}
    </div>
</div>

<script src="{{ asset('js/cbpFWTabs.js') }}"></script>
<script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/multiselect/js/jquery.multi-select.js') }}"></script>

<script>
    $(".select2").select2({
        formatNoMatches: function () {
            return "{{ __('messages.noRecordFound') }}";
        }
    });

    $('.delete-groupEmp').click(function () {
        var userId = $(this).data('ruser-id');
        var groupId =   $(this).data('rgroup-id'); 
        var url = "{{ route('admin.messageGroup.remove-message-group') }}";
        var token = "{{ csrf_token() }}";

        $.easyAjax({
            type: 'POST',
            url: url,
            data: {'_token': token, 'userId': userId, 'groupId': groupId},
            success: function (response) {
                if (response.status == "success") {
                  //  $.unblockUI();
//                                    swal("Deleted!", response.message, "success");
                    window.location.reload();
                }
            }
        });
    });

    $('#save-category').click(function () {
            $.easyAjax({
                url: '{{route('admin.messageGroup.share-message-group')}}',
                container: '#createProjectCategory',
                file: (document.getElementById("image").files.length == 0) ? false : true,
                type: "POST",
                data: $('#createProjectCategory').serialize(),
                success: function (response) {
                    if(response.status == 'success'){
                        window.location.reload();
                    }
                }
            })
        
    });
</script>