<link rel="stylesheet" href="{{ asset('plugins/bower_components/icheck/skins/all.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bower_components/multiselect/css/multi-select.css') }}">
<style>
    .select2-container-multi .select2-choices .select2-search-choice{border: 1px solid #929291;border-radius: 60px;background: #edda54;padding: 5px 5px 5px 20px;font-size: 12px;}
    .select2-container-multi .select2-search-choice-close{left: 7px;top: 4px;}
    .modal-body{font-family: 'Roboto', sans-serif;font-size: 14px;}
    .btn-group-sm>.btn, .btn-sm, .btn-group-xs>.btn, .btn-xs {line-height: initial;}
    .modal-content {width:900px !important;}
</style>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title">@lang('modules.groupMessages.sendMsgEmployees')</h4>
</div>
<div class="modal-body">
    <div class="portlet-body">
        <div class="table-responsive">
        <table class="table table-bordered table-hover toggle-circle default footable-loaded footable" id="users-table">
                        <thead>
                        <tr>
                            <th>@lang('app.id')</th>
                            <th>@lang('modules.employees.employeeName')</th>
                            <th>@lang('modules.files.filePath')</th>
                            <th>@lang('modules.files.message')</th>
                            <th>@lang('app.createdAt')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($groups as $key=>$userGroup)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $userGroup->employeeName }}</td>
                                <td><a href="{{ $userGroup->filePath }}" target="_blank">{{ $userGroup->filePath }}</td>
                                <td>{{ $userGroup->messageText }}</td>
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

        <hr>
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