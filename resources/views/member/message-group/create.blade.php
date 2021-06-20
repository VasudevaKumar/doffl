<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title">@lang('modules.files.messagegroupName')</h4>
</div>
<div class="modal-body">
    <div class="portlet-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('modules.files.messagegroupName')</th>
                    <th>@lang('app.action')</th>

                </tr>
                </thead>
                <tbody id="groupBody">
                @foreach($data['groups'] as $key=>$group)
                    <tr id="cat-{{ $group->id }}">
                        <td>{{ $key+1 }}</td>
                        <td>{{ ucwords($group->name) }}</td>
                        <td><a href="javascript:;" data-cat-id="{{ $group->id }}" class="btn btn-sm btn-danger btn-rounded delete-category">@lang("app.remove")</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <hr>
        {!! Form::open(['id'=>'createGroupCategory','class'=>'ajax-form','method'=>'POST']) !!}
        <div class="form-body">
            <div class="row">
                <div class="col-xs-12 ">
                    <div class="form-group">
                        <label>@lang('modules.files.groupName')</label>
                        <input type="text" name="group_name" id="group_name" class="form-control">
                    </div>
                </div>
            </div>


        </div>
        <div class="form-actions">
            <button type="button" id="save-group" class="btn btn-success"> <i class="fa fa-check"></i> @lang('app.save')</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>

<script>

    $('.delete-category').click(function () {
        alert('here');
        var id = $(this).data('cat-id');
        var url = "{{ route('admin.messageGroup.destroy',':id') }}";
        url = url.replace(':id', id);

        var token = "{{ csrf_token() }}";

        $.easyAjax({
            type: 'POST',
                            url: url,
                            data: {'_token': token, '_method': 'DELETE'},
            success: function (response) {
                if (response.status == "success") {
                    $.unblockUI();
//                                    swal("Deleted!", response.message, "success");
                    $('#cat-'+id).fadeOut();
                }
            }
        });
    });

    $('#save-group').click(function () {
        $.easyAjax({
            url: '{{route('admin.messageGroup.store-group')}}',
            container: '#createGroupCategory',
            type: "POST",
            data: $('#createGroupCategory').serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    if(response.status == 'success'){
                        console.log(response.data);
                        var options = [];
                        var rData = [];
                        rData = response.data.groups;
                        console.log(rData);
                        $.each(rData, function( index, value ) {
                           // var selectData = '';
                           // selectData = '<option value="'+value.id+'">'+value.category_name+'</option>';
                           // options.push(selectData);
                        var content = '';
                        content += '<tr id = "cat-'+value.id+'"><td>'+response.data.key+'</td><td>'+value.name+'</td><td><a href="javascript:;" data-cat-id="'+value.id+'" class="btn btn-sm btn-danger btn-rounded delete-category">@lang("app.remove")</a></td></tr>';
                        $("#groupBody").append(content);
                            

        $('.delete-category').click(function () {
        var id = $(this).data('cat-id');
        var url = "{{ route('admin.messageGroup.destroy',':id') }}";
        url = url.replace(':id', id);

        var token = "{{ csrf_token() }}";

        $.easyAjax({
            type: 'POST',
                            url: url,
                            data: {'_token': token, '_method': 'DELETE'},
            success: function (response) {
                if (response.status == "success") {
                    $.unblockUI();
//                                    swal("Deleted!", response.message, "success");
                    $('#cat-'+id).fadeOut();
                }
            }
        });
    });


                        });

                    }
                }
            }
        })
    });
</script>
